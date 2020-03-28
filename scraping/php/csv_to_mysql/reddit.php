<?php

$host = '';
$db_user = '';
$db_password = '';
$db = '';
$conn = mysqli_connect($host,$db_user,$db_password,$db);

$row = 0;
if (($handle = fopen("reddit_data_clean.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle)) !== FALSE) {
        $subreddit = $data[6];
        $title = addslashes($data[1]);
        $text = addslashes($data[2]);
        $num_c = $data[3];
        $score = $data[4];
        $epoch = $data[5];

        $sql = "INSERT INTO `reddit`(`subreddit`, `post_title`, `post_text`, `num_comments`, `score`, `epoch_timestamp`) VALUES ($id, '$subreddit', '$title', '$text', $num_c, $score, $epoch)";
        if ($row > 0) {
                if(!mysqli_query($conn, $sql)) {
                        echo "$sql \n\n";
                }
                if (($row % 100000) == 0 ) echo "Completed row $row \n";
        }
        $row++;
        }
    }
    fclose($handle);

