<?php

namespace App\Controllers\Course;

class CourseController
{
    /**
     * Display instructor's courses listing
     */
    public function index()
    {
        // Get filters from request
        $search = $_GET['search'] ?? '';
        $status = $_GET['status'] ?? '';
        $categoryId = $_GET['category'] ?? '';
        $sortBy = $_GET['sort'] ?? 'created_desc';
        $page = (int)($_GET['page'] ?? 1);
        $perPage = 6;

        // Dummy courses data
        $allCourses = [
            [
                'id' => 1,
                'title' => 'Laravel Fundamentals for Modern Web Development',
                'status' => 'published',
                'category_id' => 1,
                'category_name' => 'Web Development',
                'thumbnail_class' => 'from-gray-900 to-gray-700',
                'thumbnail_text' => 'Laravel',
                'students_count' => 45,
                'sections_count' => 12,
                'rating' => 4.8,
                'price' => 199,
                'revenue' => 2850,
                'created_at' => '2024-01-15'
            ],
            [
                'id' => 2,
                'title' => 'Advanced React Development Patterns',
                'status' => 'draft',
                'category_id' => 1,
                'category_name' => 'Web Development',
                'thumbnail_class' => 'from-blue-900 to-blue-700',
                'thumbnail_text' => 'React',
                'students_count' => 0,
                'sections_count' => 8,
                'rating' => 0,
                'price' => 299,
                'revenue' => 0,
                'created_at' => '2024-02-20'
            ],
            [
                'id' => 3,
                'title' => 'Node.js Backend Development Mastery',
                'status' => 'pending',
                'category_id' => 1,
                'category_name' => 'Web Development',
                'thumbnail_class' => 'from-purple-900 to-purple-700',
                'thumbnail_text' => 'Node.js',
                'students_count' => 0,
                'sections_count' => 15,
                'rating' => 0,
                'price' => 399,
                'revenue' => 0,
                'created_at' => '2024-03-10'
            ],
            [
                'id' => 4,
                'title' => 'Full Stack JavaScript Development',
                'status' => 'published',
                'category_id' => 1,
                'category_name' => 'Web Development',
                'thumbnail_class' => 'from-green-900 to-green-700',
                'thumbnail_text' => 'JS',
                'students_count' => 28,
                'sections_count' => 20,
                'rating' => 4.6,
                'price' => 499,
                'revenue' => 1890,
                'created_at' => '2024-01-05'
            ],
            [
                'id' => 5,
                'title' => 'Vue.js Complete Guide',
                'status' => 'published',
                'category_id' => 1,
                'category_name' => 'Web Development',
                'thumbnail_class' => 'from-emerald-900 to-emerald-700',
                'thumbnail_text' => 'Vue',
                'students_count' => 32,
                'sections_count' => 14,
                'rating' => 4.7,
                'price' => 249,
                'revenue' => 2240,
                'created_at' => '2023-12-20'
            ],
            [
                'id' => 6,
                'title' => 'Python for Web Development',
                'status' => 'draft',
                'category_id' => 2,
                'category_name' => 'Programming',
                'thumbnail_class' => 'from-yellow-900 to-yellow-700',
                'thumbnail_text' => 'Python',
                'students_count' => 0,
                'sections_count' => 5,
                'rating' => 0,
                'price' => 199,
                'revenue' => 0,
                'created_at' => '2024-03-25'
            ]
        ];

        // Apply filters to dummy data
        $filteredCourses = $allCourses;

        // Search filter
        if (!empty($search)) {
            $filteredCourses = array_filter($filteredCourses, function($course) use ($search) {
                return stripos($course['title'], $search) !== false;
            });
        }

        // Status filter
        if (!empty($status)) {
            $filteredCourses = array_filter($filteredCourses, function($course) use ($status) {
                return $course['status'] === $status;
            });
        }

        // Category filter
        if (!empty($categoryId)) {
            $filteredCourses = array_filter($filteredCourses, function($course) use ($categoryId) {
                return $course['category_id'] == $categoryId;
            });
        }

        // Sort courses
        switch ($sortBy) {
            case 'created_asc':
                usort($filteredCourses, fn($a, $b) => strtotime($a['created_at']) - strtotime($b['created_at']));
                break;
            case 'title_asc':
                usort($filteredCourses, fn($a, $b) => strcmp($a['title'], $b['title']));
                break;
            case 'title_desc':
                usort($filteredCourses, fn($a, $b) => strcmp($b['title'], $a['title']));
                break;
            case 'students_desc':
                usort($filteredCourses, fn($a, $b) => $b['students_count'] - $a['students_count']);
                break;
            default: // created_desc
                usort($filteredCourses, fn($a, $b) => strtotime($b['created_at']) - strtotime($a['created_at']));
                break;
        }

        // Pagination
        $totalCourses = count($filteredCourses);
        $totalPages = ceil($totalCourses / $perPage);
        $offset = ($page - 1) * $perPage;
        $courses = array_slice($filteredCourses, $offset, $perPage);

        // Dummy categories data
        $categories = [
            ['id' => 1, 'name' => 'Web Development'],
            ['id' => 2, 'name' => 'Programming'],
            ['id' => 3, 'name' => 'Data Science'],
            ['id' => 4, 'name' => 'Mobile Development'],
            ['id' => 5, 'name' => 'Design']
        ];

        // Course statistics
        $stats = [
            'total' => count($allCourses),
            'published' => count(array_filter($allCourses, fn($c) => $c['status'] === 'published')),
            'draft' => count(array_filter($allCourses, fn($c) => $c['status'] === 'draft')),
            'pending' => count(array_filter($allCourses, fn($c) => $c['status'] === 'pending'))
        ];

        // Status options
        $statusOptions = [
            'draft' => 'Draft',
            'pending' => 'Pending Review',
            'published' => 'Published'
        ];

        // Prepare data for view
        $data = [
            'courses' => $courses,
            'categories' => $categories,
            'pagination' => [
                'current_page' => $page,
                'total_pages' => $totalPages,
                'total_items' => $totalCourses,
                'start_item' => $totalCourses > 0 ? $offset + 1 : 0,
                'end_item' => min($offset + $perPage, $totalCourses),
                'per_page' => $perPage
            ],
            'filters' => [
                'search' => $search,
                'status' => $status,
                'category' => $categoryId,
                'sort' => $sortBy
            ],
            'stats' => $stats,
            'statusOptions' => $statusOptions
        ];

        // Page metadata
        $pageData = [
            'title' => 'My Courses - TARUMT LMS',
            'pageTitle' => 'My Courses',
            'pageSubtitle' => 'Manage and track your course content',
            'currentPage' => 'courses',
            'breadcrumbs' => [
                ['title' => 'Courses']
            ],
            'pageActions' => '<button type="button" class="bg-black text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black transition-colors duration-200" onclick="window.location.href=\'/instructor/courses/create\'">
                <i class="fas fa-plus mr-2"></i>
                Create Course
            </button>'
        ];

        // Include view file
        extract(array_merge($data, $pageData));
        include '../app/Views/course/instructor/courses/index.php';
    }

