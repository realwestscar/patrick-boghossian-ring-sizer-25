<?php
// Start session for flash messages
session_start();

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data and sanitize
    $email = isset($_POST['email']) ? filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL) : '';
    $name = isset($_POST['name']) ? htmlspecialchars(trim($_POST['name'])) : '';
    
    // Validate data
    $errors = [];
    
    // Validate email (only required field)
    if (empty($email)) {
        $errors[] = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Please enter a valid email address";
    } elseif (!preg_match('/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', $email)) {
        $errors[] = "Please enter a valid email in format: username@domain.com";
    }
    
    // Check if email already exists in the CSV
    if (empty($errors) && file_exists('subscribers.csv')) {
        $existing_subscribers = file('subscribers.csv', FILE_IGNORE_NEW_LINES);
        // Skip the header row
        if (count($existing_subscribers) > 0) {
            array_shift($existing_subscribers);
        }
        
        foreach ($existing_subscribers as $subscriber) {
            $subscriber_data = str_getcsv($subscriber);
            // Email is the second column (index 1)
            if (isset($subscriber_data[1]) && trim($subscriber_data[1], '"') === $email) {
                $errors[] = "This email is already registered. Thank you for your interest!";
                break;
            }
        }
    }
    
    // Check for errors
    if (!empty($errors)) {
        $_SESSION['form_error'] = implode('<br>', $errors);
        header('Location: index.php');
        exit;
    }
    
    // Process valid form data
    try {
        // Current timestamp
        $timestamp = date('Y-m-d H:i:s');
        
        // Format data for CSV storage
        $csv_line = $timestamp . ',"' . $email . '"';
        
        // Add name if provided
        if (!empty($name)) {
            $csv_line .= ',"' . $name . '"';
        } else {
            $csv_line .= ',""';
        }
        
        $csv_line .= PHP_EOL;
        
        // CSV file path
        $file = 'subscribers.csv';
        
        // Check if file exists and create with headers if it doesn't
        if (!file_exists($file)) {
            $headers = "Date,Email,Name" . PHP_EOL;
            file_put_contents($file, $headers);
        }
        
        // Append data
        file_put_contents($file, $csv_line, FILE_APPEND);
        
        // Set success message
        $_SESSION['form_success'] = "Thank you for your interest! We'll contact you soon with early access details.";
    } catch (Exception $e) {
        // Log error
        error_log("Error saving signup: " . $e->getMessage());
        
        // Set error message
        $_SESSION['form_error'] = "Sorry, there was a problem processing your request. Please try again later.";
    }
    
    // Redirect back to the home page
    header('Location: index.php');
    exit;
} else {
    // If someone tries to access this file directly, redirect to home
    header('Location: index.php');
    exit;
}
