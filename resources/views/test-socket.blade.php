@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1>Test Socket</h1>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script type="text/javascript">
Echo.channel("home")
    .listen("NewMessage", (event) => {
        console.log(event.invoice);
        alert(`The winner for this raffle is ${event.invoice.customer_name}`);
    });
</script>
@endpush