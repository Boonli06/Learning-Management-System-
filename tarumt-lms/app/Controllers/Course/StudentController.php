<?php

namespace App\Controllers\Course;

class StudentController
{
    /**
     * Student dashboard - overview of learning progress
     */
    public function dashboard()
    {
        // Get student data
        $studentId = $_SESSION['user']['id'] ?? 1;
        
        // Get dashboard statistics
        $stats = $this->getDashboardStats($studentId);
        
        // Get recent activity
        $recentCourses = $this->getRecentCourses($studentId);
        $recommendations = $this->getRecommendedCourses($studentId);
        
        // Page metadata
        $pageData = [
            'title' => 'Dashboard - TARUMT LMS',
            'pageTitle' => 'Dashboard',
            'pageSubtitle' => 'Welcome back, continue your learning journey',
            'currentPage' => 'dashboard',
            'cartCount' => $this->getCartCount($studentId)
        ];

        $data = [
            'stats' => $stats,
            'recentCourses' => $recentCourses,
            'recommendations' => $recommendations
        ];

        // Include view file
        extract(array_merge($data, $pageData));
        include '../app/Views/course/student/dashboard/index.php';
    }

    /**
     * Browse courses - main course catalog
     */
    public function browse()
    {
        // Get filters from request
        $search = $_GET['search'] ?? '';
        $category_id = $_GET['category'] ?? '';
        $level = $_GET['level'] ?? '';
        $price = $_GET['price'] ?? '';
        $sortBy = $_GET['sort'] ?? 'popular';
        $page = (int)($_GET['page'] ?? 1);
        $perPage = 12;

        // Get all courses
        $allCourses = $this->getAllPublicCourses();

        // Apply filters
        $filteredCourses = $this->filterCourses($allCourses, $search, $category_id, $level, $price);

        // Sort courses
        $filteredCourses = $this->sortCourses($filteredCourses, $sortBy);

        // Pagination
        $totalCourses = count($filteredCourses);
        $totalPages = ceil($totalCourses / $perPage);
        $offset = ($page - 1) * $perPage;
        $courses = array_slice($filteredCourses, $offset, $perPage);

        // Get filter options
        $categories = $this->getCategories();
        $levels = ['beginner' => 'Beginner', 'intermediate' => 'Intermediate', 'advanced' => 'Advanced'];
        $priceRanges = ['free' => 'Free', '0-50' => 'Under RM50', '50-200' => 'RM50-200', '200+' => 'Over RM200'];
        $sortOptions = [
            'popular' => 'Most Popular',
            'newest' => 'Newest',
            'price_low' => 'Price: Low to High',
            'price_high' => 'Price: High to Low',
            'rating' => 'Highest Rated'
        ];

        // Page metadata
        $pageData = [
            'title' => 'Browse Courses - TARUMT LMS',
            'pageTitle' => 'Browse Courses',
            'pageSubtitle' => 'Discover new skills and advance your career',
            'currentPage' => 'browse',
            'cartCount' => $this->getCartCount($_SESSION['user']['id'] ?? 1)
        ];

        $data = [
            'courses' => $courses,
            'categories' => $categories,
            'levels' => $levels,
            'priceRanges' => $priceRanges,
            'sortOptions' => $sortOptions,
            'filters' => compact('search', 'category_id', 'level', 'price', 'sortBy'),
            'pagination' => [
                'current_page' => $page,
                'total_pages' => $totalPages,
                'total_items' => $totalCourses,
                'per_page' => $perPage
            ]
        ];

        // Include view file
        extract(array_merge($data, $pageData));
        include '../app/Views/course/student/browse/index.php';
    }

    /**
     * Browse courses by category
     */
    public function browseCategory($categoryId)
    {
        $category = $this->getCategoryById($categoryId);
        
        if (!$category) {
            $_SESSION['error'] = 'Category not found';
            header('Location: /student/browse');
            exit;
        }

        // Get courses in this category
        $courses = $this->getCoursesByCategory($categoryId);

        // Page metadata
        $pageData = [
            'title' => $category['name'] . ' Courses - TARUMT LMS',
            'pageTitle' => $category['name'] . ' Courses',
            'pageSubtitle' => $category['description'] ?? 'Explore courses in ' . $category['name'],
            'currentPage' => 'browse-courses',
            'cartCount' => $this->getCartCount($_SESSION['user']['id'] ?? 1),
            'breadcrumbs' => [
                ['title' => 'Browse Courses', 'url' => '/student/browse'],
                ['title' => $category['name']]
            ]
        ];

        $data = [
            'category' => $category,
            'courses' => $courses
        ];

        // Include view file
        extract(array_merge($data, $pageData));
        include '../app/Views/course/student/browse/category.php';
    }

