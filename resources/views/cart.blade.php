@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        {{-- <div class="card-header">{{ __('Dashboard') }}</div> --}}

        <div class="card-body">
            @if(session('cart'))
            <table id="cart" class="table table-hover table-condensed">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th style="width:100px">Price</th>
                        <th style="width:120px">Quantity</th>
                        <th style="width:100px" class="text-center">Subtotal</th>
                        <th style="width:80px"></th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $total = 0;
                    @endphp

                        @foreach(session('cart') as $id => $details)
                            @php
                                $photo  = $details['photo'];
                                $photo  = product_img_src($photo, "100x100");

                                $total += $details['price'] * $details['quantity']
                            @endphp
                            <tr data-id="{{ $id }}">
                                <td data-th="Product">
                                    <div class="row">
                                        <div class="col-sm-3 hidden-xs"><img src="{{ $photo }}" width="100" height="100" class="img-responsive"/></div>
                                        <div class="col-sm-9">
                                            <h4 class="nomargin">{{ $details['title'] }}</h4>
                                        </div>
                                    </div>
                                </td>
                                <td data-th="Price">&#8377;{{ $details['price'] }}</td>
                                <td data-th="Quantity">
                                    <input type="number" value="{{ $details['quantity'] }}" class="form-control quantity update-cart" />
                                </td>
                                <td data-th="Subtotal" class="text-center">&#8377;{{ $details['price'] * $details['quantity'] }}</td>
                                <td class="actions" data-th="">
                                    <button class="btn btn-danger btn-sm remove-from-cart"><i class="fa fa-trash-o"></i></button>
                                </td>
                            </tr>
                        @endforeach

                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="5" class="text-right"><h3><strong>Total &#8377;{{ $total }}</strong></h3></td>
                    </tr>
                    <tr>
                        <td colspan="5" class="text-right">
                            <a href="{{ url('/') }}" class="btn btn-warning"><i class="fa fa-angle-left"></i> Continue Shopping</a>
                            <a href="{{ route('checkout') }}" class="btn btn-success">Checkout</a>
                        </td>
                    </tr>
                </tfoot>
            </table>
            @else
                <div class="text-center py-5">
                    <h3 class="text-danger">Your shopping cart is empty</h3>
                    <a href="{{ url('/') }}" class="btn btn-primary">Continue Shopping <i class="fa fa-angle-right"></i></a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
