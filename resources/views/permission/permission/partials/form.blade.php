@if ($edit)
    {!! Form::open(['route' => ['permission.permissions.update', $permission->id], 'method' => 'PUT', 'id' => 'permission-form']) !!}
@else
    {!! Form::open(['route' => 'permission.permissions.store', 'id' => 'permission-form']) !!}
@endif

<div class="form-group">
    {!! Form::label('name', trans('permission.name')) !!}
    {!! Form::text('name', $edit ? $permission->name : old('name'), [ 'placeholder' => trans('permission.name'), 'class' => 'form-control' ]) !!}
</div>

<div class="form-group">
    {!! Form::label('display_name', trans('permission.display_name')) !!}
    {!! Form::text('display_name', $edit ? $permission->display_name : old('display_name'), [ 'placeholder' => trans('permission.display_name'), 'class' => 'form-control' ]) !!}
</div>

<div class="form-group">
    {!! Form::label('description', trans('permission.description')) !!}
    {!! Form::textarea('description', $edit ? $permission->description : old('description'), [ 'rows' => 2, 'placeholder' => trans('permission.description'), 'class' => 'form-control' ]) !!}
</div>

<button type="submit" class="btn btn-primary btn-block">
    <i class="fa fa-save"></i>
    {{ $edit ? trans('app.update') : trans('app.create') }}
</button>

{!! Form::close() !!}