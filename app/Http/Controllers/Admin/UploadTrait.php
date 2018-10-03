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

    protected $rules = ['file' => 'mimes:png,gif,jpeg,jpg'];

    /** Мультизвгрузка изображений
     * @param Request $request
     * @param $page
     * @param array $imageStyle
     * @return bool
     */

    public function multipleUpload(array $files, $page, $imageStyle = array(), $fieldName = "images")
    {

        if ($files) {
            foreach ($files as $file):
                $validator = Validator::make(array('file' => $file), $this->rules);
                if ($validator->passes()) {
                    $filename = md5(microtime()) . '-' . $file->getClientOriginalName();
                    $path = storage_path('app/public/files');
                    Storage::disk('public')->put('files/' . $filename, file_get_contents($file));
                    $mimetype = Storage::disk('public')->mimeType('files/' . $filename);
                    $imageStyle = array_merge($imageStyle, ['thumbnail' => ['width' => 100, 'height' => 100]]);
                    foreach ($imageStyle as $key => $value) {
                        if (!Storage::disk('public')->has("files/$key")) {
                            Storage::disk('public')->makeDirectory("files/$key", 777, true);
                        }
                        $img = Image::make($path . '/' . $filename)->resize($value['width'], $value['height'], function ($constraint) {
                            $constraint->aspectRatio();
                        });
                        $img->save($path . "/$key/" . $filename);
                    }
                    $image = Upload::create([
                        //'uploadstable_id' => $article->id,
                        'filename' => $filename,
                        'mime' => $mimetype,
                    ]);
                    $page->files()->save($image);

                } else {

                }

            endforeach;
        } else {
            return true;
        }
    }

}