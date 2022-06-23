@extends('layouts.dashboard')

@section('title', 'Create Categoryt')

@section('content')


        <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            @include('admin.categories._form', [
                'button_lable' => 'Add'
        ])
            

    </form>

@endsection