<?php


namespace App\Services;


trait Cacheable
{
    /**
     *  Уникальный ключ кэша для экземпляра модели
     */
    public function getCacheKey()
    {
        return sprintf("%s_%s_%s",
            get_class($this),
            $this->id,
            $this->updated_at->timestamp
        );
    }

}