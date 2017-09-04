<?php

use Illuminate\Database\Seeder;
use Viviniko\Menu\Models\Menu;
use Viviniko\Menu\Models\MenuItem;

class MenusTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
    {
		$menu = Menu::create([
			'name' => 'main',
            'display_name' => 'Main Menu',
			'description' => 'System menu.',
		]);

        $menuMail = MenuItem::create([
            'parent_id' => null,
            'menu_id' => $menu->id,
            'title' => 'Mail',
            'url' => '',
            'target' => '_self',
            'icon_class' => 'fa fa-envelope',
            'sort' => 1100,
        ]);

        MenuItem::create([
            'parent_id' => $menuMail->id,
            'menu_id' => $menu->id,
            'title' => 'Templates',
            'url' => 'mail/templates',
            'target' => '_self',
            'icon_class' => 'fa fa-circle-o',
            'sort' => 0,
        ]);

        MenuItem::create([
            'parent_id' => $menuMail->id,
            'menu_id' => $menu->id,
            'title' => 'Domains',
            'url' => 'mail/domains',
            'target' => '_self',
            'icon_class' => 'fa fa-circle-o',
            'sort' => 1,
        ]);

        MenuItem::create([
            'parent_id' => $menuMail->id,
            'menu_id' => $menu->id,
            'title' => 'Users',
            'url' => 'mail/users',
            'target' => '_self',
            'icon_class' => 'fa fa-circle-o',
            'sort' => 2,
        ]);

        MenuItem::create([
            'parent_id' => $menuMail->id,
            'menu_id' => $menu->id,
            'title' => 'Aliases',
            'url' => 'mail/aliases',
            'target' => '_self',
            'icon_class' => 'fa fa-circle-o',
            'sort' => 3,
        ]);

        $menuMedia = MenuItem::create([
            'parent_id' => null,
            'menu_id' => $menu->id,
            'title' => 'Mail',
            'url' => '',
            'target' => '_self',
            'icon_class' => 'fa fa-folder',
            'sort' => 1100,
        ]);

        MenuItem::create([
            'parent_id' => $menuMedia->id,
            'menu_id' => $menu->id,
            'title' => 'Medias',
            'url' => 'medias',
            'target' => '_self',
            'icon_class' => 'fa fa-circle-o',
            'sort' => 3,
        ]);

        MenuItem::create([
            'parent_id' => $menuMedia->id,
            'menu_id' => $menu->id,
            'title' => 'Files',
            'url' => 'medias/files',
            'target' => '_self',
            'icon_class' => 'fa fa-circle-o',
            'sort' => 3,
        ]);

        $menuPermission = MenuItem::create([
            'parent_id' => null,
            'menu_id' => $menu->id,
            'title' => 'Permission',
            'url' => '',
            'target' => '_self',
            'icon_class' => 'fa fa-key',
            'sort' => 1200,
        ]);

        MenuItem::create([
            'parent_id' => $menuPermission->id,
            'menu_id' => $menu->id,
            'title' => 'Users',
            'url' => 'users',
            'target' => '_self',
            'icon_class' => 'fa fa-users',
            'sort' => 0,
        ]);

        $menuSettings = MenuItem::create([
            'parent_id' => null,
            'menu_id' => $menu->id,
            'title' => 'Settings',
            'url' => '',
            'target' => '_self',
            'icon_class' => 'fa fa-cog',
            'sort' => 1300,
        ]);

        MenuItem::create([
            'parent_id' => $menuSettings->id,
            'menu_id' => $menu->id,
            'title' => 'Menus',
            'url' => 'menus',
            'target' => '_self',
            'icon_class' => 'fa fa-bars',
            'sort' => 0,
        ]);
	}
}
