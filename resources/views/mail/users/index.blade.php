@extends('layouts.master')

@section('content_header')
    <h1>
        @lang('mail.users.users')
        <small>@lang('mail.users.users')</small>
    </h1>
    <ol class="breadcrumb">
        <li>
            <i class="fa fa-home home-icon"></i>
            <a href="/">@lang('app.dashboard')</a>
        </li>
        <li class="active">
            <a href="{{ route('mail.users.index') }}">@lang('mail.users.users')</a>
        </li>
    </ol>
@stop

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <div class="box-title">@lang('mail.users.users')</div>
            <div class="box-tools">
                <a href="{{ route('mail.users.create') }}" class="btn btn-success btn-sm" title="@lang('mail.users.create')" target="_modal">
                    @lang('mail.users.create')
                </a>
            </div>
        </div>
        <div class="box-body">
            <table class="table table-hover table-striped">
                <thead>
                <tr>
                    <th>#</th>
                    <th>@lang('mail.users.domain')</th>
                    <th>@lang('mail.users.email')</th>
                    <th>@lang('mail.users.role')</th>
                    <th>@lang('app.action')</th>
                </tr>
                </thead>
                <tbody>
                @forelse($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->domain->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->role }}</td>
                    <td>
                        <a href="{{ route('mail.users.edit', $user->id) }}" class="btn btn-primary btn-circle"
                        target="_modal" title="@lang('mail.users.edit')">
                            <i class="fa fa-pencil"></i>
                        </a>
                        <a href="{{ route('mail.users.destroy', $user->id) }}" class="btn btn-danger btn-circle"
                        data-method="DELETE">
                            <i class="fa fa-trash"></i>
                        </a>
                    </td>
                </tr>
                @empty
                    <tr>
                        <td colspan="5">@lang('app.no_records_found')</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
            {!! $users->links() !!}
        </div>
    </div>
@endsection
