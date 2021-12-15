@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12"><br>
            <h2 class="font-weight-bold">Edit Invoice</h2>
        <form action="{{ route('invoices.update',$invoice->id) }}" method="POST" autocomplete="off">
            @method('PATCH') 
            @csrf
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="invoice_number">Invoice Number</label>
                    <input type="text" class="form-control" id="invoice_number" name="invoice_number" value="{{ old('invoice_number', $invoice->invoice_number) }}">
                    @error('invoice_number')
                        <p class="text-danger font-italic mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group col-md-6">
                    <label for="invoice_date">Invoice Date</label>
                    <input type="date" class="form-control" id="invoice_date" name="invoice_date" value="{{ old('invoice_date', $invoice->invoice_date) }}">
                    @error('invoice_date')
                        <p class="text-danger font-italic mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="form-group">
                <label for="customer_name">Customer Name</label>
                <input type="text" class="form-control" id="customer_name" name="customer_name" value="{{ old('customer_name', $invoice->customer_name) }}">
                @error('customer_name')
                    <p class="text-danger font-italic mt-1">{{ $message }}</p>
                @enderror
            </div>

            <table class="table table-striped mb-4" width="100" id="productTable">
            <thead>
                <tr class="text-center">
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Sub Total</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($invoice->products as $product)
                    <tr class="text-center" x-data="productsTable();">
                        <input type="hidden" class="form-control" name="product_ids[]" value="{{ $product->id }}">
                        <td>
                            <input type="text" class="form-control" name="product_names[]" value="{{ $product->product_name }}" required>
                        </td>
                        <td>
                            <input type="number" class="form-control qty" name="product_quantities[]" value="{{ $product->product_quantity }}" data-action="calculateTotal" value="0" required>
                        </td>
                        <td>
                            <input type="number" class="form-control price" name="product_prices[]" value="{{ $product->product_price }}" data-action="calculateTotal" value="0" required>
                        </td>
                        <td>
                            <input type="text" class="form-control sub-total" name="sub_totals[]" value="{{ $product->sub_total }}" readonly>
                        </td>
                        <td>
                            <button type="button" class="btn btn-sm btn-danger deleteField" data-id="{{ $product->id }}">-</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td><button type="button" class="btn btn-sm btn-success addField">+ Add Field</button></td>
                </tr>
            </tfoot>
            </table>

             <div class="form-group float-right">
                <label for="total">Grand Total</label> 
                <input type="text" id="total" name="total" class="form-control" value="{{ $invoice->total }}" readonly>
            </div>

            <div>
                <a href="{{ route('invoices.index') }}" class="btn btn-danger mr-1">Back</a>
                <button type="submit" class="btn btn-info">Update Invoice</button>
            </div>
        </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/main.js') }}"></script>
@endpush
