<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'loginname' => 'required',
            'loginpassword' => 'required',
        ]);

        if (auth()->attempt([
            'name' => $credentials['loginname'],
            'password' => $credentials['loginpassword']
        ])) {
            $request->session()->regenerate();
            return redirect('/home');
        }

        // Jika gagal login, redirect kembali dengan pesan error
        return back()->withErrors([
            'loginname' => 'Login gagal. Periksa kembali nama dan password.',
        ]);
    }

    public function logout()
    {
        auth()->logout();
        return redirect('/');
    }

    public function register()
    {
        // Jika sudah login, arahkan langsung ke home
        if (auth()->check()) {
            return redirect('/home');
        }
        return view('index');
    }

    public function create(Request $request)
    {
        $userData = $request->validate([
            'name' => ['required', 'min:3', 'max:45', Rule::unique('users', 'name')],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => ['required', 'min:6', 'max:16'],
        ]);

        $userData['password'] = bcrypt($userData['password']);
        $user = User::create($userData);

        auth()->login($user);
        return redirect('/home');
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $data = $request->validate([
            'name' => ['required', 'min:3', 'max:45', Rule::unique('users')->ignore($user->id)],
            'password' => ['required', 'min:6', 'max:16'],
        ]);

        $user->name = $data['name'];
        $user->password = bcrypt($data['password']);
        $user->save();

        // Logout user agar login ulang dengan data baru
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('message', 'Akun berhasil diperbarui. Silakan login kembali.');
    }

    public function delete(Request $request)
    {
        $user = auth()->user();

        auth()->logout(); // Logout user terlebih dahulu

        // Hapus user
        $user->delete();

        // Invalidasi session dan redirect
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('message', 'Akun Anda berhasil dihapus.');
    }

    public function index()
    {
        // Menampilkan hanya post milik user yang sedang login
        $posts = auth()->user()->userPosts()->latest()->get();
        return view('personal', compact('posts'));
    }

    public function indexAll()
    {
        // Menampilkan semua post
        $posts = Post::latest()->get();
        return view('home', compact('posts'));
    }
}
