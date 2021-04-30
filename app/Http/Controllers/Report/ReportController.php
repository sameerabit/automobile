<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\ProductBatch;

class ReportController extends Controller
{

    public function products()
    {
        $productBatches = ProductBatch::get();
        return view('reports.products', [
            'productBatches' => $productBatches,
        ]);
    }

}