@extends('app.layout')

@section('sub_content')

@livewire($name, ['id' => request()->id])

@endsection