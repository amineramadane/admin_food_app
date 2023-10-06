<div>

    @section('heading')
    @endsection
    @include('components.page_header')

    <div class="content">
        @include('components.message')
        @if ($view == 'index')
            <div class="d-flex justify-content-end mb-2">
                @can($this->ObjectFilter->getTable().'_export')
                    <a wire:click="export" class="text-white ml-4 btn btn-sm btn-success float-right">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="mr-2 bi bi-file-earmark-spreadsheet-fill" viewBox="0 0 16 16">
                            <path d="M6 12v-2h3v2H6z" />
                            <path d="M9.293 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.707A1 1 0 0 0 13.707 4L10 .293A1 1 0 0 0 9.293 0zM9.5 3.5v-2l3 3h-2a1 1 0 0 1-1-1zM3 9h10v1h-3v2h3v1h-3v2H9v-2H6v2H5v-2H3v-1h2v-2H3V9z" />
                        </svg>{{__("Export excel")}}
                    </a>
                @endcan
                @can($this->ObjectFilter->getTable().'_import')
                    @livewire('import-component', [
                        'key' => 'import_excel_contacts',
                        'DemoFile' => 'download/Contacts.xlsx',
                        'ImportModels' => App\Imports\ImportContacts::class,
                        'rules' => [
                            'orderList.phone' => 'required',
                        ]
                    ])
                    <a data-toggle="modal" data-target="#import_excel_contacts" class="text-white ml-4 btn btn-sm btn-success float-right">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="mr-2 bi bi-file-earmark-spreadsheet-fill" viewBox="0 0 16 16">
                            <path d="M6 12v-2h3v2H6z"/>
                            <path d="M9.293 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.707A1 1 0 0 0 13.707 4L10 .293A1 1 0 0 0 9.293 0zM9.5 3.5v-2l3 3h-2a1 1 0 0 1-1-1zM3 9h10v1h-3v2h3v1h-3v2H9v-2H6v2H5v-2H3v-1h2v-2H3V9z"/>
                        </svg>{{__("import_excel_contacts")}}
                    </a>
                @endcan
            </div>
            @include('components.filter')
            @php($deletekey = uniqid())
            @include('components.modalDelete',['deletekey' => $deletekey ])
            @include('components.index',['deletekey' => $deletekey ])
        @elseif ($view == 'create')
            @include('livewire.contact.edit')
        @elseif ($view == 'edit')
            @include('livewire.contact.edit')
        @elseif ($view == 'show')
            @include('livewire.contact.show')
        @endif
    </div>

    @include('components.script')
</div>