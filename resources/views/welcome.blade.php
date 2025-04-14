<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Trading Platform</title>

    <!-- Add Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />

    <style>
        /* Custom styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .navbar {
            position: absolute;
            top: 20px;
            right: 20px;
        }

        .container {
            padding: 50px;
            text-align: center;
        }

        h1 {
            font-size: 48px;
            color: #333;
            margin-bottom: 20px;
        }

        .product-card {
            background-color: white;
            border-radius: 10px;
            padding: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s;
            text-align: center;
        }

        .product-card:hover {
            transform: scale(1.05);
        }

        .product-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 10px;
        }

        .product-name {
            font-size: 18px;
            font-weight: bold;
            margin-top: 10px;
        }

        .product-price {
            color: green;
            font-size: 16px;
            font-weight: bold;
        }

        /* Footer styling */
        footer {
            background-color: #333;
            color: white;
            padding: 10px;
            text-align: center;
            position: fixed;
            bottom: 0;
            width: 100%;
        }

        footer a {
            color: #4CAF50;
            text-decoration: none;
        }

        footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <!-- Navbar for Login and Register buttons at the top right -->
    <div class="navbar">
        <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
        <a href="{{ route('register') }}" class="btn btn-secondary">Register</a>
    </div>

    <!-- Main Content -->
    <div class="container">
        <h1 style="color:rgb(28, 98, 178);">Welcome to  F&E E-Trading Platform</h1>
        <p><h3>Your one-stop platform to buy and sell products.</h3></p>

        <!-- Product Gallery -->
        <div class="row mt-4">
            <!-- Product 1 -->
            <div class="col-md-4 mb-4">
                <div class="product-card">
                    <img src="{{ asset('images/1.jpg') }}" alt="Camera">
                    <div class="product-name">Camera</div>
                    <div class="product-price">$600</div>
                </div>
            </div>

            <!-- Product 2 -->
            <div class="col-md-4 mb-4">
                <div class="product-card">
                    <img src="{{ asset('images/2.jpg') }}" alt="Skin Lotion">
                    <div class="product-name">Skin Lotion</div>
                    <div class="product-price">$15</div>
                </div>
            </div>

            <!-- Product 3 -->
            <div class="col-md-4 mb-4">
                <div class="product-card">
                    <img src="{{ asset('images/3.jpg') }}" alt="Phone">
                    <div class="product-name">Phone</div>
                    <div class="product-price">$500</div>
                </div>
            </div>

            <!-- Product 4 -->
            <div class="col-md-4 mb-4">
                <div class="product-card">
                    <img src="{{ asset('images/4.jpg') }}" alt="Computer Peripherals">
                    <div class="product-name">Computer Peripherals</div>
                    <div class="product-price">$120</div>
                </div>
            </div>

            <!-- Product 5 -->
            <div class="col-md-4 mb-4">
                <div class="product-card">
                    <img src="{{ asset('images/5.jpg') }}" alt="Cooking Oil">
                    <div class="product-name">Cooking Oil</div>
                    <div class="product-price">$10</div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="product-card">
                    <img src="{{ asset('images/6.jpg') }}" alt="Phone">
                    <div class="product-name">electronic</div>
                    <div class="product-price">$400</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer with email -->
    <footer>
        <p>For inquiries, email us at: <a href="mailto:iranziferdinand845@gmail.com">iranziferdinand845@gmail.com</a></p>
    </footer>

    <!-- Add Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