    /**
     * Search courses
     */
    public function search()
    {
        $query = $_GET['q'] ?? '';
        
        if (empty($query)) {
            header('Location: /student/browse');
            exit;
        }

        // Perform search
        $courses = $this->searchCourses($query);

        // Page metadata
        $pageData = [
            'title' => 'Search Results - TARUMT LMS',
            'pageTitle' => 'Search Results',
            'pageSubtitle' => 'Results for "' . htmlspecialchars($query) . '"',
            'currentPage' => 'browse',
            'cartCount' => $this->getCartCount($_SESSION['user']['id'] ?? 1)
        ];

        $data = [
            'query' => $query,
            'courses' => $courses,
            'totalResults' => count($courses)
        ];

        // Include view file
        extract(array_merge($data, $pageData));
        include '../app/Views/course/student/browse/search.php';
    }

    /**
     * Show course details
     */
    public function showCourse($courseId)
    {
        $course = $this->getCourseById($courseId);
        
        if (!$course) {
            $_SESSION['error'] = 'Course not found';
            header('Location: /student/browse');
            exit;
        }

        $studentId = $_SESSION['user']['id'] ?? 1;

        // Check if student already enrolled
        $isEnrolled = $this->isEnrolled($studentId, $courseId);
        
        // Get course sections and lectures
        $sections = $this->getCourseSections($courseId);
        
        // Get related courses
        $relatedCourses = $this->getRelatedCourses($courseId);

        // Check if in cart/wishlist
        $inCart = $this->isInCart($studentId, $courseId);
        $inWishlist = $this->isInWishlist($studentId, $courseId);

        // Page metadata
        $pageData = [
            'title' => $course['title'] . ' - TARUMT LMS',
            'pageTitle' => $course['title'],
            'pageSubtitle' => 'Course Details',
            'currentPage' => 'course',
            'cartCount' => $this->getCartCount($studentId)
        ];

        $data = [
            'course' => $course,
            'sections' => $sections,
            'relatedCourses' => $relatedCourses,
            'isEnrolled' => $isEnrolled,
            'inCart' => $inCart,
            'inWishlist' => $inWishlist
        ];

        // Include view file
        extract(array_merge($data, $pageData));
        include '../app/Views/course/student/course/show.php';
    }

    /**
     * Learn course - course player
     */
    public function learnCourse($courseId)
    {
        $studentId = $_SESSION['user']['id'] ?? 1;
        
        // Check if student is enrolled
        if (!$this->isEnrolled($studentId, $courseId)) {
            $_SESSION['error'] = 'You need to enroll in this course first';
            header('Location: /student/course/' . $courseId);
            exit;
        }

        $course = $this->getCourseById($courseId);
        $sections = $this->getCourseSections($courseId);
        $progress = $this->getCourseProgress($studentId, $courseId);

        // Get current lecture (from URL param or first lecture)
        $currentLectureId = $_GET['lecture'] ?? null;
        $currentLecture = null;
        
        if ($currentLectureId) {
            $currentLecture = $this->getLectureById($currentLectureId);
        } else {
            // Get first lecture
            foreach ($sections as $section) {
                if (!empty($section['lectures'])) {
                    $currentLecture = $section['lectures'][0];
                    break;
                }
            }
        }

        // Page metadata
        $pageData = [
            'title' => $course['title'] . ' - Learn - TARUMT LMS',
            'pageTitle' => $course['title'],
            'pageSubtitle' => 'Learning Mode',
            'currentPage' => 'learn',
            'cartCount' => $this->getCartCount($studentId)
        ];

        $data = [
            'course' => $course,
            'sections' => $sections,
            'currentLecture' => $currentLecture,
            'progress' => $progress
        ];

        // Include view file
        extract(array_merge($data, $pageData));
        include '../app/Views/course/student/course/learn.php';
    }

