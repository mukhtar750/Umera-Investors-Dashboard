<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction Receipt - {{ $transaction->reference }}</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #333;
            line-height: 1.6;
            background-color: #f9fafb;
            margin: 0;
            padding: 40px;
        }
        .receipt-container {
            max-width: 800px;
            margin: 0 auto;
            background: #fff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #eee;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .logo img {
            height: 60px;
        }
        .company-info {
            text-align: right;
            font-size: 0.9em;
            color: #666;
        }
        .receipt-title {
            text-align: center;
            margin-bottom: 40px;
        }
        .receipt-title h1 {
            font-size: 24px;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: #1a1a1a;
            margin: 0;
        }
        .receipt-details {
            display: flex;
            justify-content: space-between;
            margin-bottom: 40px;
        }
        .detail-group h3 {
            font-size: 14px;
            text-transform: uppercase;
            color: #888;
            margin: 0 0 5px 0;
        }
        .detail-group p {
            margin: 0;
            font-weight: 600;
            font-size: 16px;
        }
        .amount-box {
            background-color: #f3f4f6;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            margin-bottom: 40px;
        }
        .amount-box .label {
            font-size: 14px;
            color: #666;
            margin-bottom: 5px;
        }
        .amount-box .value {
            font-size: 32px;
            font-weight: bold;
            color: #059669;
        }
        .transaction-info {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 40px;
        }
        .transaction-info th, .transaction-info td {
            padding: 12px 15px;
            border-bottom: 1px solid #eee;
            text-align: left;
        }
        .transaction-info th {
            color: #666;
            font-weight: 600;
            width: 40%;
        }
        .footer {
            text-align: center;
            font-size: 12px;
            color: #999;
            margin-top: 60px;
            border-top: 1px solid #eee;
            padding-top: 20px;
        }
        .print-actions {
            text-align: center;
            margin-top: 40px;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #059669;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 600;
            border: none;
            cursor: pointer;
            transition: background-color 0.2s;
        }
        .btn:hover {
            background-color: #047857;
        }
        @media print {
            body {
                background: white;
                padding: 0;
            }
            .receipt-container {
                box-shadow: none;
                padding: 0;
                margin: 0;
            }
            .print-actions {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="receipt-container">
        <div class="header">
            <div class="logo">
                <img src="{{ asset('images/logo.png') }}" alt="Umera Logo">
            </div>
            <div class="company-info">
                <strong>Umera Farms</strong><br>
                Invest in Agriculture<br>
                support@umera.com<br>
            </div>
        </div>

        <div class="receipt-title">
            <h1>Payment Receipt</h1>
        </div>

        <div class="receipt-details">
            <div class="detail-group">
                <h3>Receipt To</h3>
                <p>{{ $transaction->user->name }}</p>
                <p style="font-size: 14px; font-weight: normal; color: #666;">{{ $transaction->user->email }}</p>
            </div>
            <div class="detail-group" style="text-align: right;">
                <h3>Date</h3>
                <p>{{ $transaction->created_at->format('M d, Y') }}</p>
                <h3 style="margin-top: 10px;">Reference</h3>
                <p style="font-family: monospace;">{{ $transaction->reference }}</p>
            </div>
        </div>

        <div class="amount-box">
            <div class="label">Amount Paid</div>
            <div class="value">₦{{ number_format($transaction->amount, 2) }}</div>
        </div>

        <table class="transaction-info">
            <tr>
                <th>Transaction Type</th>
                <td>{{ ucwords(str_replace('_', ' ', $transaction->type)) }}</td>
            </tr>
            <tr>
                <th>Description</th>
                <td>{{ $transaction->description }}</td>
            </tr>
            <tr>
                <th>Status</th>
                <td>
                    <span style="color: {{ $transaction->status === 'completed' ? '#059669' : ($transaction->status === 'pending' ? '#d97706' : '#dc2626') }}; font-weight: bold; text-transform: capitalize;">
                        {{ $transaction->status }}
                    </span>
                </td>
            </tr>
            @if($transaction->allocation)
            <tr>
                <th>Related Offering</th>
                <td>{{ $transaction->allocation->offering->name ?? 'N/A' }}</td>
            </tr>
            @endif
        </table>

        <div class="footer">
            <p>This is a computer-generated receipt and requires no signature.</p>
            <p>&copy; {{ date('Y') }} Umera Farms. All rights reserved.</p>
        </div>

        <div class="print-actions">
            <button onclick="window.print()" class="btn">Print / Save as PDF</button>
        </div>
    </div>

    <script>
        // Optional: Auto-print on load if query param present
        // if (window.location.search.includes('print=true')) {
        //     window.print();
        // }
    </script>
</body>
</html>
