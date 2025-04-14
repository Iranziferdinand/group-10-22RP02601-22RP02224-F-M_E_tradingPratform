<?php

namespace App\Http\Controllers;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Middleware\AdminMiddleware;
use App\Models\Stock;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(AdminMiddleware::class);
    }

    public function products()
    {
        $products = Product::latest()->get();
        return view('admin.products.index', compact('products'));
    }

    public function createProduct()
    {
        return view('admin.products.create');
    }

    public function storeProduct(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);
            $validated['image'] = $imageName;
        }

        Product::create($validated);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product created successfully.');
    }

    public function editProduct(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    public function updateProduct(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('image')) {
            if ($product->image) {
                $oldImagePath = public_path('images/' . $product->image);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);
            $validated['image'] = $imageName;
        }

        $product->update($validated);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully.');
    }

    public function deleteProduct(Product $product)
    {
        if ($product->image) {
            $imagePath = public_path('images/' . $product->image);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }
        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted successfully.');
    }

    public function purchaseStats()
    {
        // Get all products with their purchase counts
        $products = Product::withCount('stocks')->get();
        
        // Get total number of customers who made purchases
        $totalCustomers = Stock::distinct('user_id')->count('user_id');
        
        // Get total revenue
        $totalRevenue = Stock::with('product')
            ->get()
            ->sum(function($stock) {
                return $stock->quantity * $stock->product->price;
            });
        
        // Get products that haven't been purchased
        $unpurchasedProducts = Product::whereDoesntHave('stocks')->get();
        
        return view('admin.purchase-stats', compact(
            'products',
            'totalCustomers',
            'totalRevenue',
            'unpurchasedProducts'
        ));
    }

    public function dashboard()
    {
        // Get total number of clients (users)
        $totalClients = \App\Models\User::where('is_admin', false)->count();
        
        // Get total number of purchased products
        $totalPurchasedProducts = Stock::sum('quantity');
        
        // Get total available products
        $totalAvailableProducts = Product::sum('quantity');
        
        // Get recent products
        $recentProducts = Product::latest()->take(5)->get();
        
        // Get recent purchases
        $recentPurchases = Stock::with(['user', 'product'])
            ->latest()
            ->take(5)
            ->get();

        // Get all clients with their purchase counts
        $clients = \App\Models\User::where('is_admin', false)
            ->withCount('stocks')
            ->withSum('stocks', 'quantity')
            ->latest()
            ->get();

        return view('admin.dashboard', compact(
            'totalClients',
            'totalPurchasedProducts',
            'totalAvailableProducts',
            'recentProducts',
            'recentPurchases',
            'clients'
        ));
    }
} 
