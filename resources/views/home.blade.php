<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome CSS for icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet">
    <style>
        .logout-icon {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 1.2rem;
            color: #333;
            display: flex;
            align-items: center;
        }
        .logout-icon i {
            margin-right: 5px;
        }
        footer {
            background-color: rgb(148, 191, 234);
            padding: 20px 0;
            text-align: center;
        }
        footer .social-icons i {
            font-size: 1.5rem;
            margin: 0 10px;
            color: #333;
        }
        footer .social-icons i:hover {
            color: #007bff;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-success bg-light">
        <div class="container">
            <a class="navbar-brand" href="#"> WELCOME TO F&M E_Trading Platform </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    @auth
                        @if(auth()->user()->is_admin)
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin') }}">
                                    <i class="fas fa-tachometer-alt"></i> Admin Panel
                                </a>
                            </li>
                        @endif
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('my.purchases') }}">
                                <i class="fas fa-shopping-bag"></i> My Purchases
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" data-toggle="modal" data-target="#stockModal">
                                <i class="fas fa-boxes"></i> View Stock
                            </a>
                        </li>
                        <li class="nav-item">
                            <form action="{{ route('logout') }}" method="POST" class="nav-link p-0">
                                @csrf
                                <button type="submit" class="btn btn-link text-dark" style="font-size: 1.2rem; border: none; background: none;">
                                    <i class="fas fa-sign-out-alt"></i> Logout
                                </button>
                            </form>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        @auth
            <h1 class="text-center">Hello {{ Auth::user()->name }}! Welcome to the Home Page</h1>
        @endauth

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @if($products->isEmpty())
            <p>No products available.</p>
        @else
            <div class="row">
                @foreach($products as $product)
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <img src="{{ asset('images/' . $product->image) }}" alt="{{ $product->name }}" class="mt-2" style="max-width: 200px;">
                            <div class="card-body">
                                <h5 class="card-title">{{ $product->name }}</h5>
                                <p class="card-text">{{ $product->description }}</p>
                                <p class="card-text"><strong>Price:</strong> ${{ $product->price }}</p>
                                <p class="card-text"><strong>Quantity:</strong> {{ $product->quantity }}</p>

                                <!-- Add to Cart Button -->
                                <button class="btn btn-primary add-to-cart" data-id="{{ $product->id }}" data-price="{{ $product->price }}" data-name="{{ $product->name }}" data-description="{{ $product->description }}" data-quantity="{{ $product->quantity }}">Buy</button>

                                <!-- Modal for Cart Form -->
                                <div class="modal fade" id="cartModal-{{ $product->id }}" tabindex="-1" aria-labelledby="cartModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="cartModalLabel">Buy {{ $product->name }}</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('placeBuy', $product->id) }}" method="POST">
                                                    @csrf
                                                    <div class="form-group">
                                                        <label for="quantity-{{ $product->id }}">Enter Quantity:</label>
                                                        <input type="number" class="form-control" id="quantity-{{ $product->id }}" name="quantity" min="1" max="{{ $product->quantity }}" required>
                                                    </div>
                                                    <p><strong>Total Price:</strong> $<span id="total-price-{{ $product->id }}">0</span></p>
                                                    <button type="submit" class="btn btn-primary">Place Your Buy</button>
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Modal for displaying stock -->
    <div class="modal fade" id="stockModal" tabindex="-1" aria-labelledby="stockModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="stockModalLabel">Current Stock</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h5>Product Stock (as of {{ \Carbon\Carbon::now()->toFormattedDateString() }}):</h5>
                    <div class="row">
                        @foreach($products as $product)
                            <div class="col-md-4 mb-3">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $product->name }}</h5>
                                        <p class="card-text"><strong>Quantity:</strong> {{ $product->quantity }}</p>
                                        <p class="card-text"><small>Last Updated: {{ $product->updated_at->toFormattedDateString() }}</small></p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <p>&copy; 2025 Iranzi Ferdinand | <a href="mailto:iranzi.ferdinand845@gmail.com">iranzi.ferdinand845@gmail.com</a> | Contact: <a href="tel:+250790055177">0790055177</a></p>
        <div class="social-icons">
            <a href="https://www.facebook.com" target="_blank" class="facebook"><i class="fab fa-facebook-square"></i></a>
            <a href="https://twitter.com" target="_blank" class="twitter"><i class="fab fa-twitter-square"></i></a>
            <a href="https://www.linkedin.com" target="_blank" class="linkedin"><i class="fab fa-linkedin"></i></a>
        </div>
    </footer>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        $(document).ready(function() {
            // Show the modal when "Buy" button is clicked
            $('.add-to-cart').click(function() {
                var productId = $(this).data('id');
                var productPrice = $(this).data('price');
                
                // Show the modal for the clicked product
                $('#cartModal-' + productId).modal('show');

                // When quantity changes, update the total price
                $('#quantity-' + productId).on('input', function() {
                    var quantity = $(this).val();
                    if (quantity && quantity > 0) {
                        var totalPrice = productPrice * quantity;
                        $('#total-price-' + productId).text(totalPrice.toFixed(2));
                    }
                });
            });
        });
    </script>
</body>
</html>