    /**
     * My courses - enrolled courses
     */
    public function myCourses()
    {
        $studentId = $_SESSION['user']['id'] ?? 1;
        
        // Get enrolled courses
        $enrolledCourses = $this->getEnrolledCourses($studentId);
        
        // Get filters
        $status = $_GET['status'] ?? 'all';
        $search = $_GET['search'] ?? '';

        // Apply filters
        if ($status !== 'all') {
            $enrolledCourses = array_filter($enrolledCourses, function($course) use ($status) {
                return $course['progress_status'] === $status;
            });
        }

        if (!empty($search)) {
            $enrolledCourses = array_filter($enrolledCourses, function($course) use ($search) {
                return stripos($course['title'], $search) !== false;
            });
        }

        // Page metadata
        $pageData = [
            'title' => 'My Courses - TARUMT LMS',
            'pageTitle' => 'My Courses',
            'pageSubtitle' => 'Continue your learning journey',
            'currentPage' => 'mycourses',
            'cartCount' => $this->getCartCount($studentId)
        ];

        $data = [
            'courses' => $enrolledCourses,
            'filters' => compact('status', 'search'),
            'statusOptions' => [
                'all' => 'All Courses',
                'in_progress' => 'In Progress',
                'completed' => 'Completed',
                'not_started' => 'Not Started'
            ]
        ];

        // Include view file
        extract(array_merge($data, $pageData));
        include '../app/Views/course/student/dashboard/mycourses.php';
    }

    /**
     * Learning progress overview
     */
    public function progress()
    {
        $studentId = $_SESSION['user']['id'] ?? 1;
        
        // Get overall progress stats
        $progressStats = $this->getProgressStats($studentId);
        
        // Get recent progress
        $recentProgress = $this->getRecentProgress($studentId);

        // Page metadata
        $pageData = [
            'title' => 'Learning Progress - TARUMT LMS',
            'pageTitle' => 'Learning Progress',
            'pageSubtitle' => 'Track your learning achievements',
            'currentPage' => 'progress',
            'cartCount' => $this->getCartCount($studentId)
        ];

        $data = [
            'progressStats' => $progressStats,
            'recentProgress' => $recentProgress
        ];

        // Include view file
        extract(array_merge($data, $pageData));
        include '../app/Views/course/student/dashboard/progress.php';
    }

    /**
     * Wishlist management
     */
    public function wishlist()
    {
        $studentId = $_SESSION['user']['id'] ?? 1;
        
        // Get wishlist items
        $wishlistCourses = $this->getWishlistCourses($studentId);

        // Page metadata
        $pageData = [
            'title' => 'Wishlist - TARUMT LMS',
            'pageTitle' => 'My Wishlist',
            'pageSubtitle' => 'Courses you want to learn',
            'currentPage' => 'wishlist',
            'cartCount' => $this->getCartCount($studentId)
        ];

        $data = [
            'courses' => $wishlistCourses
        ];

        // Include view file
        extract(array_merge($data, $pageData));
        include '../app/Views/course/student/dashboard/wishlist.php';
    }

    /**
     * Shopping cart
     */
    public function cart()
    {
        $studentId = $_SESSION['user']['id'] ?? 1;
        
        // Get cart items
        $cartCourses = $this->getCartCourses($studentId);
        
        // Calculate totals
        $subtotal = array_sum(array_column($cartCourses, 'price'));
        $discount = 0; // TODO: Apply coupons
        $total = $subtotal - $discount;

        // Page metadata
        $pageData = [
            'title' => 'Shopping Cart - TARUMT LMS',
            'pageTitle' => 'Shopping Cart',
            'pageSubtitle' => 'Review your selected courses',
            'currentPage' => 'cart',
            'cartCount' => count($cartCourses)
        ];

        $data = [
            'courses' => $cartCourses,
            'subtotal' => $subtotal,
            'discount' => $discount,
            'total' => $total
        ];

        // Include view file
        extract(array_merge($data, $pageData));
        include '../app/Views/course/student/cart.php';
    }

    /**
     * Checkout page
     */
    public function checkout()
    {
        $studentId = $_SESSION['user']['id'] ?? 1;
        
        // Get cart items
        $cartCourses = $this->getCartCourses($studentId);
        
        if (empty($cartCourses)) {
            $_SESSION['error'] = 'Your cart is empty';
            header('Location: /student/cart');
            exit;
        }

        // Calculate totals
        $subtotal = array_sum(array_column($cartCourses, 'price'));
        $total = $subtotal; // TODO: Apply discounts/taxes

        // Page metadata
        $pageData = [
            'title' => 'Checkout - TARUMT LMS',
            'pageTitle' => 'Checkout',
            'pageSubtitle' => 'Complete your purchase',
            'currentPage' => 'checkout',
            'cartCount' => count($cartCourses)
        ];

        $data = [
            'courses' => $cartCourses,
            'subtotal' => $subtotal,
            'total' => $total
        ];

        // Include view file
        extract(array_merge($data, $pageData));
        include '../app/Views/course/student/checkout.php';
    }

