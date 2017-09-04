{{--
@var $slot          form id.
@var $errorBlock    errors block id, default jsErrorBlock. The block MUST has a ul element in it.It will auto use toastr.error if the errors block doesn't exist.
@var $url           when ajax successes where to redirect. default is reload the current page.
@callback           success callback function name.If callback is set url param will be ignored.

Usage:
@component('includes.js-message-js')
    createForm  //formId
    @slot('url', 'xxx') // optional
    @slot('errorBlock', 'errorblockId') // optional
    @slot('callback', 'functionName') // optional
@endcomponent
--}}
<script>
    <?php $index = str_random(7) ?>
    var errorBlockId_{{ $index }} = $('#{{ $errorBlock or 'jsErrorBlock' }}');
    $('#{{ $slot }}').on('submit', function() {
        errorBlockId_{{ $index }}.hide().find('ul').html('');
        $.ajax({
            type: guessMethod($(this)),
            url: $(this).attr('action'),
            data: $(this).serialize()
        }).done(function (data) {
            @if (isset($callback))
            {{ $callback }}.apply(this, [data]);
            return;
            @endif
            if (data && data.message.toLowerCase() === 'ok') {
                if ('{{ $url or '' }}' == '') {
                    location.reload();
                } else {
                    location.href = '{{ $url or '' }}';
                }
            }
        }).fail(function (xhr) {
            if (xhr.status === 422) {
                var data = $.parseJSON(xhr.responseText);
                var errors = data.errors;
                var lis = [];
                for (var index in errors) {
                    var error = errors[index];
                    for (var i in error) {
                        lis.push('<li>' + error[i] + '</li>');
                    }
                }
                if (errorBlockId_{{ $index }}.length) {
                    errorBlockId_{{ $index }}.show().find('ul').append(lis.join(''));
                } else {
                    lis = lis.map(function (li) {
                        return li.replace(/(<\/?)li(>)/g, "$1div$2");
                    });
                    toastr.error(lis.join(''));
                }
            } else {
                toastr.error('Server Error.');
            }
        });
        return false;
    });
    if (typeof guessMethod === 'undefined') {
        function guessMethod ($form) {
            $hidden = $form.find('input[type=hidden][name=_method]');
            if ($hidden.length) {
                return $hidden.eq(0).val();
            }
            $method = $form.attr('method');
            if (!!$method) {
                return $method;
            }
            return 'get';
        }
    }
</script>
