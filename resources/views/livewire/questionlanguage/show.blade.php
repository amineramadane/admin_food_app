<div class="card bg-white">
    <div class="card-body">
        <div class="form-group row">
            <div class="col-md-2">{{ __('message') }}</div>
            <div class="col-md-7">
                <textarea class="form-control" rows="3" readonly>{{$this->Object->message}}</textarea>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-2">{{ __('error_message') }}</div>
            <div class="col-md-7">
                <textarea class="form-control" rows="3" readonly>{{$this->Object->error_message}}</textarea>
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