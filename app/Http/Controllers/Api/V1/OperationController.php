<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
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
            'group_id'     =>   'required|numeric|exists:groups,id'
        ]);

        if ($validator->fails()) {
            $this->formatValidationErrors($validator);
        }


        //TODO::add file to group
        if ($this->checkUser($file, Group::findOrFail($request->group_id))) {
            $file->group_id = $request->group_id;
            $file->save();
        }
        return new FileResource($file);
    }
    /**
     *  delete file from group
     */
    public function deleteFileFromGroup(Request $request, File $file)
    {
        //TODO::validate request
        $validator = Validator::make($request->all(), [
            'users'     =>   'required|array|numeric'
        ]);

        if ($validator->fails()) {
            $this->formatValidationErrors($validator);
        }
        //TODO::remove file from group
        if ($this->checkUser($file, Group::findOrFail($request->group_id))) {
            $file->group_id = null;
            $file->save();
            return ['message'   =>   'the file is deleted from group successfuly'];
        }
    }
    /**
     *Add Users TO Group
     *
     */
    public function addUserToGroup(Request $request, Group $group)
    {
        //TODO::validate  request
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