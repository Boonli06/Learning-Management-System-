<?php

namespace App\Controllers\Course;

class GoalController
{
    /**
     * Display goals listing for instructor
     */
    public function index()
    {
        // Get filters from request
        $search = $_GET['search'] ?? '';
        $course_id = $_GET['course_id'] ?? '';
        $sortBy = $_GET['sort'] ?? 'created_desc';
        $page = (int)($_GET['page'] ?? 1);
        $perPage = 15;

        // Dummy goals data
        $allGoals = [
            [
                'id' => 1,
                'goal' => 'Master the fundamentals of Laravel framework architecture',
                'course_id' => 1,
                'course_title' => 'Laravel Fundamentals',
                'order' => 1,
                'created_at' => '2024-01-10',
                'updated_at' => '2024-03-15'
            ],
            [
                'id' => 2,
                'goal' => 'Build and deploy a complete web application using Laravel',
                'course_id' => 1,
                'course_title' => 'Laravel Fundamentals',
                'order' => 2,
                'created_at' => '2024-01-10',
                'updated_at' => '2024-03-10'
            ],
            [
                'id' => 3,
                'goal' => 'Understand database relationships and Eloquent ORM',
                'course_id' => 1,
                'course_title' => 'Laravel Fundamentals',
                'order' => 3,
                'created_at' => '2024-01-10',
                'updated_at' => '2024-03-08'
            ],
            [
                'id' => 4,
                'goal' => 'Create dynamic and interactive user interfaces with React',
                'course_id' => 2,
                'course_title' => 'React Development',
                'order' => 1,
                'created_at' => '2024-02-01',
                'updated_at' => '2024-03-05'
            ],
            [
                'id' => 5,
                'goal' => 'Implement state management using hooks and context',
                'course_id' => 2,
                'course_title' => 'React Development',
                'order' => 2,
                'created_at' => '2024-02-01',
                'updated_at' => '2024-03-02'
            ],
            [
                'id' => 6,
                'goal' => 'Handle data analysis and visualization with Python libraries',
                'course_id' => 3,
                'course_title' => 'Data Science with Python',
                'order' => 1,
                'created_at' => '2024-01-25',
                'updated_at' => '2024-03-01'
            ],
            [
                'id' => 7,
                'goal' => 'Apply machine learning algorithms to real-world datasets',
                'course_id' => 3,
                'course_title' => 'Data Science with Python',
                'order' => 2,
                'created_at' => '2024-01-25',
                'updated_at' => '2024-02-28'
            ],
            [
                'id' => 8,
                'goal' => 'Design user-centered interfaces following UX principles',
                'course_id' => 4,
                'course_title' => 'UI/UX Design Basics',
                'order' => 1,
                'created_at' => '2024-02-10',
                'updated_at' => '2024-02-25'
            ]
        ];

        // Apply filters
        $filteredGoals = $allGoals;

        // Search filter
        if (!empty($search)) {
            $filteredGoals = array_filter($filteredGoals, function($goal) use ($search) {
                return stripos($goal['goal'], $search) !== false || 
                       stripos($goal['course_title'], $search) !== false;
            });
        }

        // Course filter
        if (!empty($course_id)) {
            $filteredGoals = array_filter($filteredGoals, function($goal) use ($course_id) {
                return $goal['course_id'] == $course_id;
            });
        }

        // Sort goals
        switch ($sortBy) {
            case 'created_asc':
                usort($filteredGoals, fn($a, $b) => strtotime($a['created_at']) - strtotime($b['created_at']));
                break;
            case 'goal_asc':
                usort($filteredGoals, fn($a, $b) => strcmp($a['goal'], $b['goal']));
                break;
            case 'goal_desc':
                usort($filteredGoals, fn($a, $b) => strcmp($b['goal'], $a['goal']));
                break;
            case 'course_asc':
                usort($filteredGoals, fn($a, $b) => strcmp($a['course_title'], $b['course_title']));
                break;
            case 'order_asc':
                usort($filteredGoals, function($a, $b) {
                    if ($a['course_id'] === $b['course_id']) {
                        return $a['order'] - $b['order'];
                    }
                    return strcmp($a['course_title'], $b['course_title']);
                });
                break;
            default: // created_desc
                usort($filteredGoals, fn($a, $b) => strtotime($b['created_at']) - strtotime($a['created_at']));
                break;
        }

        // Pagination
        $totalGoals = count($filteredGoals);
        $totalPages = ceil($totalGoals / $perPage);
        $offset = ($page - 1) * $perPage;
        $goals = array_slice($filteredGoals, $offset, $perPage);

        // Statistics
        $stats = [
            'total' => count($allGoals),
            'by_course' => []
        ];

        // Group goals by course
        foreach ($allGoals as $goal) {
            $courseTitle = $goal['course_title'];
            if (!isset($stats['by_course'][$courseTitle])) {
                $stats['by_course'][$courseTitle] = 0;
            }
            $stats['by_course'][$courseTitle]++;
        }

        // Get filter options
        $courses = $this->getCoursesForFilter();

        // Sort options
        $sortOptions = [
            'created_desc' => 'Newest First',
            'created_asc' => 'Oldest First',
            'goal_asc' => 'Goal A-Z',
            'goal_desc' => 'Goal Z-A',
            'course_asc' => 'Course A-Z',
            'order_asc' => 'Order within Course'
        ];

        // Prepare data for view
        $data = [
            'goals' => $goals,
            'pagination' => [
                'current_page' => $page,
                'total_pages' => $totalPages,
                'total_items' => $totalGoals,
                'start_item' => $totalGoals > 0 ? $offset + 1 : 0,
                'end_item' => min($offset + $perPage, $totalGoals),
                'per_page' => $perPage
            ],
            'filters' => [
                'search' => $search,
                'course_id' => $course_id,
                'sort' => $sortBy
            ],
            'stats' => $stats,
            'courses' => $courses,
            'sortOptions' => $sortOptions
        ];

        // Page metadata
        $pageData = [
            'title' => 'Learning Goals - TARUMT LMS',
            'pageTitle' => 'Learning Goals',
            'pageSubtitle' => 'Manage course learning objectives and outcomes',
            'currentPage' => 'goals',
            'breadcrumbs' => [
                ['title' => 'Learning Goals']
            ]
        ];
        
        // Include view file
        extract(array_merge($data, $pageData));
        include '../app/Views/course/instructor/goals/index.php';
    }

