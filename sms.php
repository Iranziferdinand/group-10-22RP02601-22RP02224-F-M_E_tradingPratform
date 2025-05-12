<?php
class Sms {
    public function sendSMS($message, $recipients) {
        $apiKey = Util::$apikey;
        $username = Util::$username;
        $from = Util::$short_code;

        // Format the phone number if needed
        if (strpos($recipients, '+') !== 0) {
            $recipients = '+' . $recipients;
        }

        $url = "https://api.sandbox.africastalking.com/version1/messaging";

        $postData = http_build_query([
            'username' => $username,
            'to'       => $recipients,
            'message'  => $message,
            'from'     => $from
        ]);

        $headers = [
            "Accept: application/json",
            "Content-Type: application/x-www-form-urlencoded",
            "apiKey: $apiKey"
        ];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        // SSL/TLS settings
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Temporarily disable SSL verification for testing
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        
        // Additional error handling
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        $errno = curl_errno($ch);

        // Log the full request and response for debugging
        error_log("SMS Request - URL: $url, Data: " . print_r($postData, true));
        error_log("SMS Response - Code: $httpCode, Response: $response");

        curl_close($ch);

        if ($errno) {
            error_log("SMS sending failed - cURL Error ($errno): $error");
            return false;
        }

        if ($httpCode != 201 && $httpCode != 200) {
            error_log("SMS sending failed - HTTP Code: $httpCode, Response: $response");
            return false;
        }

        // Parse the response to verify the message was sent
        $responseData = json_decode($response, true);
        if (isset($responseData['SMSMessageData']['Recipients'][0]['status']) && 
            $responseData['SMSMessageData']['Recipients'][0]['status'] === 'Success') {
            return true;
        }

        error_log("SMS sending failed - Invalid response format: " . $response);
        return false;
    }
}
?>
