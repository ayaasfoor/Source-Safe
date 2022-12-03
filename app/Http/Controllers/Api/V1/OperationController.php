<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\File;
use App\Models\Group;
use Illuminate\Http\Request;

class OperationController extends Controller
{
    /**
     * Add File To Group
     *
     */
    public function addFileToGroup(Request $request, File $file)
    {
        $request->validate([
            'group_id'     =>   'required|exists:groups,id|numeric'
        ]);
        $file->group_id = $request->group_id;
        $file->saveOrFail();
        return $file;
    }
    /**
     *  delete file from group
     */
    public function deleteFileFromGroup(File $file)
    {
        $file->group_id = null;
        $file->save();
        return $file ;
    }
    /**
     *Add Users TO Group
     *
     */
    public function addUserToGroup(Request $request, Group $group)
    {
        $request->validate([
            'users'     =>   'required|array|numeric'
        ]);
        $group->users()->sync($request->users);
        return $group->users;
    }
}