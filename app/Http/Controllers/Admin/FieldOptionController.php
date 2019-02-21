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
    ];

    public function index()
    {

        $fieldOptions = FieldOption::orderBy('type')->latest('created_at')->paginate(12);

        return view('AdminLTE.fieldOption.index')->with([
            'fieldOptions' => $fieldOptions,
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('AdminLTE.fieldOption.create');
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
    public function edit(FieldOption $fieldOption)
    {

        return view('AdminLTE.fieldOption.edit', [
            'fieldOption' => $fieldOption,

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
            'flash_message'   =>   "Параметр обновлен",
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
            'flash_message'   =>   "Блок {$title} удален",
        ]);
    }

}
