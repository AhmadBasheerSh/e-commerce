@extends('site.master')

@section('title', 'About | ' . config('app.name'))

@section('content')
    <section class="page-header">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="content">
                        <h1 class="page-name">{{ __('site.Checkout') }}</h1>
                        <ol class="breadcrumb">
                            <li><a href="{{ route('site.index') }}">{{ __('site.Home') }}</a></li>
                            <li class="active">{{ __('site.Checkout') }}</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="page-wrapper">
        <div class="checkout shopping">
            <div class="container">
                <div class="row">
                    <div class="col-md-8">
                        <script src="https://eu-test.oppwa.com/v1/paymentWidgets.js?checkoutId={{ $id }}"></script>
                        <form action="{{ route('site.payment') }}" class="paymentWidgets" data-brands="VISA MASTER AMEX MADA"></form>

                        {{-- <div id="smart-button-container">
                            <div style="text-align: center;">
                              <div id="paypal-button-container"></div>
                            </div>
                          </div>
                        <script src="https://www.paypal.com/sdk/js?client-id=AXIzjs4AK6Fq_YMtGksv9XL51eQnD7ZxSw3y9PCixgd1wX8GMObAml8t00xdtBqtnjalvXg_n8Qf3gYI&currency=USD" data-sdk-integration-source="button-factory"></script>
                        <script>
                          function initPayPalButton() {
                            paypal.Buttons({
                              style: {
                                shape: 'rect',
                                color: 'blue',
                                layout: 'vertical',
                                label: 'checkout',
                              },
                              createOrder: function(data, actions) {
                                return actions.order.create({
                                  purchase_units: [{"amount":{"currency_code":"USD","value":100}}]
                                });
                              },
                              onApprove: function(data, actions) {
                                return actions.order.capture().then(function(orderData) {
                                  // Full available details
                                  console.log('Capture result', orderData, JSON.stringify(orderData, null, 2));
                                  // Show a success message within this page, e.g.
                                  const element = document.getElementById('paypal-button-container');
                                  element.innerHTML = '';
                                  element.innerHTML = '<h3>Thank you for your payment!</h3>';
                                  // Or go to another URL:  actions.redirect('thank_you.html');
                                });
                              },
                              onError: function(err) {
                                console.log(err);
                              }
                            }).render('#paypal-button-container');
                          }
                          initPayPalButton();
                        </script> --}}
                    </div>
                    <div class="col-md-4">
                        <div class="product-checkout-details">
                            <div class="block">
                                <h4 class="widget-title">{{ __('site.OrderSummary') }}</h4>
                                <div class="media product-card">
                                    @php
                                        $total = 0;
                                    @endphp
                                    @foreach (auth()->user()->carts as $cart)
                                        <a class="pull-left" href="product-single.html">
                                            <img class="media-object" width="80" src="{{ asset('uploads/products/'.$cart->product->image) }}" alt="Image">
                                        </a>
                                        <div class="media-body">
                                            <h4 class="media-heading"><a href="product-single.html">{{ $cart->product->trans_name }}</a>
                                            </h4>
                                            <p class="price">{{ $cart->quantity }} x {{ $cart->price }}</p>
                                            <a onclick="return confirm('Are you sure?!')" class="product-remove" href="{{ route('site.remove_cart', $cart->id) }}">{{ __('site.remove') }}</a>
                                        </div>
                                        {{ $total += $cart->quantity * $cart->price; }}
                                    @endforeach
                                </div>
                                <div class="discount-code">
                                    <div class="summary-total">
                                        <span>{{ __('site.Total') }}</span>
                                        <span>{{ $total }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