    /**
     * Show course creation form
     */
    public function create()
    {
        // Dummy categories data with subcategories
        $categories = [
            [
                'id' => 1,
                'name' => 'Web Development',
                'subcategories' => [
                    ['id' => 1, 'name' => 'Frontend Development'],
                    ['id' => 2, 'name' => 'Backend Development'],
                    ['id' => 3, 'name' => 'Full Stack Development'],
                    ['id' => 4, 'name' => 'Web Design']
                ]
            ],
            [
                'id' => 2,
                'name' => 'Mobile Development',
                'subcategories' => [
                    ['id' => 5, 'name' => 'iOS Development'],
                    ['id' => 6, 'name' => 'Android Development'],
                    ['id' => 7, 'name' => 'React Native'],
                    ['id' => 8, 'name' => 'Flutter']
                ]
            ],
            [
                'id' => 3,
                'name' => 'Data Science',
                'subcategories' => [
                    ['id' => 9, 'name' => 'Machine Learning'],
                    ['id' => 10, 'name' => 'Data Analysis'],
                    ['id' => 11, 'name' => 'Data Visualization'],
                    ['id' => 12, 'name' => 'Big Data']
                ]
            ],
            [
                'id' => 4,
                'name' => 'Design',
                'subcategories' => [
                    ['id' => 13, 'name' => 'UI/UX Design'],
                    ['id' => 14, 'name' => 'Graphic Design'],
                    ['id' => 15, 'name' => 'Web Design'],
                    ['id' => 16, 'name' => 'Mobile Design']
                ]
            ],
            [
                'id' => 5,
                'name' => 'Business',
                'subcategories' => [
                    ['id' => 17, 'name' => 'Entrepreneurship'],
                    ['id' => 18, 'name' => 'Management'],
                    ['id' => 19, 'name' => 'Finance'],
                    ['id' => 20, 'name' => 'Strategy']
                ]
            ],
            [
                'id' => 6,
                'name' => 'Marketing',
                'subcategories' => [
                    ['id' => 21, 'name' => 'Digital Marketing'],
                    ['id' => 22, 'name' => 'Content Marketing'],
                    ['id' => 23, 'name' => 'Social Media'],
                    ['id' => 24, 'name' => 'SEO']
                ]
            ]
        ];

        // Difficulty options
        $difficultyOptions = [
            'beginner' => 'Beginner',
            'intermediate' => 'Intermediate',
            'advanced' => 'Advanced',
            'expert' => 'Expert'
        ];

        // Language options
        $languageOptions = [
            'en' => 'English',
            'ms' => 'Bahasa Malaysia',
            'zh' => 'Chinese',
            'ta' => 'Tamil'
        ];

        // Prepare data for view
        $data = [
            'categories' => $categories,
            'difficultyOptions' => $difficultyOptions,
            'languageOptions' => $languageOptions
        ];

        // Page metadata
        $pageData = [
            'title' => 'Create Course - TARUMT LMS',
            'pageTitle' => 'Create New Course',
            'pageSubtitle' => 'Build your course from the ground up',
            'currentPage' => 'courses',
            'breadcrumbs' => [
                ['title' => 'Courses', 'url' => '/instructor/courses'],
                ['title' => 'Create Course']
            ]
        ];

        // Include view file
        extract(array_merge($data, $pageData));
        include '../app/Views/course/instructor/courses/create.php';
    }
    
    /**
     * Store a new course
     */
    public function store()
    {
        // TODO: 暂时注释，等UI完成后实现
        return;
        
        // Validate input
        // $data = $this->validateCourseData($_POST);
        // 
        // if (!$data) {
        //     $this->redirectBack(['error' => 'Please check your input and try again.']);
        //     return;
        // }
        //
        // Add instructor ID
        // $data['instructor_id'] = $_SESSION['user_id'];
        // $data['status'] = Course::STATUS_DRAFT;
        // $data['slug'] = $this->generateSlug($data['title']);
        //
        // try {
        //     $course = Course::create($data);
        //     $this->redirect("/instructor/courses/{$course->id}/edit", [
        //         'success' => 'Course created successfully! Continue building your content.'
        //     ]);
        // } catch (Exception $e) {
        //     $this->redirectBack(['error' => 'Failed to create course. Please try again.']);
        // }
    }

