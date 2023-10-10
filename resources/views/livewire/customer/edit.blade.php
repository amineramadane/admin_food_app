<div class="card bg-white">
    <div class="card-body">

        <div class="form-group row">
            <div class="col-md-2">{{ __('full_name') }}</div>
            <div class="col-md-7">
                <input wire:model="Object.full_name" rows="5" placeholder="{{ __('full_name') }}..." type="text" class="form-control" />
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-2">{{ __('Phone') }}<span class="required" style="color:red;">&nbsp;*</span></div>
            <div class="col-md-7">
                <input wire:model="Object.phone" rows="5" placeholder="{{ __('Phone') }}..." type="text" class="form-control{{ $errors->has('Object.phone') ? ' is-invalid' : '' }}" />
                @error('Object.phone')
                <span class="text-danger" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-2">{{ __('Email') }}</div>
            <div class="col-md-7">
                <input wire:model="Object.email" rows="5" placeholder="{{ __('Email') }}..." type="email" class="form-control" />
                @error('Object.email')
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