<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (!$request->expectsJson()) {
            // adminsitration
            if ($request->is('administration/*')) {
                return route('admin_login');
            }

            // teacher
            if ($request->is('teacher/*')) {
                return route('teacher_login');
            }

            // student
            if ($request->is('student/*')) {
                return route('student_login');
            }

            // index page
            return route('index');
        }
    }
}
