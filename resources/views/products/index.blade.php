<table border="1">
    <thead>
        <tr>
            <th>Image</th>
            <th>Product Name</th>
            <th>Price</th>
           <th>Available Quantity</th>
            <th>Total Stock</th>
            <th>Action</th> <!-- Added Action column for the Buy form -->
        </tr>
    </thead>
    <tbody>
        @foreach($products as $product)
        <tr>
            <td>
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" width="50" height="50" alt="Product Image">
                @else
                    No Image
                @endif
            </td>
            <td>{{ $product->name }}</td>
            <td>{{ number_format($product->price, 2) }}</td>
            <td>{{ $product->quantity }}</td>
            <td>{{ $product->stock->sum('quantity') }}</td>
            <td>
                <form action="{{ route('placeBuy', $product->id) }}" method="POST">
                    @csrf
                    <label for="quantity">Quantity:</label>
                    <input type="number" name="quantity" min="1" max="{{ $product->quantity }}" required>
                    <button type="submit">Buy</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
