@extends('layouts.admin.default')

@section('content')
<div class="container-fluid">
    <div class="card mx-auto" style="max-width: 750px;">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h3 class="mb-0">Edit Product</h3>
                <a href="{{ route('admin.products.index') }}" class="btn btn-primary"><i class="fas fa-chevron-left"></i> Back</a>
            </div>
        </div>

        <div class="card-body pt-3">
            @php
                $editUrl = route('admin.products.update', ['product' => $product->product_id]);
            @endphp
            <form id="edit_product_form" action="{{ $editUrl }}" enctype="multipart/form-data" accept-charset="utf-8">
                @csrf
                @method('PUT')

                <div class="form-group col-md-6 mb-2">
                    <label for="sku">SKU</label>
                    <input type="text" name="sku" id="sku" value="{{ $product->sku }}" class="form-control">
                    <p id="sku_msg" class="input-status-msg"></p>
                </div>

                <div class="form-group mb-2">
                    <label for="title">Product Title</label>
                    <input type="text" name="title" id="title" value="{{ $product->title }}" class="form-control">
                    <p id="title_msg" class="input-status-msg"></p>
                </div>

                <div class="form-group mb-2">
                    <label for="description">Description</label>
                    <textarea name="description" id="description" class="form-control">{{ $product->description }}</textarea>
                    <p id="description_msg" class="input-status-msg"></p>
                </div>

                <div class="row">
                    <div class="form-group col-md-6 mb-2">
                        <label for="qty">Quantity</label>
                        <input type="number" name="qty" id="qty" value="{{ $product->qty }}" class="form-control">
                        <p id="qty_msg" class="input-status-msg"></p>
                    </div>
                    <div class="form-group col-md-6 mb-2">
                        <label for="price">Price</label>
                        <input type="number" name="price" id="price" value="{{ $product->price }}" class="form-control">
                        <p id="price_msg" class="input-status-msg"></p>
                    </div>
                </div>

                <div class="form-group col-md-6 mb-2">
                    <label for="photo">Photo</label>
                    <input type="file" name="photo" id="photo" class="form-control">
                </div>

                <div id="edit_product_status" class="my-3"></div>

                <div class="d-table mx-auto">
                    <button type="submit" id="edit_product_submit" class="btn btn-primary" style="min-width: 110px;">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
