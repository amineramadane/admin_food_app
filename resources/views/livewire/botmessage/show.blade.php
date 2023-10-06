<div class="card bg-white">
    <div class="card-body">

        <div class="form-group row">
            <div class="col-md-2">{{ __('welcome_message') }}</div>
            <div class="col-md-7">
                <textarea class="form-control" rows="5" readonly>{{$this->Object->welcome_message}}</textarea>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-2">{{ __('excuse_message') }}</div>
            <div class="col-md-7">
                <textarea type="text" class="form-control" rows="5" readonly>{{$this->Object->excuse_message}}</textarea>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-2">{{ __('cancel_message') }}</div>
            <div class="col-md-7">
                <textarea type="text" class="form-control" rows="5" readonly>{{$this->Object->cancel_message}}</textarea>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-2">{{ __('language') }}</div>
            <div class="col-md-7">
                <input type="text" class="form-control" readonly value="{{$ListLang[$this->Object->language_id] ?? ''}}">
            </div>
        </div>
    </div>
</div>