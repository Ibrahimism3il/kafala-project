<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    // تسجيل الدخول
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // إذا كان المدير، بناءً على الإيميل
            if ($user->email === 'admin@example.com') {
                return redirect('/admin/dashboard');
            }

            // توجيه حسب الدور
            if ($user->role === 'kafel') {
                return redirect('/kafel/dashboard');
            } elseif ($user->role === 'orphan') {
                return redirect('/orphan/dashboard');
            } else {
                return redirect('/');
            }
        }

        return back()->withErrors(['email' => 'بيانات الدخول غير صحيحة'])->withInput();
    }

    //  تسجيل حساب جديد
    public function register(Request $request)
    {
        $role = $request->input('user_type');

        // التحقق الأساسي
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);

        //  تحقق إضافي لليتيم
        if ($role === 'orphan') {
            $request->validate([
                'age'            => 'required|numeric|min:1',
                'area'           => 'required|string|max:100',
                'gender'         => 'required|string|max:10',
                'social_status'  => 'required|in:يتيم الأب,يتيم الأبوين',
                'health_status'  => 'required|in:سليم,مريض',
            ]);
        }

        //  حفظ الوثيقة إن وجدت
        $documentPath = null;
        if ($request->hasFile('document')) {
            $documentPath = $request->file('document')->store('documents', 'public');
        }

        // رفع صورة الكافل أو اليتيم
        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('photos', 'public');
        }


        // إنشاء المستخدم
        $user = User::create([
            'name'           => $request->input('name'),
            'email'          => $request->input('email'),
            'password'       => Hash::make($request->input('password')),
            'role'           => $role,
            'age'            => $role === 'orphan' ? $request->input('age') : null,
            'area'           => $role === 'orphan' ? $request->input('area') : null,
            'gender'         => $role === 'orphan' ? $request->input('gender') : ($role === 'kafel' ? $request->input('kafel_type') : null),
            'kafel_type'     => $role === 'kafel' ? $request->input('kafel_type') : null, //  هذا هو السطر المهم
            'social_status'  => $role === 'orphan' ? $request->input('social_status') : null,
            'health_status'  => $role === 'orphan' ? $request->input('health_status') : null,
            'photo'          => $photoPath,
        ]);


        // إذا كان يتيم، أضف سجل إلى جدول orphans
        if ($role === 'orphan') {
            \App\Models\Orphan::create([
                'name'           => $request->input('name'),
                'age'            => $request->input('age'),
                'area'           => $request->input('area'),
                'gender'         => $request->input('gender'),
                'social_status'  => $request->input('social_status'),
                'health_status'  => $request->input('health_status'),
                //'document'       => $documentPath,
                'user_id'        => $user->id,
            ]);
        }

        //  تسجيل الدخول تلقائيًا
        Auth::login($user);

        //  التوجيه حسب الدور
        if ($role === 'kafel') {
            return redirect('/kafel/dashboard');
        } elseif ($role === 'orphan') {
            return redirect('/orphan/dashboard');
        } else {
            return redirect('/');
        }
    }


    //  تسجيل الخروج
    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('/');
    }
}
