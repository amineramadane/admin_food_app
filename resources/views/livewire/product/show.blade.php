<div class="card bg-white">
    <div class="card-body">

        <img src="{{ optional($Object->image)->path }}" alt="" style="position: absolute; right: 60px; width: 7rem;">
    <fieldset disabled="disabled">
        <div class="form-group row">
            <label class="col-md-2">{{ __('name') }}</label>
            <div class="col-md-7">
                <input wire:model="Object.name" rows="5" placeholder="{{ __('name') }}..." type="text" class="form-control{{ $errors->has('Object.name') ? ' is-invalid' : '' }}" />
            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-2 ">{{ __('vat rate') }}</label>
            <div class="col-md-2">
                <select wire:model="Object.vat_rate" class="form-control">
                    @foreach ($ListVatRates as $VatRate)
                        <option value="{{ $VatRate }}">{{ $VatRate }} %</option>
                    @endforeach
                </select>
            </div>
            <label class="col-md-2 text-center pt-1 ">{{ __('category') }}</label>
            <div class="col-md-3">
                <select wire:model="Object.category_id" class="form-control">
                    <option value="">{{ __('select category...') }}</option>
                    @foreach ($ListCategories as $IdCategory => $nameCategory)
                        <option value="{{ $IdCategory }}">{{ $nameCategory }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-2 ">{{ __('ht price') }}</label>
            <div class="col-md-2">
                <input wire:model="Object.ht_price" rows="5" placeholder="{{ __('ht price') }}..." type="number" min="0" class="form-control{{ $errors->has('Object.ht_price') ? ' is-invalid' : '' }}" />
            </div>
            <label class="col-md-2 text-center pt-1 ">{{ __('prepare time') }}</label>
            <div class="col-md-3">
                <input wire:model="Object.prepareTime" rows="5" placeholder="{{ __('prepare time') }}..." type="text" class="form-control{{ $errors->has('Object.prepareTime') ? ' is-invalid' : '' }}" />
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-2">{{ __('Description') }}</div>
            <div class="col-md-7">
                <textarea wire:model="Object.description" rows="5" placeholder="{{ __('Description') }}..." type="description" class="form-control">
                </textarea>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-2">{{ __('Active') }}</div>
            <div class="col-md-2">
                <select wire:model="Object.active" class="form-control">
                    @foreach ($ListBoolean as $key => $value)
                        <option value="{{ $key }}">{{ __($value) }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </fieldset>
    </div>
</div>