    /**
     * Process checkout
     */
    public function processCheckout()
    {
        $studentId = $_SESSION['user']['id'] ?? 1;
        
        // TODO: Process payment with Stripe
        // For now, simulate successful payment
        
        $cartCourses = $this->getCartCourses($studentId);
        
        if (empty($cartCourses)) {
            $_SESSION['error'] = 'Your cart is empty';
            header('Location: /student/cart');
            exit;
        }

        // TODO: Create payment record and enroll student in courses
        
        // Clear cart
        $this->clearCart($studentId);
        
        $_SESSION['success'] = 'Payment successful! You have been enrolled in ' . count($cartCourses) . ' course(s).';
        header('Location: /student/dashboard/mycourses');
        exit;
    }

    // All student action methods now expect authenticated student
    public function addToCart()
    {
        $courseId = $_POST['course_id'] ?? null;
        $studentId = $_SESSION['user']['id'];
        
        if (!$courseId) {
            echo json_encode(['success' => false, 'message' => 'Course ID required']);
            exit;
        }

        // TODO: Add to cart in database
        
        echo json_encode(['success' => true, 'message' => 'Course added to cart']);
        exit;
    }

    public function removeFromCart()
    {
        $courseId = $_POST['course_id'] ?? null;
        $studentId = $_SESSION['user']['id'];
        
        if (!$courseId) {
            echo json_encode(['success' => false, 'message' => 'Course ID required']);
            exit;
        }

        // TODO: Remove from cart in database
        
        echo json_encode(['success' => true, 'message' => 'Course removed from cart']);
        exit;
    }

    public function addToWishlist()
    {
        $courseId = $_POST['course_id'] ?? null;
        $studentId = $_SESSION['user']['id'];
        
        if (!$courseId) {
            echo json_encode(['success' => false, 'message' => 'Course ID required']);
            exit;
        }

        // TODO: Add to wishlist in database
        
        echo json_encode(['success' => true, 'message' => 'Course added to wishlist']);
        exit;
    }

    public function removeFromWishlist()
    {
        $courseId = $_POST['course_id'] ?? null;
        $studentId = $_SESSION['user']['id'];
        
        if (!$courseId) {
            echo json_encode(['success' => false, 'message' => 'Course ID required']);
            exit;
        }

        // TODO: Remove from wishlist in database
        
        echo json_encode(['success' => true, 'message' => 'Course removed from wishlist']);
        exit;
    }

    public function completeLecture($courseId, $lectureId)
    {
        $studentId = $_SESSION['user']['id'];
        
        // TODO: Mark lecture as completed in database
        
        echo json_encode(['success' => true, 'message' => 'Lecture marked as completed']);
        exit;
    }

    public function courseProgress($courseId)
    {
        $studentId = $_SESSION['user']['id'];
        $progress = $this->getCourseProgress($studentId, $courseId);
        
        echo json_encode($progress);
        exit;
    }

    // Private helper methods with updated dummy data including proper image paths
    private function getDashboardStats($studentId)
    {
        return [
            'enrolled_courses' => 12,
            'completed_courses' => 3,
            'in_progress' => 9,
            'total_hours' => 48.5,
            'certificates' => 3,
            'current_streak' => 7
        ];
    }

    private function getRecentCourses($studentId)
    {
        return [
            [
                'id' => 1,
                'title' => 'Laravel Fundamentals',
                'thumbnail' => 'https://via.placeholder.com/400x200/4f46e5/ffffff?text=Laravel',
                'progress' => 75,
                'last_accessed' => '2024-03-20',
                'next_lecture' => 'Advanced Routing'
            ],
            [
                'id' => 2,
                'title' => 'React Development',
                'thumbnail' => 'https://via.placeholder.com/400x200/06b6d4/ffffff?text=React',
                'progress' => 45,
                'last_accessed' => '2024-03-19',
                'next_lecture' => 'State Management'
            ]
        ];
    }

