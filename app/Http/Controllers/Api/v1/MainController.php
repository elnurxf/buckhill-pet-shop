<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Http\Resources\PromotionResource;
use App\Models\Post;
use App\Models\Promotion;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class MainController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function promotions(Request $request)
    {
        $limit = $request->filled('limit') ? (int) $request->get('limit') : 10;
        $limit = abs(min($limit, 50));

        return PromotionResource::collection(
            Promotion::sortable($request)
                ->where(function (Builder $query) use ($request) {
                    if ($request->boolean('valid')) {
                        $query->valid();
                    }
                })
                ->simplePaginate($limit)
                ->withQueryString()
        );
    }

    /**
     * Display a listing of the resource.
     */
    public function blog(Request $request)
    {
        $limit = $request->filled('limit') ? (int) $request->get('limit') : 10;
        $limit = abs(min($limit, 50));

        return PostResource::collection(
            Post::sortable($request)->paginate($limit)->withQueryString()
        );
    }

    /**
     * Display the specified resource.
     */
    public function post(Post $post)
    {
        return PostResource::make($post);
    }
}
