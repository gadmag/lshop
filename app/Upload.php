<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;


class Upload extends Model
{
    protected $table = 'uploads';
    protected $fillable = ['uploadstable_id', 'uploadstable_type', 'mime', 'size', 'type', 'name','title','alt', 'order'];


    public function uploadstable()
    {
        return $this->morphTo();
    }


    /**
     * Remove file from all directories
     * @return bool|null
     */
    public function delete()
    {
        $storage = Storage::disk('uploads');
        $storage->delete($this->name);
        foreach ($storage->directories() as $directory){
            $storage->delete($directory.'/'.$this->name);
        }
        return parent::delete();
    }

    public function deleteAll($ids)
    {
       $uploads = $this->whereIn('id', $ids)->get();
       foreach ($uploads as $upload){
           $upload->delete();
       }
    }

}