    private function getRecommendedCourses($studentId)
    {
        return [
            [
                'id' => 5,
                'title' => 'Vue.js for Beginners',
                'thumbnail' => 'https://via.placeholder.com/400x200/10b981/ffffff?text=Vue.js',
                'price' => 89.00,
                'rating' => 4.8,
                'students' => 1250
            ],
            [
                'id' => 6,
                'title' => 'Advanced PHP',
                'thumbnail' => 'https://via.placeholder.com/400x200/8b5cf6/ffffff?text=PHP',
                'price' => 129.00,
                'rating' => 4.9,
                'students' => 892
            ]
        ];
    }

    private function getAllPublicCourses()
    {
        return [
            [
                'id' => 1,
                'title' => 'Laravel Fundamentals',
                'description' => 'Master Laravel framework from basics to advanced concepts',
                'thumbnail' => 'https://via.placeholder.com/400x200/4f46e5/ffffff?text=Laravel',
                'price' => 99.00,
                'rating' => 4.7,
                'students' => 2340,
                'duration' => 12.5,
                'level' => 'beginner',
                'category_id' => 1,
                'category' => 'Web Development',
                'instructor' => 'John Doe',
                'updated_at' => '2024-03-15'
            ],
            [
                'id' => 2,
                'title' => 'React Development',
                'description' => 'Build modern web applications with React',
                'thumbnail' => 'https://via.placeholder.com/400x200/06b6d4/ffffff?text=React',
                'price' => 129.00,
                'rating' => 4.8,
                'students' => 1890,
                'duration' => 15.0,
                'level' => 'intermediate',
                'category_id' => 1,
                'category' => 'Web Development',
                'instructor' => 'Jane Smith',
                'updated_at' => '2024-03-12'
            ],
            [
                'id' => 3,
                'title' => 'Data Science with Python',
                'description' => 'Learn data analysis and machine learning with Python',
                'thumbnail' => 'https://via.placeholder.com/400x200/f59e0b/ffffff?text=Python',
                'price' => 149.00,
                'rating' => 4.9,
                'students' => 3210,
                'duration' => 20.5,
                'level' => 'intermediate',
                'category_id' => 2,
                'category' => 'Data Science',
                'instructor' => 'Dr. Wilson',
                'updated_at' => '2024-03-10'
            ]
        ];
    }

    private function filterCourses($courses, $search, $categoryId, $level, $price)
    {
        if (!empty($search)) {
            $courses = array_filter($courses, function($course) use ($search) {
                return stripos($course['title'], $search) !== false || 
                       stripos($course['description'], $search) !== false;
            });
        }

        if (!empty($categoryId)) {
            $courses = array_filter($courses, function($course) use ($categoryId) {
                return $course['category_id'] == $categoryId;
            });
        }

        if (!empty($level)) {
            $courses = array_filter($courses, function($course) use ($level) {
                return $course['level'] === $level;
            });
        }

        if (!empty($price)) {
            $courses = array_filter($courses, function($course) use ($price) {
                $coursePrice = $course['price'];
                switch ($price) {
                    case 'free':
                        return $coursePrice == 0;
                    case '0-50':
                        return $coursePrice > 0 && $coursePrice <= 50;
                    case '50-200':
                        return $coursePrice > 50 && $coursePrice <= 200;
                    case '200+':
                        return $coursePrice > 200;
                    default:
                        return true;
                }
            });
        }

        return $courses;
    }

    private function sortCourses($courses, $sortBy)
    {
        switch ($sortBy) {
            case 'newest':
                usort($courses, function($a, $b) {
                    return strtotime($b['updated_at']) - strtotime($a['updated_at']);
                });
                break;
            case 'price_low':
                usort($courses, function($a, $b) {
                    return $a['price'] - $b['price'];
                });
                break;
            case 'price_high':
                usort($courses, function($a, $b) {
                    return $b['price'] - $a['price'];
                });
                break;
            case 'rating':
                usort($courses, function($a, $b) {
                    return $b['rating'] - $a['rating'];
                });
                break;
            default: // popular
                usort($courses, function($a, $b) {
                    return $b['students'] - $a['students'];
                });
                break;
        }
        return $courses;
    }

    private function getCategories()
    {
        return [
            ['id' => 1, 'name' => 'Web Development'],
            ['id' => 2, 'name' => 'Data Science'],
            ['id' => 3, 'name' => 'Mobile Development'],
            ['id' => 4, 'name' => 'UI/UX Design']
        ];
    }

