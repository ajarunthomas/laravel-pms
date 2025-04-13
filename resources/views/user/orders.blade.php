@extends('partials.layout')

@section('body')
<div class="h3 mt-10">
    Orders
</div>

<div class="row">
@if(count($orders) <= 0)
    <p>No Orders Found</p>
@else
@foreach($orders as $o)
    @php $p = 0; $q = 0; @endphp
    <div class="card col-lg-12">
        <div class="card-body">
            
            <h5 class="card-title">Order Number: {{ $o->order_number }}</h5>
            <span class="badge bg-secondary">Status: {{ str_replace("_", " ", $o->status) }}</span>

            <a class="btn btn-primary float-end" data-bs-toggle="collapse" href="#multiCollapseExample{{ $o->id }}" role="button" aria-expanded="false" aria-controls="multiCollapseExample{{ $o->id }}">View Order Items</a>
            </p>
            <div class="row">
                <div class="col">
                    <div class="collapse multi-collapse" id="multiCollapseExample{{ $o->id }}">
                        <div class="card card-body">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($o->details)
                                    @foreach($o->details as $i)
                                    <tr>
                                        <td>{{ $i->product ? $i->product->name : "NA" }}</td>
                                        <td>{{ $i->total_price }}</td>
                                        <td>{{ $i->total_quantity }}</td>
                                    </tr>
                                    @php $p += $i->total_price; $q = $i->total_quantity; @endphp
                                    @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <span class="badge bg-success">Price: AED {{ $p }}</span>
            <span class="badge bg-info">Quantity: {{ $q }}</span>
        </div>
    </div>
@endforeach
@endif
</div>

{{ $orders->links('pagination::bootstrap-5') }}

@endsection