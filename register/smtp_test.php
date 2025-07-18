<?php
$connection = fsockopen("smtp.gmail.com", 587, $errno, $errstr, 10);
if (!$connection) {
    echo "Port 587 failed: $errstr ($errno)";
} else {
    echo "SMTP connection successful on port 587!";
    fclose($connection);
}
