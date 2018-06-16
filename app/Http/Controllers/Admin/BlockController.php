<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Block;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;

class BlockController extends Controller
{


   private $rules = [
                    'title' => 'required|min:3',
                   'region' => 'required',
                   'body' => 'required|min:3',
                    ];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {



        $blocks = Block::latest('created_at')->paginate(10);

//        dd($blocks);
        return view('AdminLTE.block.index')->with([
            'blocks' => $blocks,

        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Gate::denies('create-post', Articles::class)) {
            abort(403, 'Unauthorized action');

        }

        return view('AdminLTE.block.create');
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

        $block = new Block();
        $block->title = $request->input('title');
        $block->region = $request->input('region.0');
        $block->body = $request->input('body');
        $block->weight = $request->input('weight');
        $block->status = $request->input('status');
        $block->save();

        return  redirect("admin/blocks/")->with([
            'flash_message'               =>   "Блок добавлен",
//          'flash_message_important'     => true
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
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $block = Block::find($id);

        if (Gate::denies('update-post', $block)) {
            abort(403, 'Unauthorized action');

        }

        return view('AdminLTE.block.edit', [
            'block' => $block,

        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, $this->rules);

        $block = Block::find($id);

        $block->title = $request->input('title');
        $block->region = $request->input('region.0');
        $block->body = $request->input('body');
        $block->weight = $request->input('weight');
        $block->status = $request->input('status');
        $block->save();
       // $block->update($request->all());
        return redirect("admin/blocks")->with([
            'flash_message'               =>   "Блок обновлен",
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

        $block = Block::findOrFail($id);
//        dd()
        $blockTitle = $block->title;
        $block->delete();
        return redirect("admin/blocks")->with([
            'flash_message'               =>   "Блок {$blockTitle} удален",
//          'flash_message_important'     => true
        ]);
    }
}