    public function indexForCourse($courseId)
    {
        // Get course info
        $course = $this->getCourseById($courseId);
        
        if (!$course) {
            $_SESSION['error'] = 'Course not found';
            header('Location: /instructor/courses');
            exit;
        }

        // Get goals for this course
        $allGoals = $this->getAllGoals();
        $goals = array_filter($allGoals, fn($g) => $g['course_id'] == $courseId);
        
        // Sort by order
        usort($goals, fn($a, $b) => $a['order'] - $b['order']);

        // Page metadata
        $pageData = [
            'title' => 'Learning Goals - ' . $course['title'] . ' - TARUMT LMS',
            'pageTitle' => 'Learning Goals for ' . $course['title'],
            'pageSubtitle' => 'Manage learning objectives for this course',
            'currentPage' => 'courses',
            'breadcrumbs' => [
                ['title' => 'Courses', 'url' => '/instructor/courses'],
                ['title' => $course['title'], 'url' => '/instructor/courses/' . $courseId],
                ['title' => 'Learning Goals']
            ]
        ];

        // Include view
        extract(array_merge([
            'course' => $course,
            'goals' => $goals
        ], $pageData));
        include '../app/Views/course/instructor/courses/goals.php';
    }

    public function create()
    {
        // Get available courses
        $courses = $this->getAvailableCourses();

        // Page metadata
        $pageData = [
            'title' => 'Create Learning Goal - TARUMT LMS',
            'pageTitle' => 'Create Learning Goal',
            'pageSubtitle' => 'Define a new learning objective for your course',
            'currentPage' => 'goals',
            'breadcrumbs' => [
                ['title' => 'Learning Goals', 'url' => '/instructor/goals'],
                ['title' => 'Create Goal']
            ]
        ];

        $data = [
            'courses' => $courses
        ];

        // Include view file
        extract(array_merge($data, $pageData));
        include '../app/Views/course/instructor/goals/create.php';
    }

    public function createForCourse($courseId)
    {
        // Get course info
        $course = $this->getCourseById($courseId);
        
        if (!$course) {
            $_SESSION['error'] = 'Course not found';
            header('Location: /instructor/courses');
            exit;
        }

        // Pre-fill course data
        $_SESSION['pre_fill'] = [
            'course_id' => $courseId
        ];

        // Redirect to regular create with pre-filled data
        header('Location: /instructor/goals/create');
        exit;
    }

    public function store()
    {
        // Validate form data
        $goal = trim($_POST['goal'] ?? '');
        $course_id = (int)($_POST['course_id'] ?? 0);
        $order = (int)($_POST['order'] ?? 1);

        // Basic validation
        $errors = [];
        
        if (empty($goal)) {
            $errors[] = 'Learning goal description is required';
        }
        
        if (strlen($goal) < 10) {
            $errors[] = 'Learning goal must be at least 10 characters long';
        }
        
        if (strlen($goal) > 500) {
            $errors[] = 'Learning goal must not exceed 500 characters';
        }
        
        if (empty($course_id)) {
            $errors[] = 'Course selection is required';
        }

        if ($order < 1) {
            $errors[] = 'Goal order must be at least 1';
        }

        // Validate course exists
        if (!$this->courseExists($course_id)) {
            $errors[] = 'Selected course does not exist';
        }

        // If there are validation errors, redirect back with errors
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old_input'] = $_POST;
            header('Location: /instructor/goals/create');
            exit;
        }

