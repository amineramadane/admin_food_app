<div class="card bg-white shadow-sm">
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
                <h5 class="col-5 d-flex align-items-center">
                    <span style="font-size:1.3rem" class="material-icons">schedule</span>
                    <span class="align-self-center">{{ __('Reminder time') }} :</span> &nbsp;
                    <span class="badge bg-primary text-white">{{ $this->Object->reminder_time }} {{ __('minutes') }}</span>
                </h5>
            </div>
            <div class="row mt-2">
                <p class="col">{{ $this->Object->description }}</p>
            </div>        
    </div>
    <div class="card-body mt-2">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation" >
                <a  class="nav-link active" id="botmessage-tab" data-toggle="tab" href="#botmessage" role="tab" aria-controls="botmessage" aria-selected="false">{{ __('messages') }}</a>
            </li>
            <li class="nav-item" role="presentation" >
                <a class="nav-link" id="question-tab" data-toggle="tab" href="#question" role="tab" aria-controls="question" aria-selected="true">{{ __('questions') }}</a>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent" style="position:relative">
            <div class="tab-pane fade show active" id="botmessage" role="tabpanel" aria-labelledby="botmessage" wire:key="botmessage">
                @livewire('botmessage-component',['bot_id' => $this->Object->id])
            </div>
            <div class="tab-pane fade" id="question" role="tabpanel" aria-labelledby="question" wire:key="question">
                @livewire('question-component',['bot_id' => $this->Object->id])
            </div>
        </div>
    </div>
</div>