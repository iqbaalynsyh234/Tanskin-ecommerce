<?php
require 'vendor/autoload.php';

use Xendit\Xendit;

Xendit::setApiKey('xnd_production_0fe7ZApI47qHxBMYkQZq8r8sGISgzCFhjdInJ3Vma9ZMfgG4vMTA2lNArdWM3');

$name = htmlspecialchars($_POST['name']);
$email = htmlspecialchars($_POST['email']);
$phone_number = htmlspecialchars($_POST['phone_number']);
$addres = htmlspecialchars($_POST['addres']);
$city = htmlspecialchars($_POST['city']);
$province = htmlspecialchars($_POST['province']);
$postal_code = htmlspecialchars($_POST['postal_code']);
$district = htmlspecialchars($_POST['district']);
$subdistrict = htmlspecialchars($_POST['subdistrict']);

$item_name = $_POST['item_name'];
$quantity = $_POST['item_quantity'];
$price = str_replace('.', '', $_POST['item_price']);
$category = $_POST['item_category'];

$items = [];
$sum_price = 10000;
for ($i = 0; $i < count($item_name); $i++) {

    $sum_price = $sum_price + $quantity[$i] * $price[$i];

    $array = array();

    if (!empty($item_name[$i])) $array['name'] = $item_name[$i];
    if (!empty($quantity[$i])) $array['quantity'] = $quantity[$i];
    if (!empty($price[$i])) $array['price'] = $price[$i];
    if (!empty($category[$i])) $array['category'] = $category[$i];

    $items[] = $array;
}

$params = [
    'external_id' => '1',
    'amount' => $sum_price,
    'description' => 'Invoice 1',
    'invoice_duration' => 86400,
    // 'for-user-id' => '3',
    // 'customer' => [
    //     'name' => $name,
    //     'email' => $email,
    //     'mobile_number' => $mobile_number,
    //     'addresses' => [
    //         [
    //             'city' => $city,
    //             'country' => $country,
    //             'postal_code' => $postal_code,
    //             'state' => $complete_address,
    //             // 'street_line1' => 'Jalan Makan',
    //             // 'street_line2' => 'Kecamatan Kebayoran Baru'
    //         ]
    //     ]
    // ],
    'currency' => 'IDR',
    // 'items' => [
    //     [
    //         'name' => 'Air Conditioner',
    //         'quantity' => 4,
    //         'price' => 100000,
    //         'category' => 'Electronic',
    //         // 'url' => 'https=>//yourcompany.com/example_item'
    //     ],
    //     [
    //         'name' => 'Air Conditioner',
    //         'quantity' => 4,
    //         'price' => 100000,
    //         'category' => 'Electronic',
    //         // 'url' => 'https=>//yourcompany.com/example_item'
    //     ],
    // ],
    // 'items' => $items,
    // 'fees' => [
    //     [
    //         'type' => 'ADMIN',
    //         'value' => 5000
    //     ]
    // ]
];

$createInvoice = \Xendit\Invoice::create($params);

// echo '<pre>';
// print_r($createInvoice);
// echo '</pre>';

if (isset($createInvoice['invoice_url'])) {

    $invoice_id = $createInvoice['id'];
    $external_id = $createInvoice['external_id'];
    $amount = $createInvoice['amount'];
    $user_id = $createInvoice['user_id'];
    $status = $createInvoice['status'];
    $merchant_name = $createInvoice['merchant_name'];
    $merchant_profile_picture_url = $createInvoice['merchant_profile_picture_url'];
    $description = $createInvoice['description'];
    $expiry_date = $createInvoice['expiry_date'];
    $invoice_url = $createInvoice['invoice_url'];
    $date = date('Y-m-d H:i:s');

    $payment_xendit = "INSERT INTO payment_xendit (invoice_id, 
    external_id, 
    amount,
    user_id,
    status,
    merchant_name,
    merchant_profile_picture_url,
    description,
    given_names,
    username,
    email,
    mobile_number,
    city,
    country,
    postal_code,
    state,
    expiry_date,
    invoice_url,
    created_at
    )
VALUES ('$invoice_id', 
    '$external_id', 
    '$amount', 
    '$user_id', 
    '$status',
    '$merchant_name',
    '$merchant_profile_picture_url',
    '$description',
    '$firstname',
    '$lastname',
    '$email',
    '$mobile_number',
    '$city',
    '$country',
    '$postal_code',
    '$complete_address',
    '$expiry_date',
    '$invoice_url',
    '$date')";

    if (mysqli_query($conn, $payment_xendit)) {

        for ($i = 0; $i < count($item_name); $i++) {

            $query = "INSERT INTO subitem_payment_xendit (external_id, 
            name, 
            quantity, 
            price, 
            category, 
            created_at
            )
            VALUES ('$external_id',
            '$item_name[$i]', 
            '$quantity[$i]', 
            '$price[$i]', 
            '$category[$i]', 
            '$date')";

            mysqli_query($conn, $query);
        }

        header('Location: ' . $createInvoice['invoice_url']);
    } else {
        echo "Error: " . $payment_xendit . "<br>" . mysqli_error($conn);
    }
    mysqli_close($conn);
}

// id 3: 63c0b4cda3c38a8d879bca25
// for_user_id 3: 6162eac2381fca10a9dc9d73

// id 4: 63c0b586a59ff77f8e70dd6d
// for_user_id 4: 6162eac2381fca10a9dc9d73

// print_r($createInvoice['id']);
// print_r($createInvoice['external_id']);
// print_r($createInvoice['user_id']);
// print_r($createInvoice['status']);
// print_r($createInvoice['merchant_name']);
// print_r($createInvoice['merchant_profile_picture_url']);
// print_r($createInvoice['amount']);
// print_r($createInvoice['description']);
// print_r($createInvoice['expiry_date']);
// print_r($createInvoice['invoice_url']);
