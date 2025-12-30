<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.html');
    exit();
}

include 'wellness_actions.php';

$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];
$wellnessItems = getAllWellnessItems();

$itemsHtml = '';
if (empty($wellnessItems)) {
    $itemsHtml = '<div class="empty-state"><p>No wellness items available at the moment. Please check back later!</p></div>';
} else {
    $itemsHtml = '<div class="items-grid">';
    foreach ($wellnessItems as $item) {
        $stockClass = $item['stock'] > 5 ? 'in-stock' : ($item['stock'] > 0 ? 'low-stock' : 'out-of-stock');
        $stockText = $item['stock'] > 0 ? $item['stock'] . ' in stock' : 'Out of Stock';
        
        $buttonHtml = '';
        if ($item['stock'] > 0) {
            $buttonHtml = '
            <form action="purchase.php" method="post">
                <input type="hidden" name="item_id" value="'.$item['id'].'">
                <input type="hidden" name="price" value="'.$item['price'].'">
                <label for="quantity-'.$item['id'].'">Quantity:</label>
                <input type="number" id="quantity-'.$item['id'].'" name="quantity" value="1" min="1" max="'.$item['stock'].'">
                <button type="submit">Purchase</button>
            </form>';
        } else {
            $buttonHtml = '<button disabled style="background-color: #ccc; cursor: not-allowed;">Unavailable</button>';
        }

        $itemsHtml .= '
        <div class="card">
            <h4>'.htmlspecialchars($item['name']).'</h4>
            <p>'.htmlspecialchars($item['description']).'</p>
            <p>Price: $'.number_format($item['price'], 2).'</p>
            <span class="stock-badge '.$stockClass.'">'.$stockText.'</span>
            '.$buttonHtml.'
        </div>';
    }
    $itemsHtml .= '</div>';
}

$template = file_get_contents('member_wellness.html');
$template = str_replace('{{wellness_content}}', $itemsHtml, $template);
echo $template;
?>