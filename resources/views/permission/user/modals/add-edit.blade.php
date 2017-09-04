@if ($edit)
    {!! Form::open(['route' => ['permission.users.update', $user->id], 'method' => 'PUT', 'id' => 'user-form']) !!}
@else
    {!! Form::open(['route' => 'permission.users.store', 'id' => 'user-form']) !!}
@endif

<div class="form-group">
    {!! Form::label('lastname', trans('permission.lastname')) !!}
    {!! Form::text('lastname', $edit ? $user->lastname : old('lastname'), [ 'placeholder' => trans('permission.lastname'), 'class' => 'form-control' ]) !!}
</div>

<div class="form-group">
    {!! Form::label('firstname', trans('permission.firstname')) !!}
    {!! Form::text('firstname', $edit ? $user->firstname : old('firstname'), [ 'placeholder' => trans('permission.firstname'), 'class' => 'form-control' ]) !!}
</div>

<div class="form-group">
    {!! Form::label('phone', trans('permission.phone')) !!}
    {!! Form::text('phone', $edit ? $user->phone : old('phone'), [ 'placeholder' => trans('permission.phone'), 'class' => 'form-control' ]) !!}
</div>

<div class="form-group">
    {!! Form::label('email', trans('permission.email')) !!}
    {!! Form::text('email', $edit ? $user->email : old('email'), [ 'placeholder' => trans('permission.email'), 'class' => 'form-control' ]) !!}
</div>

<div class="form-group">
    {!! Form::label('password', trans('permission.password')) !!}
    {!! Form::password('password', [ 'placeholder' => trans('permission.password'), 'class' => 'form-control' ]) !!}
</div>

<div class="form-group">
    {!! Form::label('password_confirmation', trans('permission.retype_password')) !!}
    {!! Form::password('password_confirmation', [ 'placeholder' => trans('permission.retype_password'), 'class' => 'form-control' ]) !!}
</div>

<div class="form-group">
    {!! Form::label('status', trans('permission.status')) !!}
    {!! Form::select('is_active', $statuses, $edit ? $user->is_active : old('is_active'), [ 'class' => 'form-control' ]) !!}
</div>

<button type="submit" class="btn btn-primary btn-block">
    <i class="fa fa-save"></i>
    {{ $edit ? trans('app.update') : trans('app.create') }}
</button>

{!! Form::close() !!}