    private function getCategoryById($id)
    {
        $categories = [
            1 => ['id' => 1, 'name' => 'Web Development', 'description' => 'Learn modern web development technologies'],
            2 => ['id' => 2, 'name' => 'Data Science', 'description' => 'Master data analysis and machine learning'],
            3 => ['id' => 3, 'name' => 'Mobile Development', 'description' => 'Build mobile apps for iOS and Android'],
            4 => ['id' => 4, 'name' => 'UI/UX Design', 'description' => 'Design beautiful and user-friendly interfaces']
        ];
        
        return $categories[$id] ?? null;
    }

    private function getCoursesByCategory($categoryId)
    {
        $allCourses = $this->getAllPublicCourses();
        return array_filter($allCourses, function($course) use ($categoryId) {
            return $course['category_id'] == $categoryId;
        });
    }

    private function searchCourses($query)
    {
        $allCourses = $this->getAllPublicCourses();
        return array_filter($allCourses, function($course) use ($query) {
            return stripos($course['title'], $query) !== false || 
                   stripos($course['description'], $query) !== false ||
                   stripos($course['instructor'], $query) !== false;
        });
    }

    private function getCourseById($id)
    {
        $courses = [
            1 => [
                'id' => 1,
                'title' => 'Laravel Fundamentals',
                'description' => 'Master Laravel framework from basics to advanced concepts. Learn routing, controllers, models, views, and more.',
                'thumbnail' => 'https://via.placeholder.com/400x200/4f46e5/ffffff?text=Laravel',
                'price' => 99.00,
                'rating' => 4.7,
                'students' => 2340,
                'duration' => 12.5,
                'level' => 'beginner',
                'category' => 'Web Development',
                'instructor' => 'John Doe',
                'instructor_avatar' => 'https://via.placeholder.com/64x64/6b7280/ffffff?text=JD',
                'updated_at' => '2024-03-15',
                'what_you_learn' => [
                    'Build complete Laravel applications',
                    'Understand MVC architecture',
                    'Work with databases using Eloquent',
                    'Create RESTful APIs',
                    'Implement authentication and authorization'
                ],
                'requirements' => [
                    'Basic knowledge of PHP',
                    'Understanding of HTML and CSS',
                    'Familiarity with database concepts'
                ]
            ]
        ];
        
        return $courses[$id] ?? null;
    }

    private function getCourseSections($courseId)
    {
        return [
            [
                'id' => 1,
                'title' => 'Getting Started',
                'lectures' => [
                    ['id' => 1, 'title' => 'Introduction', 'duration' => '5:30', 'is_preview' => true],
                    ['id' => 2, 'title' => 'Setup Environment', 'duration' => '12:15', 'is_preview' => false]
                ]
            ],
            [
                'id' => 2,
                'title' => 'Laravel Basics',
                'lectures' => [
                    ['id' => 3, 'title' => 'Routing Basics', 'duration' => '8:45', 'is_preview' => false],
                    ['id' => 4, 'title' => 'Controllers', 'duration' => '15:20', 'is_preview' => false]
                ]
            ]
        ];
    }

    private function getRelatedCourses($courseId)
    {
        return [
            [
                'id' => 2,
                'title' => 'Advanced Laravel',
                'thumbnail' => 'https://via.placeholder.com/400x200/4f46e5/ffffff?text=Advanced+Laravel',
                'price' => 149.00,
                'rating' => 4.8,
                'students' => 890
            ]
        ];
    }

    private function isEnrolled($studentId, $courseId)
    {
        // TODO: Check database
        return in_array($courseId, [1, 2]); // Dummy data
    }

    private function isInCart($studentId, $courseId)
    {
        // TODO: Check database
        return false;
    }

    private function isInWishlist($studentId, $courseId)
    {
        // TODO: Check database
        return false;
    }

    private function getCartCount($studentId)
    {
        // TODO: Get from database
        return 2;
    }

    private function getEnrolledCourses($studentId)
    {
        return [
            [
                'id' => 1,
                'title' => 'Laravel Fundamentals',
                'thumbnail' => 'https://via.placeholder.com/400x200/4f46e5/ffffff?text=Laravel',
                'progress' => 75,
                'progress_status' => 'in_progress',
                'enrolled_at' => '2024-02-15',
                'last_accessed' => '2024-03-20'
            ],
            [
                'id' => 2,
                'title' => 'React Development',
                'thumbnail' => 'https://via.placeholder.com/400x200/06b6d4/ffffff?text=React',
                'progress' => 100,
                'progress_status' => 'completed',
                'enrolled_at' => '2024-01-20',
                'last_accessed' => '2024-03-10',
                'completed_at' => '2024-03-10'
            ]
        ];
    }

