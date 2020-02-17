<?php

namespace Facebook\WebDriver;

use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;

require_once('vendor/autoload.php');
$host = 'http://localhost:4444';
$conn = mysqli_connect('localhost', 'root', '', 'cse_6240');

$years = array();
for ($i = 2012; $i > 2011; $i--) {
    array_push($years,$i);
}

$capabilities = DesiredCapabilities::chrome();
$driver = RemoteWebDriver::create($host, $capabilities);

$pages = array("index.html","101_200.html","201_300.html","301_400.html","401_500.html");
$pages_2 = array("1.html","101.html","201.html","301.html","401.html");

foreach ($years as $year) {
    if ($year > 2005) {
        $rank = 1;
        foreach ($pages as $page) {
            $driver->get('https://money.cnn.com/magazines/fortune/fortune500/'. $year .'/full_list/'. $page);
            $driver->manage()->window()->maximize();
            sleep(10);
            if ( $year > 2008) $table = explode("\n",$driver->findElement(WebDriverBy::xpath('//*[@id="cnnmagFeatData"]/table[1]/tbody'))->getText());
            elseif ($year == 2008) $table = explode("\n",$driver->findElement(WebDriverBy::xpath('//*[@id="magFeatData"]/table[1]/tbody'))->getText());
            elseif ($year == 2007) $table = explode("\n",$driver->findElement(WebDriverBy::xpath('//*[@id="MagListDataTable"]/div[2]/table[1]/tbody'))->getText());
            elseif ($year == 2006) $table = explode("\n",$driver->findElement(WebDriverBy::xpath('//*[@id="MagListDataTable"]/table[2]/tbody'))->getText());
            foreach ($table as $row) {
                $columns = explode(" ", $row);
                $length = count($columns);
                $name = '';
                for ($i = 1; $i < ($length - 2); $i++) {
                    $name = $name . " " . preg_replace('/[\']+/', '', $columns[$i]);
                }
                $revenues = (float)preg_replace('/[^0-9.]+/', '', $columns[$length - 2]);
                $profits = (float)preg_replace('/[^0-9-.]+/', '', $columns[$length - 1]);
                
                $insert_query = "INSERT INTO `fortune_500` (`year`, `rank`, `name`, `revenues`, `profits`) VALUES ('$year','$rank', '$name', '$revenues','$profits')";
                $select_query = "SELECT * FROM `fortune_500` WHERE `rank` = '$rank' AND `year` = '$year'";
                $result = mysqli_query($conn, $select_query);
                if ($revenues != 0) {
                    if (mysqli_num_rows($result) == 0) mysqli_query($conn, $insert_query);
                    $rank++;
                }
            }
        }
    }
    else {
        $rank = 1;
        foreach ($pages_2 as $page) {
            $driver->get('https://money.cnn.com/magazines/fortune/fortune500_archive/full/'. $year .'/' . $page);
            $driver->manage()->window()->maximize();
            sleep(10);
            $table = explode("\n",$driver->findElement(WebDriverBy::xpath('//*[@id="MagListDataTable"]/table[2]/tbody'))->getText());
            foreach ($table as $row) {
                $columns = explode(" ", $row);
                $length = count($columns);
                $name = '';
                for ($i = 1; $i < ($length - 2); $i++) {
                    $name = $name . " " . preg_replace('/[\']+/', '', $columns[$i]);
                }
                $revenues = (float)preg_replace('/[^0-9.]+/', '', $columns[$length - 2]);
                $profits = (float)preg_replace('/[^0-9-.]+/', '', $columns[$length - 1]);
                
                $insert_query = "INSERT INTO `fortune_500` (`year`, `rank`, `name`, `revenues`, `profits`) VALUES ('$year','$rank', '$name', '$revenues','$profits')";
                $select_query = "SELECT * FROM `fortune_500` WHERE `rank` = '$rank' AND `year` = '$year'";
                $result = mysqli_query($conn, $select_query);
                if ($revenues != 0) {
                    if (mysqli_num_rows($result) == 0) mysqli_query($conn, $insert_query);
                    $rank++;
                }
            }
        }
    }
    
}

$driver->quit();