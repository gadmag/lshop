{{--{{dd($stats)}}--}}
<!-- Morris.js charts -->
@push('script')
    <script>
        var data = {!! $stats !!};
        console.log(data);
        var line = new Morris.Area({
            element: 'line-chart',
            resize: true,
             data: data,
            xkey: 'date',
            ykeys: ['value'],
            labels: ['Заказ'],
            lineColors: ['#a0d0e0', '#3c8dbc'],
            hideHover: 'auto'

        });
    </script>
@endpush
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">График заказов</h3>
    </div>
    <div class="box-body">
        <div class="chart tab-pane" id="line-chart" style="height: 300px;"></div>
    </div>

</div>

