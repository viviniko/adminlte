<?php

namespace App\Http\Controllers\Menu;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Viviniko\Menu\Enums\MenuLinkTarget;
use Viviniko\Menu\Models\Menu;
use Viviniko\Menu\Models\MenuItem;
use Viviniko\Menu\Repositories\Menu\MenuRepository;
use Viviniko\Menu\Repositories\MenuItem\MenuItemRepository;
use Viviniko\Permission\Repositories\Permission\PermissionRepository;

class MenuItemController extends Controller {

    protected $menus;

    protected $menuItems;

    protected $permissions;

    public function __construct(MenuRepository $menuRepository, MenuItemRepository $menuItemRepository, PermissionRepository $permissionRepository)
    {
        $this->menus = $menuRepository;
        $this->menuItems = $menuItemRepository;
        $this->permissions = ['' => trans('menu.public')] + $permissionRepository->lists()->all();
    }

    /**
     * Displays the page with all available menu items.
     *
     * @param Menu $menu
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Menu $menu)
    {
        return view('menu.item.index', compact('menu'));
    }

    /**
     * Displays the form for creating new menu.
     *
     * @param Menu $menu
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Menu $menu)
    {
        $edit = false;
        $permissions = $this->permissions;
        $targets = MenuLinkTarget::values();

        return view('menu.item.add-edit', compact('edit', 'menu', 'targets', 'permissions'));
    }

    /**
     * Store menu to database.
     *
     * @param Menu $menu
     * @param Request $request
     * @return mixed
     */
    public function store(Menu $menu, Request $request)
    {
        $data = $request->all();
        $data['menu_id'] = $menu->id;
        $data['sort'] = (int) $data['sort'];

        $menuItem = $this->menuItems->create($data);

        return redirect()->route('menu.items.list', $menu->id)
            ->withSuccess(trans('menu.created_successfully'));
    }

    /**
     * Displays the form for editing specific menu.
     *
     * @param MenuItem $menuItem
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(MenuItem $menuItem)
    {
        $edit = true;
        $permissions = $this->permissions;
        $targets = MenuLinkTarget::values();

        return view('menu.item.add-edit', compact('edit', 'menuItem', 'targets', 'permissions'));
    }

    /**
     * Update specified menu.
     *
     * @param MenuItem $menuItem
     * @param Request $request
     * @return mixed
     */
    public function update(MenuItem $menuItem, Request $request)
    {
        $data = $request->all();
        $data['sort'] = (int) $data['sort'];
        $this->menuItems->update($menuItem->id, $data);

        return redirect()->route('menu.items.list', $menuItem->menu->id)
            ->withSuccess(trans('menu.updated_successfully'));
    }

    /**
     * Destroy the menu if it is removable.
     *
     * @param MenuItem $menuItem
     * @return mixed
     * @throws \Exception
     */
    public function destroy(MenuItem $menuItem)
    {
        $this->menusItems->delete($menuItem->id);

        return redirect()->route('menu.menus.index')
            ->withSuccess(trans('menu.deleted_successfully'));
    }

    public function deleteAll(Request $request)
    {
        $ids = $request->get('ids');
        $this->menuItems->deleteAll($ids);

        return back()->withSuccess(trans('menu.deleted_successfully'));
    }

    public function tree(Menu $menu)
    {
        return response()->json($this->menuItems->getTreeByMenuId($menu->id));
    }

    public function move(Request $request)
    {
        $id = (int) $request->get('id');
        $parentId = (int) $request->get('parent_id');
        $sort = (int) $request->get('sort');
        $menuItem = $this->menuItems->find($id);
        if ($menuItem) {
            $this->menuItems->update($menuItem->id, [ 'parent_id' => $parentId, 'sort' => $sort ]);
        }

        return response()->json([ 'code' => 0 ]);
    }

}
