<div wire:key="{{$chartkey}}" class="card shadow p-3 mb-5 bg-white rounded">
    <div class="card-body">

        <h3 class="col-md-12 text-center ">{{ $data['title'] }}</h3>

        <div class="col-md-12" id="pieChart{{$chartkey}}" style="height: 100%"></div>

        <script>
            try {
                
           
            var data = {!!json_encode($data, JSON_HEX_TAG) !!};
            count = 0;
            pieData = [];
            $.each(data.childrens, function(key, value) {
                prc = 0;
                prc = (value.count / data.count) * 100;
                pieData.push([value.name, prc]);
            });

            $('#pieChart{{$chartkey}}').highcharts({
                chart: {
                    type: 'pie',
                    options3d: {
                        enabled: true,
                        alpha: 45,
                        beta: 0
                    }
                },
                credits: {
                    enabled: false
                },
                title: {
                    text: ''
                },
                accessibility: {
                    enabled: false,
                    point: {
                        valueSuffix: '%'
                    }
                },
                tooltip: {
                    // pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                    pointFormat: '<b>{point.percentage:.2f}%</b>'
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        depth: 35,
                        dataLabels: {
                            enabled: true,
                            format: '{point.name}'
                        }
                    }
                },
                series: [{
                    type: 'pie',
                    name: 'Browser share',
                    data: pieData
                }]
            });

        } catch (error) {
                console.log(error);
        }
        </script>

    </div>
</div>