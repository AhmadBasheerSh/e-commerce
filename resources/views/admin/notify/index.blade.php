@extends('admin.master')

@section('styles')
    <style>
        button {
            border: 0;
            background: transparent;;
        }

    </style>
@endsection

@section('title', 'Notify | ' . env('APP_NAME'))

@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">Notification</h1>

@if (session('msg'))
    <div class="alert alert-{{ session('type') }}">
        {{ session('msg') }}
    </div>
@endif

<div class="container">
    <br>
  <br>
    <h3>({{ auth()->user()->unreadnotifications->count() }}) Unread Notifications</h3>
    <a href="{{ route('readall') }}">Read All</a>
    <div class="list-group">
        @foreach (auth()->user()->notifications as $notification)
            <a href="{{ route('readd', $notification->id) }}" class="list-group-item {{ $notification->read_at ? 'active' : '' }}">
                {{ $notification->data['data'] }}

                <span class="badge badge-light">
                    <form action="{{ route('deletee', $notification->id) }}" method="POST">
                        @csrf
                        @method('delete')
                    <button >Delete</button>
                    </form>
                </span>
            </a>
        @endforeach

      </div>
</div>

<br>
  <br>
@stop
