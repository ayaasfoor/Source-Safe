<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;

class OperationController extends Controller
{
    public function addFileToGroup(Request $request, File $file)
    {
        $request->validate([
            'group_id'     =>   'required|exists:groups,id|numeric'
        ]);
        $file->group_id = $request->group_id;
        $file->saveOrFail();
        return $file;
    }
}
