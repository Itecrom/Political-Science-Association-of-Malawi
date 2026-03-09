<?php
function news_url($slug) {
    $slug = ltrim($slug, '/');
    return '/' . urlencode($slug);
}
?>
