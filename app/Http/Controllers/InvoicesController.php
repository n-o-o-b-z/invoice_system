<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;
use App\Models\InvoiceProduct;

class InvoicesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $invoices = Invoice::latest()->paginate(10);

        return view('invoices.index',compact('invoices'));
    }

    public function create()
    {
        return view('invoices.create');
    }

    protected static function validateData($id = null)
    {
        $validatedData = request()->validate([
            'invoice_number' => ['required','unique:invoices,invoice_number,'.$id],
            'invoice_date' => ['required','date'],
            'customer_name' => ['required','min:2'],
            'total' => ['required','regex:/^\d+(\.\d{1,2})?$/']
        ]);

        return $validatedData;
    }

    public function store()
    {
        $validatedData = self::validateData();
        $invoice = Invoice::create($validatedData);
        $total = 0;

        foreach (request()->product_names as $i => $productName) 
        {
            $subTotal = request()->product_prices[$i] * request()->product_quantities[$i];

            InvoiceProduct::create([
                'invoice_id' => $invoice->id,
                'product_name' => $productName,
                'product_quantity' => request()->product_quantities[$i],
                'product_price' => request()->product_prices[$i],
                'sub_total' => $subTotal
            ]);

            $total += $subTotal;
        }

        $invoice->total = $total;
        $invoice->save();

        return redirect(route('invoices.index'))->with('success', 'New invoice sucessfully saved');
    }

    public function show(Invoice $invoice)
    {
        return view('invoices.show',compact('invoice'));
    }

    public function edit(Invoice $invoice)
    {
        return view('invoices.edit',compact('invoice'));        
    }

    public function update(Invoice $invoice)
    {
        $validatedData = self::validateData($invoice->id);
        $invoice->update($validatedData);

        $total = 0;
        $invoiceProduct = new InvoiceProduct;
        $data = [];
        $latestID = $invoiceProduct->latest('id')->first()->id;

        foreach (request()->product_names as $i => $product_name) 
        {
            $subTotal = request()->product_prices[$i] * request()->product_quantities[$i];

            $data[$i]['id'] = isset(request()->product_ids[$i]) ? request()->product_ids[$i]: $latestID += 1;
            $data[$i]['invoice_id'] = $invoice->id;
            $data[$i]['product_name'] = $product_name;
            $data[$i]['product_quantity'] = request()->product_quantities[$i];
            $data[$i]['product_price'] = request()->product_prices[$i];
            $data[$i]['sub_total'] = $subTotal;
            $data[$i]['created_at'] = now();
            $data[$i]['updated_at'] = now();

            $total += $subTotal;
        }

        $invoiceProduct->insertOrUpdate($data);
        $invoice->total = $total;
        $invoice->save();

        return redirect(route('invoices.index'))->with('success', 'Invoice sucessfully updated');
    }

    public function destroy($id)
    {
        $invoice = Invoice::findOrFail($id);
        InvoiceProduct::where('invoice_id', $invoice->id)->delete();
        $invoice->delete();

        return redirect(route('invoices.index'))->with('success', 'Invoice sucessfully deleted');
    }

}