<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Middleware\CheckStatus;
use App\Http\Resources\FileResource;
use App\Models\File;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OperationController extends Controller
{

    /**
     * Add File To Group
     *
     */
    public function addFileToGroup(Request $request, File $file)
    {
        //TODO::validate request
        $validator = Validator::make($request->all(), [
            'users'     =>   'required|array|numeric'
        ]);

        if ($validator->fails()) {
            $this->formatValidationErrors($validator);
        }


        //TODO::add file to group
        if ($this->checkUser($file, Group::findOrFail($request->group_id))) {
            $file->group_id = $request->group_id;
        }
        return new FileResource($file);
    }
    /**
     *  delete file from group
     */
    public function deleteFileFromGroup(File $file)
    {
        $file->group_id = null;
        $file->save();
        return $file;
    }
    /**
     *Add Users TO Group
     *
     */
    public function addUserToGroup(Request $request, Group $group)
    {
        //TODO::va request
        $validator = Validator::make($request->all(), [
            'users'     =>   'required|array|numeric'
        ]);

        if ($validator->fails()) {
            $this->formatValidationErrors($validator);
        }

        $group->users()->sync($request->users);
        return $group->users;
    }
    /**
     *check if user is creating file and group to add to group or delete it
     *
     */
    public function checkUser(File $file, Group $group)
    {
        return auth()->id() == $file->user_id and $file->user_id == $group->user_id;
    }
}