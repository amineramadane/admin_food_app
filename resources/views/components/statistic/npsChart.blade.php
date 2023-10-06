<div wire:key="{{$chartkey}}" class="card shadow p-3 mb-5 bg-white rounded">
    <div class="card-body">
        <div class="row">
            <h3 class="col-md-12 text-center ">{{ $data['question']->title }}</h3>
        </div>
        <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4 mb-5">
            
        <div class="col mt-4">
            <div class="card shadow" style="border-radius:15px;border-left:4px solid #EF6C00; background-color: #ef6c000d !important;">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h4 class="mb-2 text-secondary" style="font-size: 1.3rem !important;">{{__('Detractors')}}</h4>
                        <h4 class="my-1 text-info" style="font-size: 1.3rem !important;">{{$data['nps']['detractors']}}</h4>
                    </div>
                    <div class="text-right">
                            <i style="font-size:4rem; color:#EF6C00;max-width:4rem;" class="material-icons">sentiment_dissatisfied</i>
                    </div>
                </div>
            </div>
            </div>
        </div>
        <div class="col mt-4">
            <div class="card shadow" style="border-radius:15px;border-left:4px solid #00c8ff; background-color: #00c8ff14 !important;">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h4 class="mb-2 text-secondary" style="font-size: 1.3rem !important;">{{__('Passives')}}</h4>
                        <h4 class="my-1 text-info" style="font-size: 1.3rem !important;">{{$data['nps']['passives']}}</h4>
                    </div>
                    <div class="text-right">
                            <i style="font-size:4rem; color:#00c8ff;max-width:4rem;" class="material-icons">sentiment_neutral</i>
                    </div>
                </div>
            </div>
            </div>
        </div>
        
        <div class="col mt-4">
            <div class="card shadow" style="border-radius:15px;border-left:4px solid #4CAA1A; background-color: #4caa1a1f !important;">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h4 class="mb-2 text-secondary" style="font-size: 1.3rem !important;">{{__('Promotors')}}</h4>
                            <h4 class="my-1 text-info" style="font-size: 1.3rem !important;">{{$data['nps']['promotors']}}</h4>
                        </div>
                        <div class="text-right">
                                <i style="font-size:4rem; color:#4CAA1A; max-width:4rem;" class="material-icons">sentiment_satisfied</i>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
        <div class="col mt-4">
            <div class="card shadow" style="border-radius:15px;border-left:4px solid #000000; background-color: #0000000d !important;">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h4 class="mb-2 text-secondary" style="font-size: 1.3rem !important;">{{__('NPS Score')}}</h4>
                            <h4 class="my-1 text-info" style="font-size: 1.3rem !important;">{{$data['nps']['score']}}</h4>
                        </div>
                        <div class="text-right">
                                <i style="font-size:4rem; color:#000000;max-width:4rem;" class="material-icons">assessment</i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>

        <div class="row pt-4 pb-4">
            <div class="col-md-6" id="" style="height: 300px;">
                <div class="col-md-9 " style="height: 10%; padding:0 !important;">
                    <div class="badge bg-secondary text-white" style="font-size: .9rem !important;">{{__('Total reviews')}} : {{$data['sum']}}</div>
                </div>
                <div class="col-md-11 scroll" style="height: 90%; overflow-y:scroll;border: 1px solid #d0d4d8;border-radius: 7px;">
                    <table class="table col-md-12" style="position:relative">
                        <thead class="bg-white shadow-sm" style="position:sticky; top:0;">
                            <tr>
                                <th scope="col" style="font-size: .9rem !important;">{{__('Rating scale')}}</th>
                                <th scope="col" style="font-size: .9rem !important;">{{__('Nbr reviews')}}</th>
                                <th scope="col" style="font-size: .9rem !important;">{{__('Prc')}} %</th>
                            </tr>
                        </thead>
                        <tbody>
                            @for($i = 0 ; $i <= 10 ; $i++) <tr>
                                <th scope="row" style="font-size: .9rem !important;">{{$i}}</th>
                                <td style="font-size: .9rem !important;">
                                    @if(isset($data['answers'][$i])){{$data['answers'][$i]}}@else 0 @endif
                                </td>
                                <td style="font-size: .9rem !important;">
                                    @if(isset($data['prc'][$i])){{$data['prc'][$i]}}@else 0 @endif %
                                </td>
                                </tr>
                                @endfor
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-6 mt-3" id="" style="height: 300px;">
                <div class="col-md-12 text-center mb-3" style="font-size: 1rem !important;"><strong>{{__('Net Promoter Score')}}</strong></div>
                <div class="col-md-12" id="npsChart{{$chartkey}}" style="height: 250px"></div>
            </div>
        </div>

        <script>
            var data = {!!json_encode($data, JSON_HEX_TAG) !!};
            // console.log(data.question);
            $('#npsChart{{$chartkey}}').highcharts({
                colors: ["#000000","#4CAA1A", "#00c8ff", "#EF6C00"],
                credits: {
                    enabled: false
                },
                // caption: {
                //     text: '<b>The caption renders in the bottom, and is part of the exported chart.</b>'
                // },
                accessibility: {
                    enabled: false
                },
                legend: {
                    reversed: true
                },
                series: [
                    {
                        name: "{{__('NPS Score')}}",
                        data: [data.nps.score],
                        stack: 1,
                        yAxis: 0
                    },
                    {
                        name: "{{__('Promotors')}}",
                        data: [data.nps.promotors],
                        stack: 0,
                        type: "bar",
                        borderWidth: 0,
                        shadow: true,
                        yAxis: 1
                    },
                    {
                        name: "{{__('Passives')}}",
                        data: [data.nps.passives],
                        stack: 0,
                        type: "bar",
                        borderWidth: 0,
                        shadow: true,
                        yAxis: 1
                    },
                    {
                        name: "{{__('Detractors')}}",
                        data: [data.nps.detractors],
                        stack: 0,
                        type: "bar",
                        borderWidth: 0,
                        shadow: true,
                        yAxis: 1
                    }
                ],
                yAxis: [{
                        title: {
                            // text: "{{__('Net_Promoter_Score')}}"
                            text: ""
                        },
                        min: -100,
                        max: 100,
                        tickInterval: 20,
                        // opposite: true
                    },
                    {
                        title: {
                            text: ""
                        },
                        // opposite: false,
                        labels: false,
                        min: -100,
                        max: 100,
                        tickInterval: 20,
                        lineWidth: 0,
                        minorGridLineWidth: 0,
                        gridLineColor: "transparent",
                        lineColor: "transparent",
                        labels: {
                            enabled: false
                        },
                        minorTickLength: 0,
                        tickLength: 0
                    }
                ],
                title: {
                    text: ""
                },
                // subtitle: {
                //     text: "{{__('Last_Survey')}}: <strong>Jan 15th, 2018</strong>"
                // },
                tooltip: {
                    formatter: function() {
                        switch (this.series.name) {
                            case "Promotors":
                                return (
                                    "<b>" +
                                    this.y +
                                    "</b> out of " +
                                    this.total +
                                    " would recommend us"
                                );
                            case "Passives":
                                return (
                                    "<b>" + this.y + "</b> out of " + this.total + " are passives"
                                );
                            case "Detractors":
                                return (
                                    "<b>" +
                                    this.y +
                                    "</b> out of " +
                                    this.total +
                                    " would not recommend us"
                                );
                            case "TimeScore":
                                return (
                                    "Average NPS in Month " + this.x + ": <b>" + this.y + "</b>"
                                );
                            default:
                                return "<b>" + this.y + "</b>";
                        }
                    }
                },

                chart: {
                    renderTo: "npsChart",
                    type: "bubble",
                    alignTicks: false
                },
                plotOptions: {
                    bar: {
                        stacking: "percent"
                    },
                    bubble: {
                        minSize: 30,
                        maxSize: 30,
                        zIndex: 1,
                        dataLabels: {
                            enabled: true,
                            format: "{point.y}"
                        }
                    }
                },
                xAxis: {
                    // title: {
                    //     text: "Survey Dates"
                    // },
                    categories: [
                        ""
                        // "@if($fromMonth) {{__($months[$fromMonth]) }} @endif {{__('to')}} {{__($months[$toMonth])}} {{$year}}"
                    ]
                }
            });
        </script>

    </div>
</div>