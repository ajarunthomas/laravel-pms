@extends('partials.layout')

@section('body')
<div class="row">
    <span>Welcome, {{ Auth::user()->name }}!</span>
</div>
<hr>

<div class="h3 mt-10">
    Products
</div>

<div class="row">
@foreach($products as $p)
    <div class="card col-lg-4">
        @if($p->images->first())
        <img src="{{ asset('/product-images') }}/{{ $p->images->first()->image_url }}" class="card-img-top" alt="{{ $p->name }} image">
        @endif
        <div class="card-body">
            
            <h5 class="card-title">{{ $p->name }}</h5>
            <p class="card-text">{{ $p->description }}</p>
            <p>
            @foreach($p->category as $c)
                <span class="badge bg-primary">{{ $c->name }}</span>
            @endforeach
            </p>
            <hr>
            <span class="badge bg-success float-start">Price: AED {{ $p->price }}</span>
            <span class="badge bg-info float-end">Stock: {{ $p->stock_quantity }}</span>
        </div>
    </div>
@endforeach
</div>

{{ $products->links('pagination::bootstrap-5') }}

@endsection