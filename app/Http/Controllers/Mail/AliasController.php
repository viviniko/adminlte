<?php

namespace App\Http\Controllers\Mail;

use Viviniko\Mail\Repositories\Alias\AliasRepository;
use Viviniko\Mail\Repositories\Domain\DomainRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AliasController extends Controller
{
    protected $aliasRepository;

    /**
     * AliasController constructor.
     * @param $aliasRepository
     */
    public function __construct(AliasRepository $aliasRepository)
    {
        $this->aliasRepository = $aliasRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $aliases = $this->aliasRepository->search([])->paginate();
        $aliases->load('domain');
        return view('mail.aliases.index', compact('aliases'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $edit = false;
        $domains = app(DomainRepository::class)->pluck('name', 'id');
        return view('mail.aliases.create-edit', compact('edit', 'domains'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->aliasRepository->create($request->all());
        $request->session()->flash('success', trans('mail.aliases.created'));
        return response()->json(['message' => 'OK']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $edit = true;
        $alias = $this->aliasRepository->find($id);
        $domains = app(DomainRepository::class)->pluck('name', 'id');
        return view('mail.aliases.create-edit', compact('edit', 'alias', 'domains'));
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
        $this->aliasRepository->update($id, $request->all());
        $request->session()->flash('success', trans('mail.aliases.updated'));
        return response()->json(['message' => 'OK']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->aliasRepository->delete($id);
        return back()->withSuccess(trans('mail.aliases.deleted'));
    }
}
