<?php

require_once __DIR__ . '/vendor/autoload.php';

use GuzzleHttp\Client;

$http = new Client;

$host = env('DB_HOST');
$db_user = env('DB_USERNAME');
$db_password = env('DB_PASSWORD');
$db = env('DB_NAME');

$conn = mysqli_connect($host,$db_user,$db_password,$db);

$api_token = env('API_TOKEN');
$api_url_1 = "https://cloud.iexapis.com/stable/stock/";
$api_url_2 = "/chart/max/?token=" . $api_token;


$query = "SELECT `id`,`stock_ticker` FROM `companies` WHERE `id` = 122";
$companies = mysqli_query($conn, $query);
foreach ($companies as $company) {
    print($company["stock_ticker"] . "\n");
    $response = $http->get($api_url_1 . $company["stock_ticker"] . $api_url_2);
    $history = json_decode($response->getBody());
    foreach ($history as $daily) {
        $company_id = $company['id'];
        $stock_ticker = $company["stock_ticker"];
        $date = $daily->date;
        $u_close = $daily->uClose;
        $u_open = $daily->uOpen;
        $u_high = $daily->uHigh;
        $u_low = $daily->uLow;
        $u_volume = $daily->uVolume;
        $close = $daily->close;
        $open = $daily->open;
        $high = $daily->high;
        $low = $daily->low;
        $volume = $daily->volume;
        $change = $daily->change;
        $change_percent = $daily->changePercent;
        $label = $daily->label;
        $change_over_time = $daily->changeOverTime;

        $insert_query = "INSERT INTO `stock_prices` (`company_id`, `stock_ticker`, `date`, `u_close`, `u_open`, `u_high`, `u_low`, `u_volume`, `close`, `open`, `high`, `low`, `volume`, `change`, `change_percent`, `label`, `change_over_time`) VALUES ('$company_id', '$stock_ticker', '$date', '$u_close', '$u_open', '$u_high', '$u_low', '$u_volume', '$close', '$open', '$high', '$low', '$volume', '$change', '$change_percent', '$label', '$change_over_time')";
        mysqli_query($conn, $insert_query);
    }
     
}