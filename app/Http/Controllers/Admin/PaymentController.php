<?php

namespace App\Http\Controllers\Admin;

use App\Payment;
use Illuminate\Http\Request;
use App\Http\Requests\PaymentRequest;
use App\Http\Controllers\Controller;

class PaymentController extends Controller
{

    use UploadTrait;


    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $payments = Payment::order()->latest()->paginate(10);
        return view('AdminLTE.payment.index', [
            'payments' => $payments
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('AdminLTE.payment.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(PaymentRequest $request)
    {
        $payment = Payment::create($request->all());
        if ($request->file('images')) {
            $this->multipleUpload($request->file('images'), $payment, []);
        }
        return redirect("admin/payments/")->with([
            'flash_message' => "Оплата добавлена",
        ]);
    }


    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $payment = Payment::findOrFail($id);
        return view('AdminLTE.payment.edit', [
            'payment' => $payment,
        ]);
    }

    /**Update the specified resource in storage.
     * @param PaymentRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(PaymentRequest $request, $id)
    {
        $payment = Payment::findOrFail($id);
        $payment->update($request->all());
        if ($request->file('images')) {
            $this->multipleUpload($request->file('images'), $payment, []);
        }
        return redirect()->route('payments.index', [
            'flash_message' => "Оплата  обновлена"
        ]);
    }

    /**Remove the specified resource from storage.
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $payment = Payment::findOrFail($id);
        $title = $payment->title;
        $payment->delete();

        return redirect()->route('payments.index', [
            'flash_message' => "Оплата {$title} удалена"
        ]);
    }

}