    private function getCourseProgress($studentId, $courseId)
    {
        return [
            'course_id' => $courseId,
            'progress_percentage' => 75,
            'completed_lectures' => 12,
            'total_lectures' => 16,
            'time_spent' => 8.5, // hours
            'last_lecture_id' => 12,
            'status' => 'in_progress'
        ];
    }

    private function getProgressStats($studentId)
    {
        return [
            'total_courses' => 12,
            'completed_courses' => 3,
            'in_progress_courses' => 9,
            'total_hours_spent' => 48.5,
            'average_progress' => 65.2,
            'certificates_earned' => 3,
            'current_streak' => 7,
            'weekly_goal' => 10, // hours
            'weekly_progress' => 6.5
        ];
    }

    private function getRecentProgress($studentId)
    {
        return [
            [
                'course_id' => 1,
                'course_title' => 'Laravel Fundamentals',
                'lecture_title' => 'Advanced Routing',
                'completed_at' => '2024-03-20 14:30:00',
                'duration' => 15 // minutes
            ],
            [
                'course_id' => 2,
                'course_title' => 'React Development',
                'lecture_title' => 'State Management with Redux',
                'completed_at' => '2024-03-19 16:45:00',
                'duration' => 20
            ],
            [
                'course_id' => 1,
                'course_title' => 'Laravel Fundamentals',
                'lecture_title' => 'Middleware Concepts',
                'completed_at' => '2024-03-18 10:15:00',
                'duration' => 12
            ]
        ];
    }

    private function getWishlistCourses($studentId)
    {
        return [
            [
                'id' => 5,
                'title' => 'Vue.js for Beginners',
                'description' => 'Learn Vue.js from scratch and build modern web applications',
                'thumbnail' => 'https://via.placeholder.com/400x200/10b981/ffffff?text=Vue.js',
                'price' => 89.00,
                'rating' => 4.8,
                'students' => 1250,
                'instructor' => 'Sarah Johnson',
                'added_to_wishlist' => '2024-03-15'
            ],
            [
                'id' => 6,
                'title' => 'Advanced PHP',
                'description' => 'Master advanced PHP concepts and best practices',
                'thumbnail' => 'https://via.placeholder.com/400x200/8b5cf6/ffffff?text=PHP',
                'price' => 129.00,
                'rating' => 4.9,
                'students' => 892,
                'instructor' => 'Mike Chen',
                'added_to_wishlist' => '2024-03-10'
            ]
        ];
    }

    private function getCartCourses($studentId)
    {
        return [
            [
                'id' => 7,
                'title' => 'Node.js Backend Development',
                'thumbnail' => 'https://via.placeholder.com/400x200/22c55e/ffffff?text=Node.js',
                'price' => 119.00,
                'instructor' => 'David Wilson',
                'duration' => 14.5,
                'rating' => 4.7
            ],
            [
                'id' => 8,
                'title' => 'MongoDB Database Design',
                'thumbnail' => 'https://via.placeholder.com/400x200/059669/ffffff?text=MongoDB',
                'price' => 99.00,
                'instructor' => 'Lisa Zhang',
                'duration' => 10.0,
                'rating' => 4.6
            ]
        ];
    }

    private function getLectureById($id)
    {
        $lectures = [
            1 => [
                'id' => 1,
                'title' => 'Introduction to Laravel',
                'description' => 'Welcome to the Laravel fundamentals course', 
                'video_url' => '/videos/laravel/intro.mp4',
                'duration' => '5:30',
                'section_id' => 1,
                'section_title' => 'Getting Started',
                'course_id' => 1,
                'is_preview' => true,
                'transcript' => 'Welcome to Laravel fundamentals...',
                'resources' => [
                    ['title' => 'Laravel Documentation', 'url' => 'https://laravel.com/docs'    ],
                    ['title' => 'Course Slides', 'url' => '/resources/slides.pdf']
                ]
            ]
        ];
        
        return $lectures[$id] ?? null;
    }

    private function clearCart($studentId)
    {
        // TODO: Clear cart in database
        return true;
    }
}