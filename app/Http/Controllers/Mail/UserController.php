<?php

namespace App\Http\Controllers\Mail;

use Viviniko\Mail\Enums\UserRoles;
use Viviniko\Mail\Repositories\Domain\DomainRepository;
use Viviniko\Mail\Repositories\User\UserRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    protected $userRepository;

    /**
     * UserController constructor.
     * @param $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = $this->userRepository->search([])->paginate();
        $users->load('domain');
        return view('mail.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $edit = false;
        $domains = app(DomainRepository::class)->search([])->get()->pluck('name', 'id');
        $roles = UserRoles::values();
        return view('mail.users.create-edit', compact('edit', 'domains', 'roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->userRepository->create($request->all());
        $request->session()->flash('success', trans('mail.users.created'));
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
        $user = $this->userRepository->find($id);
        $domains = app(DomainRepository::class)->search([])->get()->pluck('name', 'id');
        $roles = UserRoles::values();
        return view('mail.users.create-edit', compact('edit', 'user', 'domains', 'roles'));
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
        $input = $request->all();
        if (is_null($input['password'])) {
            unset($input['password']);
        }
        $this->userRepository->update($id, $input);
        $request->session()->flash('success', trans('mail.users.updated'));
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
        $this->userRepository->delete($id);
        return back()->withSuccess(trans('mail.users.deleted'));
    }
}
