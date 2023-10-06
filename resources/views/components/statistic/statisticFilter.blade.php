{{-- Filter --}}

<div class="card bg-white shadow mb-4" style="position:sticky; top:0; z-index:100;">
    <div class="card-body">
        <div class="row">
            <div class="col-md-9 row my-2">
                <label class="col-2 my-1 pr-0 nowrap text-secondary text-right pr-2" for="fromMonth" nowrap>{{ __('Month') }}</label>
                <div class="col-xl col-md-4 px-0">
                    <div class="input-group bg-light">
                        <select name="fromMonth" id="fromMonth" wire:model="fromMonth" class="form-control form-control-sm" >
                            @foreach ($months as $m => $month)
                                <option value="{{$m}}">{{__($month)}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
                <label class="col-1 my-1 px-0 text-center text-secondary" for="toMonth">{{ __('to')}}</label>
                <div class="col-xl pr-2 col-md-4 px-0">
                    <div class="input-group bg-light">
                        <select name="toMonth" id="toMonth" wire:model="toMonth" class="form-control form-control-sm" >
                            @foreach ($months as $m => $month)
                                <option value="{{$m}}">{{__($month)}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <label class="col-2 my-1 pr-0 nowrap text-secondary text-right pr-2" for="year" nowrap>{{ __('Year') }}</label>
                <div class="col-xl col-md-4 px-0">
                    <div class="input-group bg-light">
                        <select name="year" id="year" wire:model="year" class="form-control form-control-sm" >
                            @foreach ($years as $y)
                                <option value="{{$y}}">{{$y}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            {{-- resetAll --}}
            <div class="col-md-1 my-2 text-centre pt-1 ml-3">
                <svg wire:click="resetFilter()" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                    fill="currentColor" class="bi bi-x-square-fill" viewBox="0 0 16 16">
                    <path
                        d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm3.354 4.646L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 1 1 .708-.708z" />
                </svg>
            </div>

            <script>
                document.addEventListener('livewire:load', function () {
                    function initFilterDate() {
                            $("#toMonth > option").each(function() {
                                if(Number(this.value) < Number($('#fromMonth').val())){
                                    this.disabled = true;
                                    this.style = "background-color:#bababa !important;"
                                }
                                else this.disabled = false;
                            });
                    }

                    initFilterDate()

                    Livewire.hook('message.processed', async (message, component) => {
                        initFilterDate()
                        if(component.data.toMonth) $('#toMonth').val(Number(component.data.toMonth))
                    })
               
                    $('#fromMonth').on('change', function() {
                        initFilterDate()
                        if(Number($('#toMonth').val()) < Number($('#fromMonth').val())){
                            @this.toMonth = Number($('#fromMonth').val())
                        }
                    })
                    Livewire.hook('message.sent', (message, component) => {
                        topbar.config({
                            autoRun      : true, 
                            barThickness : 3,
                            barColors    : {
                                '0'      : '#e3342f',
                                '0.3'      : '#bb45ee',
                                '1.0'      : '#bb45ee'
                            },
                            shadowBlur   : 5,
                            shadowColor  : 'rgba(0, 0, 0, 1)',
                            className    : 'topbar',
                        })
                        topbar.show()
                    })
                    Livewire.hook('message.processed', (message, component) => {topbar.hide()})

             });
            </script>
        </div>
    </div>
</div>