<div wire:key="{{$chartkey}}" class="card shadow p-3 mb-5 bg-white rounded">
    <div class="card-body">
        <div class="row mb-5">
            <h3 class="col-md-12 text-center ">{{ $data['question']->title }}</h3>
        </div>


        <div class="row">
            <div class="col-md-6" id="" style="height: 300px;">
                <div class="col-md-9 " style="height: 10%; padding:0 !important;">
                    <div class="badge bg-secondary text-white" style="font-size: .9rem !important;">{{__('Total reviews')}} : {{$data['sum']}}</div>
                </div>
                <div class="col-md-11 scroll" style="height: 90%; overflow-y:scroll;border: 1px solid #d0d4d8;border-radius: 7px;">
                    <table class="table" style="position:relative">
                        <thead class="bg-white shadow-sm" style="position:sticky; top:0;">
                            <tr>
                                <th scope="col">{{__('rating scale')}}</th>
                                <th scope="col">{{__('Nbr reviews')}}</th>
                                <th scope="col" style="font-size: .9rem !important;">{{__('Prc')}} %</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data['choices'] as $keyrating => $rating) <tr>
                                <th scope="row">{{$rating}}</th>
                                <td>
                                    @if(isset($data['answers'][$keyrating]))
                                    {{$data['answers'][$keyrating]}}
                                    @else
                                    0
                                    @endif
                                </td>
                                <td style="font-size: .9rem !important;">
                                    @if(isset($data['prc'][$keyrating]))
                                        {{$data['prc'][$keyrating]}}
                                    @else
                                        0
                                    @endif
                                        %
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
            </div>
            <div class="col-md-6" id="" style="height: 300px;">
                <div class="col-md-12" id="pieChart{{$chartkey}}" style="height: 100%"></div>
            </div>
        </div>





        <script>
            var data = {!!json_encode($data, JSON_HEX_TAG) !!};
            count = 0;
            pieData = [];
            $.each(data.choices, function(key, value) {
                prc = 0;
                if (data.answers[key] && data.sum != 0) prc = (data.answers[key] / data.sum) * 100;
                pieData.push([data.choices[key], prc]);
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
        </script>

    </div>
</div>