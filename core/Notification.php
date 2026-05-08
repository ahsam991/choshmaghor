<?php

class Notification {
    
    // Sends a WhatsApp message using a simple cURL webhook (e.g. CallMeBot or UltraMsg)
    // Here we structure it to use generic settings from config/settings.json or fallback.
    public static function sendWhatsAppOrderAlert($order, $items, $shipping) {
        $settingsFile = APP_PATH . '/config/settings.json';
        $settings = [];
        if (file_exists($settingsFile)) {
            $settings = json_decode(file_get_contents($settingsFile), true) ?? [];
        }

        // WhatsApp config
        $wa_api_url = $settings['whatsapp_api_url'] ?? ''; 
        $wa_instance_id = $settings['whatsapp_instance_id'] ?? '';
        $wa_token = $settings['whatsapp_token'] ?? '';
        $wa_admin_phone = $settings['whatsapp_admin_phone'] ?? '';
        
        // If not configured, just return true (skip sending)
        if (empty($wa_api_url) || empty($wa_token) || empty($wa_admin_phone)) {
            return false;
        }

        $itemsList = "";
        foreach ($items as $item) {
            $itemsList .= "- {$item['name']} (x{$item['quantity']})\n";
        }

        $message = "🚨 *New Order Alert (#{$order['id']})* 🚨\n\n";
        $message .= "👤 *Customer:* {$shipping['name']}\n";
        $message .= "📞 *Phone:* {$shipping['phone']}\n";
        $message .= "📍 *Address:* {$shipping['address']}, {$shipping['city']}\n";
        
        if (!empty($shipping['landmark'])) {
            $message .= "🏢 *Landmark:* {$shipping['landmark']}\n";
        }
        
        if (!empty($shipping['latitude']) && !empty($shipping['longitude'])) {
            $message .= "🗺 *Map:* https://www.google.com/maps?q={$shipping['latitude']},{$shipping['longitude']}\n";
        }
        
        $message .= "\n📦 *Products:*\n{$itemsList}\n";
        $message .= "💰 *Total Amount:* ৳" . number_format($order['total_amount'], 2) . "\n";
        $message .= "💳 *Payment:* " . strtoupper($shipping['payment_method']) . "\n";
        $message .= "⏰ *Time:* " . date('Y-m-d h:i A');

        // Example standard WhatsApp Cloud API payload format
        // Modify this according to the exact API provider you use.
        $data = [
            "messaging_product" => "whatsapp",
            "to" => $wa_admin_phone,
            "type" => "text",
            "text" => ["body" => $message]
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $wa_api_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer " . $wa_token,
            "Content-Type: application/json"
        ]);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5); // Don't block order process too long

        $response = curl_exec($ch);
        curl_close($ch);
        
        return $response ? true : false;
    }

    // Sends an Email Order Confirmation using built-in mail() or simple SMTP wrapper
    public static function sendEmailConfirmation($order, $items, $shipping) {
        $to = $shipping['email'];
        if (empty($to)) return false;

        $subject = "Order Confirmation - #" . $order['id'] . " - ChoshmaZone";
        
        $itemsHtml = "";
        foreach ($items as $item) {
            $itemsHtml .= "<li>{$item['name']} (x{$item['quantity']}) - ৳" . number_format($item['price'] * $item['quantity'], 2) . "</li>";
        }

        $html = "
        <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; border: 1px solid #ddd; border-radius: 8px; overflow: hidden;'>
            <div style='background-color: #d4af37; padding: 20px; text-align: center;'>
                <h1 style='color: #000; margin: 0;'>Order Confirmed!</h1>
            </div>
            <div style='padding: 20px;'>
                <p>Hello <strong>{$shipping['name']}</strong>,</p>
                <p>Thank you for shopping with ChoshmaZone. Your order <strong>#{$order['id']}</strong> has been received successfully.</p>
                
                <h3 style='border-bottom: 1px solid #eee; padding-bottom: 5px;'>Order Details</h3>
                <ul style='list-style-type: none; padding: 0;'>
                    {$itemsHtml}
                </ul>
                <h3 style='text-align: right;'>Total: ৳" . number_format($order['total_amount'], 2) . "</h3>
                
                <div style='background-color: #f9f9f9; padding: 15px; border-radius: 5px; margin-top: 20px;'>
                    <h4 style='margin-top: 0;'>Delivery Information</h4>
                    <p style='margin: 5px 0;'><strong>Address:</strong> {$shipping['address']}, {$shipping['city']}</p>
                    <p style='margin: 5px 0;'><strong>Phone:</strong> {$shipping['phone']}</p>
                    " . (!empty($shipping['landmark']) ? "<p style='margin: 5px 0;'><strong>Landmark:</strong> {$shipping['landmark']}</p>" : "") . "
                    <p style='margin: 5px 0;'><strong>Payment Method:</strong> " . strtoupper($shipping['payment_method']) . "</p>
                </div>
            </div>
            <div style='background-color: #1a1a1a; color: #fff; padding: 15px; text-align: center; font-size: 12px;'>
                <p>&copy; " . date('Y') . " ChoshmaZone. All rights reserved.</p>
            </div>
        </div>
        ";

        $headers = "MIME-Version: 1.0\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8\r\n";
        $headers .= "From: ChoshmaZone Orders <orders@choshmazone.com>\r\n";
        $headers .= "Reply-To: support@choshmazone.com\r\n";

        return @mail($to, $subject, $html, $headers);
    }
}
