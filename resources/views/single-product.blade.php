@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        {{-- <div class="card-header">{{ __('Dashboard') }}</div> --}}

        <div class="card-body">

            <div class="row single-product">
                @php
                    $product_id    = $product->product_id;
                    $title  = $product->title;
                    $desc  = $product->description;
                    $price  = ol_rupee($product->price, 2);

                    $photo  = $product->photo;
                    $photo  = product_img_src($photo, "640x480");

                    $productUrl = route('products.single', ['id' => $product_id]);
                @endphp

                <div class="col-12 col-sm-5 col-md-4">
                    <div class="product-image">
                        <img src="{{ $photo }}" alt="photo">
                    </div>
                </div>
                <div class="col-12 col-sm-7 col-md-8">
                    <div class="product-info">
                        <h3 class="mt-0 mb-0">{{ $title }}</h3>
                        <p class="h5 mt-2">{!! $price !!}</p>

                        <button id="addToCartBtn" class="btn btn-primary mt-2" data-product-id="{{ $product_id }}">Add To Cart</button>
                        <div id="addToCartStatus" class="my-2"></div>

                        <p class="mt-5">{!! $desc !!}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
