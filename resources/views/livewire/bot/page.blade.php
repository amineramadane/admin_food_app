<div>

    @section('heading')
    @endsection
    @include('components.page_header')


    
    <div class="content">
        @include('components.message')
        @if ($view == 'index')
            @include('components.filter')
            @php($deletekey = uniqid())
            @include('components.modalDelete',['deletekey' => $deletekey ])
            @include('components.index',['deletekey' => $deletekey ])
        @elseif ($view == 'create')
            @include('livewire.bot.edit')
        @elseif ($view == 'edit')
            @include('livewire.bot.edit')
        @elseif ($view == 'show')
            @include('livewire.bot.show')
        @endif
    </div>

    @include('components.script')
</div>