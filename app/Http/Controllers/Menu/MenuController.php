<?php

namespace App\Http\Controllers\Menu;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Viviniko\Menu\Models\Menu;
use Viviniko\Menu\Repositories\Menu\MenuRepository;

class MenuController extends Controller
{
    protected $menus;

    public function __construct(MenuRepository $menuRepository)
    {
        $this->menus = $menuRepository;
    }

    /**
     * Displays the page with all available menus.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $menus = $this->menus->all();

        return view('menu.index', compact('menus'));
    }

    /**
     * Displays the form for creating new menu.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $edit = false;

        return view('menu.add-edit', compact('edit'));
    }

    /**
     * Store menu to database.
     *
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        $this->menus->create($request->all());

        return redirect()->route('menu.menus.index')
            ->withSuccess(trans('menu.created_successfully'));
    }

    /**
     * Displays the form for editing specific menu.
     *
     * @param Menu $menu
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Menu $menu)
    {
        $edit = true;

        return view('menu.add-edit', compact('edit', 'menu'));
    }

    /**
     * Update specified menu.
     *
     * @param Menu $menu
     * @param Request $request
     * @return mixed
     */
    public function update(Menu $menu, Request $request)
    {
        $this->menus->update($menu->id, $request->all());

        return redirect()->route('menu.menus.index')
            ->withSuccess(trans('menu.updated_successfully'));
    }

    /**
     * Destroy the menu if it is removable.
     *
     * @param Menu $menu
     * @return mixed
     * @throws \Exception
     */
    public function destroy(Menu $menu)
    {
        $this->menus->delete($menu->id);

        return redirect()->route('menu.menus.index')
            ->withSuccess(trans('menu.deleted_successfully'));
    }

}
