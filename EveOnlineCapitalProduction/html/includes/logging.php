<?php
// EveOnlineCapitalProduction/html/includes/logging.php

function log_message($message) {
    $log_file = __DIR__ . '/../logs/log.txt';  // Ensure the logs folder is writable
    file_put_contents($log_file, date('[Y-m-d H:i:s] ') . $message . PHP_EOL, FILE_APPEND);
}
?>