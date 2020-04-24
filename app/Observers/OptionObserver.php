<?php

namespace App\Observers;

use App\Option;
use Illuminate\Support\Facades\Storage;

class OptionObserver
{
    /**
     * Handle the option "created" event.
     *
     * @param \App\Option $option
     * @return void
     */
    public function created(Option $option)
    {
        //
    }

    /**
     * Handle the option "updated" event.
     *
     * @param \App\Option $option
     * @return void
     */
    public function updated(Option $option)
    {
        //
    }

    /**
     * Handle the option "deleted" event.
     *
     * @param \App\Option $option
     * @return void
     */
    public function deleted(Option $option)
    {
        if ($option->discount()->exists()){
            $option->discount()->first()->delete();
        }

        foreach ($option->files as $file) {
            Storage::disk('public')->delete('files/' . $file->filename);
            Storage::disk('public')->delete('files/thumbnail/' . $file->filename);
            Storage::disk('public')->delete('files/600x450/' . $file->filename);
            Storage::disk('public')->delete('files/250x250/' . $file->filename);
            Storage::disk('public')->delete('files/90x110/' . $file->filename);
            $file->delete();
        }
    }

    /**
     * Handle the option "restored" event.
     *
     * @param \App\Option $option
     * @return void
     */
    public function restored(Option $option)
    {
        //
    }

    /**
     * Handle the option "force deleted" event.
     *
     * @param \App\Option $option
     * @return void
     */
    public function forceDeleted(Option $option)
    {
        //
    }
}
