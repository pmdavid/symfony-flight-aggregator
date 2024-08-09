<?php

use App\Kernel;

require_once dirname(__DIR__).'/vendor/autoload_runtime.php';

// Patch: Avoiding warning in response
set_error_handler(function ($severity, $message, $file, $line) {
    if (error_reporting() & $severity) {
        if (strpos($message, 'ini_set(): assert.warning INI setting is deprecated') !== false) {
            return true;
        }

        return false;
    }
});

return function (array $context) {
    return new Kernel($context['APP_ENV'], (bool) $context['APP_DEBUG']);
};
