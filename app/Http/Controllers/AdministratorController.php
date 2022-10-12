<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdministratorController extends Controller
{

    // authenticate
    function authenticate(Request $request)
    {
        $credentials = Validator::make(
            $request->all(),
            [
                'username' => ['required', 'exists:administrators,username'],
                'password' => ['required']
            ],
            [
                'username.exists' => 'Username not found.'
            ]
        );

        if ($credentials->failed()) {
            return
                back()
                ->withInput(['username'])
                ->withErrors($credentials->errors());
        }

        if (Auth::guard('administrator')->attempt($credentials->validate())) {
            $request->session()->regenerate();
            return
                redirect()
                ->intended('/administration/dashboard');
        } else {
            return
                back()
                ->withErrors([
                    'login_error' => 'There was an error with your login.'
                ]);
        }
    }

    // logout
    public function logout(Request $request)
    {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/administration/login');
    }

    public function store_teacher(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'teacher_id' => ['required', 'unique:teachers,teacher_id'],
                'lastname' => ['required'],
                'firstname' => ['required'],
                'email' => ['required', 'email', 'unique:teachers,email'],
                'phone_number' => ['required']
            ],
            [],
            [
                'teacher_id' => 'Teacher ID'
            ]
        );

        if ($validator->fails()) {
            return back()
                ->withErrors($validator->errors())
                ->withInput();
        }

        $formValues = $request->all();
        $sanitized = ucfirst(str_replace(' ', '', $formValues['lastname']));
        $password = Hash::make($sanitized);
        $formValues['password'] = $password;

        Teacher::create($formValues);
        return
            back()
            ->with([
                'toast' => [
                    'type' => 'success',
                    'message' => 'Teacher added successfully.'
                ]
            ]);
    }
}
