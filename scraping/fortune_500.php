<?php

namespace Facebook\WebDriver;

use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;

require_once('vendor/autoload.php');
$host = 'http://localhost:4444';
$conn = mysqli_connect('localhost', 'root', '', 'cse_6240');

$years = array();
for ($i = 2019; $i > 1995; $i--) {
    if ($i > 2011 || $i < 2007) array_push($years,$i);
}

$capabilities = DesiredCapabilities::chrome();
$driver = RemoteWebDriver::create($host, $capabilities);


foreach ($years as $year) {
    $driver->get('https://fortune.com/fortune500/'. $year .'/search/');
    $driver->manage()->window()->maximize();
    sleep(15);

    $select = $driver->findElement(WebDriverBy::xpath('//*[@id="content"]/div/div[2]/div/div[2]/div/div[2]/span[2]'))
                 ->findElement(WebDriverBy::cssSelector("option[value='100']"))
                 ->click();
    for ($i = 0; $i < 5; $i++) {
        $table = $driver->findElement(WebDriverBy::xpath('//*[@id="content"]/div/div[2]/div/div[1]/div[2]'));
        for ($j = 1; $j <= 100; $j++) {
            $div = $table->findElement(WebDriverBy::xpath('div['. $j .']'));
            $columns = explode("\n",$div->getText());
            if ($year > 2016) {
                $rank = (int)$columns[0];
                $name = preg_replace('/[\']+/', '', $columns[1]);
                $revenues = (float)preg_replace('/[^0-9.]+/', '', $columns[2]);
                $revenue_perc = (float)preg_replace('/[^0-9-.]+/', '', $columns[3]);
                $profits = (float)preg_replace('/[^0-9-.]+/', '', $columns[4]);
                $profits_perc = (float)preg_replace('/[^0-9-.]+/', '', $columns[5]);
                $assets = (float)preg_replace('/[^0-9.]+/', '', $columns[6]);
                $market_cap = (float)preg_replace('/[^0-9.]+/', '', $columns[7]);
                $change_in_rank = ($columns[10] == '-' ? 0 : (int)$columns[10]);
                $employees = (float)preg_replace('/[^0-9]+/', '', $columns[9]);

                $insert_query = "INSERT INTO `fortune_500` (`year`, `rank`, `name`, `revenues`, `revenue_percent_change`, `profits`, `profits_percent_change`, `assets`, `market_cap`, `change_in_rank`, `employees`) VALUES ('$year','$rank', '$name', '$revenues', '$revenue_perc', '$profits', '$profits_perc', '$assets', '$market_cap', '$change_in_rank', '$employees')";
                $select_query = "SELECT * FROM `fortune_500` WHERE `rank` = '$rank' AND `year` = '$year'";
                $result = mysqli_query($conn, $select_query);
                if (mysqli_num_rows($result) == 0) mysqli_query($conn, $insert_query);
            }
            elseif ($year == 2016) {
                $rank = (int)$columns[0];
                $name = preg_replace('/[\']+/', '', $columns[1]);
                $revenues = (float)preg_replace('/[^0-9.]+/', '', $columns[2]);
                $revenue_perc = (float)preg_replace('/[^0-9-.]+/', '', $columns[3]);
                $profits = (float)preg_replace('/[^0-9-.]+/', '', $columns[4]);
                $profits_perc = (float)preg_replace('/[^0-9-.]+/', '', $columns[5]);
                $assets = (float)preg_replace('/[^0-9.]+/', '', $columns[6]);
                $market_cap = (float)preg_replace('/[^0-9.]+/', '', $columns[8]);
                $employees = (float)preg_replace('/[^0-9]+/', '', $columns[7]);

                $insert_query = "INSERT INTO `fortune_500` (`year`, `rank`, `name`, `revenues`, `revenue_percent_change`, `profits`, `profits_percent_change`, `assets`, `market_cap`, `employees`) VALUES ('$year','$rank', '$name', '$revenues', '$revenue_perc', '$profits', '$profits_perc', '$assets', '$market_cap', '$employees')";
                $select_query = "SELECT * FROM `fortune_500` WHERE `rank` = '$rank' AND `year` = '$year'";
                $result = mysqli_query($conn, $select_query);
                if (mysqli_num_rows($result) == 0) mysqli_query($conn, $insert_query);
            }
            elseif ($year == 2015) {
                $rank = (int)$columns[0];
                $name = preg_replace('/[\']+/', '', $columns[1]);
                $revenue_perc = (float)preg_replace('/[^0-9-.]+/', '', $columns[2]);
                $profits = (float)preg_replace('/[^0-9-.]+/', '', $columns[3]);
                $profits_perc = (float)preg_replace('/[^0-9-.]+/', '', $columns[4]);
                $assets = (float)preg_replace('/[^0-9.]+/', '', $columns[5]);
                $market_cap = (float)preg_replace('/[^0-9.]+/', '', $columns[7]);
                $employees = (float)preg_replace('/[^0-9]+/', '', $columns[6]);

                $insert_query = "INSERT INTO `fortune_500` (`year`, `rank`, `name`, `revenue_percent_change`, `profits`, `profits_percent_change`, `assets`, `market_cap`, `employees`) VALUES ('$year','$rank', '$name', '$revenue_perc', '$profits', '$profits_perc', '$assets', '$market_cap', '$employees')";
                $select_query = "SELECT * FROM `fortune_500` WHERE `rank` = '$rank' AND `year` = '$year'";
                $result = mysqli_query($conn, $select_query);
                if (mysqli_num_rows($result) == 0) mysqli_query($conn, $insert_query);
            }
            elseif ($year == 2014 || $year == 2013) {
                $rank = (int)$columns[0];
                $name = preg_replace('/[\']+/', '', $columns[1]);
                $revenues = (float)preg_replace('/[^0-9.]+/', '', $columns[2]);
                $revenue_perc = (float)preg_replace('/[^0-9-.]+/', '', $columns[3]);
                $profits = (float)preg_replace('/[^0-9-.]+/', '', $columns[4]);
                $profits_perc = (float)preg_replace('/[^0-9-.]+/', '', $columns[5]);
                $assets = (float)preg_replace('/[^0-9.]+/', '', $columns[6]);
                $market_cap = (float)preg_replace('/[^0-9.]+/', '', $columns[8]);

                $insert_query = "INSERT INTO `fortune_500` (`year`, `rank`, `name`, `revenues`, `revenue_percent_change`, `profits`, `profits_percent_change`, `assets`, `market_cap`) VALUES ('$year','$rank', '$name', '$revenues', '$revenue_perc', '$profits', '$profits_perc', '$assets', '$market_cap')";
                $select_query = "SELECT * FROM `fortune_500` WHERE `rank` = '$rank' AND `year` = '$year'";
                $result = mysqli_query($conn, $select_query);
                if (mysqli_num_rows($result) == 0) mysqli_query($conn, $insert_query);
            }
        }
        $next =  $driver->findElement(WebDriverBy::xpath('//*[@id="content"]/div/div[2]/div/div[2]/div/div[3]/button'))->click();
    }

}

$driver->quit();

