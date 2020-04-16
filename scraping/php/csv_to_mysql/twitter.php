<?php

$host = '';
$db_user = '';
$db_password = '';
$db = '';
$conn = mysqli_connect($host,$db_user,$db_password,$db);

$row = 0;
if (($handle = fopen("../../../data/local_data/twitter/twitter_sentiment.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle)) !== FALSE) {
        $index = $data[1];
        $company = addslashes($data[2]);
        $tweet_text = addslashes($data[3]);
        $date = $data[4];
        $hashtags = addslashes($data[5]);
        $retweets = $data[6];
        $favorites = $data[7];
        $pre_clean_len = $data[8];
        $clean_text = addslashes($data[9]);
        $overall_sentiment = $data[10];
        $positive_sentiment = $data[11];
        $neutral_sentiment = $data[12];
        $negative_sentiment = $data[13];

        $sql = "INSERT INTO `twitter`(`index`, `company_name`, `tweet_text`, `hashtags`, `retweets`, `favorites`, `pre_clean_len`, `clean_text`, `overall_sentiment`, `positive_sentiment`, `neutral_sentiment`, `negative_sentiment`, `date`) VALUES ($index, '$company', '$tweet_text', '$hashtags', $retweets, $favorites, $pre_clean_len, '$clean_text', $overall_sentiment, $positive_sentiment, $neutral_sentiment, $negative_sentiment, '$date')";
        if ($row > 0) {
            //if (!mysqli_query($conn, $sql)) echo "$sql \n\n"; 
            echo "$sql \n\n";
            if (($row % 100000) == 0) echo "Completed row $row \n";
        }
        $row++;
        }
    }
fclose($handle);
