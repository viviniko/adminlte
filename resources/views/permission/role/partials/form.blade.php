@if ($edit)
    {!! Form::open(['route' => ['permission.roles.update', $role->id], 'method' => 'PUT', 'id' => 'role-form']) !!}
@else
    {!! Form::open(['route' => 'permission.roles.store', 'id' => 'role-form']) !!}
@endif

<div class="form-group">
    {!! Form::label('name', trans('permission.name')) !!}
    {!! Form::text('name', $edit ? $role->name : old('name'), [ 'placeholder' => trans('permission.name'), 'class' => 'form-control' ]) !!}
</div>

<div class="form-group">
    {!! Form::label('display_name', trans('permission.display_name')) !!}
    {!! Form::text('display_name', $edit ? $role->display_name : old('display_name'), [ 'placeholder' => trans('permission.display_name'), 'class' => 'form-control' ]) !!}
</div>

<div class="form-group">
    {!! Form::label('description', trans('permission.description')) !!}
    {!! Form::textarea('description', $edit ? $role->description : old('description'), [ 'rows' => 2, 'placeholder' => trans('permission.description'), 'class' => 'form-control' ]) !!}
</div>
<style>
    .list-inline{margin-left: 10px;}
    .list-inline li{width: 45%;}
</style>
<div class="form-group">
    {!! Form::label('permission', trans('permission.permissions')) !!}
    <div><a href="#" class="permission-select-all">Select All</a> / <a href="#"  class="permission-deselect-all">Deselect All</a></div>
    @foreach ($permissions as $group => $groupPermissions)
        <ul class="permissions checkbox">
            <li>
                {!! Form::checkbox('permission-'.$group, null, false, [ 'id' => 'permission-'.$group, 'class' => 'permission-group' ]) !!}
                {!! Form::label('permission-'.$group, $group) !!}
                <ul class="list-inline">
                @foreach($groupPermissions as $permission)
                    <li>
                        {!! Form::checkbox('permissions[]', $permission->id, $edit ? $role->hasPermission($permission->name) : null, [ 'id' => 'permission-'.$permission->id, 'class' => 'permission-checkbox' ]) !!}
                        {!! Form::label('permission-'.$permission->id, $permission->display_name) !!}
                    </li>
                @endforeach
                </ul>
            </li>
        </ul>
    @endforeach
</div>

<button type="submit" class="btn btn-primary btn-block">
    <i class="fa fa-save"></i>
    {{ $edit ? trans('permission.update_role') : trans('permission.create_role') }}
</button>

{!! Form::close() !!}


<script>
    $(function() {
        $('.permission-group').on('change', function(){
            $(this).siblings('ul').find("input[type='checkbox']").prop('checked', this.checked);
        });

        $('.permission-select-all').on('click', function(){
            $('ul.permissions').find("input[type='checkbox']").prop('checked', true);
            return false;
        });

        $('.permission-deselect-all').on('click', function(){
            $('ul.permissions').find("input[type='checkbox']").prop('checked', false);
            return false;
        });

        function parentChecked(){
            $('.permission-group').each(function(){
                var allChecked = true;
                $(this).siblings('ul').find("input[type='checkbox']").each(function(){
                    if(!this.checked) allChecked = false;
                });
                $(this).prop('checked', allChecked);
            });
        }

        parentChecked();

        $('.permission-checkbox').on('change', function(){
            parentChecked();
        });
    });
</script>