<?php

$consumerKey = 'your_consumer_key';
$consumerSecret = 'your_consumer_secret';

// Generate the access token
$credentials = base64_encode($consumerKey . ':' . $consumerSecret);

$ch = curl_init('https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials');
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: Basic ' . $credentials]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

$access_token = json_decode($response)->access_token;

// Create the STK Push payload
$payload = [
    "BusinessShortCode" => "your_shortcode",
    "Password" => base64_encode("your_shortcode" . "your_passkey" . date("YmdHis")),
    "Timestamp" => date("YmdHis"),
    "TransactionType" => "CustomerPayBillOnline",
    "Amount" => "1", // Replace with the actual amount
    "PartyA" => "2547xxxxxxxx", // Replace with the customer's phone number
    "PartyB" => "your_shortcode",
    "PhoneNumber" => "2547xxxxxxxx", // Replace with the customer's phone number
    "CallBackURL" => "https://your-callback-url.com", // Replace with your callback URL
    "AccountReference" => "BuyMeCoffee",
    "TransactionDesc" => "Buy Me a Coffee"
];

// Initiate the STK Push request
$ch = curl_init('https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest');
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Authorization: Bearer ' . $access_token,
    'Content-Type: application/json'
]);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

echo $response;
<?php

// Set the Consumer Key and Consumer Secret
$consumerKey = 'yAhYLcHhl6TsI5BdV4aNOwnwWHpyMUEq';
$consumerSecret = 'Np4KaAev4OGDrLOT';

// Generate the access token
function generateAccessToken($consumerKey, $consumerSecret)
{
    $url = 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
    $credentials = base64_encode($consumerKey . ':' . $consumerSecret);

    $headers = [
        'Authorization: Basic ' . $credentials,
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    curl_close($ch);

    return json_decode($response, true);
}

// Generate the access token
$accessToken = generateAccessToken($consumerKey, $consumerSecret);

// Check if access token was successfully obtained
if (isset($accessToken['access_token'])) {
    // Use the access token to make API requests
    // ...
} else {
    echo 'Failed to generate access token';
}
