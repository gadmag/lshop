<?php


namespace App\Http\Controllers;
use Illuminate\Support\Facades\Mail;
use Validator;
use Illuminate\Http\Request;

class SubscriberController extends Controller
{
    public function sendOrder(Request $request)
    {
        $this->validate($request, [
           'name' => 'required|min:3',
            'email' => 'required|email',
            'telephone' => 'required',
        ]);

        Mail::send('emails.order', [
            'name' => $request->name,
            'email' => $request->email,
            'title_product' => $request->title_product,
            'telephone' => $request->telephone,
            'description' => $request->description,

        ],

            function ($message)
        {
           // $message->to('info@rada-stroy.com', 'Рада-строй')->subject('Заказ с сайта rada-stroy.com');
            $message->to('gadjim4@gmail.com', 'Рада-строй')->subject('Заказ с сайта rada-stroy.com');
        });

      return  view('partials.successForm',['formTitle' => 'Форма заказа', 'message' => 'Ваш заказ принят']);
    }


    public function sendBackCall(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:3',
            'telephone' => 'required',

        ]);

        Mail::send('emails.call', [
            'name' => $request->name,
            'telephone' => $request->telephone,
            'date' => $request->date,

        ],

            function ($message)
            {
                $message->to('info@rada-stroy.com', 'Рада-строй')->subject('Обратный звонок с сайта rada-stroy.com');
            });

        return  view('partials.successForm',['formTitle' => 'Обратный звокок', 'message' => 'Ваш запрос принят']);
    }
}