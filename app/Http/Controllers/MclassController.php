<?php

namespace App\Http\Controllers;

use App\Models\Mclass;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class MclassController extends Controller
{
    // store
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => ['required'],
                'subject' => ['required'],
                'description' => ['required'],
                'class_color' => [
                    'required',
                    Rule::in(Mclass::$colors),
                ]
            ]
        );

        if ($validator->fails()) {
            return
                back()
                ->withErrors($validator->errors());
        }

        $formValues = $request->all();
        $formValues['teacher'] = Auth::guard('teacher')->user()->getAuthIdentifier();
        $formValues['code'] = Str::random(7);
        $mclass = Mclass::create($formValues);

        return
            redirect()
            ->intended("/teacher/classes/{$mclass->id}")
            ->with([
                'toast' => [
                    'type' => 'success',
                    'message' => 'Class added successfully.'
                ]
            ]);
    }
}
