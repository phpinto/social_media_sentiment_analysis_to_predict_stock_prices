<?php

namespace Facebook\WebDriver;

use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;

require_once('vendor/autoload.php');
$host = 'http://localhost:4444';
//$host = env('DB_HOST');
$db_user = env('DB_USERNAME');
$db_password = env('DB_PASSWORD');
$db = env('DB_NAME');
// $conn = mysqli_connect($host,$db_user,$db_password,$db);
$capabilities = DesiredCapabilities::chrome();
$driver = RemoteWebDriver::create($host, $capabilities);

$driver->get('https://www.airbnb.com/rooms/42076319?location=New%20York%2C%20NY%2C%20United%20States&adults=2&check_in=2020-10-02&check_out=2020-10-06&previous_page_section_name=1000&federated_search_id=a8a36c90-8252-4444-8d36-e9628087a4fe');
$driver->manage()->window()->maximize();
sleep(5);
$select = $driver->findElement(WebDriverBy::xpath('/html/body/div[3]/div/div/div/div/div/div/div[1]/main/div/div[4]/div/div/div[1]/div[1]/div/div/div/div/section/div/div/div/div[1]/div[2]'));
for ($j = 1; $j <= 7; $j = $j + 2) {
    $span = $select->findElement(WebDriverBy::xpath('span['. $j .']'));
    print($span->getText());
    
}

// $driver->quit();

