<?php

namespace App\Http\Controllers\Teacher\Command;

use App\Http\Controllers\Controller;
use App\Http\Requests\Teacher\CourseCreateRequest;
use App\Models\Course;
use App\Utils\Api\ApiResponse;
use App\Models\CourseCategory;

class CourseCreateController extends Controller
{
    use ApiResponse;

    public function store(CourseCreateRequest $request)
    {
        $course = Course::query()
            ->create([
                'title' => $request->title,
                'created_by' => $request->user()->id,   //sanctum paketi ile girish etmihsi userin id-sii alir
            ]);

        $this->storeCategories($request, $course->id);


        //save edende id-ni qaytarir
        return $this->createdResponse(
            [
                'course_id' => $course->id
            ]
        );
    }

    private function storeCategories(CourseCreateRequest $request, int $courseId): void
    {
        $insertCategories = [];

        foreach ($request->categories ?? [] as $category)
        {
            $insertCategories[] = [
                'course_id' => $courseId,
                'category_id' => $category,
            ];
        }

        CourseCategory::query()->insert($insertCategories);
    }
}
