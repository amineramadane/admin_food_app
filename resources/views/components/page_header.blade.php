<div class="page-header">

    <div class="page-title">
        <h4>{{__($this->ModelRoute)}}</h4>
        <div class="heading">

            @if($this->view == 'index' && $this->ObjectFilter->can('create'))
                @can($this->ObjectFilter->getTable().'_create')
                    <button wire:click="viewCreate" class="btn btn-success btn-round"><i class="material-icons">add</i>{{__('Add') }}</button>
                @endcan
            @endif

            @yield('heading')

            @if($this->view == 'show' || $this->view == 'create' || $this->view == 'edit')
            {{-- @if (Str::endsWith(url()->previous(), $this->ObjectFilter->getTable())) --}}
                    <span wire:click="viewIndex" class="btn btn-secondary btn-round"><i class="material-icons md-18">arrow_back</i> <span class="d-md-inline d-none">{{__('Back To List')}}</span></span>
            {{--    @else
                    <a href="{{ url()->previous() }}" class="btn btn-secondary btn-round"><i class="material-icons md-18">arrow_back</i> <span class="d-md-inline d-none">{{__('Back To List')}}</span></a>
                @endif --}}
            @endif

        </div>
    </div>

    <div class="breadcrumb-line mx-3 mt-3">
        <div class="d-flex">
            <div class="breadcrumb">
                
                <a href="{{ route('home') }}" class="breadcrumb-item">
                    <i class="material-icons mr-2">home</i>
                    {{ __('Home') }}
                </a>

                @if ($this->view == 'index')
                    <span class="breadcrumb-item {{$this->view == 'index' ? 'active':''}}" >{{__($this->ModelRoute)}}</span>
                @else
                    <a href="#" wire:click="viewIndex" class="breadcrumb-item">{{__($this->ModelRoute)}}</a>
                @endif

                @if ($this->view == 'create')
                    <span class="breadcrumb-item active">{{__('create')}}</span>
                @elseif($this->view == 'edit')
                    <span class="breadcrumb-item active">{{__('edit')}}</span>
                @endif
            </div>
        </div>
    </div>
</div>