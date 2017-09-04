@include('includes.js-messages')
@if($edit)
{!! Form::model($domain, ['url' => route('mail.domains.update', $domain->id), 'id' => 'domainForm', 'method' => 'PUT']) !!}
@else
{!! Form::open(['url' => route('mail.domains.store'), 'id' => 'domainForm']) !!}
@endif
<div class="form-group @if ($errors->has('name')) has-error @endif ">
    {!! Form::label('name', trans('mail.domains.name')) !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>
{!! Form::submit(trans('app.submit'), ['class' => 'btn btn-primary']) !!}
{!! Form::close() !!}
@component('includes.js-messages-js')
    domainForm
@endcomponent