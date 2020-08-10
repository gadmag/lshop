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

    protected $isWatermark;

    protected $path;

    /** Мультизвгрузка изображений
     * @param array $file
     * @param array $styles
     * @param bool $isWatermark
     * @return mixed
     */

    public function multipleUpload($file, $styles = array(), $isWatermark = false)
    {
//        $validator = Validator::make(array('file' => $file), $this->rules);
//        if (!$validator->passes()) {
//            return 'Invalid validation adding files';
//        }
//        dd($file);
        $this->isWatermark = $isWatermark;
        $this->path = storage_path('app/public/files');
        $filename = $this->getFileName($file->getClientOriginalName());
        Storage::disk('public')->put('files/' . $filename, file_get_contents($file));
        $mimetype = Storage::disk('public')->mimeType('files/' . $filename);
        $size = Storage::disk('public')->size('files/' . $filename);
        if (in_array($mimetype,['image/jpg','image/jpeg','image/gif','image/png'])){
            $this->createImgStyle($filename,$styles);
        }


        return array(
            'name' => $filename,
            'mime' => $mimetype,
            'size' => $size,
        );


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


    protected function createImgStyle(string $filename, array $styles): void
    {
        $imageStyle = array_merge($styles, ['thumbnail' => ['width' => 100, 'height' => 100]]);

        foreach ($imageStyle as $key => $value) {
            if (!Storage::disk('public')->has("files/$key")) {
                Storage::disk('public')->makeDirectory("files/$key", 777, true);
            }

            $img = Image::make($this->path . '/' . $filename)->fit($value['width'], $value['height'], function ($constraint) {
//                            $constraint->aspectRatio();
                $constraint->upsize();
            });

            $img->save($this->path . "/$key/" . $filename);
        }
        if ($this->isWatermark) {
            $this->watermark($filename, ['', '600x450']);
        }
    }

    protected function getFileName(string $originalName): string
    {
        $filename = pathinfo($originalName, PATHINFO_FILENAME);
        $extension = pathinfo($originalName, PATHINFO_EXTENSION);
        return md5(microtime()) . '_' . str_slug($filename, '_') . '.' . str_slug($extension, '_');
    }
}