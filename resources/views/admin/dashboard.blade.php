@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Admin Dashboard') }}</div>

                <div class="card-body">
                    <!-- Statistics Cards -->
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <div class="card bg-primary text-white">
                                <div class="card-body">
                                    <h5 class="card-title">Total Clients</h5>
                                    <p class="card-text display-4">{{ $totalClients }}</p>
                                    <p class="card-text">Registered customers</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-success text-white">
                                <div class="card-body">
                                    <h5 class="card-title">Purchased Products</h5>
                                    <p class="card-text display-4">{{ $totalPurchasedProducts }}</p>
                                    <p class="card-text">Total items sold</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-info text-white">
                                <div class="card-body">
                                    <h5 class="card-title">Available Products</h5>
                                    <p class="card-text display-4">{{ $totalAvailableProducts }}</p>
                                    <p class="card-text">Items in stock</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Products -->
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Recent Products</h5>
                            <a href="{{ route('admin.products.index') }}" class="btn btn-primary btn-sm">View All</a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Product Name</th>
                                            <th>Price</th>
                                            <th>Quantity</th>
                                            <th>Image</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($recentProducts as $product)
                                            <tr>
                                                <td>{{ $product->name }}</td>
                                                <td>${{ number_format($product->price, 2) }}</td>
                                                <td>{{ $product->quantity }}</td>
                                                <td>
                                                    @if($product->image)
                                                        <img src="{{ asset('images/' . $product->image) }}" alt="{{ $product->name }}" style="width: 50px; height: 50px; object-fit: cover;">
                                                    @else
                                                        <img src="{{ asset('images/default-product.png') }}" alt="No image" style="width: 50px; height: 50px; object-fit: cover;">
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-warning btn-sm">Edit</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Purchases -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">Recent Purchases</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Customer</th>
                                            <th>Product</th>
                                            <th>Quantity</th>
                                            <th>Total Price</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($recentPurchases as $purchase)
                                            <tr>
                                                <td>{{ $purchase->user->name }}</td>
                                                <td>{{ $purchase->product->name }}</td>
                                                <td>{{ $purchase->quantity }}</td>
                                                <td>${{ number_format($purchase->quantity * $purchase->product->price, 2) }}</td>
                                                <td>{{ $purchase->created_at->format('M d, Y H:i') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Clients List -->
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Clients List</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Total Purchases</th>
                                            <th>Total Items Bought</th>
                                            <th>Joined Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($clients as $client)
                                            <tr>
                                                <td>{{ $client->name }}</td>
                                                <td>{{ $client->email }}</td>
                                                <td>{{ $client->stocks_count }}</td>
                                                <td>{{ $client->stocks_sum_quantity ?? 0 }}</td>
                                                <td>{{ $client->created_at->format('M d, Y') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 