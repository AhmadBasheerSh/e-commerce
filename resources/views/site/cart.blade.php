@extends('site.master')

@section('title', 'About | ' . config('app.name'))

@section('content')
    <section class="page-header">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="content">
                        <h1 class="page-name">{{ __('site.Cart') }}</h1>
                        <ol class="breadcrumb">
                            <li><a href="{{ route('site.index') }}">{{ __('site.Home') }}</a></li>
                            <li class="active">{{ __('site.Cart') }}</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="page-wrapper">
        <div class="cart shopping">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <div class="block">
                            <div class="product-list">
                                @if (auth()->user()->carts->count() > 0)
                                    <form method="post" action="{{ route('site.update_cart') }}">
                                        @csrf
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th class="">{{ __('site.Name') }}</th>
                                                    <th class="">{{ __('site.Price') }}</th>
                                                    <th class="">{{ __('site.Quantity') }}</th>
                                                    <th class="">{{ __('site.Total') }}</th>
                                                    <th class="">{{ __('site.Actions') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @php
                                                $total = 0;
                                            @endphp

                                            @foreach (auth()->user()->carts as $cart)
                                                <tr class="">
                                                    <td class="">
                                                        <div class="product-info">
                                                            <img width="80" src="{{ asset('uploads/products/'.$cart->product->image) }}"
                                                                alt="">
                                                            <a href="{{ route('site.product', $cart->product->slug) }}">{{ $cart->product->trans_name }}</a>
                                                        </div>
                                                    </td>
                                                    <td class="">${{ $cart->price }}</td>
                                                    <td class=""><input type="number" value="{{ $cart->quantity }}" style="width: 50px" name="qyt[{{ $cart->product_id }}]" min="1" max="{{ $cart->product->quantity }}"></td>
                                                    <td class="">${{ $cart->price * $cart->quantity }}</td>
                                                    <td class="">
                                                        <a onclick="return confirm('Are you sure?!')" class="product-remove" href="{{ route('site.remove_cart', $cart->id) }}">{{ __('site.remove') }}</a>
                                                    </td>
                                                </tr>
                                            @endforeach

                                            </tbody>
                                        </table>
                                        <button class="btn btn-solid-border">{{ __('site.UpdateCart') }}</button>
                                        <a href="{{ route('site.checkout') }}" class="btn btn-main pull-right">{{ __('site.Checkout') }}</a>
                                    </form>
                                @else
                                    <div class="text-center">
                                        <a href="{{ route('site.shop') }}" class="btn btn-main">{{ __('site.ShopNow') }}</a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
