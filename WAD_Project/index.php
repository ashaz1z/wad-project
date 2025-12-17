<?php

include 'includes/header.php'; 
include 'includes/navbar.php';

$page = isset($_GET['page']) ? $_GET['page'] : 'home';

$allowed_pages = ['home', 'login', 'register', 'about', 'menu'];

if (in_array($page, $allowed_pages)) {
    if (file_exists("pages/$page.php")) {
        include "pages/$page.php";
    } else {
        echo "<h1>404: Page file missing!</h1>";
    }
} else {
    echo "<h1>404: Page not found!</h1>";
}

include 'includes/footer.php';

?>
