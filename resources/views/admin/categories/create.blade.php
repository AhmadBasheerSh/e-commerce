@extends('admin.master')

@section('title', 'Create Category | ' . env('APP_NAME'))

@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">{{ __('site.CreateNewCategory') }}</h1>

@if (session('msg'))
    <div class="alert alert-{{ session('type') }}">
        {{ session('msg') }}
    </div>
@endif

@include('admin.errors')

<form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="mb-3">
        <label>{{ __('site.EnglishName') }}</label>
        <input type="text" name="name_en" placeholder="{{ __('site.EnglishName') }}" class="form-control" />
    </div>

    <div class="mb-3">
        <label>{{ __('site.ArabicName') }}</label>
        <input type="text" name="name_ar" placeholder="{{ __('site.ArabicName') }}" class="form-control" />
    </div>

    <div class="mb-3">
        <label for="image">{{ __('site.Image') }}</label>
        <input type="file" id="image" name="image" class="form-control" />
    </div>

    <div class="mb-3">
        <label>{{ __('site.Category') }}</label>
        <select name="parent_id" class="form-control">
            <option value="">{{ __('site.Select') }}</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}">{{ $category->trans_name }}</option>
            @endforeach
        </select>
    </div>

    <button class="btn btn-success px-5">{{ __('site.Add') }}</button>


</form>

@stop
