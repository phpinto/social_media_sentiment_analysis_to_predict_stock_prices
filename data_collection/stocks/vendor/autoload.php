<?php

require_once __DIR__ . '/composer/autoload_real.php';

if(file_exists(__DIR__ . '/env.php')) {
    include __DIR__ . '/env.php';
}

if(!function_exists('env')) {
    function env($key, $default = null)
    {
        $value = getenv($key);

        if ($value === false) {
            return $default;
        }

        return $value;
    }
}

return ComposerAutoloaderInitdc8cd892a2f5ef65dcde78b7e629ea05::getLoader();

