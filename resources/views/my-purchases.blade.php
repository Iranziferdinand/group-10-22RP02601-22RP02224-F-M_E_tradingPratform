@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('My Purchases') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if($stocks->isEmpty())
                        <p>You haven't made any purchases yet.</p>
                    @else
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Quantity</th>
                                        <th>Price</th>
                                        <th>Total</th>
                                        <th>Purchase Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $grandTotal = 0;
                                    @endphp
                                    @foreach($stocks as $stock)
                                        @php
                                            $total = $stock->quantity * $stock->product->price;
                                            $grandTotal += $total;
                                        @endphp
                                        <tr>
                                            <td>{{ $stock->product->name }}</td>
                                            <td>{{ $stock->quantity }}</td>
                                            <td>${{ number_format($stock->product->price, 2) }}</td>
                                            <td>${{ number_format($total, 2) }}</td>
                                            <td>{{ $stock->created_at->format('M d, Y H:i') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3" class="text-end"><strong>Grand Total:</strong></td>
                                        <td colspan="2"><strong>${{ number_format($grandTotal, 2) }}</strong></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <div class="mt-4">
                            <h5>Payment Methods</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card mb-3">
                                        <div class="card-body">
                                            <h6 class="card-title">Mobile Money (MoMo)</h6>
                                            <p class="card-text">Pay using Mobile Money</p>
                                            <button class="btn btn-primary" onclick="generateInvoice('momo')">Pay with MoMo</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card mb-3">
                                        <div class="card-body">
                                            <h6 class="card-title">PayPal</h6>
                                            <p class="card-text">Pay using PayPal</p>
                                            <button class="btn btn-primary" onclick="generateInvoice('paypal')">Pay with PayPal</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="invoiceModal" class="modal fade" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Invoice</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div id="invoiceContent">
                                            <!-- Invoice content will be generated here -->
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary" onclick="printInvoice()">Print Invoice</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function generateInvoice(paymentMethod) {
    const invoiceContent = document.getElementById('invoiceContent');
    const grandTotal = {{ $grandTotal }};
    const date = new Date().toLocaleDateString();
    
    let invoiceHTML = `
        <div class="text-center mb-4">
            <h4>Invoice</h4>
            <p>Date: ${date}</p>
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
    `;

    @foreach($stocks as $stock)
        invoiceHTML += `
            <tr>
                <td>{{ $stock->product->name }}</td>
                <td>{{ $stock->quantity }}</td>
                <td>${{ number_format($stock->product->price, 2) }}</td>
                <td>${{ number_format($stock->quantity * $stock->product->price, 2) }}</td>
            </tr>
        `;
    @endforeach

    invoiceHTML += `
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" class="text-end"><strong>Grand Total:</strong></td>
                        <td><strong>${{ number_format($grandTotal, 2) }}</strong></td>
                    </tr>
                    <tr>
                        <td colspan="4" class="text-end">
                            <strong>Payment Method:</strong> ${paymentMethod.toUpperCase()}
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    `;

    invoiceContent.innerHTML = invoiceHTML;
    new bootstrap.Modal(document.getElementById('invoiceModal')).show();
}

function printInvoice() {
    const invoiceContent = document.getElementById('invoiceContent').innerHTML;
    const printWindow = window.open('', '', 'height=600,width=800');
    printWindow.document.write(`
        <html>
            <head>
                <title>Invoice</title>
                <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
            </head>
            <body>
                ${invoiceContent}
                <script>
                    window.onload = function() {
                        window.print();
                        window.close();
                    }
                </script>
            </body>
        </html>
    `);
    printWindow.document.close();
}
</script>
@endpush
@endsection 