<?php
// log.php
include 'includes/logging.php';  // Include logging for any errors

log_message("Log viewer accessed.");

$log_file = 'logs/log.txt';  // Path to log file

if (file_exists($log_file)) {
    $log_contents = file_get_contents($log_file);
    echo nl2br(htmlspecialchars($log_contents));
} else {
    echo "Log file does not exist.";
}
?>
