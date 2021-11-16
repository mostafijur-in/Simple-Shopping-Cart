@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        {{-- <div class="card-header">{{ __('Dashboard') }}</div> --}}

        <div class="card-body">

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
                        $photo  = "https://via.placeholder.com/100x100.png/?text=100x100";
                    @endphp
                    @if(session('cart'))
                        @foreach(session('cart') as $id => $details)
                            @php $total += $details['price'] * $details['quantity'] @endphp
                            <tr data-id="{{ $id }}">
                                <td data-th="Product">
                                    <div class="row">
                                        <div class="col-sm-3 hidden-xs"><img src="{{ $photo }}" width="100" height="100" class="img-responsive"/></div>
                                        <div class="col-sm-9">
                                            <h4 class="nomargin">{{ $details['name'] }}</h4>
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
                    @endif
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="5" class="text-right"><h3><strong>Total &#8377;{{ $total }}</strong></h3></td>
                    </tr>
                    <tr>
                        <td colspan="5" class="text-right">
                            <a href="{{ url('/') }}" class="btn btn-warning"><i class="fa fa-angle-left"></i> Continue Shopping</a>
                            <button id="checkoutBtn" class="btn btn-success">Checkout</button>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection


@section('scripts')
<script type="text/javascript">

    $(".update-cart").change(function (e) {
        e.preventDefault();

        var ele = $(this);

        $.ajax({
            url: appUrl+"/cart/update",
            method: "patch",
            data: {
                id: ele.parents("tr").attr("data-id"),
                quantity: ele.parents("tr").find(".quantity").val(),
                _token: '{{ csrf_token() }}',
            },
            success: function (response) {
               window.location.reload();
            }
        });
    });

    $(".remove-from-cart").click(function (e) {
        e.preventDefault();

        var ele = $(this);

        if(confirm("Are you sure want to remove?")) {
            $.ajax({
                url: appUrl+"/cart/remove",
                method: "DELETE",
                data: {
                    id: ele.parents("tr").attr("data-id"),
                    _token: '{{ csrf_token() }}',
                },
                success: function (response) {
                    window.location.reload();
                }
            });
        }
    });

</script>
@endsection
