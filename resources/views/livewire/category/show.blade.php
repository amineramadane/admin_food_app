<div class="card bg-white">
    <div class="card-body">
        <fieldset disabled="disabled">
        <img src="{{ optional($Object->image)->path }}" alt="" style="position: absolute; right: 60px; width: 6rem;">

        <div class="form-group row">
            <label class="col-md-2">{{ __('name') }}</label>
            <div class="col-md-7">
                <input wire:model="Object.name" rows="5" placeholder="{{ __('name') }}..." type="text" class="form-control{{ $errors->has('Object.name') ? ' is-invalid' : '' }}" />
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
                        <option value="{{ $key }}">{{ $value }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        </fieldset>
    </div>
</div>