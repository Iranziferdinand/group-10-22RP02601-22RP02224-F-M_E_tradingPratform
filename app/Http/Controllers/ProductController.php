<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function store(Request $request)
{
    // Validate incoming request data
    $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'price' => 'required|numeric|min:0',
        'quantity' => 'required|integer|min:1',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // Handle image upload if there is an image
    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('products', 'public');
    } else {
        $imagePath = null;
    }

    // Create a new product record in the database
    Product::create([
        'name' => $request->name,
        'description' => $request->description ?? '',  // Default to empty string if null
        'price' => $request->price,
        'quantity' => $request->quantity,
        'image' => $imagePath,
    ]);

    // Redirect to the home page after successful creation
    return redirect()->route('home')->with('success', 'Product added successfully!');
}

    public function create()
    {
        return view('products.create');
    }
    public function placeBuy(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);
        $quantity = $request->input('quantity');
        $totalPrice = $product->price * $quantity;

        // Store purchase in stock table
        Stock::create([
            'product_id' => $product->id,
            'quantity' => $quantity,
            'total_price' => $totalPrice,
            'user_id' => Auth::id(),
        ]);

        // Update the product's quantity
        $product->decrement('quantity', $quantity);

        return redirect()->route('home')->with('success', 'Purchase successful!');
    }
    

    
}
