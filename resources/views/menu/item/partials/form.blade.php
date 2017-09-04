@if ($edit)
    {!! Form::open(['route' => ['menu.items.update', $menuItem->id], 'method' => 'PUT', 'id' => 'menu-form']) !!}
@else
    {!! Form::open(['route' => ['menu.items.store', $menu->id], 'id' => 'menu-form']) !!}
@endif

<div class="form-group">
    {!! Form::label('title', trans('menu.title')) !!}
    {!! Form::text('title', $edit ? $menuItem->title : old('title'), [ 'placeholder' => trans('menu.title'), 'class' => 'form-control' ]) !!}
</div>

<div class="form-group">
    {!! Form::label('url', trans('menu.url')) !!}
    {!! Form::text('url', $edit ? $menuItem->url : old('url'), [ 'placeholder' => trans('menu.url'), 'class' => 'form-control' ]) !!}
</div>

<div class="form-group">
    {!! Form::label('sort', trans('menu.sort')) !!}
    {!! Form::text('sort', $edit ? $menuItem->sort : old('sort'), [ 'placeholder' => trans('menu.sort'), 'class' => 'form-control' ]) !!}
</div>

<div class="form-group">
    {!! Form::label('description', trans('menu.description')) !!}
    {!! Form::textarea('description', $edit ? $menuItem->description : old('description'), [ 'rows' => 2, 'placeholder' => trans('menu.description'), 'class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('icon_class', trans('menu.icon_class')) !!}
    {!! Form::text('icon_class', $edit ? $menuItem->icon_class : old('icon_class'), [ 'placeholder' => trans('menu.icon_class'), 'class' => 'form-control' ]) !!}
</div>

<div class="form-group">
    {!! Form::label('target', trans('menu.target')) !!}
    {!! Form::select('target', $targets, $edit ? $menuItem->target : old('target'), ['class' => 'form-control', 'id' => 'target']) !!}
</div>

<div class="form-group">
    {!! Form::label('color', trans('menu.color')) !!}
    {!! Form::text('color', $edit ? $menuItem->color : old('color'), [ 'placeholder' => trans('menu.color'), 'class' => 'form-control' ]) !!}
</div>

<div class="form-group">
    {!! Form::label('permission', trans('menu.permission')) !!}
    {!! Form::select('permission_id', $permissions, $edit ? $menuItem->permission_id : '', ['class' => 'form-control', 'id' => 'permission_id']) !!}
</div>

<button type="submit" class="btn btn-primary  btn-block">
    <i class="fa fa-save"></i>
    {{ $edit ? trans('menu.update_menu') : trans('menu.create_menu') }}
</button>

{!! Form::close() !!}