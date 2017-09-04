@extends('layouts.master')

@section('title')
    @lang('media.medias')
@stop

@section('content_header')
    <h1>
        @lang('media.medias')
        <small>@lang('media.medias')</small>
    </h1>
    <ol class="breadcrumb">
        <li>
            <i class="fa fa-home home-icon"></i>
            <a href="/">@lang('app.dashboard')</a>
        </li>
        <li class="active">@lang('media.medias')</li>
    </ol>
@stop

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <div class="box-title">@lang('media.medias')</div>
        </div>
        <div class="box-body">
            <div class="col-md-1">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-lg">@lang('media.upload')</button>

                <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myModalLabel">Upload</h4>
                            </div>
                            <div class="modal-body">
                                <input id="input-files" name="files" type="file" multiple class="file-uploading">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-11">
                {!! Form::open(['method' => 'GET', 'class' => 'form-inline']) !!}
                <div class="form-group @if ($errors->has('filename')) has-error @endif ">
                    {!! Form::label('filename', trans('media.filename')) !!}
                    {!! Form::text('filename', null, ['class' => 'form-control']) !!}
                </div>
                {!! Form::submit(trans('app.search'), ['class' => 'btn btn-default']) !!}
                <a href="{{ route('media.medias.index') }}" class="btn btn-default">@lang('app.reset')</a>
                {!! Form::close() !!}
            </div>
            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th>#</th>
                    <th>@lang('media.filename')</th>
                    <th>@lang('media.mime_type')</th>
                    <th>@lang('media.size')</th>
                    <th>@lang('app.created_at')</th>
                    <th>@lang('app.action')</th>
                </tr>
                </thead>
                <tbody>
                @foreach($medias as $media)
                    <tr>
                        <td>{{ $media->id }}</td>
                        <td>{{ $media->filename }}</td>
                        <td>{{ $media->mime_type }}</td>
                        <td>{{ $media->readable_size }}</td>
                        <td>{{ $media->created_at }}</td>
                        <td>
                            <button type="button" class="btn btn-default btn-circle btn-copy" title="{{ trans('media.media_copy') }}" data-clipboard-text="{{ $media->url }}">
                                <i class="fa fa-copy"></i>
                            </button>
                            <button type="button" class="btn btn-success btn-circle btn-preview" title="{{ trans('media.media_view') }}" data-toggle="modal" data-target="#modal-image-view" data-src="{{ $media->url }}">
                                <i class="fa fa-eye"></i>
                            </button>
                            <a href="{{ route('media.medias.destroy', $media->id) }}" class="btn btn-danger btn-circle btn-delete"
                               title="@lang('app.delete')"
                               data-toggle="tooltip"
                               data-placement="top"
                               data-method="DELETE">
                                <i class="glyphicon glyphicon-trash"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="box-footer">
            {!! $medias->links() !!}
        </div>
    </div>
    <div class="modal fade" id="modal-image-view">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        ×
                    </button>
                    <h4 class="modal-title">Image Preview</h4>
                </div>
                <div class="modal-body">
                    <img id="preview-image" src="" class="img-responsive">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
@stop

@push('js')
    @include('layouts.plugins.bootstrap-fileinput')
    <script src="/vendor/clipboard/dist/clipboard.min.js"></script>
    <script>
        $(function () {
            $("#input-files").fileinput({
                uploadUrl: "{{ route('media.medias.upload') }}", // server upload action
                'uploadExtraData' : {
                    'inputname' : 'files',
                    '_token': '{{ csrf_token() }}'
                },
                uploadAsync: true,
                maxFileCount: 5
            }).on('filebatchuploadcomplete', function () {
                window.location.reload();
            });
            $(".btn-preview").on('click', function () {
                $("#preview-image").attr('src', $(this).attr('data-src'))
            });
            var clipboard = new Clipboard('.btn-copy');
            clipboard.on('success', function (e) {
                toastr.success('{{ trans('media.copy_success') }}');
            });
            clipboard.on('error', function (e) {
                swal({
                    title: "{{ trans('media.copy_failed') }}",
                    text: "{{ trans('media.copy_it_manually') }}:",
                    type: "input",
                    closeOnConfirm: false,
                    animation: "slide-from-top",
                    inputValue: e.text
                });
            });
        });
    </script>
@endpush
