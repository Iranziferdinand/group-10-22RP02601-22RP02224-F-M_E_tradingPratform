@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Purchase Statistics') }}</div>

                <div class="card-body">
                    <!-- Summary Cards -->
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <div class="card bg-primary text-white">
                                <div class="card-body">
                                    <h5 class="card-title">Total Customers</h5>
                                    <p class="card-text display-4">{{ $totalCustomers }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-success text-white">
                                <div class="card-body">
                                    <h5 class="card-title">Total Revenue</h5>
                                    <p class="card-text display-4">${{ number_format($totalRevenue, 2) }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-warning text-white">
                                <div class="card-body">
                                    <h5 class="card-title">Unpurchased Products</h5>
                                    <p class="card-text display-4">{{ $unpurchasedProducts->count() }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Products Purchase Statistics -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">Products Purchase Statistics</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Product Name</th>
                                            <th>Price</th>
                                            <th>Total Purchases</th>
                                            <th>Total Quantity Sold</th>
                                            <th>Total Revenue</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($products as $product)
                                            @php
                                                $totalQuantity = $product->stocks->sum('quantity');
                                                $productRevenue = $totalQuantity * $product->price;
                                            @endphp
                                            <tr>
                                                <td>{{ $product->name }}</td>
                                                <td>${{ number_format($product->price, 2) }}</td>
                                                <td>{{ $product->stocks_count }}</td>
                                                <td>{{ $totalQuantity }}</td>
                                                <td>${{ number_format($productRevenue, 2) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Unpurchased Products -->
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Unpurchased Products</h5>
                        </div>
                        <div class="card-body">
                            @if($unpurchasedProducts->isEmpty())
                                <p>All products have been purchased at least once.</p>
                            @else
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Product Name</th>
                                                <th>Price</th>
                                                <th>Quantity Available</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($unpurchasedProducts as $product)
                                                <tr>
                                                    <td>{{ $product->name }}</td>
                                                    <td>${{ number_format($product->price, 2) }}</td>
                                                    <td>{{ $product->quantity }}</td>
                                                    <td>
                                                        <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm btn-primary">Edit</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 