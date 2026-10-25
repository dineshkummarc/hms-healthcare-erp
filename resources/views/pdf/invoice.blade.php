<!DOCTYPE html>
<html lang="{{ $locale }}" dir="{{ $isRtl ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <title>Invoice #{{ $invoice->invoice_number }}</title>
    <style>
        body { font-family: 'DejaVu Sans', 'Noto Sans', sans-serif; font-size: 12px; color: #333; line-height: 1.5; margin: 20px; }
        .header { border-bottom: 2px solid #0284c7; padding-bottom: 15px; margin-bottom: 20px; }
        .org-title { font-size: 20px; font-weight: bold; color: #0284c7; }
        .table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        .table th, .table td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        .table th { background-color: #f1f5f9; }
        .total-box { margin-top: 20px; float: right; width: 300px; }
        .total-row { display: flex; justify-content: space-between; padding: 4px 0; }
        .paid-badge { color: #16a34a; font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        <div class="org-title">{{ $invoice->organization->name ?? 'Healthcare Center' }}</div>
        <div>{{ $invoice->branch->name ?? 'Main Branch' }} | {{ $invoice->branch->address ?? '' }}</div>
        <div>Phone: {{ $invoice->branch->phone ?? '' }} | Email: {{ $invoice->branch->email ?? '' }}</div>
    </div>

    <table style="width: 100%; margin-bottom: 15px;">
        <tr>
            <td style="width: 50%; vertical-align: top;">
                <strong>Billed To:</strong><br>
                {{ $invoice->patient->full_name }}<br>
                MRN: {{ $invoice->patient->mrn }}<br>
                Phone: {{ $invoice->patient->phone }}
            </td>
            <td style="width: 50%; vertical-align: top; text-align: right;">
                <strong>Invoice Number:</strong> {{ $invoice->invoice_number }}<br>
                <strong>Date:</strong> {{ $invoice->invoice_date->format('Y-m-d') }}<br>
                <strong>Status:</strong> <span class="paid-badge">{{ strtoupper($invoice->status) }}</span>
            </td>
        </tr>
    </table>

    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Item / Service Description</th>
                <th>Qty</th>
                <th>Unit Price</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($invoice->items as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item->description }}</td>
                <td>{{ $item->quantity }}</td>
                <td>${{ number_format($item->unit_price, 2) }}</td>
                <td>${{ number_format($item->total, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div style="clear: both; margin-top: 20px;">
        <table style="float: right; width: 300px; border-collapse: collapse;">
            <tr>
                <td style="padding: 4px 8px;"><strong>Subtotal:</strong></td>
                <td style="text-align: right; padding: 4px 8px;">${{ number_format($invoice->subtotal, 2) }}</td>
            </tr>
            <tr>
                <td style="padding: 4px 8px;"><strong>Discount:</strong></td>
                <td style="text-align: right; padding: 4px 8px;">-${{ number_format($invoice->discount, 2) }}</td>
            </tr>
            <tr>
                <td style="padding: 4px 8px;"><strong>Tax:</strong></td>
                <td style="text-align: right; padding: 4px 8px;">+${{ number_format($invoice->tax, 2) }}</td>
            </tr>
            <tr style="border-top: 2px solid #333; font-size: 14px;">
                <td style="padding: 4px 8px;"><strong>Total:</strong></td>
                <td style="text-align: right; padding: 4px 8px;"><strong>${{ number_format($invoice->total, 2) }}</strong></td>
            </tr>
            <tr>
                <td style="padding: 4px 8px;"><strong>Paid Amount:</strong></td>
                <td style="text-align: right; padding: 4px 8px; color: #16a34a;">${{ number_format($invoice->paid_amount, 2) }}</td>
            </tr>
            <tr>
                <td style="padding: 4px 8px;"><strong>Balance Due:</strong></td>
                <td style="text-align: right; padding: 4px 8px; color: #dc2626; font-weight: bold;">${{ number_format($invoice->balance_due, 2) }}</td>
            </tr>
        </table>
    </div>

    <div style="margin-top: 150px; font-size: 10px; color: #666; text-align: center; border-top: 1px solid #eee; padding-top: 10px;">
        Thank you for choosing {{ $invoice->organization->name ?? 'our healthcare services' }}. This is a computer generated document.
    </div>
</body>
</html>
