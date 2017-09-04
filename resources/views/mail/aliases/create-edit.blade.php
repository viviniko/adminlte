@include('includes.js-messages')
@if ($edit)
{!! Form::model($alias, ['url' => route('mail.aliases.update', $alias->id), 'id' => 'aliasForm', 'method' => 'PUT']) !!}
@else
{!! Form::open(['url' => route('mail.aliases.store'), 'id' => 'aliasForm']) !!}
@endif
<div class="form-group @if ($errors->has('domain_id')) has-error @endif ">
    {!! Form::label('domain_id', trans('mail.aliases.domain')) !!}
    {!! Form::select('domain_id', $domains, null, ['class' => 'form-control']) !!}
</div>
<div class="form-group @if ($errors->has('source')) has-error @endif ">
    {!! Form::label('source', trans('mail.aliases.source')) !!}
    {!! Form::text('source', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group @if ($errors->has('destination')) has-error @endif ">
    {!! Form::label('destination', trans('mail.aliases.destination')) !!}
    {!! Form::text('destination', null, ['class' => 'form-control']) !!}
</div>
{!! Form::submit(trans('app.submit'), ['class' => 'btn btn-primary']) !!}
{!! Form::close() !!}
@component('includes.js-messages-js')
    aliasForm
@endcomponent
