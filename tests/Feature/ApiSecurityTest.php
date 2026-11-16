<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\RateLimiter;
use Tests\TestCase;

/**
 * Security rules for the public API. These need no database: guests are
 * rejected by the auth middleware before any controller runs, and the
 * validation cases fail before anything is saved.
 */
class ApiSecurityTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        RateLimiter::clear('submit-min:127.0.0.1');
        RateLimiter::clear('submit-day:127.0.0.1');
    }

    /** @dataProvider protectedRoutes */
    public function test_guests_cannot_use_write_or_private_routes(string $method, string $uri): void
    {
        $this->json($method, $uri)->assertStatus(401);
    }

    public static function protectedRoutes(): array
    {
        $cases = [];
        foreach ([
            ['POST', '/api/category'], ['PUT', '/api/category/1'], ['DELETE', '/api/category/1'],
            ['POST', '/api/album/1'], ['PUT', '/api/album/1'], ['DELETE', '/api/album/1'],
            ['POST', '/api/song/1'], ['PUT', '/api/song/1'], ['DELETE', '/api/song/1'],
            ['POST', '/api/book'], ['PUT', '/api/book/1'], ['DELETE', '/api/book/1'],
            ['POST', '/api/article'], ['PUT', '/api/article/1'], ['DELETE', '/api/article/1'],
            ['POST', '/api/stream'], ['PUT', '/api/stream/1'], ['DELETE', '/api/stream/1'],
            ['POST', '/api/slide'], ['DELETE', '/api/slide/1'],
            ['POST', '/api/link'], ['PUT', '/api/link/1'], ['DELETE', '/api/link/1'],
            ['POST', '/api/announcement'], ['PUT', '/api/announcement/1'], ['DELETE', '/api/announcement/1'],
            ['POST', '/api/history'], ['PUT', '/api/history/1'], ['DELETE', '/api/history/1'],
            // Visitor names and phone numbers.
            ['GET', '/api/comments'], ['GET', '/api/comment/1'],
            ['PUT', '/api/comment/1'], ['DELETE', '/api/comment/1'],
        ] as [$method, $uri]) {
            $cases["$method $uri"] = [$method, $uri];
        }
        return $cases;
    }

    public function test_comment_validation_returns_422(): void
    {
        $this->postJson('/api/comment', ['full_name' => 'A', 'phone' => 'abc', 'message' => 'hi'])
            ->assertStatus(422)
            ->assertJsonStructure(['error', 'status'])
            ->assertJsonPath('status', false);
    }

    public function test_question_requires_text_and_caps_length(): void
    {
        $this->postJson('/api/question', [])->assertStatus(422);
        $this->postJson('/api/question', ['qn' => str_repeat('x', 2001)])->assertStatus(422);
    }

    public function test_public_submissions_are_rate_limited(): void
    {
        // Invalid payloads keep this database-free; the limiter counts them anyway.
        for ($i = 0; $i < 5; $i++) {
            $this->postJson('/api/question', [])->assertStatus(422);
        }
        $this->postJson('/api/question', [])->assertStatus(429);
    }

    public function test_landing_page_only_serves_known_types(): void
    {
        $this->get('/app/song/12')->assertOk()->assertSee('abulfadhwl://open/song/12', false);
        $this->get('/app/evil/12')->assertNotFound();
    }
}
