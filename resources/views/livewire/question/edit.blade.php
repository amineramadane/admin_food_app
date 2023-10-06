<div class="card bg-white">
    <div class="card-body">
        <div class="form-group row">
            <div class="col-md-2">{{ __('title') }}<span class="required" style="color:red;">&nbsp;*</span></div>
            <div class="col-md-8">

                <input id="title" wire:model="Object.title" rows="5" placeholder="{{ __('title') }}..." type="text" class="form-control{{ $errors->has('Object.title') ? ' is-invalid' : '' }}" />

                @error('Object.title')
                <span class="text-danger" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-2">{{ __('status') }}</div>
            <div class="col-md-8">
                <select wire:model="Object.status" class="form-control">
                    @foreach ($ListStatus as $key => $value)
                    <option value="{{ $key }}">{{ __($value) }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-2">{{ __('question_type') }}</div>
            <div class="col-md-8">
                <select wire:model="Object.question_type" class="form-control" id="types" >
                    @foreach ($questionTypes as $key => $value)
                    <option value="{{ $key }}">{{ __($value) }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        @if($this->Object->question_type == 2)
            @php($uniq = uniqid())
            <div class="form-group row" wire:key="{{ $uniq }}">
                <div class="col-md-2 mt-2">{{ __('choice') }}<span class="required" style="color:red;">&nbsp;*</span></div>
                <div class="col-lg-2">
                    <input id="numberChoice_{{$uniq}}" placeholder="{{__('Rating scale')}}..." type="number" class="form-control addInput" />
                </div>
                <div class="col-md-3">
                    <input id="textChoice_{{$uniq}}" placeholder="{{__('title')}}..." type="text" class="form-control addInput" />
                </div>

                <div class="col-md-2">
                    <select id="statusChoice_{{$uniq}}"  class="form-control addInput">
                        <option value="10">negative</option>
                        <option value="20">positive</option>
                    </select>
                </div>

                <div class="col-md-1">
                    <button class="btn btn-sm btn-success form-control" id="addChoice_{{$uniq}}" wire:click="">
                        <i class="material-icons md-18">add</i>
                    </button>
                </div>
                @error('Object.choices')
                    <span class="text-danger" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                <script>
                    $('.addInput').on('keyup change', function() {
                        if($.trim($('#numberChoice_{{$uniq}}').val()).length && $.trim($('#textChoice_{{$uniq}}').val()).length ){
                            $('#addChoice_{{$uniq}}').attr("wire:click",'addChoice(`'+$('#numberChoice_{{$uniq}}').val()+'|'+$('#textChoice_{{$uniq}}').val()+'|'+$('#statusChoice_{{$uniq}}').val()+'`)');
                        }else{
                            $('#addChoice_{{$uniq}}').attr("wire:click",'');
                        }
                    })
                </script>

            </div>
            @if(!empty($choices))
            <div class="form-group row">
                <div class="col-md-2"></div>
                <div class="col-md-8 bg-light pt-2" style="max-height: 200px; overflow-y:scroll">
                    @foreach($choices as $key => $choice)
                        <div class="form-group row">
                            <div class="col-md-2">
                                <input readonly value="{{ $key }}" type="number" class="form-control" />
                            </div>
                            <div class="col-md-6">
                                <input readonly value="{{ $choice }}" type="text" class="form-control" />
                            </div>
                            <div class="col-md-2">
                                <h4>
                                    <span class="badge text-white bg-{{ $statusChoices[$key] == 10 ? 'danger' :'success' }}">{{$positiveORnegative[$statusChoices[$key]]}}</span>
                                </h4>
                            </div>
                            <div class="ml-3" style="white-space: nowrap">
                                <button class="rounded btn btn-danger btn-sm form-control" wire:click="deleteChoice({{$key}})">
                                    <i class="material-icons ">delete</i>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif
        @endif
        <div class="form-group row" style="display:none;">
            <div class="col-md-2">{{ __('answer_type') }}</div>
            <div class="col-md-7">
                <select wire:model="Object.answer_type" class="form-control" id="answer_types">
                    @foreach ($answerTypes as $key => $value)
                        <option value="{{ $key }}">{{ __($value) }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-12 text-right">
                <button {{ ($this->Object->question_type == 2 && (empty($choices) || count($choices) < 2 )) ? 'disabled' : 'wire:click=save' }} class="btn btn-primary "><i class="fas fa-save mr-1"></i>
                    {{ __('Save') }}
                </button>
                <button wire:click="viewIndex" class="btn btn-danger">
                    {{ __('Cancel') }}
                </button>
            </div>
        </div>
    </div>
</div>