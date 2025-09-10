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
                // Authentication routes
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

                // Static pages
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

                // Dashboard routing
                case '/dashboard':
                    if (isset($_SESSION['user'])) {
                        $userRole = $_SESSION['user']['role'];
                        if ($userRole === 'instructor') {
                            require_once '../app/Views/course/instructor/dashboard.php';
                        } elseif ($userRole === 'student') {
                            $title = 'Student Dashboard - TARUMT LMS';
                            $pageTitle = 'Dashboard';
                            $pageSubtitle = 'Welcome back, continue your learning journey';
                            $currentPage = 'dashboard';
                            $cartCount = 3;
                            require_once '../app/Views/course/student/dashboard.php';
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

                // Course management routes
                case '/instructor/courses':
                    if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'instructor') {
                        if ($method === 'GET') {
                            require_once __DIR__ . '/../app/Controllers/Course/CourseController.php';
                            $controller = new \App\Controllers\Course\CourseController();
                            $controller->index();
                        } else {
                            self::handleMethodNotAllowed();
                        }
                    } else {
                        header('Location: /login');
                        exit;
                    }
                    break;
                    
                case '/instructor/courses/create':
                    if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'instructor') {
                        if ($method === 'GET') {
                            require_once __DIR__ . '/../app/Controllers/Course/CourseController.php';
                            $controller = new \App\Controllers\Course\CourseController();
                            $controller->create();
                        } elseif ($method === 'POST') {
                            $_SESSION['success'] = 'Course created successfully!';
                            header('Location: /instructor/courses');
                            exit;
                        } else {
                            self::handleMethodNotAllowed();
                        }
                    } else {
                        header('Location: /login');
                        exit;
                    }
                    break;
                
                // Course edit
                case (preg_match('/^\/instructor\/courses\/(\d+)\/edit$/', $path, $matches) ? $path : false):
                    if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'instructor') {
                        if ($method === 'GET') {
                            require_once __DIR__ . '/../app/Controllers/Course/CourseController.php';
                            $controller = new \App\Controllers\Course\CourseController();
                            $controller->edit($matches[1]);
                        } elseif ($method === 'POST' || $method === 'PUT') {
                            require_once __DIR__ . '/../app/Controllers/Course/CourseController.php';
                            $controller = new \App\Controllers\Course\CourseController();
                            $controller->update($matches[1]);
                        } else {
                            self::handleMethodNotAllowed();
                        }
                    } else {
                        header('Location: /login');
                        exit;
                    }
                    break;

                // Course show
                case (preg_match('/^\/instructor\/courses\/(\d+)$/', $path, $matches) ? $path : false):
                    if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'instructor') {
                        if ($method === 'GET') {
                            $_GET['id'] = $matches[1];
                            require_once '../app/Views/course/instructor/courses/show.php';
                        } else {
                            self::handleMethodNotAllowed();
                        }
                    } else {
                        header('Location: /login');
                        exit;
                    }
                    break;

                // Course preview
                case (preg_match('/^\/instructor\/courses\/(\d+)\/preview$/', $path, $matches) ? $path : false):
                    if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'instructor') {
                        if ($method === 'GET') {
                            require_once __DIR__ . '/../app/Controllers/Course/CourseController.php';
                            $controller = new \App\Controllers\Course\CourseController();
                            $controller->preview($matches[1]);
                        } else {
                            self::handleMethodNotAllowed();
                        }
                    } else {
                        header('Location: /login');
                        exit;
                    }
                    break;

                // Course settings
                case (preg_match('/^\/instructor\/courses\/(\d+)\/settings$/', $path, $matches) ? $path : false):
                    if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'instructor') {
                        if ($method === 'GET') {
                            require_once __DIR__ . '/../app/Controllers/Course/CourseController.php';
                            $controller = new \App\Controllers\Course\CourseController();
                            $controller->settings($matches[1]);
                        } elseif ($method === 'POST') {
                            require_once __DIR__ . '/../app/Controllers/Course/CourseController.php';
                            $controller = new \App\Controllers\Course\CourseController();
                            $controller->updateSettings($matches[1]);
                        } else {
                            self::handleMethodNotAllowed();
                        }
                    } else {
                        header('Location: /login');
                        exit;
                    }
                    break;

                // Course pricing
                case (preg_match('/^\/instructor\/courses\/(\d+)\/pricing$/', $path, $matches) ? $path : false):
                    if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'instructor') {
                        if ($method === 'GET') {
                            require_once __DIR__ . '/../app/Controllers/Course/CourseController.php';
                            $controller = new \App\Controllers\Course\CourseController();
                            $controller->pricing($matches[1]);
                        } elseif ($method === 'POST') {
                            require_once __DIR__ . '/../app/Controllers/Course/CourseController.php';
                            $controller = new \App\Controllers\Course\CourseController();
                            $controller->updatePricing($matches[1]);
                        } else {
                            self::handleMethodNotAllowed();
                        }
                    } else {
                        header('Location: /login');
                        exit;
                    }
                    break;
                    
                // Analytics overview
                case '/instructor/analytics':
                    if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'instructor') {
                        if ($method === 'GET') {
                            require_once __DIR__ . '/../app/Controllers/Course/AnalyticsController.php';
                            $controller = new \App\Controllers\Course\AnalyticsController();
                            
                            if (isset($_GET['course_id'])) {
                                $controller->analytics($_GET['course_id']);
                            } else {
                                $controller->analyticsOverview();
                            }
                        } else {
                            self::handleMethodNotAllowed();
                        }
                    } else {
                        header('Location: /login');
                        exit;
                    }
                    break;

                // Course analytics redirect
                case (preg_match('/^\/instructor\/courses\/(\d+)\/analytics$/', $path, $matches) ? $path : false):
                    if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'instructor') {
                        if ($method === 'GET') {
                            header('Location: /instructor/analytics?course_id=' . $matches[1]);
                            exit;
                        } else {
                            self::handleMethodNotAllowed();
                        }
                    } else {
                        header('Location: /login');
                        exit;
                    }
                    break;

                // Category management routes
                case '/instructor/categories':
                    if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'instructor') {
                        if ($method === 'GET') {
                            require_once __DIR__ . '/../app/Controllers/Course/CategoryController.php';
                            $controller = new \App\Controllers\Course\CategoryController();
                            $controller->index();
                        } else {
                            self::handleMethodNotAllowed();
                        }
                    } else {
                        header('Location: /login');
                        exit;
                    }
                    break;

                case '/instructor/categories/create':
                    if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'instructor') {
                        if ($method === 'GET') {
                            require_once __DIR__ . '/../app/Controllers/Course/CategoryController.php';
                            $controller = new \App\Controllers\Course\CategoryController();
                            $controller->create();
                        } elseif ($method === 'POST') {
                            require_once __DIR__ . '/../app/Controllers/Course/CategoryController.php';
                            $controller = new \App\Controllers\Course\CategoryController();
                            $controller->store();
                        } else {
                            self::handleMethodNotAllowed();
                        }
                    } else {
                        header('Location: /login');
                        exit;
                    }
                    break;

                // Category edit
                case (preg_match('/^\/instructor\/categories\/(\d+)\/edit$/', $path, $matches) ? $path : false):
                    if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'instructor') {
                        if ($method === 'GET') {
                            require_once __DIR__ . '/../app/Controllers/Course/CategoryController.php';
                            $controller = new \App\Controllers\Course\CategoryController();
                            $controller->edit($matches[1]);
                        } elseif ($method === 'POST' || $method === 'PUT') {
                            require_once __DIR__ . '/../app/Controllers/Course/CategoryController.php';
                            $controller = new \App\Controllers\Course\CategoryController();
                            $controller->update($matches[1]);
                        } else {
                            self::handleMethodNotAllowed();
                        }
                    } else {
                        header('Location: /login');
                        exit;
                    }
                    break;

                // Category show and delete
                case (preg_match('/^\/instructor\/categories\/(\d+)$/', $path, $matches) ? $path : false):
                    if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'instructor') {
                        $actualMethod = $method;
                        if ($method === 'POST' && isset($_POST['_method']) && $_POST['_method'] === 'DELETE') {
                            $actualMethod = 'DELETE';
                        }
                        
                        if ($actualMethod === 'GET') {
                            require_once __DIR__ . '/../app/Controllers/Course/CategoryController.php';
                            $controller = new \App\Controllers\Course\CategoryController();
                            $controller->show($matches[1]);
                        } elseif ($actualMethod === 'DELETE') {
                            require_once __DIR__ . '/../app/Controllers/Course/CategoryController.php';
                            $controller = new \App\Controllers\Course\CategoryController();
                            $controller->destroy($matches[1]);
                        } else {
                            self::handleMethodNotAllowed();
                        }
                    } else {
                        header('Location: /login');
                        exit;
                    }
                    break;

                // Section management routes
                case '/instructor/sections':
                    if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'instructor') {
                        if ($method === 'GET') {
                            require_once __DIR__ . '/../app/Controllers/Course/SectionController.php';
                            $controller = new \App\Controllers\Course\SectionController();
                            $controller->index();
                        } else {
                            self::handleMethodNotAllowed();
                        }
                    } else {
                        header('Location: /login');
                        exit;
                    }
                    break;

                case '/instructor/sections/create':
                    if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'instructor') {
                        if ($method === 'GET') {
                            require_once __DIR__ . '/../app/Controllers/Course/SectionController.php';
                            $controller = new \App\Controllers\Course\SectionController();
                            $controller->create();
                        } elseif ($method === 'POST') {
                            require_once __DIR__ . '/../app/Controllers/Course/SectionController.php';
                            $controller = new \App\Controllers\Course\SectionController();
                            $controller->store();
                        } else {
                            self::handleMethodNotAllowed();
                        }
                    } else {
                        header('Location: /login');
                        exit;
                    }
                    break;

                // Section edit
                case (preg_match('/^\/instructor\/sections\/(\d+)\/edit$/', $path, $matches) ? $path : false):
                    if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'instructor') {
                        if ($method === 'GET') {
                            require_once __DIR__ . '/../app/Controllers/Course/SectionController.php';
                            $controller = new \App\Controllers\Course\SectionController();
                            $controller->edit($matches[1]);
                        } elseif ($method === 'POST' || $method === 'PUT') {
                            require_once __DIR__ . '/../app/Controllers/Course/SectionController.php';
                            $controller = new \App\Controllers\Course\SectionController();
                            $controller->update($matches[1]);
                        } else {
                            self::handleMethodNotAllowed();
                        }
                    } else {
                        header('Location: /login');
                        exit;
                    }
                    break;

                // Section show and delete
                case (preg_match('/^\/instructor\/sections\/(\d+)$/', $path, $matches) ? $path : false):
                    if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'instructor') {
                        $actualMethod = $method;
                        if ($method === 'POST' && isset($_POST['_method']) && $_POST['_method'] === 'DELETE') {
                            $actualMethod = 'DELETE';
                        }
                        
                        if ($actualMethod === 'GET') {
                            require_once __DIR__ . '/../app/Controllers/Course/SectionController.php';
                            $controller = new \App\Controllers\Course\SectionController();
                            $controller->show($matches[1]);
                        } elseif ($actualMethod === 'DELETE') {
                            require_once __DIR__ . '/../app/Controllers/Course/SectionController.php';
                            $controller = new \App\Controllers\Course\SectionController();
                            $controller->destroy($matches[1]);
                        } else {
                            self::handleMethodNotAllowed();
                        }
                    } else {
                        header('Location: /login');
                        exit;
                    }
                    break;

                // Lecture management routes
                case '/instructor/lectures':
                    if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'instructor') {
                        if ($method === 'GET') {
                            require_once __DIR__ . '/../app/Controllers/Course/LectureController.php';
                            $controller = new \App\Controllers\Course\LectureController();
                            $controller->index();
                        } else {
                            self::handleMethodNotAllowed();
                        }
                    } else {
                        header('Location: /login');
                        exit;
                    }
                    break;

                case '/instructor/lectures/create':
                    if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'instructor') {
                        if ($method === 'GET') {
                            require_once __DIR__ . '/../app/Controllers/Course/LectureController.php';
                            $controller = new \App\Controllers\Course\LectureController();
                            $controller->create();
                        } elseif ($method === 'POST') {
                            require_once __DIR__ . '/../app/Controllers/Course/LectureController.php';
                            $controller = new \App\Controllers\Course\LectureController();
                            $controller->store();
                        } else {
                            self::handleMethodNotAllowed();
                        }
                    } else {
                        header('Location: /login');
                        exit;
                    }
                    break;

                // Lecture edit
                case (preg_match('/^\/instructor\/lectures\/(\d+)\/edit$/', $path, $matches) ? $path : false):
                    if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'instructor') {
                        if ($method === 'GET') {
                            require_once __DIR__ . '/../app/Controllers/Course/LectureController.php';
                            $controller = new \App\Controllers\Course\LectureController();
                            $controller->edit($matches[1]);
                        } elseif ($method === 'POST' || $method === 'PUT') {
                            require_once __DIR__ . '/../app/Controllers/Course/LectureController.php';
                            $controller = new \App\Controllers\Course\LectureController();
                            $controller->update($matches[1]);
                        } else {
                            self::handleMethodNotAllowed();
                        }
                    } else {
                        header('Location: /login');
                        exit;
                    }
                    break;

                // Lecture show and delete
                case (preg_match('/^\/instructor\/lectures\/(\d+)$/', $path, $matches) ? $path : false):
                    if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'instructor') {
                        $actualMethod = $method;
                        if ($method === 'POST' && isset($_POST['_method']) && $_POST['_method'] === 'DELETE') {
                            $actualMethod = 'DELETE';
                        }
                        
                        if ($actualMethod === 'GET') {
                            require_once __DIR__ . '/../app/Controllers/Course/LectureController.php';
                            $controller = new \App\Controllers\Course\LectureController();
                            $controller->show($matches[1]);
                        } elseif ($actualMethod === 'DELETE') {
                            require_once __DIR__ . '/../app/Controllers/Course/LectureController.php';
                            $controller = new \App\Controllers\Course\LectureController();
                            $controller->destroy($matches[1]);
                        } else {
                            self::handleMethodNotAllowed();
                        }
                    } else {
                        header('Location: /login');
                        exit;
                    }
                    break;

                // Lecture duplicate route
                case (preg_match('/^\/instructor\/lectures\/(\d+)\/duplicate$/', $path, $matches) ? $path : false):
                    if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'instructor') {
                        if ($method === 'GET') {
                            require_once __DIR__ . '/../app/Controllers/Course/LectureController.php';
                            $controller = new \App\Controllers\Course\LectureController();
                            $controller->duplicate($matches[1]);
                        } elseif ($method === 'POST') {
                            require_once __DIR__ . '/../app/Controllers/Course/LectureController.php';
                            $controller = new \App\Controllers\Course\LectureController();
                            $controller->storeDuplicate($matches[1]);
                        } else {
                            self::handleMethodNotAllowed();
                        }
                    } else {
                        header('Location: /login');
                        exit;
                    }
                    break;

                // Section-specific lecture routes
                case (preg_match('/^\/instructor\/sections\/(\d+)\/lectures\/create$/', $path, $matches) ? $path : false):
                    if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'instructor') {
                        if ($method === 'GET') {
                            require_once __DIR__ . '/../app/Controllers/Course/LectureController.php';
                            $controller = new \App\Controllers\Course\LectureController();
                            $controller->createForSection($matches[1]);
                        } else {
                            self::handleMethodNotAllowed();
                        }
                    } else {
                        header('Location: /login');
                        exit;
                    }
                    break;

                case (preg_match('/^\/instructor\/sections\/(\d+)\/lectures$/', $path, $matches) ? $path : false):
                    if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'instructor') {
                        if ($method === 'GET') {
                            require_once __DIR__ . '/../app/Controllers/Course/LectureController.php';
                            $controller = new \App\Controllers\Course\LectureController();
                            $controller->indexForSection($matches[1]);
                        } else {
                            self::handleMethodNotAllowed();
                        }
                    } else {
                        header('Location: /login');
                        exit;
                    }
                    break;

                // Goals management routes
                case '/instructor/goals':
                    if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'instructor') {
                        if ($method === 'GET') {
                            require_once __DIR__ . '/../app/Controllers/Course/GoalController.php';
                            $controller = new \App\Controllers\Course\GoalController();
                            $controller->index();
                        } else {
                            self::handleMethodNotAllowed();
                        }
                    } else {
                        header('Location: /login');
                        exit;
                    }
                    break;

                case '/instructor/goals/create':
                    if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'instructor') {
                        if ($method === 'GET') {
                            require_once __DIR__ . '/../app/Controllers/Course/GoalController.php';
                            $controller = new \App\Controllers\Course\GoalController();
                            $controller->create();
                        } elseif ($method === 'POST') {
                            require_once __DIR__ . '/../app/Controllers/Course/GoalController.php';
                            $controller = new \App\Controllers\Course\GoalController();
                            $controller->store();
                        } else {
                            self::handleMethodNotAllowed();
                        }
                    } else {
                        header('Location: /login');
                        exit;
                    }
                    break;

                // Goal edit
                case (preg_match('/^\/instructor\/goals\/(\d+)\/edit$/', $path, $matches) ? $path : false):
                    if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'instructor') {
                        if ($method === 'GET') {
                            require_once __DIR__ . '/../app/Controllers/Course/GoalController.php';
                            $controller = new \App\Controllers\Course\GoalController();
                            $controller->edit($matches[1]);
                        } elseif ($method === 'POST' || $method === 'PUT') {
                            require_once __DIR__ . '/../app/Controllers/Course/GoalController.php';
                            $controller = new \App\Controllers\Course\GoalController();
                            $controller->update($matches[1]);
                        } else {
                            self::handleMethodNotAllowed();
                        }
                    } else {
                        header('Location: /login');
                        exit;
                    }
                    break;

                // Goal show and delete
                case (preg_match('/^\/instructor\/goals\/(\d+)$/', $path, $matches) ? $path : false):
                    if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'instructor') {
                        $actualMethod = $method;
                        if ($method === 'POST' && isset($_POST['_method']) && $_POST['_method'] === 'DELETE') {
                            $actualMethod = 'DELETE';
                        }
                        
                        if ($actualMethod === 'GET') {
                            require_once __DIR__ . '/../app/Controllers/Course/GoalController.php';
                            $controller = new \App\Controllers\Course\GoalController();
                            $controller->show($matches[1]);
                        } elseif ($actualMethod === 'DELETE') {
                            require_once __DIR__ . '/../app/Controllers/Course/GoalController.php';
                            $controller = new \App\Controllers\Course\GoalController();
                            $controller->destroy($matches[1]);
                        } else {
                            self::handleMethodNotAllowed();
                        }
                    } else {
                        header('Location: /login');
                        exit;
                    }
                    break;

                // Goal duplicate
                case (preg_match('/^\/instructor\/goals\/(\d+)\/duplicate$/', $path, $matches) ? $path : false):
                    if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'instructor') {
                        if ($method === 'GET') {
                            require_once __DIR__ . '/../app/Controllers/Course/GoalController.php';
                            $controller = new \App\Controllers\Course\GoalController();
                            $controller->duplicate($matches[1]);
                        } elseif ($method === 'POST') {
                            require_once __DIR__ . '/../app/Controllers/Course/GoalController.php';
                            $controller = new \App\Controllers\Course\GoalController();
                            $controller->storeDuplicate($matches[1]);
                        } else {
                            self::handleMethodNotAllowed();
                        }
                    } else {
                        header('Location: /login');
                        exit;
                    }
                    break;

                // Course-specific goal routes
                case (preg_match('/^\/instructor\/courses\/(\d+)\/goals\/create$/', $path, $matches) ? $path : false):
                    if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'instructor') {
                        if ($method === 'GET') {
                            require_once __DIR__ . '/../app/Controllers/Course/GoalController.php';
                            $controller = new \App\Controllers\Course\GoalController();
                            $controller->createForCourse($matches[1]);
                        } else {
                            self::handleMethodNotAllowed();
                        }
                    } else {
                        header('Location: /login');
                        exit;
                    }
                    break;

                case (preg_match('/^\/instructor\/courses\/(\d+)\/goals$/', $path, $matches) ? $path : false):
                    if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'instructor') {
                        if ($method === 'GET') {
                            require_once __DIR__ . '/../app/Controllers/Course/GoalController.php';
                            $controller = new \App\Controllers\Course\GoalController();
                            $controller->indexForCourse($matches[1]);
                        } else {
                            self::handleMethodNotAllowed();
                        }
                    } else {
                        header('Location: /login');
                        exit;
                    }
                    break;

                // Student Browse Routes
                case '/student/browse':
                    if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'student') {
                        if ($method === 'GET') {
                            require_once __DIR__ . '/../app/Controllers/Course/StudentController.php';
                            $controller = new \App\Controllers\Course\StudentController();
                            $controller->browse();
                        } else {
                            self::handleMethodNotAllowed();
                        }
                    } else {
                        header('Location: /login');
                        exit;
                    }
                    break;

                case '/student/browse/search':
                    if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'student') {
                        if ($method === 'GET') {
                            require_once __DIR__ . '/../app/Controllers/Course/StudentController.php';
                            $controller = new \App\Controllers\Course\StudentController();
                            $controller->search();
                        } else {
                            self::handleMethodNotAllowed();
                        }
                    } else {
                        header('Location: /login');
                        exit;
                    }
                    break;

                // Student Browse by Category
                case (preg_match('/^\/student\/browse\/category\/(\d+)$/', $path, $matches) ? $path : false):
                    if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'student') {
                        if ($method === 'GET') {
                            require_once __DIR__ . '/../app/Controllers/Course/StudentController.php';
                            $controller = new \App\Controllers\Course\StudentController();
                            $controller->browseCategory($matches[1]);
                        } else {
                            self::handleMethodNotAllowed();
                        }
                    } else {
                        header('Location: /login');
                        exit;
                    }
                    break;

                // Student Course Routes
                case (preg_match('/^\/student\/course\/(\d+)$/', $path, $matches) ? $path : false):
                    if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'student') {
                        if ($method === 'GET') {
                            require_once __DIR__ . '/../app/Controllers/Course/StudentController.php';
                            $controller = new \App\Controllers\Course\StudentController();
                            $controller->showCourse($matches[1]);
                        } else {
                            self::handleMethodNotAllowed();
                        }
                    } else {
                        header('Location: /login');
                        exit;
                    }
                    break;

                case (preg_match('/^\/student\/course\/(\d+)\/learn$/', $path, $matches) ? $path : false):
                    if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'student') {
                        if ($method === 'GET') {
                            require_once __DIR__ . '/../app/Controllers/Course/StudentController.php';
                            $controller = new \App\Controllers\Course\StudentController();
                            $controller->learnCourse($matches[1]);
                        } else {
                            self::handleMethodNotAllowed();
                        }
                    } else {
                        header('Location: /login');
                        exit;
                    }
                    break;

                // Student Dashboard Routes
                case '/student/dashboard':
                    if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'student') {
                        if ($method === 'GET') {
                            require_once __DIR__ . '/../app/Controllers/Course/StudentController.php';
                            $controller = new \App\Controllers\Course\StudentController();
                            $controller->dashboard();
                        } else {
                            self::handleMethodNotAllowed();
                        }
                    } else {
                        header('Location: /login');
                        exit;
                    }
                    break;

                case '/student/dashboard/mycourses':
                    if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'student') {
                        if ($method === 'GET') {
                            require_once __DIR__ . '/../app/Controllers/Course/StudentController.php';
                            $controller = new \App\Controllers\Course\StudentController();
                            $controller->myCourses();
                        } else {
                            self::handleMethodNotAllowed();
                        }
                    } else {
                        header('Location: /login');
                        exit;
                    }
                    break;

                case '/student/dashboard/progress':
                    if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'student') {
                        if ($method === 'GET') {
                            require_once __DIR__ . '/../app/Controllers/Course/StudentController.php';
                            $controller = new \App\Controllers\Course\StudentController();
                            $controller->progress();
                        } else {
                            self::handleMethodNotAllowed();
                        }
                    } else {
                        header('Location: /login');
                        exit;
                    }
                    break;

                case '/student/dashboard/wishlist':
                    if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'student') {
                        if ($method === 'GET') {
                            require_once __DIR__ . '/../app/Controllers/Course/StudentController.php';
                            $controller = new \App\Controllers\Course\StudentController();
                            $controller->wishlist();
                        } else {
                            self::handleMethodNotAllowed();
                        }
                    } else {
                        header('Location: /login');
                        exit;
                    }
                    break;

                // Cart and Wishlist Actions
                case '/student/cart/add':
                    if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'student') {
                        if ($method === 'POST') {
                            require_once __DIR__ . '/../app/Controllers/Course/StudentController.php';
                            $controller = new \App\Controllers\Course\StudentController();
                            $controller->addToCart();
                        } else {
                            self::handleMethodNotAllowed();
                        }
                    } else {
                        header('Location: /login');
                        exit;
                    }
                    break;

                case '/student/cart/remove':
                    if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'student') {
                        if ($method === 'POST') {
                            require_once __DIR__ . '/../app/Controllers/Course/StudentController.php';
                            $controller = new \App\Controllers\Course\StudentController();
                            $controller->removeFromCart();
                        } else {
                            self::handleMethodNotAllowed();
                        }
                    } else {
                        header('Location: /login');
                        exit;
                    }
                    break;

                case '/student/wishlist/add':
                    if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'student') {
                        if ($method === 'POST') {
                            require_once __DIR__ . '/../app/Controllers/Course/StudentController.php';
                            $controller = new \App\Controllers\Course\StudentController();
                            $controller->addToWishlist();
                        } else {
                            self::handleMethodNotAllowed();
                        }
                    } else {
                        header('Location: /login');
                        exit;
                    }
                    break;

                case '/student/wishlist/remove':
                    if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'student') {
                        if ($method === 'POST') {
                            require_once __DIR__ . '/../app/Controllers/Course/StudentController.php';
                            $controller = new \App\Controllers\Course\StudentController();
                            $controller->removeFromWishlist();
                        } else {
                            self::handleMethodNotAllowed();
                        }
                    } else {
                        header('Location: /login');
                        exit;
                    }
                    break;

                // Cart and Checkout Routes
                case '/student/cart':
                    if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'student') {
                        if ($method === 'GET') {
                            require_once __DIR__ . '/../app/Controllers/Course/StudentController.php';
                            $controller = new \App\Controllers\Course\StudentController();
                            $controller->cart();
                        } else {
                            self::handleMethodNotAllowed();
                        }
                    } else {
                        header('Location: /login');
                        exit;
                    }
                    break;

                case '/student/checkout':
                    if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'student') {
                        if ($method === 'GET') {
                            require_once __DIR__ . '/../app/Controllers/Course/StudentController.php';
                            $controller = new \App\Controllers\Course\StudentController();
                            $controller->checkout();
                        } elseif ($method === 'POST') {
                            require_once __DIR__ . '/../app/Controllers/Course/StudentController.php';
                            $controller = new \App\Controllers\Course\StudentController();
                            $controller->processCheckout();
                        } else {
                            self::handleMethodNotAllowed();
                        }
                    } else {
                        header('Location: /login');
                        exit;
                    }
                    break;

                // Course Progress Tracking
                case (preg_match('/^\/student\/course\/(\d+)\/lecture\/(\d+)\/complete$/', $path, $matches) ? $path : false):
                    if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'student') {
                        if ($method === 'POST') {
                            require_once __DIR__ . '/../app/Controllers/Course/StudentController.php';
                            $controller = new \App\Controllers\Course\StudentController();
                            $controller->completeLecture($matches[1], $matches[2]);
                        } else {
                            self::handleMethodNotAllowed();
                        }
                    } else {
                        header('Location: /login');
                        exit;
                    }
                    break;

                case (preg_match('/^\/student\/course\/(\d+)\/progress$/', $path, $matches) ? $path : false):
                    if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'student') {
                        if ($method === 'GET') {
                            require_once __DIR__ . '/../app/Controllers/Course/StudentController.php';
                            $controller = new \App\Controllers\Course\StudentController();
                            $controller->courseProgress($matches[1]);
                        } else {
                            self::handleMethodNotAllowed();
                        }
                    } else {
                        header('Location: /login');
                        exit;
                    }
                    break;
                    
                // 404 fallback
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