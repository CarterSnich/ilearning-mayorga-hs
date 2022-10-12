<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\StudentRegistration;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class AdministrationController extends Controller
{
    /**
     * Login page
     **/
    public function login()
    {
        return view('administration.login');
    }

    /**
     * Dashboard page
     **/
    public function dashboard(Request $request)
    {
        return
            view('administration.dashboard');
    }

    /**
     * Students page
     **/
    public function students(Request $request)
    {
        switch ($request->get('s')) {
            case 'enrolled':
                return view('administration.enrolled-students', [
                    'students' => Student::all()
                ]);
                break;

            case 'rejected':
                return view('administration.rejected-registrations', [
                    'registrations' => StudentRegistration::where('status', '=', 'rejected')->get()
                ]);
                break;

            default:
                return view('administration.pending-registrations', [
                    'registrations' => StudentRegistration::where('status', '=', 'pending')->get()
                ]);
                break;
        }
    }

    /**
     * Teachers page    
     **/
    public function teachers()
    {
        return view('administration.teachers', [
            'teachers' => Teacher::orderBy('teacher_id')->get()
        ]);
    }

    /**
     * Teachers Add page
     **/
    public function teachers_add()
    {
        return view('administration.teachers_add');
    }

    /**
     * Classes page
     **/
    public function classes()
    {
        return view('administration.classes');
    }


    /*
     | --------------------------------
     |      REQUESTS
     | --------------------------------
     */


    public function accept(Request $request)
    {
        $registration = StudentRegistration::where('id', '=', $request->registration_id)->first();
        $registration->status = 'enrolled';
        $registration->save();

        $student = Student::create($registration->toArray());

        Mail::send([], [], function ($message) use ($student) {
            $message
                ->to($student->email)
                ->subject('iLearning Student Sign-up')
                ->setBody(
                    "You can now sign-in.",
                    'text/html'
                );
        });

        return
            redirect()
            ->back()
            ->with([
                'toast' => [
                    'type' => 'success',
                    'message' => 'Student accepted successfully.'
                ]
            ]);
    }
}