    /**
     * Show course edit form
     */
    public function edit($id)
    {
    // Find course from dummy data (simulate finding by ID)
    $allCourses = [
        [
            'id' => 1,
            'title' => 'Laravel Fundamentals for Modern Web Development',
            'short_description' => 'Master Laravel framework from basics to advanced concepts with hands-on projects and real-world examples.',
            'description' => 'This comprehensive Laravel course will take you from complete beginner to confident Laravel developer. You will learn MVC architecture, Eloquent ORM, routing, middleware, authentication, and much more. By the end of this course, you will be able to build full-featured web applications using Laravel.',
            'category_id' => 1,
            'subcategory_id' => 2,
            'difficulty_level' => 'intermediate',
            'language' => 'en',
            'price' => 199.00,
            'pricing_type' => 'paid',
            'estimated_duration' => 25,
            'prerequisites' => 'Basic knowledge of PHP and HTML/CSS. Understanding of object-oriented programming concepts is helpful but not required.',
            'status' => 'published',
            'thumbnail' => null,
            'promo_video_url' => 'https://youtube.com/watch?v=example1',
            'allow_preview' => true,
            'enable_qa' => true,
            'certificate_enabled' => true,
            'created_at' => '2024-01-15'
        ],
        [
            'id' => 2,
            'title' => 'Advanced React Development Patterns',
            'short_description' => 'Deep dive into advanced React patterns, hooks, performance optimization, and state management.',
            'description' => 'Take your React skills to the next level with this advanced course covering modern React patterns, custom hooks, performance optimization techniques, and advanced state management strategies.',
            'category_id' => 1,
            'subcategory_id' => 1,
            'difficulty_level' => 'advanced',
            'language' => 'en',
            'price' => 299.00,
            'pricing_type' => 'paid',
            'estimated_duration' => 30,
            'prerequisites' => 'Solid understanding of React fundamentals, JavaScript ES6+, and basic state management.',
            'status' => 'draft',
            'thumbnail' => null,
            'promo_video_url' => '',
            'allow_preview' => false,
            'enable_qa' => true,
            'certificate_enabled' => true,
            'created_at' => '2024-02-20'
        ],
        [
            'id' => 3,
            'title' => 'Node.js Backend Development Mastery',
            'short_description' => 'Build scalable backend applications with Node.js, Express, and MongoDB.',
            'description' => 'Learn to build robust and scalable backend applications using Node.js and Express. This course covers API development, database integration, authentication, security, testing, and deployment.',
            'category_id' => 1,
            'subcategory_id' => 2,
            'difficulty_level' => 'intermediate',
            'language' => 'en',
            'price' => 399.00,
            'pricing_type' => 'paid',
            'estimated_duration' => 40,
            'prerequisites' => 'JavaScript fundamentals, basic understanding of web development concepts.',
            'status' => 'pending',
            'thumbnail' => null,
            'promo_video_url' => '',
            'allow_preview' => true,
            'enable_qa' => true,
            'certificate_enabled' => true,
            'created_at' => '2024-03-10'
        ]
    ];

    // Find the specific course
    $course = null;
    foreach ($allCourses as $c) {
        if ($c['id'] == $id) {
            $course = $c;
            break;
        }
    }

    // If course not found, redirect to courses list
    if (!$course) {
        $_SESSION['error'] = 'Course not found.';
        header('Location: /instructor/courses');
        exit;
    }

    // Same categories data as create method
    $categories = [
        [
            'id' => 1,
            'name' => 'Web Development',
            'subcategories' => [
                ['id' => 1, 'name' => 'Frontend Development'],
                ['id' => 2, 'name' => 'Backend Development'],
                ['id' => 3, 'name' => 'Full Stack Development'],
                ['id' => 4, 'name' => 'Web Design']
            ]
        ],
        [
            'id' => 2,
            'name' => 'Mobile Development',
            'subcategories' => [
                ['id' => 5, 'name' => 'iOS Development'],
                ['id' => 6, 'name' => 'Android Development'],
                ['id' => 7, 'name' => 'React Native'],
                ['id' => 8, 'name' => 'Flutter']
            ]
        ],
        [
            'id' => 3,
            'name' => 'Data Science',
            'subcategories' => [
                ['id' => 9, 'name' => 'Machine Learning'],
                ['id' => 10, 'name' => 'Data Analysis'],
                ['id' => 11, 'name' => 'Data Visualization'],
                ['id' => 12, 'name' => 'Big Data']
            ]
        ],
        [
            'id' => 4,
            'name' => 'Design',
            'subcategories' => [
                ['id' => 13, 'name' => 'UI/UX Design'],
                ['id' => 14, 'name' => 'Graphic Design'],
                ['id' => 15, 'name' => 'Web Design'],
                ['id' => 16, 'name' => 'Mobile Design']
            ]
        ],
        [
            'id' => 5,
            'name' => 'Business',
            'subcategories' => [
                ['id' => 17, 'name' => 'Entrepreneurship'],
                ['id' => 18, 'name' => 'Management'],
                ['id' => 19, 'name' => 'Finance'],
                ['id' => 20, 'name' => 'Strategy']
            ]
        ],
        [
            'id' => 6,
            'name' => 'Marketing',
            'subcategories' => [
                ['id' => 21, 'name' => 'Digital Marketing'],
                ['id' => 22, 'name' => 'Content Marketing'],
                ['id' => 23, 'name' => 'Social Media'],
                ['id' => 24, 'name' => 'SEO']
            ]
        ]
    ];

    // Difficulty options
    $difficultyOptions = [
        'beginner' => 'Beginner',
        'intermediate' => 'Intermediate',
        'advanced' => 'Advanced',
        'expert' => 'Expert'
    ];

    // Language options
    $languageOptions = [
        'en' => 'English',
        'ms' => 'Bahasa Malaysia',
        'zh' => 'Chinese',
        'ta' => 'Tamil'
    ];

    // Prepare data for view
    $data = [
        'course' => $course,
        'categories' => $categories,
        'difficultyOptions' => $difficultyOptions,
        'languageOptions' => $languageOptions
    ];

    // Page metadata
    $pageData = [
        'title' => "Edit {$course['title']} - TARUMT LMS",
        'pageTitle' => 'Edit Course',
        'pageSubtitle' => $course['title'],
        'currentPage' => 'courses',
        'breadcrumbs' => [
            ['title' => 'Courses', 'url' => '/instructor/courses'],
            ['title' => 'Edit Course']
        ]
    ];

    // Include view file
    extract(array_merge($data, $pageData));
    include '../app/Views/course/instructor/courses/edit.php';
}

/**
 * Update course
 */
public function update($id)
{
    // Simulate validation and update process
    $errors = [];

    // Basic validation
    if (empty($_POST['title'])) {
        $errors[] = 'Course title is required.';
    }
    if (empty($_POST['short_description'])) {
        $errors[] = 'Short description is required.';
    }
    if (empty($_POST['description'])) {
        $errors[] = 'Course description is required.';
    }
    if (empty($_POST['category_id'])) {
        $errors[] = 'Category is required.';
    }
    if (empty($_POST['subcategory_id'])) {
        $errors[] = 'Subcategory is required.';
    }
    if (empty($_POST['difficulty_level'])) {
        $errors[] = 'Difficulty level is required.';
    }
    if (empty($_POST['language'])) {
        $errors[] = 'Language is required.';
    }

    // Pricing validation
    if ($_POST['pricing_type'] === 'paid') {
        if (empty($_POST['price']) || $_POST['price'] <= 0) {
            $errors[] = 'Valid price is required for paid courses.';
        }
    }

    if (!empty($errors)) {
        $_SESSION['error'] = implode(' ', $errors);
        header("Location: /instructor/courses/{$id}/edit");
        exit;
    }

    // Simulate successful update
    $_SESSION['success'] = 'Course updated successfully!';
    header('Location: /instructor/courses');
    exit;
}
    /**
     * Show course preview
     */
    public function preview($id)
    {
        // Extended course data for preview (should match edit method courses but with additional preview fields)
        $allCourses = [
            [
                'id' => 1,
                'title' => 'Laravel Fundamentals for Modern Web Development',
                'short_description' => 'Master Laravel framework with hands-on projects and real-world applications. Build complete web applications from scratch.',
                'description' => 'This comprehensive Laravel course will take you from beginner to advanced level. You\'ll learn how to build modern web applications using Laravel\'s powerful features including Eloquent ORM, Blade templating, authentication, and much more.',
                'instructor_name' => 'Wyane Teh',
                'instructor_avatar' => '/images/instructors/wyane-teh.jpg',
                'category' => 'Web Development',
                'subcategory' => 'Backend Development',
                'price' => 199,
                'original_price' => 299,
                'difficulty_level' => 'Intermediate',
                'language' => 'English',
                'status' => 'published',
                'thumbnail' => '/images/courses/laravel-course.jpg',
                'promo_video_url' => 'https://youtube.com/watch?v=example',
                'prerequisites' => 'Basic HTML, CSS, and PHP knowledge',
                'estimated_duration' => 25,
                'total_lectures' => 48,
                'students_count' => 45,
                'rating' => 4.8,
                'reviews_count' => 23,
                'last_updated' => '2024-01-15',
                'created_at' => '2024-01-10'
            ],
            [
                'id' => 2,
                'title' => 'Advanced React Development Patterns',
                'short_description' => 'Deep dive into advanced React patterns, hooks, performance optimization, and state management.',
                'description' => 'Take your React skills to the next level with this advanced course covering modern React patterns, custom hooks, performance optimization techniques, and advanced state management strategies.',
                'instructor_name' => 'Moo Jun Xian',
                'instructor_avatar' => '/images/instructors/moo-jun-xian.jpg',
                'category' => 'Web Development',
                'subcategory' => 'Frontend Development',
                'price' => 299,
                'original_price' => 399,
                'difficulty_level' => 'Advanced',
                'language' => 'English',
                'status' => 'draft',
                'thumbnail' => '/images/courses/react-course.jpg',
                'promo_video_url' => '',
                'prerequisites' => 'Solid understanding of React fundamentals, JavaScript ES6+, and basic state management.',
                'estimated_duration' => 30,
                'total_lectures' => 52,
                'students_count' => 0,
                'rating' => 0,
                'reviews_count' => 0,
                'last_updated' => '2024-02-20',
                'created_at' => '2024-02-20'
            ],
            [
                'id' => 3,
                'title' => 'Node.js Backend Development Mastery',
                'short_description' => 'Build scalable backend applications with Node.js, Express, and MongoDB.',
                'description' => 'Learn to build robust and scalable backend applications using Node.js and Express. This course covers API development, database integration, authentication, security, testing, and deployment.',
                'instructor_name' => 'Lee Boon Li',
                'instructor_avatar' => '/images/instructors/lee-boon-li.jpg',
                'category' => 'Web Development',
                'subcategory' => 'Backend Development',
                'price' => 399,
                'original_price' => 499,
                'difficulty_level' => 'Intermediate',
                'language' => 'English',
                'status' => 'pending',
                'thumbnail' => '/images/courses/nodejs-course.jpg',
                'promo_video_url' => '',
                'prerequisites' => 'JavaScript fundamentals, basic understanding of web development concepts.',
                'estimated_duration' => 40,
                'total_lectures' => 65,
                'students_count' => 0,
                'rating' => 0,
                'reviews_count' => 0,
                'last_updated' => '2024-03-10',
                'created_at' => '2024-03-10'
            ]
        ];

        // Find the specific course
        $course = null;
        foreach ($allCourses as $c) {
            if ($c['id'] == $id) {
                $course = $c;
                break;
            }
        }

        // If course not found, redirect to courses list
        if (!$course) {
            $_SESSION['error'] = 'Course not found.';
            header('Location: /instructor/courses');
            exit;
        }

        // Course learning goals/objectives
        $goals = [
            'Build complete Laravel applications from scratch',
            'Master Eloquent ORM and database relationships',
            'Implement authentication and authorization systems',
            'Create RESTful APIs with proper validation',
            'Deploy Laravel applications to production environments',
            'Understand and implement security best practices'
        ];

        // Course sections and lectures
        $sections = [
            [
                'id' => 1,
                'title' => 'Getting Started with Laravel',
                'lectures_count' => 8,
                'duration' => '2h 30m',
                'lectures' => [
                    ['title' => 'Course Introduction & What You\'ll Build', 'duration' => '5:30', 'is_preview' => true],
                    ['title' => 'Laravel Installation & Development Environment', 'duration' => '12:45', 'is_preview' => true],
                    ['title' => 'Project Structure Overview & Best Practices', 'duration' => '18:20', 'is_preview' => false],
                    ['title' => 'Your First Laravel Route & Controllers', 'duration' => '15:30', 'is_preview' => false],
                    ['title' => 'Understanding Laravel Service Container', 'duration' => '22:15', 'is_preview' => false],
                    ['title' => 'Working with Artisan Commands', 'duration' => '14:45', 'is_preview' => false],
                    ['title' => 'Configuration and Environment Variables', 'duration' => '16:30', 'is_preview' => false],
                    ['title' => 'Setting Up Your First Laravel Project', 'duration' => '25:00', 'is_preview' => false]
                ]
            ],
            [
                'id' => 2,
                'title' => 'MVC Architecture & Routing',
                'lectures_count' => 12,
                'duration' => '4h 15m',
                'lectures' => [
                    ['title' => 'Understanding MVC Pattern in Laravel', 'duration' => '20:15', 'is_preview' => false],
                    ['title' => 'Creating and Organizing Controllers', 'duration' => '25:30', 'is_preview' => false],
                    ['title' => 'Working with Views and Blade Templates', 'duration' => '18:45', 'is_preview' => false],
                    ['title' => 'Advanced Routing Techniques', 'duration' => '22:30', 'is_preview' => false],
                    ['title' => 'Route Model Binding', 'duration' => '17:20', 'is_preview' => false],
                    ['title' => 'Middleware and Request Filtering', 'duration' => '24:15', 'is_preview' => false]
                ]
            ],
            [
                'id' => 3,
                'title' => 'Database & Eloquent ORM',
                'lectures_count' => 15,
                'duration' => '5h 45m',
                'lectures' => [
                    ['title' => 'Database Configuration and Connections', 'duration' => '15:20', 'is_preview' => false],
                    ['title' => 'Migrations & Schema Builder', 'duration' => '22:10', 'is_preview' => false],
                    ['title' => 'Eloquent Models and Basic Operations', 'duration' => '28:45', 'is_preview' => false],
                    ['title' => 'Relationships and Associations', 'duration' => '35:30', 'is_preview' => false],
                    ['title' => 'Query Builder and Advanced Queries', 'duration' => '26:15', 'is_preview' => false]
                ]
            ],
            [
                'id' => 4,
                'title' => 'Authentication & Authorization',
                'lectures_count' => 10,
                'duration' => '3h 20m',
                'lectures' => [
                    ['title' => 'Setting Up Laravel Authentication', 'duration' => '18:30', 'is_preview' => false],
                    ['title' => 'User Registration and Login', 'duration' => '24:45', 'is_preview' => false],
                    ['title' => 'Password Reset and Email Verification', 'duration' => '21:15', 'is_preview' => false],
                    ['title' => 'Role-Based Access Control', 'duration' => '28:20', 'is_preview' => false]
                ]
            ],
            [
                'id' => 5,
                'title' => 'API Development & Testing',
                'lectures_count' => 8,
                'duration' => '2h 55m',
                'lectures' => [
                    ['title' => 'Building RESTful APIs', 'duration' => '22:30', 'is_preview' => false],
                    ['title' => 'API Authentication with Sanctum', 'duration' => '19:45', 'is_preview' => false],
                    ['title' => 'Testing Your Application', 'duration' => '26:15', 'is_preview' => false],
                    ['title' => 'API Documentation and Best Practices', 'duration' => '18:40', 'is_preview' => false]
                ]
            ]
        ];

        // Prepare data for view
        $data = [
            'course' => $course,
            'goals' => $goals,
            'sections' => $sections
        ];

        // Page metadata
        $pageData = [
            'title' => "{$course['title']} - Preview - TARUMT LMS",
            'pageTitle' => 'Course Preview',
            'pageSubtitle' => 'See how your course appears to students',
            'currentPage' => 'course-preview',
            'breadcrumbs' => [
                ['title' => 'Courses', 'url' => '/instructor/courses'],
                ['title' => 'Preview Course']
            ]
        ];

        // Include view file
        extract(array_merge($data, $pageData));
        include '../app/Views/course/instructor/courses/preview.php';
    }

