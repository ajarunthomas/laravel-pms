@extends('partials.layout')

@section('body')
<div class="h3 mt-10">
    Products
    <a class="btn btn-sm btn-primary float-end" href="{{ route('products.add') }}">Add Product</a>
</div>

@if(session()->has('message'))
<div class="row">
    <div class="col-lg-12 mt-2">
        <div class="alert alert-{{ session('alert_type') }} alert-sm" role="alert">{{ session('message') }}</div>
    </div>
</div>
@endif

<div class="row">
    <div class="card col-lg-12">
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $p)
                    <tr>
                        <td>{{ $p->name }}</td>
                        <td>{{ $p->price }}</td>
                        <td>{{ $p->stock_quantity }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

{{ $products->links('pagination::bootstrap-5') }}

@endsection