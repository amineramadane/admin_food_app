<div>
    @if ($view == 'index')
        <div class="d-flex justify-content-end mt-3">
            @if($this->ObjectFilter->can('edit'))
                @can($this->ObjectFilter->getTable().'_edit')
                    <button wire:click="viewQuestionPosition" wire:key="question_position" class="btn btn-primary btn-round mr-3"><i class="material-icons">open_with</i> {{__('position') }}</button>
                @endcan
            @endif
            @if($this->ObjectFilter->can('create'))
                @can($this->ObjectFilter->getTable().'_create')
                    <button wire:click="viewCreate" wire:key="question" class="btn btn-success btn-round"><i class="material-icons">add</i>{{__('Add') }}</button>
                @endcan
            @endif
        </div>
    @endif
    @if($this->view != 'index')
        <div class="d-flex justify-content-end mt-3">
            <button wire:click="viewIndex" class="btn btn-secondary btn-round"><i class="material-icons md-18">arrow_back</i> <span class="d-md-inline d-none">{{__('Back To List')}}</span></button>
        </div>
    @endif
    <div class="content mt-4" style="box-shadow: 0 0 20px #8080803d;">
        
        @include('components.message')
        @if ($view == 'index')
            @php($deletekey = uniqid())
            @include('components.modalDelete',['deletekey' => $deletekey ])
            @include('components.index',['deletekey' => $deletekey ])
        @elseif ($view == 'create')
            @include('livewire.question.edit')
        @elseif ($view == 'edit')
            @include('livewire.question.edit')
        @elseif ($view == 'show')
            @include('livewire.question.show')
        @elseif($view == 'update_position')
            @include('livewire.question.sortquestion')    
        @endif
    </div>

    @include('components.script')
</div>