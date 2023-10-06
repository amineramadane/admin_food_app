{{-- Filter --}}
<style>
    .select2-container .select2-selection--single {
        height: calc(1.5em + 0.5rem + 2px) !important;
    }
    .select2-selection--single .select2-selection__rendered{
        line-height: calc(1.5em + 0.5rem + 2px) !important;
    }
</style>

<div class="card bg-white">
    <div class="card-body">
        <div class="row">
            @foreach ($this->displayColumnsSorted as $Column => $value)
                @if(isset($value['filter']) && ($filter = $value['filter']) != null)
                    @php($WireModel = (isset($filter['by']) && count($filter['by']) == 1) ? $filter['by'][0] : $Column)
                    @switch($value['filter']['type'] ?? 'exact')
                        @case('like') @case('likeRange') @case('exact')
                            <div class="col-md-3 my-2">
                                <div class="input-group bg-light">
                                    <input wire:model="ObjectFilter.{{$WireModel}}" name="ObjectFilter.{{$WireModel}}" placeholder="{{ __($value['filter']['placeholder'] ?? $Column)}}..." class="form-control form-control-sm" type="text"/>                        
                                </div>
                            </div>
                            @break
                        @case('select')
                            <div {!! $view!='index' ? 'hidden' : '' !!} class="col-md-3 col-xs-12 my-2">
                                <div wire:ignore>
                                    <select wire:model="ObjectFilter.{{$WireModel}}" name="ObjectFilter.{{$WireModel}}" class="form-control form-control-sm styleSelect2">
                                        <option value="">{{ __($value['filter']['placeholder'] ?? $Column)}}...</option>
                                        @foreach (${$value['filter']['list'] ?? $Column} as $key => $type)
                                            <option value="{{ $key }}">{{ __($type) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @break
                        @case('dateRange')
                            <div class="col-md-6 row my-2">
                                <label class="col-3 my-1 pr-0 nowrap text-secondary" for="article_date_livrer" nowrap>{{ __($value['filter']['placeholder'] ?? __('Date'))}}</label>
                                <div class="col-xl col-md-4 px-0">
                                    <div class="input-group bg-light">
                                        <input wire:model="ObjectFilter.{{$WireModel}}_start" name="ObjectFilter.{{$WireModel}}" type="date" id="article_date_livrer" class="form-control form-control-sm" name="article_date_livrer" placeholder="{{ __('Date Livrer...')}}" />
                                    </div>
                                </div>
                                
                                <label class="col-1 my-1 px-0 text-center text-secondary" for="article_date_livrer1">{{ __('to')}}</label>

                                <div class="col-xl pr-2 col-md-4 px-0">
                                    <div class="input-group bg-light">
                                        <input wire:model="ObjectFilter.{{$WireModel}}_end" name="ObjectFilter.{{$WireModel}}" type="date" id="article_date_livrer1" class="form-control form-control-sm" name="article_date_livrer" placeholder="{{ __('Date Livrer...')}}" />
                                    </div>
                                </div>
                            </div>
                            @break
                    @endswitch
                @endif
            @endforeach

            {{-- resetAll --}}
            <div class="col-md-1 my-2 text-centre pt-1">
                <svg wire:click="resetFilter()" onclick="resetFilter()" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                    fill="currentColor" class="bi bi-x-square-fill" viewBox="0 0 16 16">
                    <path
                        d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm3.354 4.646L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 1 1 .708-.708z" />
                </svg>
            </div>
        </div>
    </div>
</div>