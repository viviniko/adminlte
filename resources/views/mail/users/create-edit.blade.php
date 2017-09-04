@include('includes.js-messages')
@if ($edit)
{!! Form::model($user, ['url' => route('mail.users.update', $user), 'id' => 'userForm', 'method' => 'PUT']) !!}
@else
{!! Form::open(['url' => route('mail.users.store'), 'id' => 'userForm']) !!}
@endif
<div class="form-group @if ($errors->has('domain_id')) has-error @endif ">
    {!! Form::label('domain_id', trans('mail.users.domain')) !!}
    {!! Form::select('domain_id', $domains, null, ['class' => 'form-control']) !!}
</div>
<div class="form-group @if ($errors->has('email')) has-error @endif ">
    {!! Form::label('email', trans('mail.users.email')) !!}
    {!! Form::text('email', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group @if ($errors->has('password')) has-error @endif ">
    {!! Form::label('password', trans('mail.users.password')) !!}
    {!! Form::password('password', ['class' => 'form-control']) !!}
</div>
<div class="form-group @if ($errors->has('role')) has-error @endif ">
    {!! Form::label('role', trans('mail.users.role')) !!}
    {!! Form::select('role', $roles, null, ['class' => 'form-control']) !!}
</div>
{!! Form::submit(trans('app.submit'), ['class' => 'btn btn-primary']) !!}
{!! Form::close() !!}
@component('includes.js-messages-js')
    userForm
@endcomponent