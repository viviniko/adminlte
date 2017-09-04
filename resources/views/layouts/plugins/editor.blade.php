{!! Html::script('vendor/ckeditor/ckeditor.js') !!}
<script>
    $.fn.modal.Constructor.prototype.enforceFocus = function () {
        var $modalElement = this.$element;
        $(document).on('focusin.modal', function (e) {
            var $parent = $(e.target.parentNode);
            if ($modalElement[0] !== e.target && !$modalElement.has(e.target).length
                // add whatever conditions you need here:
                &&
                !$parent.hasClass('cke_dialog_ui_input_select') && !$parent.hasClass('cke_dialog_ui_input_text')) {
                $modalElement.focus()
            }
        })
    };
    CKEDITOR.config.extraPlugins = 'dialogadvtab,colorbutton,colordialog,copyformatting,find,font,indentblock,smiley,justify,liststyle,preview,selectall,showblocks';
    @if (!isset($replace) || $replace . '' == 'true')
    CKEDITOR.replace('{{ $slot }}', {
        on: {
            change: function() {
                this.updateElement();
            }@if (isset($options)), @endif
            {{ $options }}
        }
    });
    @endif
</script>
