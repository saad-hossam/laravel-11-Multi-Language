<?php
namespace App\Http\Controllers\Dashboard\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Http\Requests\StoreAdminRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;

class AuthController extends Controller implements HasMiddleware
{
    // تعريف الميدل وير على مستوى الكلاس
    public static function middleware(): array
    {
        return [
            new Middleware(middleware:'guest:admin',except:['logout']),
        ];
    }

    // عرض فورمة تسجيل الدخول
    public function showLoginForm()
    {
        return view('dashboard.auth.login');
    }

    // معالجة عملية تسجيل الدخول
    public function login(StoreAdminRequest $request)
    {
           // التحقق من القيم

        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember');

        // محاولة تسجيل الدخول
        if (Auth::guard('admin')->attempt($credentials, $remember)) {
            return redirect()->intended(route('dashboard.index'));
        }

        return redirect()->back()->with('error', 'Invalid Email or Password');
    }

    // معالجة عملية الخروج
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout(); // تسجيل خروج المستخدم
        $request->session()->invalidate(); // إبطال الجلسة
        $request->session()->regenerateToken(); // إعادة توليد توكن CSRF

        return redirect()->route('login')->with('success', 'Logged out successfully');
    }
}

