<div class="card bg-white">
    <div class="card-body">

    <div class="form-group row">
            <div class="col-md-2">{{ __('full_name') }}</div>
            <div class="col-md-7">
                <input readonly value="{{ $this->Object->full_name }}" rows="5" placeholder="{{ __('full_name') }}..." type="text" class="form-control" />
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-2">{{ __('Phone') }}</div>
            <div class="col-md-7">
                <input readonly value="{{ $this->Object->phone }}" rows="5" placeholder="{{ __('Phone') }}..." type="text" class="form-control{{ $errors->has('Object.phone') ? ' is-invalid' : '' }}" />
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-2">{{ __('Email') }}</div>
            <div class="col-md-7">
                <input readonly value="{{ $this->Object->email }}" rows="5" placeholder="{{ __('Email') }}..." type="email" class="form-control" />
            </div>
        </div>
    </div>
</div>