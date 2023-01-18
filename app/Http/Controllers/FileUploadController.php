<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileUploadController extends Controller
{
    public function upload(Request $request){
        // handle file upload from filepond vue component
        $file = $request->file('file');
        $filename =$file->getClientOriginalName();
        //replace spaces with underscores
        $filename = str_replace(' ', '_', $filename);
        $filename = time().'_'.$filename;
        $path = $file->storeAs('public/uploads', $filename);
        return response()->json(['filename' => $filename]);
    }

    public function remove(Request $request){
        // handle file remove from filepond vue component
        $filename = $request->input('filename');
        $path = 'public/uploads/'.$filename;
        if(Storage::exists($path)){
            Storage::delete($path);
        }
        return response()->json(['filename' => $filename]);
    }
}
