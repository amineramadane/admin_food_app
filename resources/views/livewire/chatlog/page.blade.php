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
        @include('livewire.chatlog.edit')
        @elseif ($view == 'edit')
        @include('livewire.chatlog.edit')
        @elseif ($view == 'show')
        @include('livewire.chatlog.show')
        @endif
    </div>

    @include('components.script')
</div>