<?php

namespace App\Http\Controllers;

use App\Rules\PersonName;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function getAllUsers()
    {
        return view('others.users')->with('users', User::orderBy('id')->get());
    }

    public function postUser(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120', new PersonName()],
            'email' => 'required|email:rfc|max:190|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        return back()->with('success', 'Msimamizi ameongezwa');
    }

    public function putUser(Request $request, $userId)
    {
        $user = User::findOrFail($userId);
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120', new PersonName()],
            'email' => 'required|email:rfc|max:190|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user->name = $data['name'];
        $user->email = $data['email'];
        if (!empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }
        $user->save();

        return back()->with('success', 'Taarifa zimehifadhiwa');
    }

    public function deleteUser($userId)
    {
        $user = User::findOrFail($userId);
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Huwezi kujifuta mwenyewe.');
        }
        if (User::count() <= 1) {
            return back()->with('error', 'Lazima abaki msimamizi angalau mmoja.');
        }
        $user->delete();

        return back()->with('success', 'Msimamizi amefutwa');
    }
}
