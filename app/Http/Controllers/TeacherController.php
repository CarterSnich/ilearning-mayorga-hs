<?php

namespace App\Http\Controllers;

use App\Models\ClassActivity;
use App\Models\Mclass;
use App\Models\Student;
use App\Models\Submission;
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
                redirect('/?t=teacher')
                ->withErrors([
                    'student_login' => 'Invalid credentials.'
                ]);
        }
    }

    // logout
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
            'mclass' => $mclass,
            'classActivities' => ClassActivity::where('mclass_id', '=', $mclass->id)->get()
        ]);
    }

    public function create_activity(Mclass $mclass)
    {
        return view('teacher.create-activity', [
            'mclass' => $mclass
        ]);
    }

    // view activity
    public function view_activity(Mclass $mclass, ClassActivity $classActivity)
    {
        $submissions =
            Submission::join('students', 'submissions.student_id', '=', 'students.id')
            ->join('class_activities', 'submissions.activity_id', '=', 'class_activities.id')
            ->where('activity_id', '=', $classActivity->id)
            ->select([
                'submissions.*',
                'students.username',
                'students.lastname',
                'students.firstname',
                'students.middlename',
                'class_activities.score AS max_score'
            ])
            ->get();

        return view('teacher.view-activity', [
            'mclass' => $mclass,
            'classActivity' => $classActivity,
            'submissions' => $submissions
        ]);
    }


    /*
     * Routes
     */
    public function submit_activity(Request $request, Mclass $mclass)
    {
        $formValues = $request->all();
        $formValues['mclass_id'] = $mclass->id;

        $validator = Validator::make($formValues, [
            'mclass_id' => ['required', 'exists:mclass,id'],
            'title' => ['required'],
            'instructions' => ['nullable', 'json'],
            'module' => ['nullable', 'file'],
            'score' => ['required', 'integer'],
            'deadline' => ['required', 'date'],
            'status' => ['required', 'boolean']
        ]);


        if ($validator->failed()) {
            return
                redirect()
                ->back()
                ->withInput()
                ->withErrors($validator->errors())
                ->with([
                    'toast' => [
                        'type' => 'warning',
                        'message' => 'Please, check you inputs.'
                    ]
                ]);
        }

        if ($request->file('module')) {
            if ($request->file('module')->store('activity-modules')) {
                $formValues['module'] =  $request->file('module')->hashName();
            } else {
                return
                    redirect()
                    ->back()
                    ->withInput()
                    ->with([
                        'toast' => [
                            'type' => 'warning',
                            'message' => 'Failed to upload module.'
                        ]
                    ]);
            }
        }

        if ($classActivity = ClassActivity::create($formValues)) {
            return
                redirect("/teacher/classes/{$mclass->id}/activity/{$classActivity->id}");
        } else {
            return
                redirect()
                ->back()
                ->withInput()
                ->with([
                    'toast' => [
                        'type' => 'warning',
                        'message' => 'Failed to submit activity.'
                    ]
                ]);
        }
    }

    // update submission score
    public function update_score(Request $request, Mclass $_, ClassActivity $classActivity,  Submission $submission)
    {
        $submission->score = $request->score;
        $submission->save();

        return
            redirect()->intended($request->headers->get('referer'));
    }
}
