@extends('layouts.master')

@section('page-title', trans('permission.roles'))

@section('page-header')
    <h1>
        @lang('permission.roles')
        <small>@lang('permission.available_system_roles')</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('permission.roles.index') }}"><i class="fa fa-dashboard"></i> @lang('app.home')</a></li>
        <li class="active">@lang('permission.roles')</li>
      </ol>
@endsection

@section('content')

    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">@lang('permission.available_system_roles')</h3>
            <div class="box-tools">
                <a href="{{ route('permission.roles.create') }}" target="_modal" title="@lang('permission.add_role')" class="btn btn-sm btn-success">
                    <i class="fa fa-plus"></i>
                    @lang('permission.add_role')
                </a>
            </div>
        </div>
        <div class="box-body table-responsive no-padding" id="users-table-wrapper">
            <table class="table table-hover">
                <thead>
                    <th>@lang('permission.name')</th>
                    <th>@lang('permission.display_name')</th>
                    <th>@lang('permission.users_with_this_role')</th>
                    <th class="text-center">@lang('app.action')</th>
                </thead>
                <tbody>
                    @if (count($roles))
                    @foreach ($roles as $role)
                    <tr>
                        <td>{{ $role->name }}</td>
                        <td>{{ $role->display_name }}</td>
                        <td>{{ $role->users_count }}</td>
                        <td class="text-center">
                            <a href="{{ route('permission.roles.edit', $role->id) }}" target="_modal" class="btn btn-primary btn-circle"
                                title="@lang('permission.edit_role')" data-toggle="tooltip" data-placement="top">
                                <i class="glyphicon glyphicon-edit"></i>
                            </a>
                            <a href="{{ route('permission.roles.destroy', $role->id) }}" class="btn btn-danger btn-circle"
                                title="@lang('permission.delete_role')"
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
