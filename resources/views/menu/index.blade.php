@extends('layouts.master')

@section('page-title', trans('menu.menus'))

@section('page-header')
    <h1>
        @lang('menu.menus')
        <small>@lang('menu.menus')</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('menu.menus.index') }}"><i class="fa fa-dashboard"></i> @lang('app.home')</a></li>
        <li class="active">@lang('menu.menus')</li>
    </ol>
@endsection

@section('content')

    <div class="box box-danger">
        <div class="box-header with-border">
            <h3 class="box-title">@lang('menu.available_system_menus')</h3>
            <div class="box-tools">
                <a href="{{ route('menu.menus.create') }}" title="@lang('menu.add_menu')" target="_modal" class="btn btn-sm btn-success">
                    <i class="fa fa-plus"></i>
                    @lang('menu.add_menu')
                </a>
            </div>
        </div>
        <div class="box-body table-responsive no-padding" id="users-table-wrapper">
            <table class="table table-hover">
                <thead>
                <th>@lang('menu.name')</th>
                <th>@lang('menu.display_name')</th>
                <th>@lang('menu.description')</th>
                <th class="text-center">@lang('app.action')</th>
                </thead>
                <tbody>
                @if (count($menus))
                    @foreach ($menus as $menu)
                        <tr>
                            <td>{{ $menu->name }}</td>
                            <td>{{ $menu->display_name }}</td>
                            <td>{{ $menu->description }}</td>
                            <td class="text-center">
                                <a href="{{ route('menu.items.list', $menu->id) }}" class="btn btn-primary btn-circle"
                                   title="@lang('menu.list_menu_items')" data-toggle="tooltip" data-placement="top">
                                    <i class="glyphicon glyphicon-list"></i>
                                </a>
                                <a href="{{ route('menu.menus.edit', $menu->id) }}" target="_modal" class="btn btn-primary btn-circle"
                                   title="@lang('menu.edit_menu')" data-toggle="tooltip" data-placement="top">
                                    <i class="glyphicon glyphicon-edit"></i>
                                </a>
                                <a href="{{ route('menu.menus.destroy', $menu->id) }}" class="btn btn-danger btn-circle"
                                   title="@lang('menu.delete_menu')"
                                   data-toggle="tooltip"
                                   data-placement="top"
                                   data-method="DELETE">
                                    <i class="glyphicon glyphicon-trash"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="4"><em>@lang('app.no_records_found')</em></td>
                    </tr>
                @endif
                </tbody>
            </table>
        </div>
    </div>

@stop
