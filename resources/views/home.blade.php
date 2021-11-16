@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        {{-- <div class="card-header">{{ __('Dashboard') }}</div> --}}

        <div class="card-body">
            <h3 class="mb-5">Products</h3>

            <div class="row product-grid">
                @foreach ($Products as $product)
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="product-grid-item">
                            @php
                                $title  = $product->title;
                                $price  = "&#8377;". number_format($product->price, 2);
                                $photo  = "https://via.placeholder.com/640x480.png/?text=640x480";

                                $productUrl = route('products.show', ['product' => $product->product_id]);
                            @endphp

                            <a href="{{ $productUrl }}">
                                <img src="{{ $photo }}" alt="photo">
                            </a>
                            <a href="{{ $productUrl }}">
                                <h5 class="mt-2 mb-0">{{ $title }}</h5>
                            </a>
                            <p class="mt-1">{!! $price !!}</p>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="text-center mt-5 mx-auto" style="width: max-content;">
                {{ $Products->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
