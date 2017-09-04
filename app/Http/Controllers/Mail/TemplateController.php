<?php

namespace App\Http\Controllers\Mail;

use Viviniko\Mail\Repositories\Template\TemplateRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TemplateController extends Controller
{
    protected $templateRepository;

    /**
     * TemplateController constructor.
     * @param $templateRepository
     */
    public function __construct(TemplateRepository $templateRepository)
    {
        $this->templateRepository = $templateRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $templates = $this->templateRepository->search([])->paginate(15);
        return view('mail.templates.index', compact('templates'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $edit = false;
        return view('mail.templates.create-edit', compact('edit'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->templateRepository->create($request->all());
        $request->session()->flash('success', trans('mail.templates.created'));
        return response()->json(['message' => 'OK']);
    }

    public function show($id)
    {
        $template = $this->templateRepository->find($id);
        return view('mail.templates.show', compact('template'));
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
        $template = $this->templateRepository->find($id);
        return view('mail.templates.create-edit', compact('edit', 'template'));
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
        $this->templateRepository->update($id, $request->all());
        $request->session()->flash('success', trans('mail.templates.updated'));
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
        $this->templateRepository->delete($id);
        return back()->withSuccess(trans('mail.templates.deleted'));
    }
}
