<?php

class AuthRouter {
    public static function handle() {
        $request = $_SERVER['REQUEST_URI'];
        $path = parse_url($request, PHP_URL_PATH);
        $method = $_SERVER['REQUEST_METHOD'];

        // Remove trailing slash except for root
        if ($path !== '/' && substr($path, -1) === '/') {
            $path = rtrim($path, '/');
        }

        try {
            // Include the controller
            require_once '../app/Controllers/Auth/AuthController.php';
            $controller = new AuthController();

            switch ($path) {
                case '/':
                    if ($method === 'GET') {
                        $controller->showWelcome();
                    } else {
                        self::handleMethodNotAllowed();
                    }
                    break;
                    
                case '/login':
                    if ($method === 'GET') {
                        $controller->showLogin();
                    } elseif ($method === 'POST') {
                        $controller->handleLogin();
                    } else {
                        self::handleMethodNotAllowed();
                    }
                    break;
                    
                case '/register':
                    if ($method === 'GET') {
                        $controller->showRegister();
                    } elseif ($method === 'POST') {
                        $controller->handleRegister();
                    } else {
                        self::handleMethodNotAllowed();
                    }
                    break;
                    
                case '/forgot-password':
                    if ($method === 'GET') {
                        $controller->showForgotPassword();
                    } elseif ($method === 'POST') {
                        $controller->handleForgotPassword();
                    } else {
                        self::handleMethodNotAllowed();
                    }
                    break;
                    
                case '/reset-password':
                    if ($method === 'GET') {
                        $controller->showResetPassword();
                    } elseif ($method === 'POST') {
                        $controller->handleResetPassword();
                    } else {
                        self::handleMethodNotAllowed();
                    }
                    break;
                    
                case '/verify-email':
                    if ($method === 'GET') {
                        $controller->showVerifyEmail();
                    } else {
                        self::handleMethodNotAllowed();
                    }
                    break;
                    
                case '/logout':
                    if ($method === 'GET') {
                        $controller->logout();
                    } else {
                        self::handleMethodNotAllowed();
                    }
                    break;

                case '/terms':
                case '/terms-of-service':
                    if ($method === 'GET') {
                        $controller->showTerms();
                    } else {
                        self::handleMethodNotAllowed();
                    }
                    break;

                case '/privacy':
                case '/privacy-policy':
                    if ($method === 'GET') {
                        $controller->showPrivacy();
                    } else {
                        self::handleMethodNotAllowed();
                    }
                    break;

                case '/dashboard':
                    if (isset($_SESSION['user'])) {
                        $userRole = $_SESSION['user']['role'];
                        if ($userRole === 'instructor') {
                            require_once '../app/Views/course/instructor/dashboard.php';
                        } elseif ($userRole === 'student') {
                            self::showComingSoon('Student Dashboard');
                        } elseif ($userRole === 'admin') {
                            self::showComingSoon('Admin Dashboard');
                        } else {
                            self::showComingSoon('Dashboard');
                        }
                    } else {
                        header('Location: /login');
                        exit;
                    }
                    break;
                    
                default:
                    self::handle404();
                    break;
            }
        } catch (Exception $e) {
            self::handle500($e);
        }
    }

    private static function handle404() {
        http_response_code(404);
        require_once '../app/Views/errors/404.php';
    }

    private static function handle500($exception = null) {
        http_response_code(500);
        require_once '../app/Views/errors/500.php';
    }

    private static function handleMethodNotAllowed() {
        http_response_code(405);
        require_once '../app/Views/errors/405.php';
    }

    private static function showComingSoon($feature) {
        require_once '../app/Views/errors/coming-soon.php';
    }
}