<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFileRequest;
use App\Http\Requests\StorFileRequest;
use App\Http\Requests\UpdateFileRequest;
use App\Http\Resources\FileResource;
use App\Models\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class FileController extends Controller
{
    public function __construct()
    {
        //TODO::midllware auth
    }
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
        return File::/* with('group')-> */paginate(11);
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
        if ($request->has('file')) {
            $fileRequest = $request->file;

            $path = $fileRequest->store('files-store', 'public');
        }
        DB::transaction(function () use ($request) {

            File::create([
                'name'          =>     $request->name,
                'slug'          =>     Str::slug($request->name, '-'),
                'path'          =>     $request->file,
                'group_id'      =>     $request->group_id,
                'status'        =>     $request->statuss
            ]);
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
        return new FileResource($file);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateFileRequest $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}