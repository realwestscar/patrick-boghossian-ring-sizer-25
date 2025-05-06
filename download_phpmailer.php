<?php
// Create directories if they don't exist
$directories = [
    'vendor/phpmailer/phpmailer/src',
    'vendor/phpmailer/phpmailer/language'
];

foreach ($directories as $dir) {
    if (!file_exists($dir)) {
        mkdir($dir, 0777, true);
    }
}

// URLs for PHPMailer files
$files = [
    'https://raw.githubusercontent.com/PHPMailer/PHPMailer/master/src/Exception.php' => 'vendor/phpmailer/phpmailer/src/Exception.php',
    'https://raw.githubusercontent.com/PHPMailer/PHPMailer/master/src/PHPMailer.php' => 'vendor/phpmailer/phpmailer/src/PHPMailer.php',
    'https://raw.githubusercontent.com/PHPMailer/PHPMailer/master/src/SMTP.php' => 'vendor/phpmailer/phpmailer/src/SMTP.php',
    'https://raw.githubusercontent.com/PHPMailer/PHPMailer/master/language/phpmailer.lang-en.php' => 'vendor/phpmailer/phpmailer/language/phpmailer.lang-en.php'
];

// Download files
foreach ($files as $url => $path) {
    $content = file_get_contents($url);
    if ($content !== false) {
        file_put_contents($path, $content);
        echo "Downloaded: $path\n";
    } else {
        echo "Failed to download: $url\n";
    }
}

echo "PHPMailer installation complete!\n";
?> 