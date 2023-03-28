<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFileRequest;
use App\Http\Resources\FileResource;
use App\Models\File;

class FileController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFileRequest $request)
    {
        $upload = $request->file('file');

        $path = $upload->store('media', 'public');

        $file = File::create([
            'name' => $upload->hashName(),
            'path' => $path,
            'size' => $upload->getSize(),
            'type' => $upload->getMimeType(),
        ]);

        return FileResource::make($file);
    }

    /**
     * Display the specified resource.
     */
    public function show(File $file)
    {
        return FileResource::make($file);
    }

}