    /**
     * Show course settings form
     */
    public function settings($id)
    {
        // Find course from dummy data
        $allCourses = [
            [
                'id' => 1,
                'title' => 'Laravel Fundamentals for Modern Web Development',
                'slug' => 'laravel-fundamentals-web-development',
                'status' => 'published',
                'visibility' => 'public',
                'enrollment_limit' => 100,
                'current_enrollments' => 45,
                'auto_approve_reviews' => true,
                'allow_course_reviews' => true,
                'enable_qa' => true,
                'enable_announcements' => true,
                'enable_assignments' => false,
                'enable_certificates' => true,
                'certificate_template' => 'default',
                'course_completion_criteria' => 'all_lectures',
                'allow_preview' => true,
                'preview_lectures_count' => 3,
                'drip_content' => false,
                'drip_interval_days' => 7,
                'discussion_moderation' => 'auto_approve',
                'student_can_download' => false,
                'closed_captions' => true,
                'course_language' => 'en',
                'course_level' => 'intermediate',
                'created_at' => '2024-01-10',
                'last_updated' => '2024-01-15'
            ],
            [
                'id' => 2,
                'title' => 'Advanced React Development Patterns',
                'slug' => 'advanced-react-development-patterns',
                'status' => 'draft',
                'visibility' => 'public',
                'enrollment_limit' => 50,
                'current_enrollments' => 0,
                'auto_approve_reviews' => true,
                'allow_course_reviews' => true,
                'enable_qa' => true,
                'enable_announcements' => true,
                'enable_assignments' => false,
                'enable_certificates' => true,
                'certificate_template' => 'default',
                'course_completion_criteria' => 'all_lectures',
                'allow_preview' => false,
                'preview_lectures_count' => 2,
                'drip_content' => false,
                'drip_interval_days' => 7,
                'discussion_moderation' => 'auto_approve',
                'student_can_download' => false,
                'closed_captions' => true,
                'course_language' => 'en',
                'course_level' => 'advanced',
                'created_at' => '2024-02-20',
                'last_updated' => '2024-02-20'
            ],
            [
                'id' => 3,
                'title' => 'Node.js Backend Development Mastery',
                'slug' => 'nodejs-backend-development-mastery',
                'status' => 'pending',
                'visibility' => 'public',
                'enrollment_limit' => 75,
                'current_enrollments' => 0,
                'auto_approve_reviews' => true,
                'allow_course_reviews' => true,
                'enable_qa' => true,
                'enable_announcements' => true,
                'enable_assignments' => true,
                'enable_certificates' => true,
                'certificate_template' => 'default',
                'course_completion_criteria' => '80_percent',
                'allow_preview' => true,
                'preview_lectures_count' => 4,
                'drip_content' => false,
                'drip_interval_days' => 7,
                'discussion_moderation' => 'auto_approve',
                'student_can_download' => false,
                'closed_captions' => true,
                'course_language' => 'en',
                'course_level' => 'intermediate',
                'created_at' => '2024-03-10',
                'last_updated' => '2024-03-10'
            ]
        ];

        // Find the specific course
        $course = null;
        foreach ($allCourses as $c) {
            if ($c['id'] == $id) {
                $course = $c;
                break;
            }
        }

        // If course not found, redirect to courses list
        if (!$course) {
            $_SESSION['error'] = 'Course not found.';
            header('Location: /instructor/courses');
            exit;
        }

        // Settings options data
        $visibilityOptions = [
            'public' => 'Public - Anyone can find and enroll',
            'unlisted' => 'Unlisted - Only accessible via direct link',
            'private' => 'Private - Invitation only'
        ];

        $statusOptions = [
            'draft' => 'Draft',
            'published' => 'Published',
            'archived' => 'Archived'
        ];

        $languageOptions = [
            'en' => 'English',
            'ms' => 'Bahasa Malaysia',
            'zh' => 'Chinese',
            'ta' => 'Tamil'
        ];

        $completionCriteriaOptions = [
            'all_lectures' => 'Complete all lectures',
            '80_percent' => 'Complete 80% of lectures',
            'final_quiz' => 'Pass final quiz',
            'manual' => 'Manual approval'
        ];

        // Prepare data for view
        $data = [
            'course' => $course,
            'visibilityOptions' => $visibilityOptions,
            'statusOptions' => $statusOptions,
            'languageOptions' => $languageOptions,
            'completionCriteriaOptions' => $completionCriteriaOptions
        ];

        // Page metadata
        $pageData = [
            'title' => "Course Settings - {$course['title']} - TARUMT LMS",
            'pageTitle' => 'Course Settings',
            'pageSubtitle' => 'Configure course behavior and student experience',
            'currentPage' => 'courses',
            'breadcrumbs' => [
                ['title' => 'Courses', 'url' => '/instructor/courses'],
                ['title' => $course['title'], 'url' => "/instructor/courses/{$course['id']}/edit"],
                ['title' => 'Settings']
            ]
        ];

        // Include view file
        extract(array_merge($data, $pageData));
        include '../app/Views/course/instructor/courses/settings.php';
    }

