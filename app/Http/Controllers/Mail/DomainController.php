<?php

namespace App\Http\Controllers\Mail;

use Viviniko\Mail\Repositories\Domain\DomainRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DomainController extends Controller
{
    protected $domainRepository;

    /**
     * DomainController constructor.
     * @param $domainRepository
     */
    public function __construct(DomainRepository $domainRepository)
    {
        $this->domainRepository = $domainRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $domains = $this->domainRepository->search([])->get();
        return view('mail.domains.index', compact('domains'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $edit = false;
        return view('mail.domains.create-edit', compact('edit'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->domainRepository->create($request->all());
        $request->session()->flash('success', trans('mail.domains.created'));
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
        $domain = $this->domainRepository->find($id);
        $edit = true;
        return view('mail.domains.create-edit', compact('edit', 'domain'));
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
        $this->domainRepository->update($id, $request->all());
        $request->session()->flash('success', trans('mail.domains.updated'));
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
        $this->domainRepository->delete($id);
        return back()->withSuccess(trans('mail.domains.deleted'));
    }
}
