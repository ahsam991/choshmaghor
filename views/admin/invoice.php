<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #<?= e($order['id']) ?> - <?= e($settings['site_title'] ?? 'ChoshmaZone') ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: <?= e($settings['theme_color'] ?? '#c9a84c') ?>;
            --dark: #1a1a1a;
            --gray: #6b7280;
            --light-gray: #f3f4f6;
        }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: var(--dark);
            margin: 0;
            padding: 40px;
            background: #f9fafb;
            line-height: 1.5;
        }
        .invoice-box {
            max-width: 850px;
            margin: auto;
            padding: 50px;
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 40px;
        }
        .logo h1 {
            margin: 0;
            font-size: 32px;
            font-weight: 800;
            color: var(--primary);
            letter-spacing: -1px;
        }
        .logo p {
            margin: 5px 0 0;
            color: var(--gray);
            font-size: 14px;
        }
        .invoice-details {
            text-align: right;
        }
        .invoice-details h2 {
            margin: 0;
            font-size: 24px;
            font-weight: 700;
            text-transform: uppercase;
            color: var(--dark);
        }
        .invoice-details p {
            margin: 4px 0;
            color: var(--gray);
            font-size: 14px;
        }
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            margin-bottom: 40px;
            padding: 24px;
            background: var(--light-gray);
            border-radius: 12px;
        }
        .info-block h3 {
            margin: 0 0 12px;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--gray);
        }
        .info-block p {
            margin: 0;
            font-size: 15px;
            font-weight: 500;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        table th {
            text-align: left;
            padding: 16px;
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
            color: var(--gray);
            border-bottom: 2px solid var(--light-gray);
        }
        table td {
            padding: 16px;
            font-size: 15px;
            border-bottom: 1px solid var(--light-gray);
        }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .total-section {
            margin-left: auto;
            width: 300px;
        }
        .total-row {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
        }
        .total-row.grand-total {
            border-top: 2px solid var(--dark);
            margin-top: 10px;
            font-weight: 800;
            font-size: 20px;
            color: var(--primary);
        }
        .footer {
            margin-top: 60px;
            text-align: center;
            padding-top: 30px;
            border-top: 1px solid var(--light-gray);
        }
        .footer p {
            margin: 4px 0;
            font-size: 14px;
            color: var(--gray);
        }
        .badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 99px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
        }
        .badge-pending { background: #fef3c7; color: #92400e; }
        .badge-completed { background: #dcfce7; color: #166534; }
        .print-btn {
            position: fixed;
            bottom: 30px;
            right: 30px;
            padding: 14px 28px;
            background: var(--dark);
            color: #fff;
            border: none;
            border-radius: 99px;
            font-weight: 700;
            cursor: pointer;
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
            transition: transform 0.2s;
        }
        .print-btn:hover { transform: translateY(-2px); }
        @media print {
            .print-btn { display: none; }
            body { padding: 0; background: #fff; }
            .invoice-box { box-shadow: none; border: none; max-width: 100%; }
        }
    </style>
</head>
<body>

    <button onclick="window.print()" class="print-btn">
        <svg style="width:20px;height:20px;vertical-align:middle;margin-right:8px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
        Print Invoice
    </button>

    <div class="invoice-box">
        <div class="header">
            <div class="logo">
                <h1><?= e($settings['site_title'] ?? 'ChoshmaZone') ?></h1>
                <p><?= e($settings['site_tagline'] ?? 'Premium Eyewear Store') ?></p>
            </div>
            <div class="invoice-details">
                <h2>Invoice</h2>
                <p><strong>#<?= e($order['id']) ?></strong></p>
                <p><?= date('d M Y', strtotime($order['created_at'])) ?></p>
                <div class="mt-2">
                    <span class="badge badge-<?= $order['status'] === 'completed' ? 'completed' : 'pending' ?>">
                        <?= ucfirst(e($order['status'])) ?>
                    </span>
                </div>
            </div>
        </div>

        <div class="info-grid">
            <div class="info-block">
                <h3>Billed To</h3>
                <?php $shipping = json_decode($order['shipping_address'] ?? '{}', true); ?>
                <p style="font-size: 18px; margin-bottom: 8px; color: var(--dark);"><?= e($shipping['name'] ?? $order['name'] ?? 'Guest') ?></p>
                <p><?= e($shipping['address'] ?? '') ?></p>
                <p><?= e($shipping['city'] ?? '') ?>, <?= e($shipping['postal_code'] ?? '') ?></p>
                <p><i class="fas fa-phone"></i> <?= e($shipping['phone'] ?? '') ?></p>
            </div>
            <div class="info-block">
                <h3>From</h3>
                <p style="font-size: 18px; margin-bottom: 8px; color: var(--dark);"><?= e($settings['site_title'] ?? 'ChoshmaZone') ?></p>
                <p><?= nl2br(e($settings['contact_address'] ?? 'Dhaka, Bangladesh')) ?></p>
                <p>Email: <?= e($settings['contact_email'] ?? 'support@choshmazone.com') ?></p>
                <p>Phone: <?= e($settings['contact_phone'] ?? '') ?></p>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Item Description</th>
                    <th class="text-center">Qty</th>
                    <th class="text-right">Price</th>
                    <th class="text-right">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($items as $item): ?>
                <tr>
                    <td style="font-weight: 600;"><?= e($item['name']) ?></td>
                    <td class="text-center"><?= $item['quantity'] ?></td>
                    <td class="text-right"><?= $settings['currency'] ?? '৳' ?><?= number_format($item['price'], 0) ?></td>
                    <td class="text-right" style="font-weight: 600;"><?= $settings['currency'] ?? '৳' ?><?= number_format($item['price'] * $item['quantity'], 0) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="total-section">
            <div class="total-row">
                <span style="color: var(--gray);">Subtotal</span>
                <span><?= $settings['currency'] ?? '৳' ?><?= number_format($order['total_amount'], 0) ?></span>
            </div>
            <div class="total-row">
                <span style="color: var(--gray);">Shipping</span>
                <span style="color: #059669; font-weight: 600;">FREE</span>
            </div>
            <div class="total-row grand-total">
                <span>Total Amount</span>
                <span><?= $settings['currency'] ?? '৳' ?><?= number_format($order['total_amount'], 0) ?></span>
            </div>
        </div>

        <div class="footer">
            <p><strong>Thank you for your purchase!</strong></p>
            <p>This is a computer-generated invoice and does not require a physical signature.</p>
            <p>&copy; <?= date('Y') ?> <?= e($settings['site_title'] ?? 'ChoshmaZone') ?>. All rights reserved.</p>
        </div>
    </div>

</body>
</html>
