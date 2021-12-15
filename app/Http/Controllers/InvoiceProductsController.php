<?php

namespace App\Http\Controllers;

use App\Models\InvoiceProduct;

class InvoiceProductsController extends Controller
{
    public function destroy(InvoiceProduct $product)
    {
        $product->delete();

        return response()->json(['success' => 'true']);
    }

}