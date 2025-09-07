<?php
session_start();

// Error reporting for development
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include the router
require_once '../config/routes.php';

// Handle the request
AuthRouter::handle();
?>