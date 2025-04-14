<?php
// app/Http/Controllers/StockController.php
namespace App\Http\Controllers;
use App\Models\Stock;
use Illuminate\Http\Request;

class StockController extends Controller
{

    public function placeBuy(Request $request, $productId)
{
    // Logic for placing the buy
    // Assuming the buy is successfully placed:
    
    // Redirect back with a success message
    return redirect()->route('home')->with('success', 'Buy placed successfully!');
}

    // List all stock records
    public function index()
    {
        $stocks = Stock::all();
        return view('stocks.index', compact('stocks'));
    }

    // Show a specific stock record
    public function show($id)
    {
        $stock = Stock::findOrFail($id);
        return view('stocks.show', compact('stock'));
    }

    // Create a new stock record (if needed for manual stock addition)
    public function create()
    {
        return view('stocks.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        Stock::create($request->all());

        return redirect()->route('stocks.index')->with('success', 'Stock added successfully.');
    }
}
