<div class="card bg-white mt-3">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-borderless">
                <thead>
                    <tr>
                        @can($this->ObjectFilter->getTable().'_show')
                            <th width="1"></th>
                        @endcan

                        @can($this->ObjectFilter->getTable().'_edit')
                            <th width="1"></th>
                        @endcan

                        @can($this->ObjectFilter->getTable().'_delete')
                            <th width="1"></th>
                        @endcan
                        
                        @foreach ($this->ObjectFilter->displayColumns as $Column => $value)
                            @if (isset($value['table']['column']))
                                @if (in_array($Column, Schema::getColumnListing($this->ObjectFilter->getTable())))
                                    <th wire:click="sort('{{$Column}}')">
                                        <div class="d-inline-flex">
                                            <i {!! !($sortColumn == $Column && $sortDirection == 'ASC') ? 'hidden':'' !!} class="bi bi-arrow-up float-right" style="font-size: 17px"></i>
                                            <i {!! !($sortColumn == $Column && $sortDirection == 'DESC') ? 'hidden':'' !!} class="bi bi-arrow-down float-right" style="font-size: 17px"></i>
                                            <i {!! $sortColumn == $Column ? 'hidden':'' !!} class="bi bi-arrow-down-up float-right" style="font-size: 17px"></i>
                                            <label class="ml-1">{{ __($value['table']['title'] ?? $Column) }}</label>
                                        </div>
                                    </th>
                                @else
                                    <th>
                                        <div class="d-inline-flex">
                                            <label class="ml-1">{{ __($value['table']['title'] ?? $Column) }}</label>
                                        </div>
                                    </th>
                                @endif
                            @endif
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @forelse($TableList as $Item)
                        <tr class="{{!method_exists($Item,'CssClass') ?: $Item->CssClass()}}">
                            @can($this->ObjectFilter->getTable().'_show')
                                <td width="1">
                                    @if($Item->can('show'))
                                        <i wire:click="viewShow({{$Item->id}})" class="bi bi-eye-fill text-success" style="cursor: pointer" data-toggle="tooltip" data-placement="top" title="{{__('Show'). ' ' . __($this->nameModel())}}"></i>
                                    @endif
                                </td>
                            @endcan
                            @can($this->ObjectFilter->getTable().'_edit')
                                <td width="1">
                                    @if($Item->can('edit'))
                                        <i wire:click="viewEdit({{$Item->id}})" class="bi bi-pencil-fill text-success" style="cursor: pointer" data-toggle="tooltip" data-placement="top" title="{{__('Edit'). ' ' . __($this->nameModel())}}"></i>
                                    @endif
                                </td>
                            @endcan
                            @can($this->ObjectFilter->getTable().'_delete')
                                <td width="1">
                                    @if($Item->can('delete'))
                                        <i wire:key="{{$Item->id}}" class="bi bi-trash-fill text-success deleteButton_{{$deletekey}}" style="cursor: pointer" data-toggle="modal" rel="tooltip" data-target="#delete_{{$deletekey}}" data-id="{{$Item->id}}" title="{{__('Delete'). ' ' . __($this->nameModel())}}" ></i>
                                        <!-- <i wire:key="{{$Item->id}}" class="bi bi-trash-fill text-success" style="cursor: pointer" wire:click="delete({{ $Item->id }})" onclick="confirm(`{{__('Are you sure you want to delete this ligne?')}}`,'sssss') || event.stopImmediatePropagation()" title="{{__('Delete'). ' ' . __($this->nameModel())}}" id="deleteButton"></i> -->
                                    @endif
                                </td>
                            @endcan

                            @foreach ($this->ObjectFilter->displayColumns as $Column => $value)
                                @if (isset($value['table']['column']))
                                    <td nowrap>
                                        @if(empty($value['table']['column'])) {{ $Item[$Column] }}
                                        @elseif(isset($value['table']['column']))
                                            @php($ListToFillableShowed = $value['table']['column'])
                                            @foreach ($ListToFillableShowed as $FillableShowed)
                                                {{ $loop->first ? '' : $value['splitedWith'] ?? ' - ' }}
                                                @php($ItemTemp = $Item)
                                                @foreach ($FillableShowed as $ColumnAuto)
                                                    @if ($ColumnAuto == 'reference' && $Column == 'reference')
                                                        <a class="text-dark reference" wire:click="viewShow({{$Item->id}})">
                                                    @elseif($ColumnAuto == 'reference' && $ItemTemp != null)
                                                        <a class="text-dark reference" href="{{ route($ItemTemp->getTable().'.show', $ItemTemp->id) }}">
                                                    @endif

                                                    @php($oldItem = $ItemTemp ?? null)
                                                    @if (Str::contains($ColumnAuto, '()'))
                                                        @php($ItemTemp = __($ItemTemp->{Str::before($ColumnAuto, '()')}())  ?? null)
                                                    @else
                                                        @php($ItemTemp = $ItemTemp->{$ColumnAuto}  ?? null)
                                                    @endif

                                                    @if($loop->last)
                                                        @if ($Column == 'status')
                                                            @if (isset($value['table']['columnColor']) && isset($this->BackgroundColorStatus[$oldItem[$value['table']['columnColor']]]))
                                                                <label class="rounded-pill px-2 text-white" style="{{ $ItemTemp != null ? 'background-color:'.$this->BackgroundColorStatus[$oldItem[$value['table']['columnColor']]] : '' }}">
                                                                    {{ $ItemTemp }}
                                                                </label>
                                                            @else
                                                                {{ $ItemTemp }}
                                                            @endif
                                                        @elseif (Str::contains($ColumnAuto, ['date', '_at']))
                                                            {{ $ItemTemp == null ? '' : date('d-m-Y', strtotime($ItemTemp)) }}
                                                        @else
                                                            {{ $ItemTemp }}
                                                        @endif
                                                    @endif
                                                    @if ($ColumnAuto == 'reference')
                                                        </a>
                                                    @endif
                                                @endforeach
                                            @endforeach
                                        @endif
                                    </td>
                                @endif
                            @endforeach

                        </tr>
                    @empty
                        <tr>
                            <td colspan="20" align="center">{{__('No results found.')}}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="float-left">
                @if(!empty($term))
                {{ $TableList->appends(['s' => $term])->links() }}
                @else
                {{ $TableList->links() }}
                @endif
            </div>

            <div class="float-right text-muted">
                {{ __('Showing') }} {{ $TableList->firstItem() }} - {{ $TableList->lastItem() }} / {{
                $TableList->total() }} ({{ __('page') }} {{ $TableList->currentPage() }})
            </div>
        </div>
    </div>
</div>