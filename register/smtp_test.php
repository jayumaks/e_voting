<?php
$connection = fsockopen("smtp.gmail.com", 465, $errno, $errstr, 10);
if (!$connection) {
    echo "Connection failed: $errstr ($errno)";
} else {
    echo "SMTP connection successful!";
    fclose($connection);
}