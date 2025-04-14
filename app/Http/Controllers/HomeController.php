<?php

namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\Stock;
use App\Models\User;
use Illuminate\Http\Request;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Fetch products from the database
        $products = Product::all();  // You can use other query methods as needed (e.g., paginate)
        $products = Product::orderBy('created_at', 'desc')->get();
        // Return the view and pass the products to it
        return view('home', compact('products'));
    }

    /**
     * Show the admin dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function admin()
    {
        // Check if user is admin
        if (!auth()->user()->is_admin) {
            return redirect()->route('home')->with('error', 'Unauthorized access.');
        }

        // Get all stock entries with related product and user information
        $stocks = Stock::with(['product', 'user'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Calculate statistics
        $totalPurchases = Stock::count();
        $totalRevenue = Stock::sum('total_price');
        $totalUsers = User::count();

        return view('admin', compact('stocks', 'totalPurchases', 'totalRevenue', 'totalUsers'));
    }

    /**
     * Show the user's purchases.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function myPurchases()
    {
        $purchases = auth()->user()->stocks()->with('product')->latest()->get();
        return view('my-purchases', compact('purchases'));
    }
}
