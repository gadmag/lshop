<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\FieldOption;

class FieldOptionController extends Controller
{

    private $rules = [
        'name' => 'required|min:3',
        'type' => 'required',
        'order' => 'integer',
    ];

    protected $options = [
        'coating' => 'Цвет покрытия',
        'stone' => 'Цвет камня',
        'material' => 'Материал',
    ];

    public function index(Request $request)
    {
        $type = $request->get('type')?:'coating';
        $fieldOptions = FieldOption::whereType($type)->order()->latest('created_at')->paginate(12);

        return view('AdminLTE.fieldOption.index')->with([
            'fieldOptions' => $fieldOptions,
            'type' => $type,
            'options' => $this->options,
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Request $request)
    {
        $type = $request->get('type')?:'coating';
        return view('AdminLTE.fieldOption.create',[
            'type' => $type,
            'title' => $this->options[$type]
        ]);
    }

    /**
     * @param Request $request
     * @param FieldOption $fieldOption
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, $this->rules);
        $fieldOption =  new FieldOption();
        $fieldOption->create($request->all());
        return  redirect("admin/fieldOptions")->with([
            'flash_message'  =>   "Параметр {$fieldOption->name} добавлен",
        ]);
    }


    /**
     * @param FieldOption $fieldOption
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Request $request, FieldOption $fieldOption)
    {
        $type = $request->get('type')?:'coating';
        return view('AdminLTE.fieldOption.edit', [
            'fieldOption' => $fieldOption,
            'type' => $type,

        ]);
    }

    /**
     * @param FieldOption $fieldOption
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(FieldOption $fieldOption, Request $request)
    {
        $this->validate($request, $this->rules);
        $fieldOption->update($request->all());

        return redirect("admin/fieldOptions")->with([
            'flash_message'   =>   "Параметр опции обновлен",
        ]);
    }

    /**
     * @param FieldOption $fieldOption
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(FieldOption $fieldOption)
    {

        $title = $fieldOption->name;
        $fieldOption->delete();
        return redirect("admin/fieldOptions")->with([
            'flash_message'   =>   "Параметр опции {$title} удален",
        ]);
    }

}
