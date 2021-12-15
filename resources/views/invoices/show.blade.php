@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12"><br>
            <h2 class="font-weight-bold">Invoice Details</h2>
        <form action="{{ route('invoices.store') }}" method="POST" autocomplete="off">
            @csrf
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="invoice_number">Invoice Number</label>
                    <input type="text" class="form-control" id="invoice_number" name="invoice_number" value="{{ $invoice->invoice_number }}" readonly>
                </div>
                <div class="form-group col-md-6">
                    <label for="invoice_date">Invoice Date</label>
                    <input type="date" class="form-control" id="invoice_date" name="invoice_date" value="{{ $invoice->invoice_date }}" readonly>
                </div>
            </div>
            <div class="form-group">
                <label for="customer_name">Customer Name</label>
                <input type="text" class="form-control" id="customer_name" name="customer_name" value="{{ $invoice->customer_name }}" readonly>
            </div>

            <table class="table table-striped mb-4" width="100" id="productTable">
            <thead>
                <tr class="text-center">
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Sub Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($invoice->products as $product)
                    <tr class="text-center">
                        <td>
                            {{ $product->product_name }}
                        </td>
                        <td>
                            {{ $product->product_quantity }}
                        </td>
                        <td>
                            {{ $product->product_price }}
                        </td>
                        <td>
                            {{ $product->sub_total }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
            </table>

            <div class="form-group float-right">
                <label for="total">Grand Total</label> 
                <input type="text" id="total" name="total" class="form-control" value="{{ $invoice->total }}" readonly>
            </div>

            <a href="{{ route('invoices.index') }}" class="btn btn-danger mr-1">Back to Invoices List</a>
        </form>
        </div>
    </div>
</div>
@endsection