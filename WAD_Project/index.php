<?php
// index.php - The Traffic Controller

// 1. Include the Header (So every page has the logo/nav)
include 'includes/header.php'; 
include 'includes/navbar.php';

// 2. Figure out which page the user wants
// If ?page=xyz is set in the URL, go there. Otherwise, go to 'home'.
$page = isset($_GET['page']) ? $_GET['page'] : 'home';

// 3. Whitelist allowed pages (Security: prevent hacking)
$allowed_pages = ['home', 'login', 'register', 'about', 'menu'];

// 4. Load the content
if (in_array($page, $allowed_pages)) {
    // Check if the file actually exists
    if (file_exists("pages/$page.php")) {
        include "pages/$page.php";
    } else {
        echo "<h1>404: Page file missing!</h1>";
    }
} else {
    echo "<h1>404: Page not found!</h1>";
}

// 5. Include the Footer
include 'includes/footer.php';
?>