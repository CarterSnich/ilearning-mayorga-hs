<?php

namespace App\Http\Controllers;

use App\Models\ClassActivity;
use App\Models\EmailSignup;
use App\Models\Mclass;
use App\Models\MclassStudent;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\StudentRegistration;
use App\Models\Submission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    // email confirmation
    public function store_email_signup(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'email' => ['required', 'email']
            ]
        );

        if ($validator->fails()) {
            return
                back()
                ->withErrors($validator->errors());
        }

        $email = $request->email;
        $token = random_int(100000, 999999) . "";

        // store entry to database
        EmailSignup::create([
            'email' => $email,
            'signup_token' => $token
        ]);

        Mail::send([], [], function ($message) use ($email, $token) {
            $message
                ->to($email)
                ->subject('iLearning Email Sign-up')
                ->setBody(
                    "Use this token to sign-up: <br> <h2>{$token}</h2>",
                    'text/html'
                );
        });

        return
            redirect()
            ->intended('/')
            ->with([
                'toast' => [
                    'type' => 'success',
                    'message' => 'Check your email inbox for sign-up token.'
                ]
            ]);
    }

    // store sign up
    public function store_signup(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'username' => ['required', 'unique:students,username'],
                'password' => ['required'],
                'password_confirmation' => ['required', 'same:password'],
                'lastname' => ['required'],
                'firstname' => ['required'],
                'middlename' => [],
                'section' => ['required'],
                'email' => ['required', 'email'],
                'phone_number' => ['required', 'regex:/09[0-9]{9}/'],
                'signup_token' => [
                    'required',
                    Rule::exists('email_signups')->where(function ($query) use ($request) {
                        return
                            $query->where('email', '=', $request->email)
                            ->where('signup_token', '=', $request->signup_token)
                            ->where('activated', '=', false);
                    })
                ],
                'aggreement' => ['required', 'accepted']
            ],
            [
                'username.unique' => 'Username already used.',
                'password_confirmation.same' => 'Password does not match.',
                'aggreement' => 'You have to agree with the Terms of Use and Privacy Policy.',
                'signup_token.exists' => 'Invalid token used, expired, or email not matched.'
            ]
        );

        // redirect back when validation failed
        if ($validator->fails()) {
            return
                back()
                ->withInput()
                ->withErrors($validator->errors());
        }

        $formFields = $request->all();
        $hashed_password = Hash::make($request->password);
        $formFields['password'] = $hashed_password;

        // redirect to index with error message when failed to store
        $student_registration = StudentRegistration::create($formFields);
        if (!$student_registration) {
            return
                redirect('/')
                ->with([
                    'toast' => [
                        'message' => 'Failed to sign up.',
                        'type' => 'error'
                    ]
                ]);
        }

        // redirect to login page
        return
            redirect('/?t=student')
            ->with([
                'toast' => [
                    'type' => 'success',
                    'message' => 'Sign-up recorded succesfully.'
                ]
            ]);;
    }

    // authenticate
    public function authenticate(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'username' => ['required', 'exists:students,username'],
                'password' => ['required']
            ]
        );


        if ($validator->fails()) {
            return
                redirect('/?t=student')
                ->withInput(['username'])
                ->withErrors([
                    'student_login' => 'Student username not found.'
                ]);
        }

        $credentials = [
            'username' => $request->username,
            'password' => $request->password
        ];

        if (Auth::guard('student')->attempt($credentials)) {
            $request->session()->regenerate();
            return
                redirect()
                ->intended('/student/classes');
        } else {
            return
                redirect('/?t=student')
                ->withErrors([
                    'student_login' => 'Invalid credentials.'
                ]);
        }
    }

    // logout
    public function logout(Request $request)
    {
        Auth::guard('student')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/?t=student');
    }

    // join class
    public function join(Request $request)
    {
        $class = Mclass::where('code', '=', $request->code)->first();

        if ($class) {
            $classStudent  = MclassStudent::create([
                'mclass_id' => $class->id,
                'student_id' => Auth::guard('student')->user()->id
            ]);

            if ($classStudent) {
                return redirect("/student/classes/{$class->id}");
            } else {
                return
                    redirect()
                    ->back()
                    ->with([
                        'toast' => [
                            'type' => 'warning',
                            'message' => 'Failed to join class.'
                        ]
                    ]);
            }
        } else {
            return
                redirect()
                ->back()
                ->with([
                    'toast' => [
                        'type' => 'warning',
                        'message' => 'No class matched the given code.'
                    ]
                ]);
        }
    }

    // submit work 
    public function submit_work(Request $request, Mclass $_, ClassActivity $classActivity)
    {
        $formInputs = $request->all();
        $formInputs['student_id'] = auth('student')->id();
        $formInputs['activity_id'] = $classActivity->id;

        $validator = Validator::make($formInputs, [
            'student_id' => ['required', 'exists:students,id'],
            'activity_id' => ['required', 'exists:class_activities,id'],
            'file' => ['nullable', 'file'],
        ]);

        if ($validator->failed()) {
            return
                redirect()
                ->back()
                ->withErrors($validator->errors())
                ->with([
                    'toast' => [
                        'type' => 'warning',
                        'message' => 'Please, check your inputs.'
                    ]
                ]);
        }


        if ($file = $request->file('file')) {
            $username = auth('student')->user()->username;
            $path = "submissions/{$username}/{$classActivity->id}/";
            $originalFilename = $file->getClientOriginalName();

            if ($file->storeAs($path, $originalFilename)) {
                $formInputs['file'] = $originalFilename;
            } else {
                return
                    redirect()
                    ->back()
                    ->with([
                        'toast' => [
                            'type' => 'warning',
                            'message' => 'Failed to upload file.'
                        ]
                    ]);
            }
        }


        if (Submission::create($formInputs)) {
            return redirect()->intended(
                $request->headers->get('referer')
            );
        } else {
            return
                redirect()
                ->back()
                ->with([
                    'toast' => [
                        'type' => 'warning',
                        'message' => 'Failed to upload file.'
                    ]
                ]);
        }
    }

    public function unsubmit_work(Request $request, Mclass $_, ClassActivity $classActivity)
    {
        $submission =
            Submission::where('student_id', '=', auth('student')->id())
            ->where('activity_id', '=', $classActivity->id)
            ->first();

        if ($submission) {
            if ($submission->delete()) {
                return
                    redirect()
                    ->intended("/student/classes/{$_->id}/activity/{$classActivity->id}");
            }
        }

        return
            redirect()
            ->back()
            ->with([
                'toast' => [
                    'type' => 'warning',
                    'message' => 'Failed to unsubmit work.'
                ]
            ]);
    }


    /*
     | --------------------------------
     |  PAGES
     | --------------------------------
     */

    //  classes
    public function classes()
    {
        return view('student.classes', [
            'classes' => MclassStudent::select('mclasses.*')
                ->rightJoin('mclasses', 'mclass_students.mclass_id', 'mclasses.id')
                ->where('mclass_students.student_id', '=', Auth::guard('student')->user()->id)
                ->get()
        ]);
    }

    public function class(Mclass $mclass)
    {
        return view('student.class', [
            'mclass' => $mclass,
            'activities' => ClassActivity::where('mclass_id', '=', $mclass->id)->get()
        ]);
    }

    public function classActivity(Request $request, Mclass $mclass, ClassActivity $classActivity)
    {
        $submission =
            Submission::where('student_id', '=', auth('student')->id())
            ->where('activity_id', '=', $classActivity->id)
            ->first();

        return view('student.view-activity', [
            'mclass' => $mclass,
            'classActivity' => $classActivity,
            'submission' => $submission
        ]);
    }
}
