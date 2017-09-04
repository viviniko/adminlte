@if ($edit)
    {!! Form::open(['route' => ['menu.menus.update', $menu->id], 'method' => 'PUT', 'id' => 'menu-form']) !!}
@else
    {!! Form::open(['route' => 'menu.menus.store', 'id' => 'menu-form']) !!}
@endif

<div class="form-group">
    {!! Form::label('name', trans('menu.name')) !!}
    {!! Form::text('name', $edit ? $menu->name : old('name'), [ 'placeholder' => trans('menu.name'), 'class' => 'form-control' ]) !!}
</div>

<div class="form-group">
    {!! Form::label('display_name', trans('menu.display_name')) !!}
    {!! Form::text('display_name', $edit ? $menu->display_name : old('display_name'), [ 'placeholder' => trans('menu.display_name'), 'class' => 'form-control' ]) !!}
</div>

<div class="form-group">
    {!! Form::label('description', trans('menu.description')) !!}
    {!! Form::textarea('description', $edit ? $menu->description : old('description'), [ 'rows' => 2, 'placeholder' => trans('menu.description'), 'class' => 'form-control' ]) !!}
</div>

<button type="submit" class="btn btn-primary btn-block">
    <i class="fa fa-save"></i>
    {{ $edit ? trans('menu.update_menu') : trans('menu.create_menu') }}
</button>

{!! Form::close() !!}