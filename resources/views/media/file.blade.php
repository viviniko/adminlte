@extends('layouts.master')

@section('title')
    @lang('media.files')
@stop

@push('css')
    <style>
        .media-path {margin: 10px auto;}
        .file, .media-path {background-color: #fff;}
        .file-box {float: left; width: 220px;}
        .file {border: 1px solid #e7eaec; padding: 0; position: relative; margin-bottom: 20px; margin-right: 20px;}
        .file .icon, .file .image {height: 100px; overflow: hidden;}
        .file .icon {padding: 15px 10px; text-align: center;}
        .file .icon i {font-size: 90px;}
        .folder-name {line-height: 50px;}
        .file-name, .folder-name {height: 50px; padding: 0 10px;text-align: center; vertical-align: center;}
        .opration {display: none; position: absolute; top: 0; right: 0;}
    </style>
@endpush

@section('content_header')
    <h1>
        @lang('media.files')
        <small>@lang('media.files')</small>
    </h1>
    <ol class="breadcrumb">
        <li>
            <i class="fa fa-home home-icon"></i>
            <a href="/">@lang('app.dashboard')</a>
        </li>
        <li class="active">@lang('media.files')</li>
    </ol>
@stop

@section('content')
    <div class="row page-title-row">
        <div class="col-md-12 media-tool">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-lg">
                <i class="fa fa-upload"></i> @lang('media.uploadFile')
            </button>
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
            <button type="button" class="btn btn-success btn-md" data-toggle="modal" data-target="#modal-folder-create">
                <i class="fa fa-plus-circle"></i> @lang('media.create_folder')
            </button>
            <div class="modal fade" id="modal-folder-create">
                <div class="modal-dialog">
                    <div class="modal-content">
                        {!! Form::open(['url' => route('media.files.mkdir'), 'class' => 'form-horizontal', 'id' => 'createFolderForm']) !!}
                            <input type="hidden" name="folder" value="{{ $folder }}">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal"> × </button>
                                <h4 class="modal-title">@lang('media.create_folder')</h4>
                            </div>
                            <div class="modal-body">
                                @include('includes.js-messages')
                                <div class="form-group">
                                    <div class="form-group">
                                        {!! Form::label('new_folder', trans('media.new_folder'), ['class' => 'col-sm-3 control-label']) !!}
                                        <div class="col-sm-8">
                                            {!! Form::text('new_folder', null, ['class' => 'form-control']) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">@lang('app.cancel')</button>
                                <button type="submit" class="btn btn-primary">@lang('app.submit')</button>
                            </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
            <button type="button" class="btn btn-success" onclick="location.reload();">
                <i class="fa fa-refresh"></i> @lang('media.refresh')
            </button>
        </div>
        <div class="col-md-12">
            <ul class="breadcrumb media-path">
                <li class="active">
                    <a href="?folder=/">root</a>
                </li>
                @foreach($pathArray as $path)
                    <li>
                        <a href="?folder={{ $path['dir'] }}">{{ $path['path'] }}</a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            @foreach($allFiles as $file)
                <div class="file-box">
                    @if ($file->is_folder)
                    <div class="file">
                        <a href="{{ route('media.files.index') }}?folder=/{{ $file->path }}">
                            <div class="icon">
                                <i class="fa fa-folder"></i>
                            </div>
                            <div class="folder-name">
                                {{ $file->name }}
                            </div>
                        </a>
                        <div class="opration" style="display: none;">
                            <a class="btn btn-xs btn-danger btn-delete-directory" href="{{ route('media.files.rmdir') }}?folder={{ $file->path }}" data-method="DELETE">
                                <i class="fa fa-times-circle fa-lg"></i> Delete
                            </a>
                        </div>
                    </div>
                    @else
                    <div class="file">
                        <a href="{{ $file->url }}" target="_blank">
                            @if (in_array($file->extension, ['jpg', 'gif', 'png', 'bmp']))
                            <div class="image">
                                <img src="{{ $file->url }}" class="img-responsive">
                            </div>
                            @else
                                <div class="icon">
                                    <i class="fa fa-file"></i>
                                </div>
                            @endif

                            <div class="file-name">
                                {{ $file->name }}
                                <br>
                                {{ $file->cTime }}
                            </div>
                        </a>
                        <div class="opration" style="display: none;">
                            <a class="btn btn-xs btn-danger btn-delete-file" href="{{ route('media.files.delete') }}?file={{ $file->path }}" data-method="DELETE">
                                <i class="fa fa-times-circle fa-lg"></i>
                            </a>
                            <button type="button" class="btn btn-xs btn-success btn-rename" data-toggle="modal" data-target="#modal-file-rename" data-name="{{ $file->name }}">
                                <i class="fa fa-edit fa-lg"></i>
                            </button>
                            @if (in_array($file->extension, ['jpg', 'gif', 'png', 'bmp']))
                            <button type="button" class="btn btn-xs btn-success btn-preview" data-toggle="modal" data-target="#modal-image-view" data-src="{{ $file->url }}">
                                <i class="fa fa-eye fa-lg"></i>
                            </button>
                            @endif
                        </div>
                    </div>
                    @endif
                </div>
            @endforeach
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
    <div class="modal fade" id="modal-file-rename">
        <div class="modal-dialog">
            <div class="modal-content">
                {!! Form::open(['url' => route('media.files.rename'), 'class' => 'form-horizontal', 'id' => 'renameForm']) !!}
                    {!! Form::hidden('folder', $folder) !!}
                    {!! Form::hidden('old_file', null, ['id' => 'old_file']) !!}
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">×</button>
                        <h4 class="modal-title">Rename File</h4>
                    </div>
                    <div class="modal-body">
                        @component('includes.js-messages')
                            renameErrorBlock
                        @endcomponent
                        <div class="form-group">
                            <div class="form-group">
                                {!! Form::label('new_file_name', trans('media.new_file_name'), ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-8">
                                    {!! Form::text('new_file_name', null, ['class' => 'form-control']) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal"> Cancel </button>
                        <button type="submit" class="btn btn-danger"> Rename File </button>
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@stop

@push('js')
    @include('layouts.plugins.bootstrap-fileinput')
    @component('includes.js-messages-js')
        createFolderForm
    @endcomponent
    @component('includes.js-messages-js')
        renameForm
        @slot('index', 1)
        @slot('errorBlock', 'renameErrorBlock')
    @endcomponent
    <script>
        var folder = '{{ $folder }}';
        $(function () {
            $("#input-files").fileinput({
                uploadUrl: "{{ route('media.files.upload') }}", // server upload action
                'uploadExtraData' : {
                    'inputname' : 'files',
                    '_token': '{{ csrf_token() }}',
                    'folder': folder
                },
                uploadAsync: true,
                maxFileCount: 5,
                allowedPreviewTypes: ['image']
            }).on('filebatchuploadcomplete', function (e) {
                window.location.reload();
            });
            $(".file-box").on('mouseover', function () {
                $(this).find('.opration').show();
            }).on('mouseout', function () {
                $(this).find('.opration').hide();
            });

            $(".btn-preview").on('click', function () {
                $("#preview-image").attr('src', $(this).attr('data-src'));
            });

            $(".btn-rename").on('click', function () {
                var value = $(this).attr('data-name');
                $('#old_file').val(value);
            });
        });
    </script>
@endpush
