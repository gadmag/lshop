<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

/**
 * App\Upload
 *
 * @mixin \Eloquent
 * @property int $id
 * @property string $filename
 * @property string $title
 * @property string $alt
 * @property string $mime
 * @property string $type
 * @property int $uploadstable_id
 * @property string $uploadstable_type
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Upload whereAlt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Upload whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Upload whereFilename($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Upload whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Upload whereMime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Upload whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Upload whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Upload whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Upload whereUploadstableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Upload whereUploadstableType($value)
 */
class Upload extends Model
{
    protected $table = 'uploads';
    protected $fillable = ['uploadstable_id', 'uploadstable_type', 'mime', 'filename','title','alt', 'order'];

    public function uploadstable()
    {
        return $this->morphTo();
    }



}