    /**
     * Update course settings
     */
    public function updateSettings($id)
    {
        // Simulate validation and update process
        $errors = [];

        // Basic validation
        if (empty($_POST['slug'])) {
            $errors[] = 'Course slug is required.';
        }
        if (empty($_POST['status'])) {
            $errors[] = 'Course status is required.';
        }
        if (empty($_POST['visibility'])) {
            $errors[] = 'Course visibility is required.';
        }

        // Enrollment limit validation
        if (isset($_POST['enrollment_limit']) && ($_POST['enrollment_limit'] < 1 || $_POST['enrollment_limit'] > 10000)) {
            $errors[] = 'Enrollment limit must be between 1 and 10,000.';
        }

        // Preview lectures validation
        if (isset($_POST['allow_preview']) && isset($_POST['preview_lectures_count'])) {
            if ($_POST['preview_lectures_count'] < 1 || $_POST['preview_lectures_count'] > 10) {
                $errors[] = 'Preview lectures count must be between 1 and 10.';
            }
        }

        if (!empty($errors)) {
            $_SESSION['error'] = implode(' ', $errors);
            header("Location: /instructor/courses/{$id}/settings");
            exit;
        }

        // Simulate successful update
        $_SESSION['success'] = 'Course settings updated successfully!';
        header("Location: /instructor/courses/{$id}/settings");
        exit;
    }

    /**
     * Show course pricing form
     */
    public function pricing($id)
    {
        // Find course from dummy data (reuse from edit method)
        $allCourses = [
            [
                'id' => 1,
                'title' => 'Laravel Fundamentals for Modern Web Development',
                'pricing_type' => 'paid',
                'price' => 199.00,
                'compare_price' => 299.00,
                'currency' => 'MYR',
                'enable_discounts' => true,
                'min_discount_percent' => 10,
                'max_discount_percent' => 90,
                'enable_coupons' => true,
                'allow_bulk_pricing' => false,
                'bulk_pricing_tiers' => [],
                'regional_pricing' => false,
                'installment_enabled' => false,
                'refund_policy' => '30_days',
                'status' => 'published',
                'created_at' => '2024-01-15'
            ],
            [
                'id' => 2,
                'title' => 'Advanced React Development Patterns',
                'pricing_type' => 'paid',
                'price' => 299.00,
                'compare_price' => 399.00,
                'currency' => 'MYR',
                'enable_discounts' => true,
                'min_discount_percent' => 15,
                'max_discount_percent' => 85,
                'enable_coupons' => true,
                'allow_bulk_pricing' => false,
                'bulk_pricing_tiers' => [],
                'regional_pricing' => false,
                'installment_enabled' => false,
                'refund_policy' => '14_days',
                'status' => 'draft',
                'created_at' => '2024-02-20'
            ],
            [
                'id' => 3,
                'title' => 'Node.js Backend Development Mastery',
                'pricing_type' => 'free',
                'price' => 0.00,
                'compare_price' => 0.00,
                'currency' => 'MYR',
                'enable_discounts' => false,
                'min_discount_percent' => 0,
                'max_discount_percent' => 0,
                'enable_coupons' => false,
                'allow_bulk_pricing' => false,
                'bulk_pricing_tiers' => [],
                'regional_pricing' => false,
                'installment_enabled' => false,
                'refund_policy' => 'no_refund',
                'status' => 'pending',
                'created_at' => '2024-03-10'
            ]
        ];

        // Find the specific course
        $course = null;
        foreach ($allCourses as $c) {
            if ($c['id'] == $id) {
                $course = $c;
                break;
            }
        }

        // If course not found, redirect to courses list
        if (!$course) {
            $_SESSION['error'] = 'Course not found.';
            header('Location: /instructor/courses');
            exit;
        }

        // Dummy coupons data for this course
        $coupons = [
            [
                'id' => 1,
                'code' => 'LAUNCH50',
                'type' => 'percentage',
                'value' => 50,
                'description' => 'Launch discount',
                'usage_limit' => 100,
                'used_count' => 23,
                'expires_at' => '2024-12-31',
                'status' => 'active'
            ],
            [
                'id' => 2,
                'code' => 'EARLY25',
                'type' => 'percentage',
                'value' => 25,
                'description' => 'Early bird discount',
                'usage_limit' => 50,
                'used_count' => 50,
                'expires_at' => '2024-06-30',
                'status' => 'expired'
            ],
            [
                'id' => 3,
                'code' => 'SAVE30',
                'type' => 'fixed',
                'value' => 30,
                'description' => 'Fixed amount discount',
                'usage_limit' => null,
                'used_count' => 8,
                'expires_at' => '2024-09-15',
                'status' => 'active'
            ]
        ];

        $refundPolicyOptions = [
            'no_refund' => 'No refunds',
            '7_days' => '7 days money-back guarantee',
            '14_days' => '14 days money-back guarantee',
            '30_days' => '30 days money-back guarantee',
            '60_days' => '60 days money-back guarantee',
            'custom' => 'Custom refund policy'
        ];

        $pricingTypeOptions = [
            'free' => 'Free Course',
            'paid' => 'Paid Course'
        ];

        // Prepare data for view
        $data = [
            'course' => $course,
            'coupons' => $coupons,
            'refundPolicyOptions' => $refundPolicyOptions,
            'pricingTypeOptions' => $pricingTypeOptions
        ];

        // Page metadata
        $pageData = [
            'title' => "Pricing - {$course['title']} - TARUMT LMS",
            'pageTitle' => 'Course Pricing',
            'pageSubtitle' => 'Set your course price and manage discount coupons',
            'currentPage' => 'courses',
            'breadcrumbs' => [
                ['title' => 'Courses', 'url' => '/instructor/courses'],
                ['title' => $course['title'], 'url' => "/instructor/courses/{$course['id']}/edit"],
                ['title' => 'Pricing']
            ]
        ];

        // Include view file
        extract(array_merge($data, $pageData));
        include '../app/Views/course/instructor/courses/pricing.php';
    }

