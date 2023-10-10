<div>
    <div class="page-header">
        <div class="page-title">
            <h4>{{__('Statistics')}}</h4>
        </div>

        <div class="breadcrumb-line mx-3 mt-3">
            <div class="d-flex">
                <div class="breadcrumb">
                    <a href="{{route('home')}}" class="breadcrumb-item"><i class="material-icons mr-2">home</i> {{__('Home')}}</a>
                    <span class="breadcrumb-item active">{{__('Statistics')}}</span>
                </div>
            </div>
        </div>
    </div>
    <style>
            .scroll{
                padding: 0 !important;
                box-shadow: inset -5px 3px 22px #8080807d;
            }
            .scroll::-webkit-scrollbar{
                    width: .7rem;;
            }
            .scroll::-webkit-scrollbar-track{
                    background: #f1f1f1;
            }
            .scroll::-webkit-scrollbar-thumb{
                background: #cdcdcd;
                border-radius: 5rem;
            }
        </style>
    <div class="content">
        <script src="{{ asset('js/Highcharts.js') }}" ></script>
        @include('components.message')
        @include('components.statistic.statisticFilter')
        
        
        @if ($view == 'index')
            @if(!empty($allData))
                <div class="row">
                @foreach ($allData as $dataKey => $dataValue)
                    @php( $chartkey = uniqid() )
                    <div class="col-md-6">
                        @include('components.statistic.pieChart',['chartkey' => $chartkey, 'data' => $dataValue])
                    </div>
                @endforeach
                </div>
            @else
                <div class="card shadow-sm p-3 mb-5 bg-white rounded">
                    <div class="card-body row d-flex justify-content-center">
                        <div class="col-4">
                            <img style="width:100%" src="images/dataNotFound.png" alt="dddd">
                        </div>
                    </div>
                </div>
            @endif
        @endif
    </div>
</div>