{{--
@var $slot      input field selector, for example  #start_time, input[name=end_time] or mutiple selector like #start_time,input[name=end_time]
@callback       what to do when applied the date, pass a function name.

Usage

------------------
    @component('layouts.plugins.daterangepicker')
        input[name=start_time],input[name=end_time] // selector
        @slot('callback', 'callback') // callback, optional
    @endcomponent
    <script>
        //the call back function
        function callback(start, end, label) {
            console.log(start, end, label);
        }
    </script>
--}}
<script>
    $(function () {
        //save the initialize value of the selector field
        var selectors = '{{ $slot }}'.split(',');
        var initValues = [];
        for (var i = 0; i < selectors.length; i ++) {
            initValues[i] = $(selectors[i]).val();
        }

        var nowDate=moment().format('L'),
            nowTime=new Date(nowDate + ' 00:00:00'),
            nowTimeEnd=new Date(nowDate + ' 23:59:59');
        $('{{ $slot }}').daterangepicker({
            "timePicker": true,
            "timePicker24Hour": true,
            "timePickerSeconds": true,
            "autoApply": false,

            "alwaysShowCalendars": true,
            "opens": "center",
            'ranges':{
                'Today': [nowTime, moment()],
                'Yesterday': [moment(nowTime).subtract(1, 'days'), moment(nowTimeEnd).subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            },
            'locale' :{
                format: 'YYYY/MM/DD/ HH:mm:ss',
                separator: ' - ',
                applyLabel: 'Apply',
                cancelLabel: 'Cancel',
                fromLabel: 'From',
                toLabel: 'To',
                customRangeLabel: 'Custom',
                daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr','Sa'],
                monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                firstDay: 1
            }
        }, function(start, end, label) {
            @if (isset($callback))
            {{ $callback }}.apply(this, [start, end, label]);
            @endif
        }).on('cancel.daterangepicker', function (ev, target) {
            $(this).val('');
        });

        //reset the initialize value to the selector field
        for (var i = 0; i < initValues.length; i ++) {
            $(selectors[i]).val(initValues[i]);
        }
    });
</script>
