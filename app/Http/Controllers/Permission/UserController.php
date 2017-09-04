<?php

namespace App\Http\Controllers\Permission;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Viviniko\Permission\Enums\UserStatus;
use Viviniko\Permission\Models\User;
use Viviniko\Permission\Repositories\User\UserRepository;

class UserController extends Controller
{
    /**
     * @var \Viviniko\Permission\Repositories\User\UserRepository
     */
    protected $users;

    /**
     * UserController constructor.
     * @param \Viviniko\Permission\Repositories\User\UserRepository $userService
     */
    public function __construct(UserRepository $users)
    {
        $this->users = $users;
    }

    public function index(Request $request)
    {
        $users = $this->users->search($request->get('search'))->paginate()->appends($request->get('search'));
        $statuses = UserStatus::values();

        return view('permission.user.index', compact('users', 'statuses'));
    }

    public function create()
    {
        $edit = false;
        $statuses = UserStatus::values();

        return view('permission.user.modals.add-edit', compact('edit', 'statuses'));
    }

    public function store(Request $request)
    {
        $data = $request->all();

        if (trim($data['phone']) == '') {
            unset($data['phone']);
        }

        $this->users->create($data);

        return redirect()->route('permission.users.index')
            ->withSuccess(trans('permission.user_created'));
    }

    public function edit(User $user)
    {
        $edit = true;
        $statuses = UserStatus::values();

        return view('permission.user.modals.add-edit', compact('edit', 'user', 'statuses'));
    }

    public function update(User $user, Request $request)
    {
        $data = $request->all();

        if (trim($data['password']) == '') {
            unset($data['password']);
            unset($data['password_confirmation']);
        }

        if (trim($data['phone']) == '') {
            unset($data['phone']);
        }

        $this->users->update($user->id, $data);

        return redirect()->route('permission.users.index')
            ->withSuccess(trans('permission.user_updated'));
    }

    public function destroy(User $user)
    {
        if ($user->id == Auth::id()) {
            return redirect()->route('permission.users.index')
                ->withErrors(trans('permission.you_cannot_delete_yourself'));
        }

        $this->users->delete($user->id);

        return redirect()->route('permission.users.index')
            ->withSuccess(trans('permission.user_deleted'));
    }
}