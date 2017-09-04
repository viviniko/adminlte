<?php

namespace App\Http\Controllers\Permission;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Viviniko\Permission\Models\Role;
use Viviniko\Permission\Repositories\Permission\PermissionRepository;
use Viviniko\Permission\Repositories\Role\RoleRepository;
use Viviniko\Permission\Repositories\User\UserRepository;

/**
 * Class RoleController
 * @package App\Http\Controllers
 */
class RoleController extends Controller
{

	/**
	 * @var RoleRepository
	 */
	protected $roles;

    /**
     * @var PermissionRepository
     */
    protected $permissions;

	/**
	 * RolesController constructor.
     *
	 * @param RoleRepository $roles
     * @param PermissionRepository $permissions
	 */
	public function __construct(RoleRepository $roles, PermissionRepository $permissions)
    {
		// $this->middleware('permission:roles.manage');
		$this->roles = $roles;
		$this->permissions = $permissions;
	}

	/**
	 * Display page with all available roles.
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index()
    {
		$roles = $this->roles->getAllWithUsersCount();

		return view('permission.role.index', compact('roles'));
	}

	/**
	 * Display form for creating new role.
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function create()
    {
		$edit = false;
		$permissions = $this->getGroupedPermissions();

		return view('permission.role.add-edit', compact('edit', 'permissions'));
	}

	/**
	 * Store newly created role to database.
	 *
	 * @param Request $request
	 * @return mixed
	 */
	public function store(Request $request)
    {
	    $data = $request->all();
		$role = $this->roles->create($data);

        if (!empty($data['permissions']) && is_array($data['permissions']))
            $this->roles->updatePermissions($role->id, $data['permissions']);

		return redirect()->route('permission.roles.index')
			->withSuccess(trans('permission.role_created'));
	}

	/**
	 * Display for for editing specified role.
	 *
	 * @param Role $role
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function edit(Role $role)
    {
		$edit = true;
        $permissions = $this->getGroupedPermissions();

		return view('permission.role.add-edit', compact('edit', 'role', 'permissions'));
	}

	/**
	 * Update specified role with provided data.
	 *
	 * @param Role $role
	 * @param Request $request
	 * @return mixed
	 */
	public function update(Role $role, Request $request)
    {
	    $data = $request->all();

		$this->roles->update($role->id, $data);

		if (!empty($data['permissions']) && is_array($data['permissions']))
            $this->roles->updatePermissions($role->id, $data['permissions']);

		return redirect()->route('permission.roles.index')
			->withSuccess(trans('permission.role_updated'));
	}

	/**
	 * Remove specified role from system.
	 *
	 * @param Role $role
	 * @param UserRepository $userRepository
	 * @return mixed
	 */
	public function destroy(Role $role, UserRepository $userRepository)
    {
		if (!$role->removable) {
			throw new NotFoundHttpException();
		}

		$userRole = $this->roles->findByName('User');

		$userRepository->switchRolesForUsers($role->id, $userRole->id);

		$this->roles->delete($role->id);

		return redirect()->route('permission.roles.index')
			->withSuccess(trans('permission.role_deleted'));
	}

	protected function getGroupedPermissions()
    {
	    return $this->permissions->all()->groupBy(function($item, $key) {
            return studly_case(strpos($item->name, '.') === false ? 'other' : explode('.', $item->name, 2)[0]);
        });
    }

}