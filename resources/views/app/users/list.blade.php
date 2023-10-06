@extends('app.layout')

@section('sub_content')

    <div class="page-header">
        <div class="page-title">
            <h4>{{__('Users')}}</h4>

            <div class="heading">
                @can('users_create')
                    <a href="{{route('users.create')}}" class="btn btn-primary btn-round"><i class="material-icons">add</i> {{__('Add New User')}}</a>
                @endcan
            </div>
        </div>

        <div class="breadcrumb-line mx-3 mt-3">
            <div class="d-flex">
                <div class="breadcrumb">
                    <a href="{{route('home')}}" class="breadcrumb-item"><i class="material-icons mr-2">home</i> {{__('Home')}}</a>
                    {{-- @if($request->has('new'))
                        <a href="{{route('users.index')}}" class="breadcrumb-item">{{__('Users')}}</a>
                        <span class="breadcrumb-item">{{__('New Users')}}</span>
                    @elseif($request->has('active'))
                        <a href="{{route('users.index')}}" class="breadcrumb-item">{{__('Users')}}</a>
                        <span class="breadcrumb-item">{{__('Active Users')}}</span>
                        @elseif($request->has('banned'))
                        <a href="{{route('users.index')}}" class="breadcrumb-item">{{__('Users')}}</a>
                        <span class="breadcrumb-item">{{__('Banned Users')}}</span>
                    @else
                        <span class="breadcrumb-item active">{{__('Users')}}</span>
                    @endif --}}
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

        @livewire('user-component')
    </div>
@endsection
