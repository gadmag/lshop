<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Upload;

class UploadController extends Controller
{
    public function deleteFile($id)
    {

        $file =  Upload::find($id);
        Storage::disk('public')->delete('files/'.$file->filename);
        Storage::disk('public')->delete('files/thumbnail/'.$file->filename);
        Storage::disk('public')->delete('files/1250x700/'.$file->filename);
        Storage::disk('public')->delete('files/600x450/'.$file->filename);
        Storage::disk('public')->delete('files/400x300/'.$file->filename);
        $file->delete();
        return response(['status' => 'Delete success']);
    }

    public function uploadFile()
    {
        return 'success';
    }

}
