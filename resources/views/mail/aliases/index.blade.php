@extends('layouts.master')

@section('content_header')
    <h1>
        @lang('mail.aliases.aliases')
        <small>@lang('mail.aliases.aliases')</small>
    </h1>
    <ol class="breadcrumb">
        <li>
            <i class="fa fa-home home-icon"></i>
            <a href="/">@lang('app.dashboard')</a>
        </li>
        <li class="active">
            <a href="{{ route('mail.aliases.index') }}">@lang('mail.aliases.aliases')</a>
        </li>
    </ol>
@stop

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <div class="box-title">@lang('mail.aliases.aliases')</div>
            <div class="box-tools">
                <a href="{{ route('mail.aliases.create') }}" class="btn btn-success btn-sm" target="_modal"
                   title="@lang('mail.aliases.create')">
                    @lang('mail.aliases.create')
                </a>
            </div>
        </div>
        <div class="box-body">
            <table class="table table-hover table-striped">
                <thead>
                <tr>
                    <th>#</th>
                    <th>@lang('mail.aliases.domain')</th>
                    <th>@lang('mail.aliases.source')</th>
                    <th>@lang('mail.aliases.destination')</th>
                    <th>@lang('app.action')</th>
                </tr>
                </thead>
                <tbody>
                @forelse($aliases as $alias)
                <tr>
                    <td>{{ $alias->id }}</td>
                    <td>{{ $alias->domain->name }}</td>
                    <td>{{ $alias->source }}</td>
                    <td>{{ $alias->destination }}</td>
                    <td>
                        <a href="{{ route('mail.aliases.edit', $alias->id) }}" class="btn btn-primary btn-circle"
                           target="_modal" title="@lang('mail.aliases.edit')">
                            <i class="fa fa-pencil"></i>
                        </a>
                        <a href="{{ route('mail.aliases.destroy', $alias->id) }}" data-method="DELETE" class="btn btn-danger btn-circle">
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
            {!! $aliases->links() !!}
        </div>
    </div>
@endsection
