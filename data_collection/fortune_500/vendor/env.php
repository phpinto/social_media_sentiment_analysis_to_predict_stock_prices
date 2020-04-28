<?php
  $variables = [
      'API_TOKEN' => 'pk_4a0efc583a10468faf2d3b138f28402a',
      'ACT_NUM' => '3b33962b23577b229374522a3737513f',
      'DB_HOST' => 'localhost',
      'DB_USERNAME' => 'root',
      'DB_PASSWORD' => '',
      'DB_NAME' => 'cse_6240',
      'DB_PORT' => '3306',
  ];

  foreach ($variables as $key => $value) {
      putenv("$key=$value");
  }