    /**
     * Update course pricing
     */
    public function updatePricing($id)
    {
        // Simulate validation and update process
        $errors = [];

        // Basic validation
        if (empty($_POST['pricing_type'])) {
            $errors[] = 'Pricing type is required.';
        }

        // Pricing validation for paid courses
        if ($_POST['pricing_type'] === 'paid') {
            if (empty($_POST['price']) || $_POST['price'] <= 0) {
                $errors[] = 'Valid price is required for paid courses.';
            }
            if (!empty($_POST['compare_price']) && $_POST['compare_price'] <= $_POST['price']) {
                $errors[] = 'Compare price must be higher than the regular price.';
            }
            if (empty($_POST['currency'])) {
                $errors[] = 'Currency is required for paid courses.';
            }
        }

        // Discount validation
        if (isset($_POST['enable_discounts']) && $_POST['enable_discounts'] === '1') {
            $minDiscount = (int)($_POST['min_discount_percent'] ?? 0);
            $maxDiscount = (int)($_POST['max_discount_percent'] ?? 0);
            
            if ($minDiscount < 1 || $minDiscount > 99) {
                $errors[] = 'Minimum discount must be between 1% and 99%.';
            }
            if ($maxDiscount < 1 || $maxDiscount > 99) {
                $errors[] = 'Maximum discount must be between 1% and 99%.';
            }
            if ($minDiscount >= $maxDiscount) {
                $errors[] = 'Minimum discount must be less than maximum discount.';
            }
        }

        if (!empty($errors)) {
            $_SESSION['error'] = implode(' ', $errors);
            header("Location: /instructor/courses/{$id}/pricing");
            exit;
        }

        // Simulate successful update
        $_SESSION['success'] = 'Course pricing updated successfully!';
        header("Location: /instructor/courses/{$id}/pricing");
        exit;
    }

    /**
     * Show analytics overview
     */
    public function analyticsOverview()
    {
        // Dummy analytics data
        $analytics = [
            'total_revenue' => 24590,
            'total_students' => 1247,
            'active_courses' => 12,
            'published_courses' => 8,
            'draft_courses' => 4,
            'avg_rating' => 4.7,
            'total_reviews' => 156,
            'monthly_revenue_growth' => 15.3,
            'weekly_student_growth' => 42
        ];

        // Page metadata
        $pageData = [
            'title' => 'Analytics Overview - TARUMT LMS',
            'pageTitle' => 'Analytics Overview',
            'pageSubtitle' => 'Track your overall course performance and revenue',
            'currentPage' => 'analytics',
            'breadcrumbs' => [
                ['title' => 'Analytics']
            ],
            'pageActions' => '
                <div class="flex space-x-3">
                    <button type="button" class="bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black transition-colors duration-200" onclick="exportAllData()">
                        <i class="fas fa-download mr-2"></i>
                        Export All Data
                    </button>
                    <button type="button" class="bg-black text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black transition-colors duration-200" onclick="window.location.href=\'/instructor/courses/create\'">
                        <i class="fas fa-plus mr-2"></i>
                        Create New Course
                    </button>
                </div>'
        ];

        // Prepare data for view
        $data = [
            'analytics' => $analytics
        ];

        // Include view file
        extract(array_merge($data, $pageData));
        include '../app/Views/course/instructor/analytics/overview.php';
    }

    /**
     * Show course analytics
     */
    public function analytics($courseId)
{
    // 模拟从数据库获取课程数据 (与其他方法保持一致的6门课程)
        $allCourses = [
            [
                'id' => 1,
                'title' => 'Laravel Fundamentals for Modern Web Development',
                'short_description' => 'Master Laravel framework with hands-on projects and real-world applications.',
                'status' => 'published',
                'created_at' => '2024-01-15',
                'instructor_name' => 'Wyane Teh',
                'category' => 'Web Development',
                'price' => 199,
                'students_count' => 45,
                'rating' => 4.8,
                'total_lectures' => 48,
                'estimated_duration' => 25
            ],
            [
                'id' => 2,
                'title' => 'Advanced React Development Patterns',
                'short_description' => 'Deep dive into advanced React patterns, hooks, and performance optimization.',
                'status' => 'draft',
                'created_at' => '2024-02-20',
                'instructor_name' => 'Moo Jun Xian',
                'category' => 'Web Development',
                'price' => 299,
                'students_count' => 0,
                'rating' => 0,
                'total_lectures' => 52,
                'estimated_duration' => 30
            ],
            [
                'id' => 3,
                'title' => 'Node.js Backend Development Mastery',
                'short_description' => 'Build scalable backend applications with Node.js, Express, and MongoDB.',
                'status' => 'pending',
                'created_at' => '2024-03-10',
                'instructor_name' => 'Lee Boon Li',
                'category' => 'Web Development',
                'price' => 399,
                'students_count' => 0,
                'rating' => 0,
                'total_lectures' => 65,
                'estimated_duration' => 40
            ],
            [
                'id' => 4,
                'title' => 'Full Stack JavaScript Development',
                'short_description' => 'Complete JavaScript development from frontend to backend.',
                'status' => 'published',
                'created_at' => '2024-01-05',
                'instructor_name' => 'Tung Meii Yinn',
                'category' => 'Web Development',
                'price' => 499,
                'students_count' => 28,
                'rating' => 4.6,
                'total_lectures' => 75,
                'estimated_duration' => 35
            ],
            [
                'id' => 5,
                'title' => 'Vue.js Complete Guide',
                'short_description' => 'Comprehensive Vue.js course from basics to advanced concepts.',
                'status' => 'published',
                'created_at' => '2023-12-20',
                'instructor_name' => 'Wyane Teh',
                'category' => 'Web Development',
                'price' => 249,
                'students_count' => 32,
                'rating' => 4.7,
                'total_lectures' => 42,
                'estimated_duration' => 28
            ],
            [
                'id' => 6,
                'title' => 'Python for Web Development',
                'short_description' => 'Learn Python web development with Django and Flask.',
                'status' => 'draft',
                'created_at' => '2024-03-25',
                'instructor_name' => 'Lee Boon Li',
                'category' => 'Programming',
                'price' => 199,
                'students_count' => 0,
                'rating' => 0,
                'total_lectures' => 38,
                'estimated_duration' => 22
            ]
        ];

        // 查找特定课程
        $course = null;
        foreach ($allCourses as $c) {
            if ($c['id'] == $courseId) {
                $course = $c;
                break;
            }
        }

        // 如果课程未找到，重定向到课程列表
        if (!$course) {
            $_SESSION['error'] = 'Course not found.';
            header('Location: /instructor/courses');
            exit;
        }

        // 详细分析数据（基于课程ID动态生成）
        $analytics = [
            'course_id' => $courseId,
            'course_title' => $course['title'],
            'course_status' => $course['status'],
            
            // 核心指标
            'total_revenue' => $this->calculateRevenue($courseId, $course),
            'total_students' => $course['students_count'],
            'avg_rating' => $course['rating'],
            'total_reviews' => $this->calculateReviews($courseId, $course),
            'completion_rate' => $this->calculateCompletionRate($courseId, $course),
            
            // 趋势数据
            'monthly_revenue_growth' => $this->calculateGrowth($courseId, 'revenue'),
            'weekly_student_growth' => $this->calculateGrowth($courseId, 'students'),
            'rating_trend' => $this->calculateRatingTrend($courseId),
            
            // 学生参与度
            'avg_watch_time' => $this->calculateWatchTime($courseId),
            'discussion_activity' => $this->calculateDiscussionActivity($courseId),
            'assignment_submission_rate' => $this->calculateAssignmentRate($courseId),
            
            // 内容分析
            'most_popular_lectures' => $this->getPopularLectures($courseId),
            'chapter_completion_rates' => $this->getChapterCompletionRates($courseId),
            'student_drop_off_points' => $this->getDropOffPoints($courseId),
            
            // 流量和转化
            'page_views' => $this->calculatePageViews($courseId),
            'preview_to_enrollment_rate' => $this->calculateConversionRate($courseId),
            'refund_rate' => $this->calculateRefundRate($courseId),
            
            // 地理和设备数据
            'top_countries' => $this->getTopCountries($courseId),
            'device_breakdown' => $this->getDeviceBreakdown($courseId),
            'referral_sources' => $this->getReferralSources($courseId),
            
            // 时间序列数据（用于图表）
            'enrollment_timeline' => $this->getEnrollmentTimeline($courseId),
            'revenue_timeline' => $this->getRevenueTimeline($courseId),
            'rating_timeline' => $this->getRatingTimeline($courseId),
            'engagement_timeline' => $this->getEngagementTimeline($courseId)
        ];

        // 比较数据（与其他课程或行业平均）
        $comparisons = [
            'vs_your_average' => $this->compareToInstructorAverage($courseId, $analytics),
            'vs_category_average' => $this->compareToCategoryAverage($courseId, $analytics),
            'vs_platform_average' => $this->compareToPlatformAverage($courseId, $analytics)
        ];

        // 改进建议
        $recommendations = $this->generateRecommendations($courseId, $analytics, $course);

        // 页面元数据
        $pageData = [
            'title' => "Analytics - {$course['title']} - TARUMT LMS",
            'pageTitle' => 'Course Analytics',
            'pageSubtitle' => $course['title'],
            'currentPage' => 'analytics',
            'breadcrumbs' => [
                ['title' => 'Analytics', 'url' => '/instructor/analytics'],
                ['title' => 'Course Details']
            ]
        ];

        // 准备视图数据
        $data = [
            'course' => $course,
            'analytics' => $analytics,
            'comparisons' => $comparisons,
            'recommendations' => $recommendations
        ];

        // 包含视图文件 - 遵循MVC模式
        extract(array_merge($data, $pageData));
        include '../app/Views/course/instructor/analytics/course-detail.php';
    }

