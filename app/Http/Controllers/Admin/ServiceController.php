<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ServiceRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Service;

class ServiceController extends Controller
{


    protected $options = [
        'engraving' => 'Гравировка',
        'fonts' => 'Шрифты',
    ];

    public function index(Request $request)
    {
        $type = $request->get('type')?:'engraving';
        $services = Service::getByType($type)->paginate(12);

        return view('AdminLTE.service.index')->with([
            'services' => $services,
            'type' => $type,
            'options' => $this->options,
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Request $request)
    {
        $type = $request->get('type')?:'engraving';
        return view('AdminLTE.service.create',[
            'type' => $type,
            'title' => $this->options[$type]
        ]);
    }

    /**
     * @param ServiceRequest $request
     * @param Service $service
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Service $service, ServiceRequest $request)
    {
        $service->create($request->all());
        return  redirect("admin/services")->with([
            'flash_message'  =>   "Услуга {$service->title} добавлена",
        ]);
    }


    /**
     * @param Service $service
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Service $service,Request $request)
    {
        $type = $request->get('type')?:'engraving';
        return view('AdminLTE.service.edit', [
            'service' => $service,
            'type' => $type,

        ]);
    }

    /**
     * @param Service $service
     * @param ServiceRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Service $service, ServiceRequest $request)
    {
        $service->update($request->all());
        return redirect("admin/services")->with([
            'flash_message'   =>   "Услуга {$service->title} обновлена",
        ]);
    }

    /**
     * @param Service $service
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Service $service)
    {

        $title = $service->title;
        $service->delete();
        return redirect("admin/services")->with([
            'flash_message'   =>   "Услуга {$title} удалена",
        ]);
    }

}
