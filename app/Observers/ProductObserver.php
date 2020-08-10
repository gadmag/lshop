<?php

namespace App\Observers;

use App\Product;
use Illuminate\Support\Facades\Storage;

class ProductObserver
{


    /**
     * Handle the product "created" event.
     *
     * @param \App\Product $product
     * @return void
     */
    public function creating(Product $product)
    {
    }

    /**
     * Handle the product "updated" event.
     *
     * @param \App\Product $product
     * @return void
     */
    public function updating(Product $product)
    {
        $product->sumOptionQty();
    }

    /**
     * Handle the product "deleted" event.
     *
     * @param Product $product
     * @throws \Exception
     */
    public function deleted(Product $product)
    {
        if ($product->productSeo()->exists()) {
            $product->getSeo()->delete();
        }

        if ($product->productSpecial()->exists()) {
            $product->getSpecial()->delete();
        }

        foreach ($product->productOptions as $option) {
            $option->delete();
        }

        foreach ($product->files as $file) {
            $file->delete();
        }
    }

    /**
     * Handle the product "restored" event.
     *
     * @param \App\Product $product
     * @return void
     */
    public function restored(Product $product)
    {
        //
    }

    /**
     * Handle the product "force deleted" event.
     *
     * @param \App\Product $product
     * @return void
     */
    public function forceDeleted(Product $product)
    {
        //
    }
}
