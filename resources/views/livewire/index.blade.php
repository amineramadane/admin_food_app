<div>

    <div class="card bg-white mt-3">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-borderless">
                    <thead>
                        <tr>
                            @can($this->ModelRoute.'_edit')
                                <th width="1"></th>
                            @endcan
                            @can($this->ModelRoute.'_delete')
                                <th width="1"></th>
                            @endcan
                            @foreach ($this->Object->displayColumns as $Column => $value)
                            <th wire:click="sort('{{$Column}}')">
                                {{ __("$Column") }}
                                <i {!! !($sortColumn == $Column && $sortDirection == 'ASC') ? 'hidden':'' !!} class="bi bi-arrow-up float-right" style="font-size: 17px"></i>
                                <i {!! !($sortColumn == $Column && $sortDirection == 'DESC') ? 'hidden':'' !!} class="bi bi-arrow-down float-right" style="font-size: 17px"></i>
                                <i {!! $sortColumn == $Column ? 'hidden':'' !!} class="bi bi-arrow-down-up float-right" style="font-size: 17px"></i>
                            </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($TableList as $Item)
                        <tr>
                            @can($this->ModelRoute.'_edit')
                                <td width="1">
                                    <a href="{{route($this->ModelRoute.'.edit', $Item->id)}}" data-toggle="tooltip" data-placement="top" title="{{__('Edit Order')}}">
                                        <i class="material-icons md-18 text-grey">edit</i>
                                    </a>
                                </td>
                            @endcan
                            @can($this->ModelRoute.'_delete')
                                <td width="1">
                                    <a href="#" data-toggle="modal" data-target="#delete-{{ $Item->id }}" title="{{__('Delete Order')}}">
                                        <i class="material-icons md-18 text-grey">delete</i>
                                    </a>
                                    <x-modal-delete :objDelete="$Item" action="{{ route($this->ModelRoute.'.destroy', $Item) }}" />
                                </td>
                            @endcan
                            @foreach ($this->Object->displayColumns as $Column => $value)
                                <td>
                                    @if ($Column=='heure')
                                        {{ date('H:i', strtotime($Item[$Column])) }}
                                    @elseif ($Column=='reference')
                                        <a class="text-dark reference" href="{{route($this->ModelRoute.'.show', $Item['id'])}}">{{ $Item[$Column] }}</a>
                                    @else
                                        @if (count($value) != 0)
                                            @php($ListToFillableShowed = $this->Object->displayColumns[$Column])

                                            @foreach ($ListToFillableShowed as $FillableShowed)
                                                @php($ItemTemp = $Item)

                                                {{ $loop->first ? '' : $FillableShowed['splitedWith'] ?? ' - ' }}

                                                @foreach ($FillableShowed as $ColumnAuto)
                                                    @php($ItemTemp = $ItemTemp[$ColumnAuto])
                                                    @if($loop->last)
                                                        {{ $ItemTemp }}
                                                    @endif
                                                @endforeach

                                            @endforeach
                                        @else
                                            {{ $Item[$Column] }}
                                        @endif
                                    @endif
                                </td>
                            @endforeach
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" align="center">{{__('No results found.')}}</td>
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
</div>

<script>
    // for reset filter front end
    function resetFilter(){
        $(".styleSelect2").each(function() {
            $(this).val({!!json_encode($this->Object->getOriginal())!!}[$(this)[0]['attributes']['wire:model']['nodeValue'].split('.')[1]]).trigger('change');
        });
    }
    
    // addEventListener for filter to list contains class styleSelect2
    document.addEventListener('livewire:load', function () {
        $(".styleSelect2").each(function() {
            $(this).select2({
                theme: 'bootstrap4',
            }).on('change', function() {
                @this.set($(this)[0]['attributes']['wire:model']['nodeValue'], $(this).val());
            });
        });
    });
</script>