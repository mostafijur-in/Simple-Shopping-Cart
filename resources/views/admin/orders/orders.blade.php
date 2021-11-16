@extends('layouts.admin.default')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h3 class="mb-0">All Orders</h3>
            </div>
        </div>

        <div class="card-body">
            <table id="cart" class="table table-hover table-condensed">
                <thead>
                    <tr>
                        <th>Order#</th>
                        <th>Customer</th>
                        <th>Products</th>
                        <th>Total</th>
                        <th>Date/Time</th>
                        <th style="width:120px"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($Orders as $order)
                        @php
                            $order_id   = $order->order_id;
                            $user_id    = $order->user_id;
                            $customer   = user_name($user_id);

                            $items  = App\Models\OrderItem::where('order_id', $order_id)->count();
                            $total  = ol_rupee($order->order_total, 0);

                            $date   = localize_date($order->created_at, "d-M-Y h:i A");
                        @endphp

                        <tr>
                            <td>{{ $order_id }}</td>
                            <td>{{ $customer }}</td>
                            <td>{{ $items }}</td>
                            <td>{!! $total !!}</td>
                            <td>{{ $date }}</td>
                            <td class="text-end">
                                <button class="btn btn-primary btn-sm"><i class="fas fa-eye"></i></button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="text-center mt-5 mx-auto" style="width: max-content;">
                {{ $Orders->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
