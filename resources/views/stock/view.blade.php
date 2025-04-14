<!-- resources/views/stock/view.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Stock</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Stock Details</h1>
        @if($stocks->isEmpty())
            <p>No stock records available.</p>
        @else
            <table class="table">
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>Quantity Purchased</th>
                        <th>Price</th>
                        <th>Created At</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($stocks as $stock)
                        <tr>
                            <td>{{ $stock->product->name }}</td>
                            <td>{{ $stock->quantity }}</td>
                            <td>${{ $stock->total_price }}</td>
                            <td>{{ $stock->created_at }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</body>
</html>
