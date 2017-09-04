@extends('layouts.master')

@section('page-title', trans('permission.permissions'))

@section('page-header')
    <h1>
        @lang('permission.permissions')
        <small>@lang('permission.permissions')</small>
    </h1>
    <ol class="breadcrumb">
        <li>
            <i class="ace-icon fa fa-home home-icon"></i>
            <a href="">@lang('app.home')</a>
        </li>
        <li class="active">@lang('permission.permissions')</li>
    </ol>
@endsection

@section('content')

    <div class="box box-warning">
        <div class="box-header with-border">
            <h3 class="box-title">@lang('permission.permissions')</h3>
            <div class="box-tools">
                <a href="{{ route('permission.permissions.create') }}" target="_modal" title="@lang('permission.add_permission')" class="btn btn-sm btn-success">
                    <i class="fa fa-plus"></i>
                    @lang('permission.add_permission')
                </a>
            </div>
        </div>
        <div class="box-body table-responsive no-padding" id="permission-table-wrapper">
            <table class="table table-hover">
                <thead>
                <th>@lang('permission.name')</th>
                <th>@lang('permission.display_name')</th>
                <th>@lang('permission.description')</th>
                <th class="text-center">@lang('app.action')</th>
                </thead>
                <tbody>
                @if (count($permissions))
                    @foreach ($permissions as $permission)
                        <tr>
                            <td>{{ $permission->name }}</td>
                            <td>{{ $permission->display_name }}</td>
                            <td>{{ $permission->description }}</td>
                            <td class="text-center">
                                <a href="{{ route('permission.permissions.edit', $permission->id) }}" target="_modal" class="btn btn-primary btn-circle"
                                   title="@lang('permission.edit_permission')" data-toggle="tooltip" data-placement="top">
                                    <i class="glyphicon glyphicon-edit"></i>
                                </a>
                                <a href="{{ route('permission.permissions.destroy', $permission->id) }}" class="btn btn-danger btn-circle"
                                   title="@lang('permission.delete_permission')"
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

@section('after-scripts-end')
    <script>
    </script>
@stop