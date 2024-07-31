<?php

namespace App\Http\Controllers\Setting\Category;

use App\Http\Controllers\Controller;
use App\Http\Requests\Setting\CategoryStoreRequest;
use App\Models\Category;
use App\Utils\Api\ApiResponse;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CommandController extends Controller
{
    use ApiResponse;
    public function store(CategoryStoreRequest $request)
    {
        $check = Category::query()
            ->where('name', $request->name)
            ->exists();

        if ($check)
            return response([
                'message' => 'Bu kateqoriya movcuddur'
            ], 400);

        $category = Category::query()
            ->create([
                'name' => $request->name
            ]);

        return $this->createdResponse([
            'id' => $category->id
        ]);

        return response([
            'message' => 'Ugurla yaradildi',
            'data' => [
                'id' => $category->id
            ]
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $check = Category::query()
            ->where('name', $request->name)
            ->where('id', '!=', $id)
            ->exists();

        if ($check)
            return response([
                'message' => 'Bu kateqoriya movcuddur'
            ], 400);

        Category::query()
            ->where('id', $id)
            ->update([
                'name' => $request->name
            ]);

        return $this->updatedResponse();

        return response([
            'message' => 'Ugurla yenilendi',
            'data' => null
        ]);
    }

    public function delete($id)
    {
        $category = Category::query()
            ->where('id', $id)
            ->first();

        if (!$category)
            return response([
                'message' => 'Tapilmadi',
                'data' => null
            ], 404);

        $category->update([
            'deleted_at' => now()
        ]);

        return $this->deletedResponse();

        return response([
            'message' => 'Ugurla silindi',
            'data' => null
        ]);
    }
}
