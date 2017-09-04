<?php

namespace App\Http\Controllers\Permission;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Viviniko\Permission\Models\Permission;
use Viviniko\Permission\Repositories\Permission\PermissionRepository;

/**
 * Class PermissionController
 * @package App\Modules\User\Http\Controllers
 */
class PermissionController extends Controller
{
	/**
	 * @var PermissionRepository
	 */
	private $permissions;

	/**
	 * PermissionsController constructor.
     *
	 * @param PermissionRepository $permissions
	 */
	public function __construct(PermissionRepository $permissions)
    {
		// $this->middleware('permission:permissions.manage');
		$this->permissions = $permissions;
	}

	/**
	 * Displays the page with all available permissions.
	 *
     * @param  Request $request
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index(Request $request)
    {
        $search = $request->get('search');
        $permissions = $this->permissions->search($search)->paginate(10)->appends($search);

        return view('permission.permission.index',compact('permissions'));
	}

	/**
	 * Displays the form for creating new permission.
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function create()
    {
		$edit = false;

		return view('permission.permission.add-edit', compact('edit'));
	}

	/**
	 * Store permission to database.
	 *
	 * @param Request $request
	 * @return mixed
	 */
	public function store(Request $request)
    {
		$this->permissions->create($request->all());

		return redirect()->route('permission.permissions.index')
			->withSuccess(trans('permission.permission_created_successfully'));
	}

	/**
	 * Displays the form for editing specific permission.
	 *
	 * @param Permission $permission
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function edit(Permission $permission)
    {
		$edit = true;

		return view('permission.permission.add-edit', compact('edit', 'permission'));
	}

	/**
	 * Update specified permission.
	 *
	 * @param Permission $permission
	 * @param Request $request
	 * @return mixed
	 */
	public function update(Permission $permission, Request $request)
    {
		$this->permissions->update($permission->id, $request->all());

		return redirect()->route('permission.permissions.index')
			->withSuccess(trans('permission.permission_updated_successfully'));
	}

	/**
	 * Destroy the permission if it is removable.
	 *
	 * @param Permission $permission
	 * @return mixed
	 * @throws \Exception
	 */
	public function destroy(Permission $permission)
    {
		$this->permissions->delete($permission->id);

		return redirect()->route('permission.permissions.index')
			->withSuccess(trans('permission.permission_deleted_successfully'));
	}

}