<?php

namespace App\Http\Controllers\Admin;

use App\Shipment;
use Illuminate\Http\Request;
use App\Http\Requests\ShipmentRequest;
use App\Http\Controllers\Controller;

class ShipmentController extends Controller
{

    use UploadTrait;


    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shipments = Shipment::order()->latest()->paginate(10);
        return view('AdminLTE.shipment.index', [
            'shipments' => $shipments
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('AdminLTE.shipment.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(ShipmentRequest $request)
    {
        $shipment = Shipment::create($request->except(['price_setting']));
        $shipment->price_setting = $request->input('price_setting','');
        $shipment->save();
        if ($request->file('images')) {
            $this->multipleUpload($request->file('images'), $shipment, []);
        }
        return redirect("admin/shipments/")->with([
            'flash_message' => "Доставка добавлена",
        ]);
    }


    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $shipment = Shipment::findOrFail($id);
        return view('AdminLTE.shipment.edit', [
            'shipment' => $shipment,
        ]);
    }

    /**Update the specified resource in storage.
     * @param ShipmentRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ShipmentRequest $request, $id)
    {
        $shipment = Shipment::findOrFail($id);
        $shipment->update($request->except(['price_setting']));
        $shipment->price_setting = $request->input('price_setting', '');
        $shipment->save();
        if ($request->file('images')) {
            $this->multipleUpload($request->file('images'), $shipment, []);
        }
        return redirect()->route('shipments.index', [
            'flash_message' => "Доставка  обновлена"
        ]);
    }

    /**Remove the specified resource from storage.
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $shipment = Shipment::findOrFail($id);
        $title = $shipment->title;
        $shipment->delete();

        return redirect()->route('shipments.index', [
            'flash_message' => "Страница {$title} удаленна"
        ]);
    }

}
