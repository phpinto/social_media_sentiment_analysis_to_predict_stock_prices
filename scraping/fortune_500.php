<?php

namespace Facebook\WebDriver;

use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;

require_once('vendor/autoload.php');
$host = 'http://localhost:4444';

$capabilities = DesiredCapabilities::chrome();
$driver = RemoteWebDriver::create($host, $capabilities);

$years = array();
for ($i = 2019; $i > 1995; $i--) {
    array_push($years,$i);
}
/*
foreach ($years as $year) {
    $driver->get('https://fortune.com/fortune500/'. $year .'/search/');
    $historyButton = $driver->findElement(
        WebDriverBy::cssSelector('#ca-history a')
    );
}*/

$driver->get('https://fortune.com/fortune500/'. $years[0] .'/search/');


$driver->manage()->window()->maximize();

$select = $driver->findElement(WebDriverBy::xpath('//*[@id="content"]/div/div[2]/div/div[2]/div/div[2]/span[2]'))
                 ->findElement(WebDriverBy::cssSelector("option[value='100']"))
                 ->click();
 
$table = $driver->findElement(WebDriverBy::xpath('//*[@id="content"]/div/div[2]/div/div[1]/div[2]'));

for ($i = 1; $i <= 1; $i++) {
    $div = $table->findElement(WebDriverBy::xpath('div['. $i .']'));
    print $div->getText();
}
                 
/*
$driver->get('https://en.wikipedia.org/wiki/Selenium_(software)');
$driver->findElement(WebDriverBy::id('searchInput')) // find search input element
    ->sendKeys('PHP') // fill the search box
    ->submit();

$driver->wait()->until(
    WebDriverExpectedCondition::elementTextContains(WebDriverBy::id('firstHeading'), 'PHP')
);

echo "The title is '" . $driver->getTitle() . "'\n";

// print URL of current page to output
echo "The current URL is '" . $driver->getCurrentURL() . "'\n";

// find element of 'History' item in menu
$historyButton = $driver->findElement(
    WebDriverBy::cssSelector('#ca-history a')
);

// read text of the element and print it to output
echo "About to click to button with text: '" . $historyButton->getText() . "'\n";

// click the element to navigate to revision history page
$historyButton->click();

// wait until the target page is loaded
$driver->wait()->until(
    WebDriverExpectedCondition::titleContains('Revision history')
);

// print the title of the current page
echo "The title is '" . $driver->getTitle() . "'\n";

// print the URI of the current page

echo "The current URI is '" . $driver->getCurrentURL() . "'\n";

// delete all cookies
$driver->manage()->deleteAllCookies();

// add new cookie
$cookie = new Cookie('cookie_set_by_selenium', 'cookie_value');
$driver->manage()->addCookie($cookie);

// dump current cookies to output
$cookies = $driver->manage()->getCookies();
print_r($cookies);

// close the browser
$driver->quit();*/
