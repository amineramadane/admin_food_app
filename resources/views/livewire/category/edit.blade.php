<div class="card bg-white">
    <div class="card-body">

        <img src="{{ optional($Object->image)->path }}" alt="" style="position: absolute; right: 60px; width: 6rem;">

        <div class="form-group row">
            <label class="col-md-2 required">{{ __('name') }}<span class="required" style="color:red;">&nbsp;*</span></label>
            <div class="col-md-7">
                <input wire:model="Object.name" rows="5" placeholder="{{ __('name') }}..." type="text" class="form-control{{ $errors->has('Object.name') ? ' is-invalid' : '' }}" />
                @error('Object.name')
                <span class="text-danger" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
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
            <div class="col-md-2 text-center pt-1">{{ __('Image') }}</div>
            <div class="col-md-3">
                <input wire:model="imageMorph" type="file" accept="image/png, image/jpeg" class="form-control{{ $errors->has('imageMorph') ? ' is-invalid' : '' }}" />
                @error('imageMorph')
                <span class="text-danger" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-12 text-right">
                <button wire:click="save" class="btn btn-primary"><i class="fas fa-save mr-1"></i>
                    {{ __('Save') }}
                </button>
                <button wire:click="viewIndex" class="btn btn-danger">
                    {{ __('Cancel') }}
                </button>
            </div>
        </div>
    </div>
</div>