    // 辅助方法用于计算各种指标
private function calculateRevenue($courseId, $course)
{
    // 基于课程价格和学生数量计算收入
    $baseRevenue = $course['price'] * $course['students_count'];
    
    // 添加一些随机变化来模拟实际情况
    $variation = rand(80, 120) / 100; // 80%-120%
    return round($baseRevenue * $variation);
}

private function calculateReviews($courseId, $course)
{
    // 大约30-60%的学生会留下评价
    $reviewRate = rand(30, 60) / 100;
    return round($course['students_count'] * $reviewRate);
}

private function calculateCompletionRate($courseId, $course)
{
    // 基于课程状态和质量模拟完成率
    $baseRate = 0.65; // 基础65%完成率
    
    if ($course['rating'] > 4.5) {
        $baseRate += 0.15; // 高评分课程+15%
    } elseif ($course['rating'] > 4.0) {
        $baseRate += 0.08; // 好评课程+8%
    }
    
    if ($course['status'] === 'published') {
        $baseRate += 0.05; // 已发布课程+5%
    }
    
    return min(round($baseRate * 100, 1), 95); // 最高95%
}

private function calculateGrowth($courseId, $type)
{
    // 模拟增长率数据
    switch ($type) {
        case 'revenue':
            return rand(-5, 25) + (rand(0, 100) / 100); // -5% to +25%
        case 'students':
            return rand(0, 50) + (rand(0, 100) / 100); // 0% to +50%
        default:
            return 0;
    }
}

private function calculateRatingTrend($courseId)
{
    // 模拟评分趋势
    return rand(-2, 8) / 10; // -0.2 to +0.8
}

private function calculateWatchTime($courseId)
{
    // 平均观看时间（分钟）
    return rand(12, 28) + (rand(0, 99) / 100);
}

private function calculateDiscussionActivity($courseId)
{
    // 每个学生平均讨论数
    return rand(2, 8) + (rand(0, 99) / 100);
}

private function calculateAssignmentRate($courseId)
{
    // 作业提交率百分比
    return rand(65, 90) + (rand(0, 99) / 100);
}

private function getPopularLectures($courseId)
{
    // 返回最受欢迎的讲座
    return [
        ['title' => 'Introduction to Laravel', 'views' => 156, 'avg_rating' => 4.9],
        ['title' => 'Setting up Development Environment', 'views' => 142, 'avg_rating' => 4.7],
        ['title' => 'Your First Laravel Application', 'views' => 138, 'avg_rating' => 4.8],
        ['title' => 'Understanding MVC Pattern', 'views' => 129, 'avg_rating' => 4.6],
        ['title' => 'Working with Databases', 'views' => 124, 'avg_rating' => 4.7]
    ];
}

private function getChapterCompletionRates($courseId)
{
    // 每章节完成率
    return [
        ['chapter' => 'Getting Started', 'completion_rate' => 92],
        ['chapter' => 'MVC Architecture', 'completion_rate' => 85],
        ['chapter' => 'Database & ORM', 'completion_rate' => 78],
        ['chapter' => 'Authentication', 'completion_rate' => 71],
        ['chapter' => 'API Development', 'completion_rate' => 64],
        ['chapter' => 'Testing & Deployment', 'completion_rate' => 58]
    ];
}

private function getDropOffPoints($courseId)
{
    // 学生流失点
    return [
        ['lecture' => 'Advanced Eloquent Relationships', 'drop_rate' => 15],
        ['lecture' => 'Building Complex Queries', 'drop_rate' => 12],
        ['lecture' => 'Testing Your Application', 'drop_rate' => 18],
        ['lecture' => 'Deployment Configuration', 'drop_rate' => 20]
    ];
}

private function calculatePageViews($courseId)
{
    // 课程页面浏览量
    return rand(500, 2000);
}

private function calculateConversionRate($courseId)
{
    // 预览到注册转化率
    return rand(8, 25) + (rand(0, 99) / 100);
}

private function calculateRefundRate($courseId)
{
    // 退款率
    return rand(2, 8) + (rand(0, 99) / 100);
}

private function getTopCountries($courseId)
{
    return [
        ['country' => 'Malaysia', 'students' => 18, 'percentage' => 40],
        ['country' => 'Singapore', 'students' => 9, 'percentage' => 20],
        ['country' => 'Indonesia', 'students' => 7, 'percentage' => 15.6],
        ['country' => 'Thailand', 'students' => 5, 'percentage' => 11.1],
        ['country' => 'Philippines', 'students' => 6, 'percentage' => 13.3]
    ];
}

private function getDeviceBreakdown($courseId)
{
    return [
        'desktop' => 65,
        'mobile' => 28,
        'tablet' => 7
    ];
}

private function getReferralSources($courseId)
{
    return [
        ['source' => 'Direct', 'percentage' => 35],
        ['source' => 'Google Search', 'percentage' => 28],
        ['source' => 'Social Media', 'percentage' => 15],
        ['source' => 'Email Marketing', 'percentage' => 12],
        ['source' => 'Referrals', 'percentage' => 10]
    ];
}

private function getEnrollmentTimeline($courseId)
{
    // 最近12个月的注册时间线
    $timeline = [];
    for ($i = 11; $i >= 0; $i--) {
        $date = date('Y-m', strtotime("-{$i} months"));
        $timeline[] = [
            'month' => $date,
            'enrollments' => rand(2, 12)
        ];
    }
    return $timeline;
}

private function getRevenueTimeline($courseId)
{
    // 最近12个月的收入时间线
    $timeline = [];
    for ($i = 11; $i >= 0; $i--) {
        $date = date('Y-m', strtotime("-{$i} months"));
        $timeline[] = [
            'month' => $date,
            'revenue' => rand(400, 2400)
        ];
    }
    return $timeline;
}

private function getRatingTimeline($courseId)
{
    // 最近12个月的评分时间线
    $timeline = [];
    $baseRating = 4.5;
    for ($i = 11; $i >= 0; $i--) {
        $date = date('Y-m', strtotime("-{$i} months"));
        $variation = (rand(-20, 20) / 100); // ±0.2变化
        $rating = max(3.0, min(5.0, $baseRating + $variation));
        $timeline[] = [
            'month' => $date,
            'rating' => round($rating, 1)
        ];
        $baseRating = $rating; // 下个月基于这个月
    }
    return $timeline;
}

private function getEngagementTimeline($courseId)
{
    // 最近12个月的参与度时间线
    $timeline = [];
    for ($i = 11; $i >= 0; $i--) {
        $date = date('Y-m', strtotime("-{$i} months"));
        $timeline[] = [
            'month' => $date,
            'avg_session_duration' => rand(15, 45),
            'completion_rate' => rand(60, 85),
            'discussion_posts' => rand(5, 25)
        ];
    }
    return $timeline;
}

private function compareToInstructorAverage($courseId, $analytics)
{
    return [
        'revenue' => ['current' => $analytics['total_revenue'], 'average' => 6500, 'difference' => 'above'],
        'students' => ['current' => $analytics['total_students'], 'average' => 35, 'difference' => 'above'],
        'rating' => ['current' => $analytics['avg_rating'], 'average' => 4.5, 'difference' => 'above'],
        'completion_rate' => ['current' => $analytics['completion_rate'], 'average' => 68, 'difference' => 'above']
    ];
}

private function compareToCategoryAverage($courseId, $analytics)
{
    return [
        'revenue' => ['current' => $analytics['total_revenue'], 'average' => 7200, 'difference' => 'below'],
        'students' => ['current' => $analytics['total_students'], 'average' => 42, 'difference' => 'above'],
        'rating' => ['current' => $analytics['avg_rating'], 'average' => 4.4, 'difference' => 'above'],
        'completion_rate' => ['current' => $analytics['completion_rate'], 'average' => 65, 'difference' => 'above']
    ];
}

private function compareToPlatformAverage($courseId, $analytics)
{
    return [
        'revenue' => ['current' => $analytics['total_revenue'], 'average' => 5800, 'difference' => 'above'],
        'students' => ['current' => $analytics['total_students'], 'average' => 38, 'difference' => 'above'],
        'rating' => ['current' => $analytics['avg_rating'], 'average' => 4.3, 'difference' => 'above'],
        'completion_rate' => ['current' => $analytics['completion_rate'], 'average' => 62, 'difference' => 'above']
    ];
}

private function generateRecommendations($courseId, $analytics, $course)
{
    $recommendations = [];

    // 基于完成率的建议
    if ($analytics['completion_rate'] < 70) {
        $recommendations[] = [
            'type' => 'content',
            'priority' => 'high',
            'title' => 'Improve Course Completion Rate',
            'description' => 'Your completion rate is below average. Consider adding more interactive elements and shorter lesson durations.',
            'action' => 'Review lesson structure'
        ];
    }

    // 基于评分的建议
    if ($analytics['avg_rating'] < 4.5) {
        $recommendations[] = [
            'type' => 'quality',
            'priority' => 'medium',
            'title' => 'Enhance Course Quality',
            'description' => 'Consider updating course content and gathering more detailed student feedback.',
            'action' => 'Update content'
        ];
    }

    // 基于参与度的建议
    if ($analytics['discussion_activity'] < 3) {
        $recommendations[] = [
            'type' => 'engagement',
            'priority' => 'medium',
            'title' => 'Increase Student Engagement',
            'description' => 'Add discussion prompts and Q&A sessions to boost student interaction.',
            'action' => 'Add interactive elements'
        ];
    }

    // 基于营销的建议
    if ($analytics['page_views'] > 1000 && $analytics['preview_to_enrollment_rate'] < 15) {
        $recommendations[] = [
            'type' => 'marketing',
            'priority' => 'high',
            'title' => 'Improve Conversion Rate',
            'description' => 'High traffic but low conversions. Consider improving your course preview and description.',
            'action' => 'Optimize course page'
        ];
    }

    return $recommendations;
}


