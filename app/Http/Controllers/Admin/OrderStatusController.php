<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\OrderStatus;

class OrderStatusController extends Controller
{

    private $rules = [
        'name' => 'required|min:3',
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orderStatus = OrderStatus::paginate(12);

        return view('AdminLTE.orderStatus.index')->with([
            'orderStatus' => $orderStatus,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('AdminLTE.orderStatus.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, $this->rules);
        $orderStatus =  new OrderStatus();
        $orderStatus->create($request->all());
        return  redirect("admin/orderStatus")->with([
            'flash_message'  =>   "Статус {$orderStatus->name} добавлен",
        ]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $orderStatus = OrderStatus::findOrFail($id);
        return view('AdminLTE.orderStatus.edit', [
            'orderStatus' => $orderStatus,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(OrderStatus $orderStatus, Request $request)
    {
        $this->validate($request, $this->rules);
        $orderStatus->update($request->all());

        return redirect("admin/orderStatus")->with([
            'flash_message'   =>   "Статус {$orderStatus->name} обновлен",
        ]);
    }

    /**
     * Remove the specified resource from storage.
     * @param OrderStatus $orderStatus
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(OrderStatus $orderStatus)
    {
        $title = $orderStatus->name;
        if ($orderStatus->is_default){
            return redirect("admin/orderStatus")->with([
                'flash_message'   =>   "Статус по умолчанию неможет быть удален",
            ]);
        }

        $orderStatus->delete();
        return redirect("admin/orderStatus")->with([
            'flash_message'   =>   "Статус {$title} удален",
        ]);
    }
}
