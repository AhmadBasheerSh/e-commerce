@extends('admin.master')

@section('title', 'Orders | ' . env('APP_NAME'))

@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">{{ __('site.AllOrders') }}</h1>

@if (session('msg'))
    <div class="alert alert-{{ session('type') }}">
        {{ session('msg') }}
    </div>
@endif

<table class="table table-bordered">
    <thead>
        <tr>
            <th>{{ __('site.ID') }}</th>
            <th>{{ __('site.Total') }}</th>
            <th>{{ __('site.User') }}</th>
            <th>{{ __('site.CreatedAt') }}</th>
            <th>{{ __('site.Actions') }}</th>
        </tr>
    </thead>
    <tbody>

        @foreach ($orders as $order)
        <tr>
            <td>{{ $order->id }}</td>
            <td>{{ $order->total }}</td>
            <td>{{ $order->user->name}}</td>
            <td>{{ $order->created_at ? $order->created_at->diffForHumans() : '' }}</td>
            <td>
                <form class="d-inline" action="{{ route('admin.users.destroy', $order->id) }}" method="POST">
                    @csrf
                    @method('delete')
                    <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure')"><i class="fas fa-trash"></i></button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

{{ $orders->links() }}

@stop
