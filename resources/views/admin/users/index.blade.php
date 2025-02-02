@extends('admin.master')

@section('title', 'Users | ' . env('APP_NAME'))

@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">{{ __('site.AllUsers') }}</h1>

@if (session('msg'))
    <div class="alert alert-{{ session('type') }}">
        {{ session('msg') }}
    </div>
@endif

<table class="table table-bordered">
    <thead>
        <tr>
            <th>{{ __('site.ID') }}</th>
            <th>{{ __('site.Name') }}</th>
            <th>{{ __('site.Email') }}</th>
            <th>{{ __('site.CreatedAt') }}</th>
            <th>{{ __('site.Actions') }}</th>
        </tr>
    </thead>
    <tbody>

        @foreach ($users as $user)
        <tr>
            <td>{{ $user->id }}</td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->created_at ? $user->created_at->diffForHumans() : '' }}</td>
            <td>
                <form class="d-inline" action="{{ route('admin.users.destroy', $user->id) }}" method="POST">
                    @csrf
                    @method('delete')
                    <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure')"><i class="fas fa-trash"></i></button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

{{ $users->links() }}

@stop
