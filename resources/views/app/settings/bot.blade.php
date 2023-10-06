@extends('app.layout')

@section('sub_content')

    <div class="page-header">
        <div class="page-title">
            <h4>{{__('Settings')}}</h4>
        </div>

        <div class="breadcrumb-line mx-3 mt-3">
            <div class="d-flex">
                <div class="breadcrumb">
                    <a href="{{route('home')}}" class="breadcrumb-item"><i class="material-icons mr-2">home</i> {{__('Home')}}</a>
                    <span class="breadcrumb-item active">{{__('Settings')}}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger" role="alert">
                {{ session('error') }}
            </div>
        @endif

        <div class="card bg-white">
            <div class="card-body">
                @include('app.settings.nav')
                <form method="POST" action="{{route('settings.bot_update')}}">
                    @method('PATCH')
                    @csrf
                    <div class="form-group row">
                        <div class="col-md-2 text-right"></div>
                        <div class="col-md-3"><strong>{{ __('Send a Test Messages WhatsApp') }}</strong></div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-2 text-right">{{ __('Message') }}</div>
                        <div class="col-md-7">
                            <textarea id="message" type="text" class="form-control{{ $errors->has('message') ? ' is-invalid' : '' }}" name="message">{{setting('bot.message')}}</textarea>
                            @if ($errors->has('message'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('message') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <div class="col-md-2"></div>
                        <div class="col-md-8">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Save') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        @if(setting('whatsapp.status') == 2)
            <div class="card bg-white mt-3">
                <div class="card-body">
                    <form method="POST" action="{{route('settings.send_test_msg_wtsp')}}">
                        @method('PATCH')
                        @csrf
                        <div class="form-group row">
                            <div class="col-md-2 text-right"></div>
                            <div class="col-md-3"><strong>{{ __('Send a Test Messages WhatsApp') }}</strong></div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-2 text-right">{{ __('Message') }}</div>
                            <div class="col-md-3">
                                <input id="test_msg_wtsp" type="text" class="form-control{{ $errors->has('test_msg_wtsp') ? ' is-invalid' : '' }}" value="{{ old('test_msg_wtsp') }}" name="test_msg_wtsp" required>

                                @if ($errors->has('test_msg_wtsp'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('test_msg_wtsp') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-2 text-right">{{ __('Send To') }}</div>
                            <div class="col-md-3">
                                <input id="send_to_num_wtsp" type="text" class="form-control{{ $errors->has('send_to_num_wtsp') ? ' is-invalid' : '' }}" value="{{ old('send_to_num_wtsp') }}" name="send_to_num_wtsp" required>

                                @if ($errors->has('send_to_num_wtsp'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('send_to_num_wtsp') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group row mb-0">
                            <div class="col-md-2"></div>
                            <div class="col-md-8">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Send') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        @endif
    </div>
@endsection
