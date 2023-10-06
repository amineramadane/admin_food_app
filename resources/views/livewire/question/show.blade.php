<div class="card bg-white mt-3">
    <div class="card-body">
            <div class=" row">
                <h2 class="col">{{ $this->Object->title }}</h2>
            </div>
            <div class="row mt-2">
                <h5 class="col-2">{{ __('status') }} : 
                    <span class="badge text-white {{ $this->Object->status == 1 ? 'bg-danger' : 'bg-success' }}">
                        {{__($ListStatus[$this->Object->status]) ?? ''}}
                    </span>
                </h5>
                <h5 class="col-3">
                    <span class="align-self-center">{{ __('question_type') }} :</span> &nbsp;
                    <span class="badge bg-info text-white">{{ __($questionTypes[$this->Object->question_type]) }}</span>
                </h5>
                <div class="col-7">
                    @if($this->Object->question_type == 2)
                        <table class="table table-bordered col-md-8" style="position:relative">
                            <thead class="bg-white shadow-sm" style="position:sticky; top:0;">
                                <tr>
                                    <th scope="col" style="font-size: .9vw !important;">{{__('Rating scale')}}</th>
                                    <th scope="col" style="font-size: .9vw !important;">{{__('title')}}</th>
                                    <th scope="col" style="font-size: .9vw !important;">{{__('status')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($choices as $keyrating => $rating)
                                    <tr>
                                        <th scope="row">{{$keyrating}}</th>
                                        <td>{{$rating}}</td>
                                        <td>
                                            <span class="badge text-white bg-{{ $statusChoices[$keyrating] == 10 ? 'danger' :'success' }}">{{$positiveORnegative[$statusChoices[$keyrating]]}}</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
            @if($this->Object->description)
                <div class="row mt-2">
                    <p class="col">{{ $this->Object->description }}</p>
                </div>
            @endif
    </div>
    <!-- <div class="card-body bg-light"> -->
        @livewire('questionlanguage-component',['question_id' => $this->Object->id])
    <!-- </div> -->
</div>