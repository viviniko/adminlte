@extends('layouts.master')

@section('content_header')
    <h1>
        @lang('mail.templates.templates')
        <small>@lang('mail.templates.templates')</small>
    </h1>
    <ol class="breadcrumb">
        <li>
            <i class="fa fa-home home-icon"></i>
            <a href="/">@lang('app.dashboard')</a>
        </li>
        <li class="active">
            <a href="{{ route('mail.templates.index') }}">@lang('mail.templates.templates')</a>
        </li>
    </ol>
@stop

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <div class="box-title">@lang('mail.templates.templates')</div>
            <div class="box-tools">
                <a href="{{ route('mail.templates.create') }}" class="btn btn-success btn-sm" target="_modal" title="@lang('mail.templates.create')">
                    @lang('mail.templates.create')
                </a>
            </div>
        </div>
        <div class="box-body">
            <table class="table table-hover table-striped">
                <thead>
                <tr>
                    <th>#</th>
                    <th>@lang('mail.templates.group')</th>
                    <th>@lang('mail.templates.name')</th>
                    <th>@lang('mail.templates.key')</th>
                    <th>@lang('mail.templates.from')</th>
                    <th>@lang('mail.templates.subject')</th>
                    <th>@lang('mail.templates.created_at')</th>
                    <th>@lang('app.action')</th>
                </tr>
                </thead>
                <tbody>
                @forelse($templates as $template)
                <tr>
                    <td>{{ $template->id }}</td>
                    <td>{{ $template->group }}</td>
                    <td>{{ $template->name }}</td>
                    <td>{{ $template->key }}</td>
                    <td>{{ $template->from }}</td>
                    <td>{{ $template->subject }}</td>
                    <td>{{ $template->created_at }}</td>
                    <td>
                        <a href="{{ route('mail.templates.show', $template->id) }}" class="btn btn-success btn-circle"
                           target="_modal" title="@lang('mail.templates.preview')">
                            <i class="fa fa-eye"></i>
                        </a>
                        <a href="{{ route('mail.templates.edit', $template->id) }}" title="@lang('mail.templates.edit')"
                           target="_modal" class="btn btn-primary btn-circle">
                            <i class="fa fa-pencil"></i>
                        </a>
                        <a href="{{ route('mail.templates.destroy', $template->id) }}"
                           class="btn btn-danger btn-circle" data-method="DELETE">
                            <i class="fa fa-trash"></i>
                        </a>
                    </td>
                </tr>
                @empty
                    <tr>
                        <td colspan="8">@lang('app.no_records_found')</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
            {!! $templates->links() !!}
        </div>
    </div>
@stop
