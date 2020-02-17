<?php

namespace Facebook\WebDriver;

use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;

require_once('vendor/autoload.php');
$host = 'http://localhost:4444';
$conn = mysqli_connect('localhost', 'root', '', 'cse_6240');

$capabilities = DesiredCapabilities::chrome();
$driver = RemoteWebDriver::create($host, $capabilities);
$driver->get('https://fortune.com/fortune500/2015/walmart');
$driver->manage()->window()->maximize();

for ($i = 0; $i < 499; $i++) {
    sleep(10);
    
    $revenues =  $driver->findElement(WebDriverBy::xpath('//*[@id="content"]/div[3]/ul/li[2]/div[2]'))->getText();
    $revenues = (float)preg_replace('/[^0-9.]+/', '', $revenues);

    $rank =  (int)$driver->findElement(WebDriverBy::xpath('//*[@id="content"]/div[2]/div[1]/div/div[1]/div[1]/div[2]'))->getText();

    $update_query = "UPDATE `fortune_500` SET `revenues`= '$revenues' WHERE `rank` = '$rank' AND `year` = '2015'";

    mysqli_query($conn, $update_query);

    if ($i == 0) {
        $next = $driver->findElement(WebDriverBy::xpath('//*[@id="content"]/div[2]/div[1]/div/div[1]/div[2]/a'))
                        ->click();
    }
    elseif ($i < 498) {
        $next = $driver->findElement(WebDriverBy::xpath('//*[@id="content"]/div[2]/div[1]/div/div[1]/div[2]/a[2]'))
                        ->click();
    }
    
}

$driver->quit();
