<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', 'DashboardController@index');

    Route::group(['namespace' => 'Permission', 'as' => 'permission.'], function () {
        Route::resource('users', 'UserController');
    });

    Route::Group(['namespace'=>'Menu', 'as' => 'menu.'], function(){
        Route::resource('menus', 'MenuController');

        Route::get('menus/{menu}/items', 'MenuItemController@index')->name('items.list');
        Route::get('menus/{menu}/items/create', 'MenuItemController@create')->name('items.create');
        Route::get('menus/items/{menuItem}/edit', 'MenuItemController@edit')->name('items.edit');
        Route::post('menus/{menu}/items/store', 'MenuItemController@store')->name('items.store');
        Route::put('menus/items/{menuItem}/update', 'MenuItemController@update')->name('items.update');
        Route::delete('menus/items/deleteAll', 'MenuItemController@deleteAll')->name('items.delete');
        Route::get('menus/{menu}/items/tree', 'MenuItemController@tree')->name('items.tree');
        Route::post('menus/items/move', 'MenuItemController@move')->name('items.move');
    });

    Route::group(['namespace' => 'Mail', 'as' => 'mail.', 'prefix' => 'mail'], function () {
        Route::resource('templates', 'TemplateController');
        Route::resource('domains', 'DomainController', [
            'except' => ['show']
        ]);
        Route::resource('users', 'UserController', [
            'except' => ['show']
        ]);
        Route::resource('aliases', 'AliasController', [
            'except' => ['show']
        ]);
    });

    Route::group(['namespace' => 'Media', 'as' => 'media.', 'prefix' => 'medias'], function () {
        Route::get('/', 'MediaController@index')->name('medias.index');

        Route::post('upload', 'MediaController@upload')->name('medias.upload');
        Route::post('delete', 'MediaController@delete')->name('medias.delete');
        Route::delete('{media}', 'MediaController@destroy')->name('medias.destroy');

        Route::get('files', 'FileController@index')->name('files.index');
        Route::post('files/upload', 'FileController@upload')->name('files.upload');
        Route::post('files/mkdir', 'FileController@mkdir')->name('files.mkdir');
        Route::delete('files/rmdir', 'FileController@rmdir')->name('files.rmdir');
        Route::delete('files/delete', 'FileController@delete')->name('files.delete');
        Route::post('files/rename', 'FileController@rename')->name('files.rename');
    });
});
