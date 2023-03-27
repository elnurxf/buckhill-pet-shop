<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBrandRequest;
use App\Http\Requests\UpdateBrandRequest;
use App\Http\Resources\BrandResource;
use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $limit = $request->filled('limit') ? $request->get('limit') : 10;
        $limit = abs(min($limit, 50));

        return BrandResource::collection(
            Brand::sortable($request)->paginate((int) $limit)->withQueryString()
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBrandRequest $request)
    {
        $validated = $request->validated();

        $brand = Brand::create($validated);

        return BrandResource::make($brand);
    }

    /**
     * Display the specified resource.
     */
    public function show(Brand $brand)
    {
        return BrandResource::make($brand);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBrandRequest $request, Brand $brand)
    {
        $validated = $request->validated();

        $brand->update($validated);

        return BrandResource::make($brand);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Brand $brand)
    {
        $brand->delete();

        return new JsonResponse([
            'success' => true,
            'error'   => null,
            'errors'  => [],
            'extra'   => [],
        ], Response::HTTP_OK);
    }
}
