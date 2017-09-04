@include('includes.js-messages')
@if ($edit)
{!! Form::model($template, ['url' => route('mail.templates.update', $template), 'id' => 'templateForm', 'method' => 'PUT']) !!}
@else
{!! Form::open(['url' => route('mail.templates.store'), 'id' => 'templateForm']) !!}
@endif
<div class="form-group @if ($errors->has('name')) has-error @endif ">
    {!! Form::label('name', trans('mail.templates.name')) !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group @if ($errors->has('subject')) has-error @endif ">
    {!! Form::label('subject', trans('mail.templates.subject')) !!}
    {!! Form::text('subject', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group @if ($errors->has('content')) has-error @endif ">
    {!! Form::label('content', trans('mail.templates.content')) !!}
    {!! Form::textarea('content', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group @if ($errors->has('from')) has-error @endif ">
    {!! Form::label('from', trans('mail.templates.from')) !!}
    {!! Form::text('from', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group @if ($errors->has('key')) has-error @endif ">
    {!! Form::label('key', trans('mail.templates.key')) !!}
    {!! Form::text('key', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group @if ($errors->has('group')) has-error @endif ">
    {!! Form::label('group', trans('mail.templates.group')) !!}
    {!! Form::text('group', null, ['class' => 'form-control']) !!}
</div>
{!! Form::submit(trans('app.submit'), ['class' => 'btn btn-primary']) !!}
{!! Form::close() !!}
@component('includes.js-messages-js')
    templateForm
@endcomponent
@component('layouts.plugins.editor')
    content
    @slot('options')
        fullPage: true, allowedContent: true
    @endslot
@endcomponent