
<div wire:ignore.self class="modal fade" id="{{$key ?? 'ImportModels' }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel{{$key}}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable {{$this->ClassCssModalDialog}}" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel{{$key}}">{{ __($key ?? 'Import Excel') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true close-btn">×</span>
                </button>
            </div>
            <div class="modal-body">

                @if (session('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger" role="alert">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="{{$this->ClassCssPart1}} text-centre">
                    {{-- <div class="alert alert-primary mt-2" role="alert">
                        Cliquez<span wire:click="downloadDemoFile" class="alert-link" style="cursor: pointer"> ici </span>pour télécharger un modèle de fichier Excel exemple !
                    </div> --}}
                    <div class="text-center py-2">
                        <button id="btn1{{$key}}" class="btn btn-success" type="button" style="display: none">
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            {{__('Loading')}}...
                        </button>
                        <button id="btn2{{$key}}" class="btn btn-outline-success" type="button" onclick="$('#btn2{{$key}}').hide(); $('#btn1{{$key}}').show(); $('#file{{$key}}').click()">
                            {{__('Upload File')}}
                        </button>
                        <input hidden id="file{{$key}}" type="file" wire:model="file" accept=".csv, .xls, .xlsx" onclick="fileOnClick()" onchange="if($('#file{{$key}}')[0].files.length) {$('#btn2{{$key}}').hide(); $('#btn1{{$key}}').show();}">
                        <button wire:click="downloadDemoFile" class="btn btn-outline-primary" type="button">
                            {{__('Download example file')}}
                        </button>
                    </div>
                </div>
                
                <div class="{{$this->ClassCssPart2}}">
                    
                    {{-- <div class="alert alert-primary pb-0" role="alert">
                        {{__('NB :')}}
                        <ul>
                            <li>Text1</li>
                            <li>Text2</li>
                        </ul>
                    </div> --}}

                    <div class="custom-control custom-switch mt-2">
                        <input type="checkbox" class="custom-control-input" id="withFirstLine{{$key}}" wire:model="withFirstLine">
                        <label class="custom-control-label" for="withFirstLine{{$key}}">{{__('Le fichier Excel contient des en-têtes?')}}</label>
                    </div>

                    <div class="mt-3">
                        <div class="row">
                            @foreach ($orderListFixed as $index => $value)
                                <div class="col-3 mb-3">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <label class="input-group-text" for="{{__($index)}}">{{__($index)}}
                                                @isset($this->rules["orderList.$index"] )
                                                    <span class="required text-danger pl-1">*</span>
                                                @endif
                                            </label>
                                        </div>
                                        <select wire:model="orderList.{{$index}}" class="custom-select {{ $errors->has("orderList.$index") ? 'is-invalid':'' }}" id="{{__($index)}}">
                                            <option value="" selected>{{__('Choose')}}...</option>
                                            @foreach ($this->dataValidateColumn[0] as $index2 => $values2)
                                                <option value={!!$index2!!}>{{$values2}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error("orderList.$index")
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                
                <div class="{{$this->ClassCssPart3}}">

                    <div class="col-md-12">
                        <nav class="nav nav-tabs mt-3">
                            <a class="nav-item nav-link active" href="#p1{{$key}}" data-toggle="tab">{{ __('Tableau de vérification') }}</a>
                        
                            <div {{ $this->withFirstLine && $this->ClassCssPart3 == '' ? '' : 'hidden'}} class=" ml-3 custom-control custom-switch mt-2">
                                <input type="checkbox" class="custom-control-input" id="showFirstLine{{$key}}" wire:model="showFirstLine">
                                <label class="custom-control-label" for="showFirstLine{{$key}}">{{__('Afficher les en-têtes dans le tableau de vérification')}}</label>
                            </div>
                        </nav>
                        
                        <div class="tab-content">
                            <div class="tab-pane active" id="p1{{$key}}">
                                <div class="table-responsive">
                                    <table class="table table-striped table-borderless border">
                                        <thead>
                                            <tr>
                                                @foreach ($this->orderListFixed as $columnName => $ColumnIndex)
                                                    @if ($this->orderList[$columnName] !== '' && $columnName !== '')
                                                        <th> {{ __($columnName) }} </th>
                                                    @endif    
                                                @endforeach
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($this->dataValidateRows as $key => $value)
                                                <tr>
                                                    @foreach ($orderList as $columnName => $ColumnIndex)
                                                        @if($ColumnIndex !== '' && $columnName !== '')
                                                            <td nowrap>
                                                                @isset($value[array_search(array_search($ColumnIndex, $this->orderListFixed), array_keys($this->orderListFixed))])
                                                                    @php($value1 = $value[array_search(array_search($ColumnIndex, $this->orderListFixed), array_keys($this->orderListFixed))])
                                                                    @isset($value1)
                                                                        @if (gettype($value1) == 'integer' && Str::contains(Str::upper($columnName), Str::upper('date')))
                                                                            {{ PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value1)->format('d-m-Y');}}
                                                                        @else
                                                                            {{ $value1 }}
                                                                        @endif
                                                                    @endisset
                                                                @endisset
                                                            </td>
                                                        @endif
                                                    @endforeach
                                                </tr>
                                            @empty 
                                                <tr>
                                                    <td colspan="100" align="center">{{__('No results found.')}}</td>
                                                </tr>
                                            @endforelse 
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
            <div class="modal-footer">
                <button type="button" wire:click="importFile" class="{{$this->ClassCssPart3}} btn btn-success close-modal">{{__('Import')}}</button>
                <button type="button" wire:click="validateColumn" class="{{$this->ClassCssPart2}} btn btn-primary close-modal">{{__('Vérifier')}}</button>
                <button type="button" wire:click="resetAll" class="btn btn-secondary close-btn" data-dismiss="modal">{{__('Cancel')}}</button>
            </div>
        </div>
    </div>
    <script>
        var theFile = document.getElementById('file{{$key}}');
    
        function fileOnClick() {
            document.body.onfocus = bodyOnFocus;
        }
            
        function bodyOnFocus() {
            if(!document.getElementById('file{{$key}}').value.length) { $('#btn2{{$key}}').show(); $('#btn1{{$key}}').hide(); } 
            document.body.onfocus = null;
        }
    </script>
</div>