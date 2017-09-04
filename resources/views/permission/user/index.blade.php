@extends('layouts.master')

@section('title', trans('permission.users'))

@section('content_header')
    <h1>
        @lang('permission.users')
        <small>@lang('permission.available_users')</small>
    </h1>
    <ol class="breadcrumb">
        <li>
            <i class="fa fa-home home-icon"></i>
            <a href="/">@lang('app.dashboard')</a>
        </li>
        <li class="active">@lang('permission.available_users')</li>
    </ol>
@stop

@section('content')
    <div class="box box-primary">
        <div class="box-header">
            <h3 class="box-title">@lang('permission.users')</h3>
            <div class="box-tools pull-right">
                <a href="{{ route('permission.users.create') }}" target="_modal" title="@lang('permission.add_user')" class="btn btn-sm btn-success">
                    <i class="fa fa-plus"></i>
                    @lang('app.add')
                </a>
            </div>
        </div>
        <form name="search" id="filter-form" action="" method="get" role="search">
        <div class="box-body table-responsive no-padding">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>@lang('permission.name')</th>
                        <th>@lang('permission.email')</th>
                        <th>@lang('permission.phone')</th>
                        <th>@lang('permission.register_time')</th>
                        <th>@lang('permission.last_activity')</th>
                        <th>@lang('app.status')</th>
                        <th>@lang('app.action')</th>
                    </tr>
                    <tr class="filter">
                        <th>{!! Form::text('search[id]', request('search.id'), [ 'placeholder' => 'ID' ]) !!}</th>
                        <th>{!! Form::text('search[name]', request('search.name'), [ 'placeholder' => 'Name' ]) !!}</th>
                        <th>{!! Form::text('search[email]', request('search.email'), [ 'placeholder' => 'Email' ]) !!}</th>
                        <th>{!! Form::text('search[phone]', request('search.phone'), [ 'placeholder' => 'Phone' ]) !!}</th>
                        <th>{!! Form::text('search[created_at]', request('search.created_at')) !!}</th>
                        <th>{!! Form::text('search[log_date]', request('search[log_date]')) !!}</th>
                        <th>{!! Form::select('search[is_active]', $statuses, request('search.status'), [ 'placeholder' => 'Status' ]) !!}</th>
                        <th>
                            <button type="submit" class="btn btn-primary btn-circle">
                                <span class="fa fa-search"></span>
                            </button>
                            <a href="{{ route('permission.users.index') }}" class="btn btn-danger btn-circle" type="button" >
                                <span class="fa fa-remove"></span>
                            </a>
                        </th>
                    </tr>

                </thead>
                <tbody>
                    @if(count($users))
                        @foreach($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->phone }}</td>
                                <td>{{ $user->created_at }}</td>
                                <td>{{ $user->log_date }}</td>
                                <td><span class="label label-{{ $user->status_class }}">{{ $user->status }}</span></td>
                                <td>
                                    <a href="{{ route('permission.users.edit', $user->id) }}" target="_modal" class="btn btn-primary btn-circle"
                                       title="@lang('app.edit')" data-toggle="tooltip" data-placement="top">
                                        <i class="glyphicon glyphicon-edit"></i>
                                    </a>
                                    <a href="{{ route('permission.users.destroy', $user->id) }}" class="btn btn-danger btn-circle"
                                       title="@lang('app.delete')"
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
                            <td colspan="11">
                                <div class="text-center">@lang('app.no_records_found')</div>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
        </form>
        <div class="box-footer clearfix">
            <div class="box-tools pull-right">
                {{ $users->links() }}
            </div>
        </div>
    </div>
@stop

@push('js')
<script>
    $(function() {
        var $daterangeSelectors = $('input[name="search[created_at]"],input[name="search[log_date]"]');

        $daterangeSelectors.daterangepicker({
            autoUpdateInput: false,
            locale: {
                cancelLabel: 'Clear'
            }
        });

        $daterangeSelectors.on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
        });

        $daterangeSelectors.on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
        });
    });
</script>
@endpush
