<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Admin\UploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Upload;

class UploadController extends Controller
{
    use UploadTrait;

    private $imgResize = [
        '600x450' => array('width' => 500, 'height' => 500),
        '250x250' => array('width' => 260, 'height' => 260),
        '90x110' => array('width' => 110, 'height' => 110)
    ];

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

    public function uploadFiles(Request $request)
    {
        $files = $request->file('files');
        $uploads = array();
        foreach ($files as $file) {
            $uploaded_file = $this->multipleUpload($file, $this->imgResize, true);
            if (is_array($uploaded_file)) {
                $uploads[] = Upload::create($uploaded_file);
            }
        }
        return ['uploads' => $uploads];
    }

}
