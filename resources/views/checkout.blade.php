@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">

        <div class="card-body">

            <div class="text-center py-5">

                @if($result["status"] === "success")
                <h3 class="text-success">{{ $result["message"] }}</h3>
                <a href="{{ url('/') }}" class="btn btn-primary">Continue Shopping <i class="fa fa-angle-right"></i></a>
                @else
                <h3 class="text-danger">{{ $result["message"] }}</h3>
                <a href="{{ url('/') }}" class="btn btn-primary">Continue Shopping <i class="fa fa-angle-right"></i></a>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
