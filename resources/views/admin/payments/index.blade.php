@extends('admin.master')

@section('title', 'Payments | ' . env('APP_NAME'))

@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">{{ __('site.AllPayments') }}</h1>

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
            <th>{{ __('site.OrderID') }}</th>
            <th>{{ __('site.CreatedAt') }}</th>
            <th>{{ __('site.Actions') }}</th>
        </tr>
    </thead>
    <tbody>

        @foreach ($payments as $payment)
        <tr>
            <td>{{ $payment->id }}</td>
            <td>{{ $payment->total }}</td>
            <td>{{ $payment->user->name}}</td>
            <td>{{ $payment->order->id}}</td>
            <td>{{ $payment->created_at ? $payment->created_at->diffForHumans() : '' }}</td>
            <td>
                <form class="d-inline" action="{{ route('admin.users.destroy', $payment->id) }}" method="POST">
                    @csrf
                    @method('delete')
                    <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure')"><i class="fas fa-trash"></i></button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

{{ $payments->links() }}

@stop
