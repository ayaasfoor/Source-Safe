<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFileRequest;
use App\Http\Requests\UpdateFileRequest;
use App\Http\Resources\FileResource;
use App\Models\File;
use App\Models\History;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class FileController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        /**
         * Lazy load by pagination
         * increase performance by with
         */
        $this->authorize('viewAny', File::class);

        return File::with('group')->paginate(7);
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFileRequest $request)
    {
        //store path file
        if ($request->has('path')) {
            $fileRequest = $request->path;
            $path = $fileRequest->store('files-store', 'public');
        }

        DB::transaction(function () use ($request, $path) {

            $file = new File();
            $file->name = $request->name;
            $file->slug = Str::slug($request->name, '-');
            $file->path = $path;
            $file->user_id = auth()->id();
            $file->saveOrFail();
            $file->users()->attach(auth()->id(), ['type_operation' => 'create']);
        });


        return response()->json('the file is stored');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(File $file)
    {
        return $file->users;
        return new FileResource($file);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateFileRequest $request, File $file)
    {
        $file->group_id = $request->group_id;
        $file->save();
        return $file;

        /*    dd($file->group->name); */
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(File $file)
    {
        //Log::info();

        $this->authorize('delete', $file);
        $file->delete();
        return response()->json('file has deleted');
    }
}