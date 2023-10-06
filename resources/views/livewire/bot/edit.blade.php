<div class="card bg-white">
    <div class="card-body">

        <div class="form-group row">
            <div class="col-md-2">{{ __('title') }}<span class="required" style="color:red;">&nbsp;*</span></div>
            <div class="col-md-7">

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
            <div class="col-md-7">

                <select wire:model="Object.status" class="form-control">
                    @foreach ($ListStatus as $key => $value)
                        <option value="{{ $key }}">{{ __($value) }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-2">{{ __('Reminder time') }}<span class="required" style="color:red;">&nbsp;*</span></div>
            <div class="col-md-7 input-group">
                <input min="1" wire:model="Object.reminder_time" type="number" class="form-control" value="{{ $this->Object->reminder_time }}" >
                <div class="input-group-append">
                    <span class="input-group-text" id="basic-addon2">{{ __('minutes') }}</span>
                </div>
                @error('Object.reminder_time')
                <span class="text-danger" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-2">{{ __('number of reminders') }}<span class="required" style="color:red;">&nbsp;*</span></div>
            <div class="col-md-7 input-group">
                <input min="0" wire:model="Object.number_reminders" type="number" class="form-control" value="{{ $this->Object->number_reminders }}" >
                <div class="input-group-append">
                    <span class="input-group-text" id="basic-addon2">{{ __('number of time') }}</span>
                </div>
                @error('Object.number_reminders')
                <span class="text-danger" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-2">{{ __('Description') }}</div>
            <div class="col-md-7">
                <textarea wire:model="Object.description" rows="5" placeholder="{{ __('description') }}..." type="text" class="form-control">
                </textarea>
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