<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Sends push notifications through the Firebase Cloud Messaging HTTP v1 API.
 *
 * The old `https://fcm.googleapis.com/fcm/send` endpoint with a "server key"
 * was shut down by Google in 2024, so anything sent to it is silently dropped.
 * v1 needs a service-account JSON file (Firebase console > Project settings >
 * Service accounts > Generate new private key). Put it OUTSIDE the web root,
 * e.g. storage/app/firebase-service-account.json, or point FIREBASE_CREDENTIALS
 * in .env at its full path. Never commit it.
 */
class FcmV1
{
    private const SCOPE = 'https://www.googleapis.com/auth/firebase.messaging';

    /** @return array{ok: bool, status: int, body: string} */
    public static function sendToTopic(
        string $topic,
        string $title,
        string $body,
        ?string $image = null,
        array $data = []
    ): array {
        try {
            $cred = self::credentials();
            $token = self::accessToken($cred);

            $notification = ['title' => $title, 'body' => $body];
            if (!empty($image)) {
                $notification['image'] = $image;
            }

            // FCM data values must all be strings.
            $data = array_map(fn ($v) => (string) ($v ?? ''), $data);

            $message = [
                'topic' => $topic,
                'notification' => $notification,
                'data' => (object) $data,
                'android' => [
                    'priority' => 'HIGH',
                    'notification' => [
                        'sound' => 'default',
                        'channel_id' => 'high_importance_channel',
                    ],
                ],
                'apns' => [
                    'headers' => ['apns-priority' => '10'],
                    'payload' => ['aps' => ['sound' => 'default']],
                ],
            ];

            $response = Http::withToken($token)
                ->timeout(20)
                ->post(
                    'https://fcm.googleapis.com/v1/projects/' . $cred['project_id'] . '/messages:send',
                    ['message' => $message]
                );

            if (!$response->successful()) {
                Log::error('FCM v1 send failed', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);
            }

            // A real success is HTTP 200 *and* a message name back from Firebase.
            // That name is Firebase's receipt that it accepted the message.
            $json = $response->json() ?: [];
            $messageId = $json['name'] ?? null;
            $ok = $response->successful() && $messageId;

            return [
                'ok' => (bool) $ok,
                'status' => $response->status(),
                'body' => $response->body(),
                'message_id' => $messageId,
                'error' => $ok ? null : ($json['error']['message'] ?? ('HTTP ' . $response->status())),
            ];
        } catch (\Throwable $e) {
            Log::error('FCM v1 send error: ' . $e->getMessage());
            return ['ok' => false, 'status' => 0, 'body' => $e->getMessage(), 'message_id' => null, 'error' => $e->getMessage()];
        }
    }

    /**
     * A silent "something changed, look again" message for the app's open
     * screens (no notification is shown). Used when the live darsa is switched
     * on/off or an announcement changes, so phones update at once instead of
     * waiting for a pull-to-refresh. It never throws and is short on time:
     * the admin's action must not wait on Firebase.
     *
     * @param string $scope streams | announcements | all
     */
    public static function signalRefresh(string $scope): void
    {
        try {
            $cred = self::credentials();
            $token = self::accessToken($cred);
            Http::withToken($token)
                ->timeout(5)
                ->post(
                    'https://fcm.googleapis.com/v1/projects/' . $cred['project_id'] . '/messages:send',
                    ['message' => [
                        'topic' => 'all',
                        'data' => ['type' => 'refresh', 'scope' => $scope],
                        'android' => ['priority' => 'HIGH', 'ttl' => '60s'],
                        'apns' => [
                            'headers' => ['apns-push-type' => 'background', 'apns-priority' => '5'],
                            'payload' => ['aps' => ['content-available' => 1]],
                        ],
                    ]]
                );
        } catch (\Throwable $e) {
            Log::warning('FCM refresh signal failed: ' . $e->getMessage());
        }
    }

    private static function credentials(): array
    {
        $path = env('FIREBASE_CREDENTIALS', storage_path('app/firebase-service-account.json'));
        if (!is_file($path)) {
            throw new \RuntimeException("Firebase service account file not found at $path");
        }
        $cred = json_decode(file_get_contents($path), true);
        if (empty($cred['private_key']) || empty($cred['client_email']) || empty($cred['project_id'])) {
            throw new \RuntimeException('Firebase service account file is not valid');
        }
        return $cred;
    }

    /** OAuth2 access token for the service account, cached for ~55 minutes. */
    private static function accessToken(array $cred): string
    {
        return Cache::remember('fcm_v1_access_token', 3300, function () use ($cred) {
            $now = time();
            $b64 = fn ($d) => rtrim(strtr(base64_encode($d), '+/', '-_'), '=');
            $unsigned = $b64(json_encode(['alg' => 'RS256', 'typ' => 'JWT'])) . '.' . $b64(json_encode([
                'iss' => $cred['client_email'],
                'scope' => self::SCOPE,
                'aud' => 'https://oauth2.googleapis.com/token',
                'iat' => $now,
                'exp' => $now + 3600,
            ]));
            if (!openssl_sign($unsigned, $signature, $cred['private_key'], OPENSSL_ALGO_SHA256)) {
                throw new \RuntimeException('Could not sign the Firebase token request');
            }
            $response = Http::asForm()->timeout(20)->post('https://oauth2.googleapis.com/token', [
                'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
                'assertion' => $unsigned . '.' . $b64($signature),
            ]);
            if (!$response->successful() || empty($response['access_token'])) {
                throw new \RuntimeException('Firebase token request failed: ' . $response->body());
            }
            return $response['access_token'];
        });
    }
}
