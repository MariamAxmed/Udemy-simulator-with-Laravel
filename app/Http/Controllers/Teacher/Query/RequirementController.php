<?php

namespace App\Http\Controllers\Teacher\Query;

use App\Http\Controllers\Controller;
use App\Http\Requests\Teacher\CourseCreateRequest;
use App\Http\Requests\Teacher\WhatLearnRequest;
use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\CourseWhatLearn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RequirementConditionController extends Controller
{
    public function get(Request $request, $course_id)
    {
        $course = Course::query()
            ->where('id', $course_id)
            ->where('created_by', $request->user()->id)
            ->exists();

        if (!$course)
            return $this->notFoundResponse();

        $learns = ::query()
            ->select(
                'id',
                'name'
            )
            ->where('course_id', $course_id)
            ->get();

        return $this->withDataResponse(
            ['learns' => $learns]
        );
    }
}
