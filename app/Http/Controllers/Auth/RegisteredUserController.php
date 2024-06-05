<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\Anggota;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            // 'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'username' => ['required', 'string', 'unique:users,username'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'register_as' => ['required', 'string', 'in:anggota,non_anggota']
        ]);

        $last_anggota = Anggota::query()->orderBy('id', 'desc')->first();
        $no_anggota = $last_anggota ? 'ANG-'. str_pad(($last_anggota->id + 1), 7, '0', STR_PAD_LEFT) : 'ANG-0000001';

        $anggota = new Anggota();
        $anggota->username = $request->username;
        $anggota->password = Hash::make($request->password);
        $anggota->nama_lengkap = $request->name;
        $anggota->no_anggota = $no_anggota;
        $anggota->save();

        // jika daftar sebagai anggota, langsung login
        if ($request->register_as === 'anggota') {
            $user = User::create([
                'name' => $request->name,
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'level' => 1, // admiin
            ]);

            // event(new Registered($user));

            Auth::login($user);

            return redirect(route('dashboard', absolute: false));
        }

        return redirect(route('login', absolute: false));
    }
}
