<?php

namespace App\Http\Controllers\Setting\Category;

use App\Http\Controllers\Controller;
use App\Http\Requests\Setting\CategoryStoreRequest;
use App\Models\Category;
use App\Utils\Api\ApiResponse;
use Carbon\Carbon;
use Illuminate\Http\Request;

class QueryController extends Controller
{
    use ApiResponse;

    public function index(Request $request)
    {
        $limit = $request->limit ?? 10;   //maks ne qeder data getirmeyidi
        $page = $request->page ?? 1;
        $offset = ($page - 1) * $limit;    //neceden bir oturmekdi

        $categories = Category::query()

            //table-a cixacaq datalar selecte yazilir
            ->select(
                'id',
                'name',
                'created_at'
            )
            ->whereNull('deleted_at');


        //filter hisse metod icinde ayrica funksiyaya cixarilib cagirildi
        $categories = $this->indexFilter($categories, $request);

        //front nece sehife cixarmalidi bilsin deye
        $total = $categories->count();

        $categories = $categories
            ->limit($limit)
            ->offset($offset)
            ->get();

        return $this->withDataResponse(
            [
                'categories' => $categories
            ]
        );

        return response([
            'message' => 'Ugurla getirildi',
            'data' => [
                'categories' => $categories,
            ],
            'meta' => [
                'limit' => $limit,
                'page' => $page,
                'total' => $total,
            ]
        ]);
    }

    private function indexFilter($categories, $request)
    {
        if ($request->name != null)
        {
            $categories = $categories->where('name', 'like', "%$request->name%");
        }

        if ($request->age != null)
        {
            $categories = $categories->where('name', 'like', "%$request->name%");
        }

        if ($request->created != null)
        {
            $categories = $categories->where('name', 'like', "%$request->name%");
        }

        if ($request->creator != null)
        {
            $categories = $categories->where('name', 'like', "%$request->name%");
        }

        return $categories;
    }

    public function get($id)
    {
        $category = Category::query()
            ->select(
                'id',
                'name',
                'created_at'
            )
            ->where('id', $id)
            ->first();

        if (!$category)
            return response([
                'message' => 'Not found',
                'data' => null
            ], 404);

        return $this->withDataResponse(
            [
                'category' => $category
            ]
        );

        return response([
            'message' => 'Retrivered successfully',
            'data' => [
                'category' => $category
            ]
        ]);
    }

    public function select()
    {
        $categories = Category::query()
            ->select(
                'id',
                'name',
            )
            ->get();

        return $this->withDataResponse(
            [
                'categories' => $categories
            ]
        );

        return response([
            'message' => 'Retrivered successfully',
            'data' => [
                'categories' => $categories
            ]
        ]);
    }
}
