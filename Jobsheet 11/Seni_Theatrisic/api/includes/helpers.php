<?php
function e($string) {
    return htmlspecialchars($string ?? '', ENT_QUOTES, 'UTF-8');
}
function baseUrl() {
    return "http://localhost/Seni_Theatrisic/api/";
}
function appUrl($path = '') {
    return baseUrl() . $path;
}
?>