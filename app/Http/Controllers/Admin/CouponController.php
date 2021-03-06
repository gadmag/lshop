<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CouponRequest;
use Illuminate\Http\Request;
use App\Coupon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;

class CouponController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $coupons = Coupon::latest('created_at')->paginate(10);

        return view('AdminLTE.coupon.index')->with([
            'coupons' => $coupons,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('AdminLTE.coupon.create');

    }

    /**
     * Store a newly created resource in storage.
     * @param CouponRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CouponRequest $request)
    {
        $coupon = Coupon::create($request->all());

        return  redirect()->route('coupons.index')->with([
            'flash_message' =>   "Купон {$coupon->name} добавлен",
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     * @param $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $coupon = Coupon::findOrFail($id);
        return view('AdminLTE.coupon.edit', [
            'coupon' => $coupon,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CouponRequest $request, $id)
    {
        $coupon = Coupon::findOrFail($id);
        $coupon->update($request->all());
        return redirect("admin/coupons")->with([
            'flash_message'               =>   "Купон обновлен",
//          'flash_message_important'     => true
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $coupon = Coupon::findOrFail($id);

        $blockTitle = $coupon->title;
        $coupon->delete();
        return redirect("admin/coupons")->with([
            'flash_message'               =>   "Купон {$blockTitle} удален",
//          'flash_message_important'     => true
        ]);
    }
}
