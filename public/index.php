<?php
// Normalize request URL (remove query strings)
$request = $_SERVER['REQUEST_URI'];
$request = strtok($request, '?'); // Strip query parameters

// Define routing logic
switch ($request) {
    case '/public/':
        require __DIR__ . '/home.php';
        break;
    case '/public/admin':
        require __DIR__ . '/admin-dashboard.php';
        break;
    case '/public/banner':
        require __DIR__ . '/banners.php';
        break;
    case '/public/index':
        require __DIR__ . '/home.php';
        break;
    case '/public/restaurant':
        require __DIR__ . '/restaurant.php';
        break;
    case '/public/search':
        require __DIR__ . '/search.php';
        break;
    case '/public/profile':
        require __DIR__ . '/profile.php';
        break;
    case '/public/account':
        require __DIR__ . '/account-dashboard.php';
        break;
    case '/public/verification':
        require __DIR__ . '/account-verification.php';
        break;
    case '/public/business':
        require __DIR__ . '/business-dashboard.php';
        break;
    case '/public/add-business':
        require __DIR__ . '/add-business.php';
        break;
    case '/public/edit-business':
        require __DIR__ . '/edit-business.php';
        break;
    default:
        http_response_code(404);
        require __DIR__ . '/404.php';
        break;
}