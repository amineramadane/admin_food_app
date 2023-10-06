<div class="card-body">
    @if ($view == 'index' && count($existlangs) !== 0 )
        @if($this->ObjectFilter->can('create'))
            @can($this->ObjectFilter->getTable().'_create')
                <div class="d-flex justify-content-end mt-3">
                    <button wire:click="viewCreate" wire:key="question" class="btn btn-success btn-round"><i class="material-icons">add</i>{{__('Add') }}</button>
                </div>
            @endcan
        @endif
    @endif
    @if($this->view == 'show' || $this->view == 'create' || $this->view == 'edit')
        <div class="d-flex justify-content-end mt-3">
            <button wire:click="viewIndex" class="btn btn-secondary btn-round"><i class="material-icons md-18">arrow_back</i> <span class="d-md-inline d-none">{{__('Back To List')}}</span></button>
        </div>
    @endif
    <div class="content mt-3" style="box-shadow: 0 0 20px #8080803d;">
        @include('components.message')
        @if ($view == 'index')
            @php($deletekey = uniqid())
            @include('components.modalDelete',['deletekey' => $deletekey ])
            @include('components.index',['deletekey' => $deletekey ])
        @elseif ($view == 'create')
            @include('livewire.questionlanguage.edit')
        @elseif ($view == 'edit')
            @include('livewire.questionlanguage.edit')
        @elseif ($view == 'show')
            @include('livewire.questionlanguage.show')
        @endif
    </div>

    @include('components.script')
</div>