@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12"><br>
            <h2 class="font-weight-bold">Invoices List</h2>
            @if ($message = Session::get('success'))
                <div class="alert alert-success" role="alert">
                    {{ $message }}
                </div>
            @endif
            <a href="{{ route('invoices.create') }}" class="btn btn-primary float-right mb-3">Create Invoice</a>

            <table class="table table-striped" width="100">
            <thead>
                <tr class="text-center">
                    <th>ID</th>
                    <th>Invoice Number</th>
                    <th>Customer</th>
                    <th>Total</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($invoices as $invoice)
                    <tr class="text-center">
                        <td>{{ $invoice->id }}</td>
                        <td>{{ $invoice->invoice_number }}</td>
                        <td>{{ $invoice->customer_name }}</td>
                        <td>{{ number_format($invoice->total, 2) }}</td>
                        <td>{{ $invoice->invoice_date }}</td>
                        <td>
                            <a href="{{ route('invoices.show',$invoice->id) }}" class="btn btn-success">View</a>
                            <a href="{{ route('invoices.edit',$invoice->id) }}" class="btn btn-warning">Edit</a>
                            <form action="{{ route('invoices.destroy',$invoice->id) }}" method="POST" style="display:inline;">
                                @csrf
								@method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this invoice?');">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            </table>
            <div class="d-flex">
                {!! $invoices->links() !!}
            </div>  
        </div>
    </div>
</div>
@endsection
