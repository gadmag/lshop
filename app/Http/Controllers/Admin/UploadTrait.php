<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Upload;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;

use Image;
use File;
use Validator;

trait UploadTrait
{

    protected $rules = ['file' => 'mimes:png,gif,jpeg'];

    /** Мультизвгрузка изображений
     * @param Request $request
     * @param $page
     * @param array $imageStyle
     * @return bool
     */

    public function multipleUpload(Request $request, $page, $imageStyle = array())
    {
       // dd($imageStyle);
        $files = Input::file('images');

        if ($files) {
            foreach ($files as $file):

                $validator = Validator::make(array('file' => $file), $this->rules);


                if ($validator->passes()) {

                    $filename = md5(microtime()) . '-' . $file->getClientOriginalName();
                    $path = storage_path('app/public/files');
                    Storage::disk('public')->put('files/' . $filename, file_get_contents($file));
                    $mimetype = Storage::disk('public')->mimeType('files/' . $filename);


                    $img = Image::make($path . '/' . $filename)->resize(100, 100);
                    $img->save($path . '/thumbnail/' . $filename);

                    foreach ($imageStyle as $key => $value)
                    {
                        $img = Image::make($path . '/' . $filename)->resize($value['width'], $value['height'], function ($constraint){
                            $constraint->aspectRatio();
                        });
                        $img->save($path . "/$key/" . $filename);
                    }
                    $image = Upload::create([
                        //'uploadstable_id' => $article->id,
                        'filename' => $filename,
                        'mime' => $mimetype,
                    ]);
//                    dd($image);
                    $page->files()->save($image);

                } else {

                }

            endforeach;
        }else {
            return true;
        }
    }

}