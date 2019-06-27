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
     * @param array $files
     * @param $page
     * @param array $imageStyle
     * @param bool $watermark
     * @return bool
     */

    public function multipleUpload(array $files, $page, $imageStyle = array(), $isWatermark = false)
    {
        if ($files) {
            foreach ($files as $file):
                $validator = Validator::make(array('file' => $file), $this->rules);
                if ($validator->passes()) {
                    $filename = md5(microtime()) . '_' . str_slug($file->getClientOriginalName(),'_');
                    $path = storage_path('app/public/files');
                    Storage::disk('public')->put('files/' . $filename, file_get_contents($file));
                    $mimetype = Storage::disk('public')->mimeType('files/' . $filename);
                    $imageStyle = array_merge($imageStyle, ['thumbnail' => ['width' => 100, 'height' => 100]]);

                    foreach ($imageStyle as $key => $value) {
                        if (!Storage::disk('public')->has("files/$key")) {
                            Storage::disk('public')->makeDirectory("files/$key", 777, true);
                        }

                        $img = Image::make($path . '/' . $filename)->fit($value['width'], $value['height'], function ($constraint) {
//                            $constraint->aspectRatio();
                            $constraint->upsize();
                        });

                        $img->save($path . "/$key/" . $filename);
                    }
                    if ($isWatermark) {
                        $this->watermark($filename, ['', '600x450']);
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

    protected function watermark($filename, $imgStyles)
    {
        $resizePercentage = 20;
        $watermark = Image::make(public_path() . '/watermark.png');
        foreach ($imgStyles as $style) {
            $img = Image::make(storage_path("app/public/files/$style/") . $filename);
            $watermarkSize = round($img->width() * ((100 - $resizePercentage) / 100), 2);
            $watermark->resize($watermarkSize, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $img->insert($watermark, 'center');
            $img->save();
        }

    }


}