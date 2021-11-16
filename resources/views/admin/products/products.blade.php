@extends('layouts.admin.default')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h3 class="mb-0">All Products</h3>
                <a href="{{ route('admin.products.create') }}" class="btn btn-primary">Add Product</a>
            </div>
        </div>

        <div class="card-body">
            <table id="cart" class="table table-hover table-condensed">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th style="width:120px"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($Products as $product)
                        @php
                            $price  = ol_rupee($product->price, 0);
                            $photo  = $product->photo;
                            $photo  = product_img_src($photo, "50x50");

                            $editUrl    = route('admin.products.edit', ['product' => $product->product_id]);
                        @endphp

                        <tr>
                            <td>
                                <div class="d-flex">
                                    <div style="width:50px;">
                                        <img src="{{ $photo }}" alt="photo" class="w-100">
                                    </div>
                                    <div class="ps-2">
                                        <small>SKU: {{ $product->sku }}</small>
                                        <br />
                                        {{ $product->title }}
                                    </div>
                                </div>
                            </td>
                            <td>{!! $price !!}</td>
                            <td>{{ $product->qty }}</td>
                            <td>
                                <a href="{{ $editUrl }}" class="btn btn-primary btn-sm me-2"><i class="fas fa-pencil-alt"></i></a>
                                <button class="btn btn-danger btn-sm"><i class="far fa-trash-alt"></i></button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="text-center mt-5 mx-auto" style="width: max-content;">
                {{ $Products->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
