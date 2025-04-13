@extends('partials.layout')

@section('body')
<div class="h3 mt-10">
    Products
    <a class="btn btn-sm btn-primary float-end" href="{{ route('products') }}">Back to Products</a>
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
            <form method="post" action="{{ route('products.add.submit') }}">
                @csrf
                <div class="form-group col-lg-4">
                    <label class="label">Product Name</label>
                    <input class="form-control" type="text" name="name" />
                </div>
                <div class="form-group col-lg-4 mb-2">
                    <label class="label">Price</label>
                    <input class="form-control" type="number" name="price" />
                </div>
                <div class="form-group col-lg-4 mb-2">
                    <label class="label">Quantity</label>
                    <input class="form-control" type="number" name="quantity" />
                </div>
                <button type="submit" class="btn btn-primary">Add Product</button>
            </form>
        </div>
    </div>
</div>

@endsection