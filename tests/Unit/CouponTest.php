<?php

namespace Tests\Unit;

use App\Coupon;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CouponTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /**
     *
     */
    public function testStatusActive()
    {
        factory(Coupon::class, 2)->create([
            'status' => 1
        ]);
        $this->assertTrue(count(Coupon::active()->get()) > 0);
    }

    /**
     *
     */
    public function testStatusNotActive()
    {
        factory(Coupon::class, 2)->create([
            'status' => 0
        ]);
        $this->assertTrue(count(Coupon::active()->get()) == 0);
    }


    public function testIsUses()
    {
        factory(Coupon::class, 2)->create([
            'uses_total' => 5
        ]);

        $this->assertTrue(count(Coupon::isUses()->get()) > 0);
    }

    public function testNotUsesTotal()
    {
        factory(Coupon::class, 2)->create([
            'uses_total' => 0
        ]);

        $this->assertTrue(count(Coupon::isUses()->get()) == 0);
    }

    public function testBetweenDate()
    {
        $coupon = factory(Coupon::class)->create([
            'date_start' => Carbon::now(),
            'date_end' => Carbon::now()->addDay()
        ]);

        $this->assertTrue(count(Coupon::betweenDate()->get()) > 0);

        $coupon->date_end = Carbon::now()->subDay();
        $coupon->save();
        $this->assertTrue(count(Coupon::betweenDate()->get()) == 0);

    }

    public function testGetByCode()
    {
        $coupon = factory(Coupon::class)->create();
        $couponFind = new Coupon();
        $this->assertEquals($coupon->name, $couponFind->getByCode($coupon->code)->name);

        $code = $coupon->code;
        $coupon->code = $this->faker->word;
        $coupon->save();
        $this->assertEquals(null, $couponFind->getByCode($code));
    }
}
