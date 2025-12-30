<?php
// Set a custom error handler to throw exceptions on errors
set_error_handler(function ($severity, $message, $file, $line) {
    if (!(error_reporting() & $severity)) {
        // This error code is not included in error_reporting
        return;
    }
    throw new ErrorException($message, 0, $severity, $file, $line);
});

echo "<h3>Demonstrating Modern Error Handling</h3>";

try {
    // This will now throw an ErrorException instead of just a warning
    $file_handle = fopen("non_existent_file.txt", "r");
} catch (ErrorException $e) {
    echo "Caught an exception: <br>";
    echo "Message: " . $e->getMessage() . "<br>";
    echo "File: " . $e->getFile() . "<br>";
    echo "Line: " . $e->getLine() . "<br>";
    // You could log the error here, show a user-friendly message, etc.
}

// Restore the previous error handler
restore_error_handler();
?>
