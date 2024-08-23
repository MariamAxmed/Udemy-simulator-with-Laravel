<?php

namespace App\Http\Controllers\Teacher\Command;

use App\Http\Controllers\Controller;
use App\Http\Requests\Teacher\CourseCreateRequest;
use App\Http\Requests\Teacher\SectionRequest;
use App\Models\Course;
use App\Models\Section;
use App\Models\CourseCategory;
use App\Utils\Api\ApiResponse;

class CourseSectionController extends Controller
{
    use ApiResponse;
    public function store(SectionRequest $request, $course_id)
    {
        $checkCourse = Course::query()
            ->where('id', $course_id)
            ->where('created_by', $request->user()->id)
            ->exists();

        if(!$checkCourse)
        {
            return $this->notFoundResponse();
        }

        $section = Section::query()
            ->create([
                'course_id' => $course_id,
                'name' => $request->get('name'),
            ]);


        //save edende id-ni qaytarir
        return $this->createdResponse(
            [
                'section_id' => $section->id
            ]
        );
    }


}