        // TODO: Save to database
        // For now, simulate success
        $goalId = rand(100, 999);

        // Clear any old input data
        unset($_SESSION['old_input'], $_SESSION['errors'], $_SESSION['pre_fill']);

        // Success message
        $_SESSION['success'] = "Learning goal has been created successfully!";

        header('Location: /instructor/goals');
        exit;
    }

    public function edit($id)
    {
        // Get goal data
        $goal = $this->getGoalById($id);
        
        if (!$goal) {
            $_SESSION['error'] = 'Learning goal not found';
            header('Location: /instructor/goals');
            exit;
        }

        // Get available courses
        $courses = $this->getAvailableCourses();

        // Page metadata
        $pageData = [
            'title' => 'Edit Learning Goal - TARUMT LMS',
            'pageTitle' => 'Edit Learning Goal',
            'pageSubtitle' => 'Update learning objective information',
            'currentPage' => 'goals',
            'breadcrumbs' => [
                ['title' => 'Learning Goals', 'url' => '/instructor/goals'],
                ['title' => 'Edit Goal']
            ]
        ];

        // Include view
        extract(array_merge([
            'goal' => $goal,
            'courses' => $courses
        ], $pageData));
        include '../app/Views/course/instructor/goals/edit.php';
    }

    public function update($id)
    {
        // Get existing goal data
        $existingGoal = $this->getGoalById($id);
        
        if (!$existingGoal) {
            $_SESSION['error'] = 'Learning goal not found';
            header('Location: /instructor/goals');
            exit;
        }

        // Validate form data (same as store method)
        $goal = trim($_POST['goal'] ?? '');
        $course_id = (int)($_POST['course_id'] ?? 0);
        $order = (int)($_POST['order'] ?? 1);

        // Basic validation (same as store)
        $errors = [];
        
        if (empty($goal)) {
            $errors[] = 'Learning goal description is required';
        }
        
        if (strlen($goal) < 10) {
            $errors[] = 'Learning goal must be at least 10 characters long';
        }
        
        if (strlen($goal) > 500) {
            $errors[] = 'Learning goal must not exceed 500 characters';
        }
        
        if (empty($course_id)) {
            $errors[] = 'Course selection is required';
        }

        if ($order < 1) {
            $errors[] = 'Goal order must be at least 1';
        }

        // Validate course exists
        if (!$this->courseExists($course_id)) {
            $errors[] = 'Selected course does not exist';
        }

        // If there are validation errors, redirect back with errors
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old_input'] = $_POST;
            header('Location: /instructor/goals/' . $id . '/edit');
            exit;
        }

        // TODO: Update in database
        // For now, simulate success

        // Clear any old input data
        unset($_SESSION['old_input'], $_SESSION['errors']);

        // Success message
        $_SESSION['success'] = "Learning goal has been updated successfully!";

        header('Location: /instructor/goals');
        exit;
    }

    public function show($id)
    {
        // Get goal data
        $goal = $this->getGoalById($id);
        
        if (!$goal) {
            $_SESSION['error'] = 'Learning goal not found';
            header('Location: /instructor/goals');
            exit;
        }

        // Page metadata
        $pageData = [
            'title' => 'Learning Goal Details - TARUMT LMS',
            'pageTitle' => 'Learning Goal Details',
            'pageSubtitle' => 'View learning objective information',
            'currentPage' => 'goals',
            'breadcrumbs' => [
                ['title' => 'Learning Goals', 'url' => '/instructor/goals'],
                ['title' => 'Goal Details']
            ]
        ];

        // Include view
        extract(array_merge(['goal' => $goal], $pageData));
        include '../app/Views/course/instructor/goals/show.php';
    }

    public function destroy($id)
    {
        $goal = $this->getGoalById($id);
        
        if (!$goal) {
            $_SESSION['error'] = 'Learning goal not found';
            header('Location: /instructor/goals');
            exit;
        }

        // TODO: Actual database deletion would go here
        
        $_SESSION['success'] = "Learning goal has been successfully deleted.";
        header('Location: /instructor/goals');
        exit;
    }

    public function duplicate($id)
    {
        // Get original goal data
        $originalGoal = $this->getGoalById($id);
        
        if (!$originalGoal) {
            $_SESSION['error'] = 'Learning goal not found';
            header('Location: /instructor/goals');
            exit;
        }

        // Get available courses
        $courses = $this->getAvailableCourses();

        // Prepare duplicate data
        $duplicateData = $originalGoal;
        $duplicateData['goal'] = 'Copy of ' . $originalGoal['goal'];
        
        // Get next order number in the same course
        $duplicateData['order'] = $this->getNextOrderInCourse($originalGoal['course_id']);

        // Page metadata
        $pageData = [
            'title' => 'Duplicate Learning Goal - TARUMT LMS',
            'pageTitle' => 'Duplicate Learning Goal',
            'pageSubtitle' => 'Create a copy of this learning objective',
            'currentPage' => 'goals',
            'breadcrumbs' => [
                ['title' => 'Learning Goals', 'url' => '/instructor/goals'],
                ['title' => 'Duplicate Goal']
            ]
        ];

        $data = [
            'originalGoal' => $originalGoal,
            'goal' => $duplicateData,
            'courses' => $courses,
            'isDuplicate' => true
        ];

        // Include duplicate view file
        extract(array_merge($data, $pageData));
        include '../app/Views/course/instructor/goals/duplicate.php';
    }

    public function storeDuplicate($originalId)
    {
        // Get original goal for reference
        $originalGoal = $this->getGoalById($originalId);
        
        if (!$originalGoal) {
            $_SESSION['error'] = 'Original learning goal not found';
            header('Location: /instructor/goals');
            exit;
        }

        // Use same validation as store method
        $this->store();
    }

    // Private helper methods
    private function getCoursesForFilter()
    {
        return [
            ['id' => '', 'title' => 'All Courses'],
            ['id' => 1, 'title' => 'Laravel Fundamentals'],
            ['id' => 2, 'title' => 'React Development'],
            ['id' => 3, 'title' => 'Data Science with Python'],
            ['id' => 4, 'title' => 'UI/UX Design Basics'],
            ['id' => 5, 'title' => 'Mobile App Development']
        ];
    }

    private function getAvailableCourses()
    {
        return [
            ['id' => 1, 'title' => 'Laravel Fundamentals', 'status' => 'active'],
            ['id' => 2, 'title' => 'React Development', 'status' => 'active'],
            ['id' => 3, 'title' => 'Data Science with Python', 'status' => 'active'],
            ['id' => 4, 'title' => 'UI/UX Design Basics', 'status' => 'draft'],
            ['id' => 5, 'title' => 'Mobile App Development', 'status' => 'active']
        ];
    }

    private function getAllGoals()
    {
        // Same dummy data as in index method
        return [
            [
                'id' => 1,
                'goal' => 'Master the fundamentals of Laravel framework architecture',
                'course_id' => 1,
                'course_title' => 'Laravel Fundamentals',
                'order' => 1,
                'created_at' => '2024-01-10',
                'updated_at' => '2024-03-15'
            ],
            [
                'id' => 2,
                'goal' => 'Build and deploy a complete web application using Laravel',
                'course_id' => 1,
                'course_title' => 'Laravel Fundamentals',
                'order' => 2,
                'created_at' => '2024-01-10',
                'updated_at' => '2024-03-10'
            ]
            // ... additional goal data
        ];
    }

    private function getCourseById($id)
    {
        $courses = [
            1 => [
                'id' => 1,
                'title' => 'Laravel Fundamentals',
                'status' => 'active'
            ],
            2 => [
                'id' => 2,
                'title' => 'React Development',
                'status' => 'active'
            ]
        ];

        return $courses[$id] ?? null;
    }

    private function getGoalById($id)
    {
        $goals = [
            1 => [
                'id' => 1,
                'goal' => 'Master the fundamentals of Laravel framework architecture',
                'course_id' => 1,
                'course_title' => 'Laravel Fundamentals',
                'order' => 1,
                'created_at' => '2024-01-10',
                'updated_at' => '2024-03-15'
            ],
            2 => [
                'id' => 2,
                'goal' => 'Build and deploy a complete web application using Laravel',
                'course_id' => 1,
                'course_title' => 'Laravel Fundamentals',
                'order' => 2,
                'created_at' => '2024-01-10',
                'updated_at' => '2024-03-10'
            ]
        ];

        return $goals[$id] ?? null;
    }

    private function courseExists($courseId)
    {
        // TODO: Check if course exists in database
        // For now, simulate with dummy data
        $validCourseIds = [1, 2, 3, 4, 5];
        return in_array($courseId, $validCourseIds);
    }

    private function getNextOrderInCourse($courseId)
    {
        $allGoals = $this->getAllGoals();
        $courseGoals = array_filter($allGoals, fn($g) => $g['course_id'] == $courseId);
        
        if (empty($courseGoals)) {
            return 1;
        }
        
        $maxOrder = max(array_column($courseGoals, 'order'));
        return $maxOrder + 1;
    }
}