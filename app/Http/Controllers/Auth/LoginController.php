<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;  // <-- HAPUS IMPORT INI (nggak dipakai lagi)
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    // Ganti: Pakai string langsung alih-alih RouteServiceProvider
    protected $redirectTo = '/dashboard';  // Default ke /dashboard (bisa ganti ke '/' atau route lain)

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    // Override: Redirect setelah login berdasarkan role (tetap pakai ini untuk custom)
    protected function redirectTo()
    {
        $user = Auth::user();
        if ($user->isAdmin()) {
            return '/products';  // Admin ke manajemen produk
        }
        return '/pos';  // Kasir ke POS utama
    }
}