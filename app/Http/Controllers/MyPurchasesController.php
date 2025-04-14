<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class MyPurchasesController extends Controller
{
    public function index()
    {
        $stocks = Auth::user()->stocks()->with('product')->latest()->get();
        return view('my-purchases', compact('stocks'));
    }
} 
