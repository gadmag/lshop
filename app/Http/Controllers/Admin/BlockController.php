<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Block;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use App\Services\Block\BlockService;

class BlockController extends Controller
{


    private $rules = [
        'title' => 'required|min:3',
        'region' => 'required',
        'body' => 'required|min:3',
    ];
    protected $regions = [
        'top_head' => 'Левый верхний блок',
        'footer' => 'Футер',
        'footer_bottom' => 'Нижний футер',
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $blocks = Block::latest('created_at')->paginate(10);
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

        return view('AdminLTE.block.create', [
            'regions' => $this->regions
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @param BlockService $blockService
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, BlockService $blockService)
    {
        $this->validate($request, $this->rules);
        $blockService->create($request->all());
        return redirect("admin/blocks/")->with([
            'flash_message' => "Блок добавлен",
//          'flash_message_important'     => true
        ]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
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
            'regions' => $this->regions
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(Request $request, $id, BlockService $blockService)
    {
        $this->validate($request, $this->rules);
        $block = $blockService->update($request->all(), $id);
        return redirect("admin/blocks")->with([
            'flash_message' => "Блок {$block->title} обновлен",
//          'flash_message_important'     => true
        ]);
    }

    /**
     *  Remove the specified resource from storage.
     * @param $id
     * @param BlockService $blockService
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id, BlockService $blockService)
    {
        $blockTitle = $blockService->delete($id);
        return redirect("admin/blocks")->with([
            'flash_message' => "Блок {$blockTitle} удален",
//          'flash_message_important'     => true
        ]);
    }
}
