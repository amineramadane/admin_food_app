<div class="card bg-white">
    <div class="card-body">
        <div class="form-group row">
            <div class="col-md-2">{{ __('welcome_message') }}<span class="required" style="color:red;">&nbsp;*</span></div>
            <div class="col-md-7">

                <textarea wire:model="Object.welcome_message" rows="5" placeholder="{{ __('write_your_welcome_message') }}..." type="text" class="form-control{{ $errors->has('Object.welcome_message') ? ' is-invalid' : '' }}">
                </textarea>

                @error('Object.welcome_message')
                <span class="text-danger" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-2">{{ __('excuse_message') }}<span class="required" style="color:red;">&nbsp;*</span></div>
            <div class="col-md-7">

                <textarea wire:model="Object.excuse_message" rows="5" placeholder="{{ __('write_your_excuse_message') }}..." type="text" class="form-control{{ $errors->has('Object.excuse_message') ? ' is-invalid' : '' }}">
                </textarea>

                @error('Object.excuse_message')
                <span class="text-danger" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-2">{{ __('cancel_message') }}<span class="required" style="color:red;">&nbsp;*</span></div>
            <div class="col-md-7">

                <textarea wire:model="Object.cancel_message" rows="5" placeholder="{{ __('write_your_cancel_message') }}..." type="text" class="form-control{{ $errors->has('Object.cancel_message') ? ' is-invalid' : '' }}">
                </textarea>

                @error('Object.cancel_message')
                <span class="text-danger" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-2">{{ __('language') }}</div>
            <div class="col-md-7">

                <select wire:model="Object.language_id" placeholder="{{ __('language') }}..." type="number" class="form-control">
                    @foreach ($existlangs as $key => $value)
                        <option value="{{ $key }}">{{ $value }}</option>
                    @endforeach
                </select>
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