@extends('layouts.master')

@section('page-title', trans('menu.menus'))

@section('page-header')
    <h1>
        @lang('menu.menus')
        <small>@lang('menu.menus')</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('menu.menus.index') }}"><i class="fa fa-dashboard"></i> @lang('app.home')</a></li>
        <li class="active">@lang('menu.menus')</li>
      </ol>
@endsection

@section('content')

    <div class="box box-warning">
        <div class="box-header with-border">
            <h3 class="box-title">@lang('menu.menus')</h3>
            <div class="box-tools">
                <a href="{{ route('menu.items.delete') }}" class="btn btn-sm btn-danger"
                   title="@lang('menu.delete_menu_items')"
                   data-toggle="tooltip"
                   data-placement="top"
                   data-method="DELETE"
                   data-options='{"init-failure":"@lang('menu.please_select_menu_items')","init":"isSelectedItems()","create-form":"getSelectedItems()"}'>
                    <i class="fa fa-trash"></i>
                    @lang('menu.delete_menu_items')
                </a>
                <a href="#" title="@lang('menu.edit_menu_item')" target="_modal" data-modal-init="modalEditOptions()" data-modal-init-failure="@lang('menu.please_select_menu_items')" class="btn btn-sm btn-success">
                    <i class="fa fa-edit"></i>
                    @lang('menu.edit_menu_item')
                </a>
                <a href="{{ route('menu.items.create', $menu->id) }}" title="@lang('menu.add_menu_item')" target="_modal" class="btn btn-sm btn-success">
                    <i class="fa fa-plus"></i>
                    @lang('menu.add_menu_item')
                </a>
            </div>
        </div>
        <div class="box-body table-responsive no-padding" id="users-table-wrapper">
            <div class="col-md-12">
                @include('menu.item.partials.tree')
            </div>
        </div>
    </div>

@stop

@push('js')
    <script>
        var $tree = $('#tree-container');
        (function() {
            $tree.jstree({
                'core': {
                    'data': {
                        'url': '{{ route('menu.items.tree', $menu->id) }}',
                        'dataType': 'json' // needed only if you do not supply JSON headers
                    },
                    "themes" : {
                        "variant" : "large"
                    },
                    'check_callback':true
                },
                'types': {
                    'default' : {
                        'icon': false
                    }
                },
                'dnd':{
                    'copy':false
                },
                'plugins': ['types', 'dnd']
            }).on('loaded.jstree', function() {
                $tree.jstree('open_all');
            }).on("changed.jstree", function (e, data) {
            }).on('move_node.jstree', function(e, data) {
                $.post("{{ route('menu.items.move') }}", {"_token": "{{ csrf_token() }}", "id": data.node.id, "parent_id": data.parent, "sort": data.position}, function(json) {
                    if (!json || json.code != 0) {
                        alert('error');
                        window.location.reload();
                    }
                });
            });
        })();

        function modalEditOptions() {
            var url = '{{ route('menu.items.edit', 'menuItemId') }}';
            var selected = $tree.jstree().get_selected();
            if (selected.length == 0) {
                return false;
            }
            return {
                'url': url.replace(/\/menuItemId/, '/'+selected[0])
            };
        }

        function isSelectedItems() {
            return $tree.jstree().get_selected().length != 0;
        }

        function getSelectedItems() {
            return 'ids=' + $tree.jstree().get_selected().join(',');
        }
    </script>
@endpush
