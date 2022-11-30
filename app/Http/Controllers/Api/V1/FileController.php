<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFileRequest;
use App\Http\Requests\StorFileRequest;
use App\Http\Requests\UpdateFileRequest;
use App\Http\Resources\FileResource;
use App\Models\File;
use App\Models\History;
use Carbon\Carbon;
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

        return File::with('users')->paginate(7);
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
            $file = File::create([
                'name'          =>     $request->name,
                'slug'          =>     Str::slug($request->name, '-'),
                'path'          =>     $path,
                'status'        =>     $request->statuss
            ]);
            History::create([
                'user_id'       => /* auth()->id() */ 1,
                'file_id'       =>  $file->id,
                'type_user'     =>  'self',
                'type_operation' =>  'create',
                'date'          =>  Carbon::now()
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
    public function destroy($id)
    {
        //
    }
}