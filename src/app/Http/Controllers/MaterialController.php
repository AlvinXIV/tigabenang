<?php

namespace App\Http\Controllers;

use App\Support\CustomerCatalog;
use Illuminate\View\View;

class MaterialController extends Controller
{
    public function index(): View
    {
        return view('customer.materials', [
            'materials' => CustomerCatalog::materials(),
        ]);
    }
}
