<?php

namespace App\Http\Controllers;

use App\Models\Mclass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TeacherController extends Controller
{
    // store
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'teacher_id' => ['required', 'regex:[0-9]{7}'],
                'lastname' => ['required'],
                'firstname' => ['required'],
                'middlename' => [],
                'email' => ['required', 'email'],
                'phone_number' => ['required', 'regex:09[0-9]{9}'],
            ],
            [
                'teacher_id.regex' => ['Invalid Teacher ID format.'],
                'phone_number.regex' => ['Invalid phone number format.']
            ]
        );

        // redirect if validation failed
        if ($validator->fails()) {
            return
                back()
                ->withInput()
                ->withErrors($validator->errors());
        }
    }

    // authenticate
    function authenticate(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'teacher_id' => ['required', 'exists:teachers,teacher_id'],
                'teacher_password' => ['required']
            ],
            [
                'teacher_id.exists' => 'Teacher ID not found.'
            ]
        );

        if ($validator->fails()) {
            return
                back()
                ->withInput(['teacher_id'])
                ->withErrors([
                    'teacher_login' => 'Teacher ID not found.'
                ]);
        }

        $credentials = [
            'teacher_id' => $request->teacher_id,
            'password' => $request->teacher_password
        ];

        if (Auth::guard('teacher')->attempt($credentials)) {
            $request->session()->regenerate();
            return
                redirect()
                ->intended('/teacher/classes');
        } else {
            return
                back()
                ->withErrors([
                    'teacher_login' => 'Invalid credentials.'
                ]);
        }
    }

    public function logout(Request $request)
    {
        Auth::guard('teacher')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/?t=teacher');
    }


    /*
     * Pages
     */


    // classes
    public function classes()
    {
        return view('teacher.classes', [
            'classes' => Mclass::where('teacher', '=', Auth::guard('teacher')->id())->get()
        ]);
    }

    public function show_class(Mclass $mclass)
    {
        return view('teacher.class', [
            'mclass' => $mclass
        ]);
    }
}
