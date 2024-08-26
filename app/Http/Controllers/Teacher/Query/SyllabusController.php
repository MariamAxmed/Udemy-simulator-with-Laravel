<?php

namespace App\Http\Controllers\Teacher\Query;

use App\Http\Controllers\Controller;
use App\Http\Requests\Teacher\CourseCreateRequest;
use App\Http\Requests\Teacher\WhatLearnRequest;
use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\CourseWhatLearn;
use App\Utils\Api\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use function Laravel\Prompts\select;

class CourseDetailController extends Controller
{
    use ApiResponse;
    public function get(Request $request, $course_id)
    {

        $course = Course::query()
            ->from('courses as c')
            ->select(
                'c.id',
                'c.title',
                'c.slug',
                'c.subtitle',
                'c.status',
                'ci.cover_img',
                'ci.description',
                'ci.price',
                'ci.currency_id',
                'ci.language_id',
            )
            ->leftJoin('course_infos as ci', 'c.id', '=', 'ci.course_id')

            ->where('c.id', $course_id)
            ->where('c.created_by', $request->user()->id)
            ->with('currency', 'language')   #Eager loading
            ->first();


        #2-ci yol LEFTJOIN ile. BU zaman WITH ishlenmir.  yeni Eager loading  olmur
        $course = Course::query()
            ->from('courses as c')
            ->select(
                'c.id',
                'c.title',
                'c.slug',
                'c.subtitle',
                'c.status',
                'ci.cover_img',
                'ci.description',
                'ci.price',
                'ci.currency_id',
                'ci.language_id',
                'cr.name as currency_name',
                'cr.code as currency_code',
            )
            ->leftJoin('course_infos as ci', 'c.id', '=', 'ci.course_id')
            ->leftJoin('currencies as cr', 'cr.id', '=', 'ci.course_id')

            ->where('c.id', $course_id)
            ->where('c.created_by', $request->user()->id)
            ->with('categories')
            ->first();

        if(!$course)
            return $this->notFoundResponse();

        return $this->withDataResponse(
            ['course' => $course]
        );
    }
}