    /**
     * Delete course
     */
    public function destroy($id)
    {
        // TODO: 暂时注释，等UI完成后实现
        return;
        
        // $course = $this->findCourseOrFail($id);
        //
        // try {
        //     $course->delete();
        //     $this->redirect('/instructor/courses', [
        //         'success' => 'Course deleted successfully.'
        //     ]);
        // } catch (Exception $e) {
        //     $this->redirectBack(['error' => 'Failed to delete course. Please try again.']);
        // }
    }

    /**
     * Bulk actions for courses
     */
    public function bulkAction()
    {
        // TODO: 暂时注释，等UI完成后实现
        return;
        
        // $action = $_POST['action'] ?? '';
        // $courseIds = $_POST['course_ids'] ?? [];
        //
        // if (empty($courseIds) || !is_array($courseIds)) {
        //     $this->redirectBack(['error' => 'No courses selected.']);
        //     return;
        // }
        //
        // $instructorId = $_SESSION['user_id'];
        // $courses = Course::whereIn('id', $courseIds)
        //                 ->byInstructor($instructorId)
        //                 ->get();
        //
        // try {
        //     switch ($action) {
        //         case 'publish':
        //             foreach ($courses as $course) {
        //                 $course->update([
        //                     'status' => Course::STATUS_PUBLISHED,
        //                     'published_at' => date('Y-m-d H:i:s')
        //                 ]);
        //             }
        //             $message = 'Courses published successfully.';
        //             break;
        //
        //         case 'unpublish':
        //             foreach ($courses as $course) {
        //                 $course->update(['status' => Course::STATUS_DRAFT]);
        //             }
        //             $message = 'Courses unpublished successfully.';
        //             break;
        //
        //         default:
        //             $this->redirectBack(['error' => 'Invalid action.']);
        //             return;
        //     }
        //
        //     $this->redirectBack(['success' => $message]);
        // } catch (Exception $e) {
        //     $this->redirectBack(['error' => 'Bulk action failed. Please try again.']);
        // }
    }

    /**
     * Find course or fail with 404
     */
    private function findCourseOrFail($id)
    {
        // TODO: 暂时注释，等UI完成后实现
        return;
        
        // $instructorId = $_SESSION['user_id'];
        // $course = Course::where('id', $id)
        //                ->byInstructor($instructorId)
        //                ->first();
        //
        // if (!$course) {
        //     $this->notFound();
        // }
        //
        // return $course;
    }

    /**
     * Get course statistics for instructor
     */
    private function getCourseStats($instructorId)
    {
        // TODO: 暂时注释，等UI完成后实现
        return;
        
        // $courses = Course::byInstructor($instructorId);
        //
        // return [
        //     'total' => $courses->count(),
        //     'published' => $courses->published()->count(),
        //     'draft' => $courses->draft()->count(),
        //     'pending' => $courses->pending()->count()
        // ];
    }

    /**
     * Get course analytics data
     */
    private function getCourseAnalytics($course)
    {
        // TODO: 暂时注释，等UI完成后实现
        return;
        
        // This would typically involve more complex queries
        // return [
        //     'students_count' => $course->student_count,
        //     'total_revenue' => $course->total_revenue,
        //     'average_rating' => $course->average_rating,
        //     'completion_rate' => 0, // Would calculate from user progress
        //     'monthly_enrollments' => [], // Would get from enrollments by month
        //     'rating_distribution' => [] // Would get from reviews
        // ];
    }

    /**
     * Validate course data
     */
    private function validateCourseData($data, $courseId = null)
    {
        // TODO: 暂时注释，等UI完成后实现
        return;
        
        // Basic validation - in real app would use proper validation library
        // $required = ['title', 'description', 'price', 'category_id'];
        // 
        // foreach ($required as $field) {
        //     if (empty($data[$field])) {
        //         return false;
        //     }
        // }
        //
        // Sanitize and return validated data
        // return [
        //     'title' => trim($data['title']),
        //     'description' => trim($data['description']),
        //     'short_description' => trim($data['short_description'] ?? ''),
        //     'price' => (float)$data['price'],
        //     'category_id' => (int)$data['category_id'],
        //     'subcategory_id' => !empty($data['subcategory_id']) ? (int)$data['subcategory_id'] : null,
        //     'difficulty_level' => $data['difficulty_level'] ?? Course::DIFFICULTY_BEGINNER,
        //     'language' => $data['language'] ?? 'English'
        // ];
    }

    /**
     * Generate unique slug for course
     */
    private function generateSlug($title)
    {
        // TODO: 暂时注释，等UI完成后实现
        return;
        
        // $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title)));
        // 
        // Check if slug exists and append number if needed
        // $originalSlug = $slug;
        // $counter = 1;
        // 
        // while (Course::where('slug', $slug)->exists()) {
        //     $slug = $originalSlug . '-' . $counter;
        //     $counter++;
        // }
        // 
        // return $slug;
    }
}