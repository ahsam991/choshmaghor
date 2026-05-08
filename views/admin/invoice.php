<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #<?= e($order['id']) ?> - ChoshmaZone</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            color: #333;
            margin: 0;
            padding: 40px;
            background: #fff;
            line-height: 1.6;
        }
        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
            font-size: 16px;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .header .logo h1 {
            margin: 0;
            font-size: 28px;
            color: #111;
        }
        .header .logo span {
            color: #888;
            font-size: 14px;
        }
        .header .invoice-details {
            text-align: right;
        }
        .header .invoice-details h2 {
            margin: 0 0 5px 0;
            color: #111;
        }
        .customer-info {
            margin-bottom: 30px;
        }
        .customer-info h3 {
            margin-top: 0;
            color: #555;
            font-size: 16px;
            text-transform: uppercase;
            border-bottom: 1px solid #eee;
            padding-bottom: 5px;
        }
        table {
            width: 100%;
            line-height: inherit;
            text-align: left;
            border-collapse: collapse;
        }
        table th {
            background: #f8f8f8;
            border-bottom: 2px solid #ddd;
            padding: 10px;
            font-weight: 600;
            color: #333;
        }
        table td {
            padding: 10px;
            border-bottom: 1px solid #eee;
        }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .total-row {
            font-weight: bold;
            font-size: 18px;
            background: #f8f8f8;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            color: #777;
            font-size: 14px;
            border-top: 1px solid #eee;
            padding-top: 20px;
        }
        .print-btn {
            display: block;
            width: 200px;
            margin: 20px auto;
            padding: 10px 20px;
            background: #c9a84c;
            color: #fff;
            text-align: center;
            text-decoration: none;
            border-radius: 5px;
            font-weight: 600;
            cursor: pointer;
            border: none;
        }
        @media print {
            .print-btn { display: none; }
            body { padding: 0; }
            .invoice-box { border: none; box-shadow: none; }
        }
    </style>
</head>
<body>

    <button onclick="window.print()" class="print-btn">🖨️ Print Cash Memo</button>

    <div class="invoice-box">
        <div class="header">
            <div class="logo">
                <h1>ChoshmaZone</h1>
                <span>Premium Eyewear</span><br>
                <span>Dhaka, Bangladesh</span><br>
                <span>Phone: 01700-000000</span>
            </div>
            <div class="invoice-details">
                <h2>CASH MEMO</h2>
                <strong>Order #:</strong> <?= e($order['id']) ?><br>
                <strong>Date:</strong> <?= date('d F Y', strtotime($order['created_at'])) ?><br>
                <strong>Status:</strong> <?= ucfirst(e($order['status'])) ?>
            </div>
        </div>

        <?php 
            $shipping = json_decode($order['shipping_address'] ?? '{}', true); 
        ?>
        <div class="customer-info">
            <h3>Billed To</h3>
            <strong><?= e($shipping['name'] ?? $order['user_name'] ?? 'Guest') ?></strong><br>
            <?= e($shipping['address'] ?? '') ?><br>
            <?= e($shipping['city'] ?? '') ?> - <?= e($shipping['postal_code'] ?? '') ?><br>
            Phone: <?= e($shipping['phone'] ?? '') ?><br>
            Email: <?= e($shipping['email'] ?? '') ?>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Item Description</th>
                    <th class="text-center">Qty</th>
                    <th class="text-right">Price</th>
                    <th class="text-right">Total</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($items as $item): ?>
                <tr>
                    <td><?= e($item['name']) ?></td>
                    <td class="text-center"><?= $item['quantity'] ?></td>
                    <td class="text-right">৳<?= number_format($item['price'], 2) ?></td>
                    <td class="text-right">৳<?= number_format($item['price'] * $item['quantity'], 2) ?></td>
                </tr>
                <?php endforeach; ?>
                
                <tr class="total-row">
                    <td colspan="3" class="text-right">Grand Total:</td>
                    <td class="text-right">৳<?= number_format($order['total_amount'], 2) ?></td>
                </tr>
            </tbody>
        </table>

        <div class="footer">
            <p>Thank you for shopping with ChoshmaZone!</p>
            <p>For any queries, contact info@choshmazone.com</p>
        </div>
    </div>

</body>
</html>
