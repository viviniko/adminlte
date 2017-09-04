@extends('layouts.master')

@section('content_header')
    <h1>
        @lang('mail.domains.domains')
        <small>@lang('mail.domains.domains')</small>
    </h1>
    <ol class="breadcrumb">
        <li>
            <i class="fa fa-home home-icon"></i>
            <a href="/">@lang('app.dashboard')</a>
        </li>
        <li class="active">
            <a href="{{ route('mail.domains.index') }}">@lang('mail.domains.domains')</a>
        </li>
    </ol>
@stop

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <div class="box-title">@lang('mail.domains.domains')</div>
            <div class="box-tools">
                <a href="{{ route('mail.domains.create') }}" class="btn btn-success btn-sm" target="_modal"
                   title="@lang('mail.domains.create')">
                    @lang('mail.domains.create')
                </a>
            </div>
        </div>
        <div class="box-body">
            <table class="table table-hover table-striped">
                <thead>
                <tr>
                    <th>#</th>
                    <th>@lang('mail.domains.name')</th>
                    <th>@lang('app.action')</th>
                </tr>
                </thead>
                <tbody>
                @forelse($domains as $domain)
                <tr>
                    <td>{{ $domain->id }}</td>
                    <td>{{ $domain->name }}</td>
                    <td>
                        <a href="{{ route('mail.domains.edit', $domain->id) }}" class="btn btn-primary btn-circle"
                           target="_modal" title="@lang('mail.domains.edit')">
                            <i class="fa fa-pencil"></i>
                        </a>
                        <a href="{{ route('mail.domains.destroy', $domain->id) }}" class="btn btn-danger btn-circle" data-method="DELETE">
                            <i class="fa fa-trash"></i>
                        </a>
                    </td>
                </tr>
                @empty
                    <tr>
                        <td colspan="4">@lang('app.no_records_found')</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
@stop
