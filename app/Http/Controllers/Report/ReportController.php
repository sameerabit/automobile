<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Product;

class ReportController extends Controller
{

    public function products()
    {
        $products = Product::get();
        return view('reports.products', [
            'products' => $products,
        ]);
    }

}