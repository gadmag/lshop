<?php

namespace Tests\Unit;

use App\Catalog;
use App\Http\Requests\ProductRequest;
use App\Services\Product\BaseQueries;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;
use App\Product;
use App\Special;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CacheProductTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;


    public function tearDown()
    {
        Cache::flush();
        parent::tearDown();
    }

    public function testCacheGetById()
    {
        $product = factory(Product::class)->create();
        $key = $product->getCacheKey();
        $query = resolve(BaseQueries::class);
        $query->getById($product->id);
        $this->assertEquals($product->id, Cache::get($key)->id);
        //get
        $productCache = $query->getById($product->id);
        $this->assertEquals($product->id, Cache::get($productCache->getCacheKey())->id);

    }

    public function testCacheGetByAlias()
    {
        $product = factory(Product::class)->create();
        $key = $product->getCacheKey();
        $query = resolve(BaseQueries::class);
        $query->getByAlias($product->alias);
        $this->assertEquals($product->id, Cache::get($key)->id);
        //get
        $productCache = $query->getByAlias($product->alias);
        $this->assertEquals($product->id, Cache::get($productCache->getCacheKey())->id);
    }

    public function testCacheGetAllByCatalog()
    {
        Cache::flush();
        $product = factory(Product::class)->create();
        $catalog = factory(Catalog::class)->create([
            'name' => $this->faker->word,
            'type' => $this->faker->word
        ]);
        $product->catalogs()->save($catalog);
        $products = factory(Product::class, 4)->create();
        $query = resolve(BaseQueries::class);
        $results = $query->getAllByCatalog($product, 4);
        $this->assertEquals(0, $results->count());
        $this->assertNull(Cache::get($products[0]->getCacheKey()));
        foreach ($products as $item) {
            $item->catalogs()->save($catalog);
        }
        $results = $query->getAllByCatalog($product, 4);
        $this->assertEquals(4, $results->count());
        $this->assertEquals($products[0]->id, Cache::get($products[0]->getCacheKey())->id);
        $this->assertEquals($products[3]->id, Cache::get($products[3]->getCacheKey())->id);
    }

    public function testCacheGetByCatalogFilter()
    {
        Cache::flush();
        $products = factory(Product::class, 3)->create([
            'title' => 'Fuck',
            'price' => 120
        ]);

        $query = resolve(BaseQueries::class);
        $results = $query->getByCatalogFilter();

        $this->assertEquals(3, $results->getCollection()->count());
        $this->assertTrue($products[0]->id === Cache::get($products[0]->getCacheKey())->id);

    }

    public function testCacheNewProducts()
    {
        Cache::flush();
        factory(Product::class, 8)->create();
        $query = resolve(BaseQueries::class);
        $results = $query->getNewProducts();
        $results = $query->getNewProducts();
        $this->assertEquals(8, $results->count());
        $this->assertTrue($results[0]->id === Cache::get($results[0]->getCacheKey())->id);
        $this->assertTrue($results[5]->id === Cache::get($results[5]->getCacheKey())->id);
    }

    public function testCacheSpecialProduct()
    {
        Cache::flush();
        factory(Product::class, 3)->create();
        $productOne = factory(Product::class)->create();
        $productTwo = factory(Product::class)->create();
        factory(Special::class)->create(['product_id' => $productOne->id]);
        factory(Special::class)->create(['product_id' => $productTwo->id]);
        $query = resolve(BaseQueries::class);
        $results = $query->getSpecialProducts();
        $this->assertEquals(2, $results->count());
        $this->assertEquals($results[0], Cache::get($results[0]->getCacheKey()));
    }

    public function testCacheUpdateProduct()
    {
        Cache::flush();
        $productOne = factory(Product::class)->create();
        $request = new ProductRequest();
        $request->merge([
            'title' => $this->faker->word,
            'price' => $this->faker->numberBetween(10, 200),
            'model' => $this->faker->word,
            'sku' => $this->faker->word,
            'status' => 1,
        ]);
        $key = $productOne->getCacheKey();
        Cache::put($key, $productOne, Carbon::now()->addDay());
        sleep(1);
        $query = resolve(BaseQueries::class);
        $result = $query->update($request, $productOne->id);
        $this->assertNotEquals($key, $result->getCacheKey());
        $this->assertNull(Cache::get($result->getCacheKey()));
    }

    public function testCacheCreateProduct()
    {
        Cache::flush();
        $user = factory(User::class)->create();
        $data = [
            'title' => $this->faker->word,
            'price' => $this->faker->numberBetween(10, 200),
            'model' => $this->faker->word,
            'sku' => $this->faker->word,
            'status' => 1,
            'user_id' => $user->id,
            'productOptions' => [
                [
                    'product_id' => 1,
                    'color' => $this->faker->word,
                    'color_stone' => $this->faker->word,
                    'price' => $this->faker->numberBetween(10, 200),
                    'weight' => $this->faker->numberBetween(10, 200),
                    'quantity' => 3
                ]
            ]
        ];
        $this->actingAs($user);
        $request = new ProductRequest();
        $request->merge($data);

        $query = resolve(BaseQueries::class);
        $product = $query->create($request);
        $this->assertEquals($data['title'], $product->title);
        $this->assertEquals($product, Cache::get($product->getCacheKey()));
    }

}
