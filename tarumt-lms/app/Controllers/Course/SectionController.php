<?php

namespace App\Controllers\Course;

class SectionController
{
    /**
     * Display sections listing for instructor
     */
    public function index()
    {
        // Get filters from request
        $search = $_GET['search'] ?? '';
        $status = $_GET['status'] ?? '';
        $course_id = $_GET['course_id'] ?? '';
        $sortBy = $_GET['sort'] ?? 'created_desc';
        $page = (int)($_GET['page'] ?? 1);
        $perPage = 10;

        // Dummy sections data
        $allSections = [
            [
                'id' => 1,
                'title' => 'Getting Started',
                'slug' => 'getting-started',
                'description' => 'Introduction to the course and basic setup',
                'course_id' => 1,
                'course_title' => 'Laravel Fundamentals',
                'order' => 1,
                'status' => 'active',
                'lecture_count' => 5,
                'total_duration' => 120, // minutes
                'is_preview' => true,
                'created_at' => '2024-01-10',
                'updated_at' => '2024-03-15'
            ],
            [
                'id' => 2,
                'title' => 'Laravel Basics',
                'slug' => 'laravel-basics',
                'description' => 'Core concepts and fundamentals of Laravel framework',
                'course_id' => 1,
                'course_title' => 'Laravel Fundamentals',
                'order' => 2,
                'status' => 'active',
                'lecture_count' => 8,
                'total_duration' => 240,
                'is_preview' => false,
                'created_at' => '2024-01-12',
                'updated_at' => '2024-03-12'
            ],
            [
                'id' => 3,
                'title' => 'Database Management',
                'slug' => 'database-management',
                'description' => 'Working with databases, migrations, and Eloquent ORM',
                'course_id' => 1,
                'course_title' => 'Laravel Fundamentals',
                'order' => 3,
                'status' => 'active',
                'lecture_count' => 12,
                'total_duration' => 360,
                'is_preview' => false,
                'created_at' => '2024-01-15',
                'updated_at' => '2024-03-10'
            ],
            [
                'id' => 4,
                'title' => 'Advanced Features',
                'slug' => 'advanced-features',
                'description' => 'Advanced Laravel concepts and best practices',
                'course_id' => 1,
                'course_title' => 'Laravel Fundamentals',
                'order' => 4,
                'status' => 'draft',
                'lecture_count' => 6,
                'total_duration' => 180,
                'is_preview' => false,
                'created_at' => '2024-01-20',
                'updated_at' => '2024-02-20'
            ],
            [
                'id' => 5,
                'title' => 'React Components',
                'slug' => 'react-components',
                'description' => 'Building reusable React components',
                'course_id' => 2,
                'course_title' => 'React Development',
                'order' => 1,
                'status' => 'active',
                'lecture_count' => 7,
                'total_duration' => 210,
                'is_preview' => true,
                'created_at' => '2024-02-01',
                'updated_at' => '2024-03-08'
            ],
            [
                'id' => 6,
                'title' => 'State Management',
                'slug' => 'state-management',
                'description' => 'Managing application state with hooks and context',
                'course_id' => 2,
                'course_title' => 'React Development',
                'order' => 2,
                'status' => 'active',
                'lecture_count' => 9,
                'total_duration' => 270,
                'is_preview' => false,
                'created_at' => '2024-02-05',
                'updated_at' => '2024-03-05'
            ],
            [
                'id' => 7,
                'title' => 'API Integration',
                'slug' => 'api-integration',
                'description' => 'Connecting React apps with external APIs',
                'course_id' => 2,
                'course_title' => 'React Development',
                'order' => 3,
                'status' => 'draft',
                'lecture_count' => 4,
                'total_duration' => 120,
                'is_preview' => false,
                'created_at' => '2024-02-10',
                'updated_at' => '2024-02-15'
            ],
            [
                'id' => 8,
                'title' => 'Python Fundamentals',
                'slug' => 'python-fundamentals',
                'description' => 'Basic Python syntax and programming concepts',
                'course_id' => 3,
                'course_title' => 'Data Science with Python',
                'order' => 1,
                'status' => 'active',
                'lecture_count' => 10,
                'total_duration' => 300,
                'is_preview' => true,
                'created_at' => '2024-01-25',
                'updated_at' => '2024-03-01'
            ]
        ];

        // Apply filters
        $filteredSections = $allSections;

        // Search filter
        if (!empty($search)) {
            $filteredSections = array_filter($filteredSections, function($section) use ($search) {
                return stripos($section['title'], $search) !== false || 
                       stripos($section['description'], $search) !== false ||
                       stripos($section['course_title'], $search) !== false;
            });
        }

        // Status filter
        if (!empty($status)) {
            $filteredSections = array_filter($filteredSections, function($section) use ($status) {
                return $section['status'] === $status;
            });
        }

        // Course filter
        if (!empty($course_id)) {
            $filteredSections = array_filter($filteredSections, function($section) use ($course_id) {
                return $section['course_id'] == $course_id;
            });
        }

        // Sort sections
        switch ($sortBy) {
            case 'created_asc':
                usort($filteredSections, fn($a, $b) => strtotime($a['created_at']) - strtotime($b['created_at']));
                break;
            case 'title_asc':
                usort($filteredSections, fn($a, $b) => strcmp($a['title'], $b['title']));
                break;
            case 'title_desc':
                usort($filteredSections, fn($a, $b) => strcmp($b['title'], $a['title']));
                break;
            case 'order_asc':
                usort($filteredSections, fn($a, $b) => $a['order'] - $b['order']);
                break;
            case 'lectures_desc':
                usort($filteredSections, fn($a, $b) => $b['lecture_count'] - $a['lecture_count']);
                break;
            default: // created_desc
                usort($filteredSections, fn($a, $b) => strtotime($b['created_at']) - strtotime($a['created_at']));
                break;
        }

        // Pagination
        $totalSections = count($filteredSections);
        $totalPages = ceil($totalSections / $perPage);
        $offset = ($page - 1) * $perPage;
        $sections = array_slice($filteredSections, $offset, $perPage);

        // Statistics
        $stats = [
            'total' => count($allSections),
            'active' => count(array_filter($allSections, fn($s) => $s['status'] === 'active')),
            'draft' => count(array_filter($allSections, fn($s) => $s['status'] === 'draft')),
            'total_lectures' => array_sum(array_column($allSections, 'lecture_count')),
            'total_duration' => array_sum(array_column($allSections, 'total_duration'))
        ];

        // Get available courses for filter dropdown
        $courses = $this->getCoursesForFilter();

        // Status options
        $statusOptions = [
            'active' => 'Active',
            'draft' => 'Draft',
            'archived' => 'Archived'
        ];

        // Sort options
        $sortOptions = [
            'created_desc' => 'Newest First',
            'created_asc' => 'Oldest First',
            'title_asc' => 'Title A-Z',
            'title_desc' => 'Title Z-A',
            'order_asc' => 'Section Order',
            'lectures_desc' => 'Most Lectures'
        ];

        // Prepare data for view
        $data = [
            'sections' => $sections,
            'pagination' => [
                'current_page' => $page,
                'total_pages' => $totalPages,
                'total_items' => $totalSections,
                'start_item' => $totalSections > 0 ? $offset + 1 : 0,
                'end_item' => min($offset + $perPage, $totalSections),
                'per_page' => $perPage
            ],
            'filters' => [
                'search' => $search,
                'status' => $status,
                'course_id' => $course_id,
                'sort' => $sortBy
            ],
            'stats' => $stats,
            'courses' => $courses,
            'statusOptions' => $statusOptions,
            'sortOptions' => $sortOptions
        ];

        // Page metadata
        $pageData = [
            'title' => 'Course Sections - TARUMT LMS',
            'pageTitle' => 'Course Sections',
            'pageSubtitle' => 'Organize your course content into structured sections',
            'currentPage' => 'sections',
            'breadcrumbs' => [
                ['title' => 'Course Sections']
            ]
        ];
        
        // Include view file
        extract(array_merge($data, $pageData));
        include '../app/Views/course/instructor/sections/index.php';
    }

    public function create() {
        // Get available courses
        $courses = $this->getAvailableCourses();

        // Status options
        $statusOptions = [
            'active' => 'Active',
            'draft' => 'Draft'
        ];

        // Page metadata
        $pageData = [
            'title' => 'Create Section - TARUMT LMS',
            'pageTitle' => 'Create Section',
            'pageSubtitle' => 'Add a new section to organize your course content',
            'currentPage' => 'sections',
            'breadcrumbs' => [
                ['title' => 'Course Sections', 'url' => '/instructor/sections'],
                ['title' => 'Create Section']
            ]
        ];

        $data = [
            'courses' => $courses,
            'statusOptions' => $statusOptions
        ];

        // Include view file
        extract(array_merge($data, $pageData));
        include '../app/Views/course/instructor/sections/create.php';
    }

    public function store() {
        // Validate form data
        $title = trim($_POST['title'] ?? '');
        $slug = trim($_POST['slug'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $course_id = (int)($_POST['course_id'] ?? 0);
        $order = (int)($_POST['order'] ?? 1);
        $status = $_POST['status'] ?? 'active';
        $is_preview = isset($_POST['is_preview']) ? 1 : 0;
        $action = $_POST['action'] ?? 'publish';

        // Basic validation
        $errors = [];
        
        if (empty($title)) {
            $errors[] = 'Section title is required';
        }
        
        if (empty($slug)) {
            $errors[] = 'URL slug is required';
        }
        
        if (empty($description)) {
            $errors[] = 'Description is required';
        }
        
        if (empty($course_id)) {
            $errors[] = 'Course selection is required';
        }

        if ($order < 1) {
            $errors[] = 'Section order must be at least 1';
        }

        // Check if slug already exists
        if ($this->slugExists($slug, $course_id)) {
            $errors[] = 'URL slug already exists in this course. Please choose a different one.';
        }

        // Validate course exists
        if (!$this->courseExists($course_id)) {
            $errors[] = 'Selected course does not exist';
        }

        // If there are validation errors, redirect back with errors
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old_input'] = $_POST;
            header('Location: /instructor/sections/create');
            exit;
        }

        // Set final status based on action
        if ($action === 'draft') {
            $status = 'draft';
        }

        // TODO: Save to database
        // For now, simulate success
        $sectionId = rand(100, 999);

        // Clear any old input data
        unset($_SESSION['old_input'], $_SESSION['errors']);

        // Success message
        if ($action === 'draft') {
            $_SESSION['success'] = "Section '{$title}' has been saved as draft.";
        } else {
            $_SESSION['success'] = "Section '{$title}' has been created successfully!";
        }

        header('Location: /instructor/sections');
        exit;
    }

    public function edit($id) {
        // Get section data
        $section = $this->getSectionById($id);
        
        if (!$section) {
            $_SESSION['error'] = 'Section not found';
            header('Location: /instructor/sections');
            exit;
        }

        // Get available courses
        $courses = $this->getAvailableCourses();

        // Status options
        $statusOptions = [
            'active' => 'Active',
            'draft' => 'Draft',
            'archived' => 'Archived'
        ];

        // Page metadata
        $pageData = [
            'title' => 'Edit Section - TARUMT LMS',
            'pageTitle' => 'Edit Section',
            'pageSubtitle' => 'Update section information and settings',
            'currentPage' => 'sections',
            'breadcrumbs' => [
                ['title' => 'Course Sections', 'url' => '/instructor/sections'],
                ['title' => 'Edit: ' . $section['title']]
            ]
        ];

        // Include view
        extract(array_merge([
            'section' => $section,
            'courses' => $courses,
            'statusOptions' => $statusOptions
        ], $pageData));
        include '../app/Views/course/instructor/sections/edit.php';
    }

    public function update($id) {
        // Get existing section data
        $existingSection = $this->getSectionById($id);
        
        if (!$existingSection) {
            $_SESSION['error'] = 'Section not found';
            header('Location: /instructor/sections');
            exit;
        }

        // Validate form data
        $title = trim($_POST['title'] ?? '');
        $slug = trim($_POST['slug'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $course_id = (int)($_POST['course_id'] ?? 0);
        $order = (int)($_POST['order'] ?? 1);
        $status = $_POST['status'] ?? 'active';
        $is_preview = isset($_POST['is_preview']) ? 1 : 0;
        $action = $_POST['action'] ?? 'update';

        // Basic validation
        $errors = [];
        
        if (empty($title)) {
            $errors[] = 'Section title is required';
        }
        
        if (empty($slug)) {
            $errors[] = 'URL slug is required';
        }
        
        if (empty($description)) {
            $errors[] = 'Description is required';
        }
        
        if (empty($course_id)) {
            $errors[] = 'Course selection is required';
        }

        if ($order < 1) {
            $errors[] = 'Section order must be at least 1';
        }

        // Check if slug already exists (excluding current section)
        if ($this->slugExists($slug, $course_id, $id)) {
            $errors[] = 'URL slug already exists in this course. Please choose a different one.';
        }

        // Validate course exists
        if (!$this->courseExists($course_id)) {
            $errors[] = 'Selected course does not exist';
        }

        // If there are validation errors, redirect back with errors
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old_input'] = $_POST;
            header('Location: /instructor/sections/' . $id . '/edit');
            exit;
        }

        // Set final status based on action
        if ($action === 'draft') {
            $status = 'draft';
        }

        // TODO: Update in database
        // For now, simulate success

        // Clear any old input data
        unset($_SESSION['old_input'], $_SESSION['errors']);

        // Success message
        if ($action === 'draft') {
            $_SESSION['success'] = "Section '{$title}' has been saved as draft.";
        } else {
            $_SESSION['success'] = "Section '{$title}' has been updated successfully!";
        }

        header('Location: /instructor/sections');
        exit;
    }

    public function show($id) {
        // Get section data
        $section = $this->getSectionById($id);
        
        if (!$section) {
            $_SESSION['error'] = 'Section not found';
            header('Location: /instructor/sections');
            exit;
        }

        // Get lectures in this section
        $lectures = $this->getLecturesBySection($id);

        // Section statistics
        $stats = [
            'total_lectures' => count($lectures),
            'total_duration' => array_sum(array_column($lectures, 'duration')),
            'completed_lectures' => count(array_filter($lectures, fn($l) => $l['status'] === 'published')),
            'avg_duration' => $lectures ? round(array_sum(array_column($lectures, 'duration')) / count($lectures), 1) : 0
        ];

        // Page metadata
        $pageData = [
            'title' => $section['title'] . ' - Section Details - TARUMT LMS',
            'pageTitle' => $section['title'],
            'pageSubtitle' => 'Section overview and lecture management',
            'currentPage' => 'sections',
            'breadcrumbs' => [
                ['title' => 'Course Sections', 'url' => '/instructor/sections'],
                ['title' => $section['title']]
            ]
        ];

        // Include view
        extract(array_merge([
            'section' => $section,
            'lectures' => $lectures,
            'stats' => $stats
        ], $pageData));
        include '../app/Views/course/instructor/sections/show.php';
    }

    public function destroy($id) {
        $section = $this->getSectionById($id);
        
        if (!$section) {
            $_SESSION['error'] = 'Section not found';
            header('Location: /instructor/sections');
            exit;
        }

        // Check if section has lectures
        $lectures = $this->getLecturesBySection($id);
        if (!empty($lectures)) {
            $_SESSION['error'] = 'Cannot delete section that contains lectures. Please move or delete all lectures first.';
            header('Location: /instructor/sections/' . $id);
            exit;
        }

        // TODO: Actual database deletion would go here
        $sectionTitle = $section['title'];
        
        $_SESSION['success'] = "Section '{$sectionTitle}' has been successfully deleted.";
        header('Location: /instructor/sections');
        exit;
    }

    // Private helper methods
    private function getCoursesForFilter() {
        return [
            ['id' => '', 'title' => 'All Courses'],
            ['id' => 1, 'title' => 'Laravel Fundamentals'],
            ['id' => 2, 'title' => 'React Development'],
            ['id' => 3, 'title' => 'Data Science with Python'],
            ['id' => 4, 'title' => 'UI/UX Design Basics'],
            ['id' => 5, 'title' => 'Mobile App Development']
        ];
    }

    private function getAvailableCourses() {
        return [
            ['id' => 1, 'title' => 'Laravel Fundamentals', 'status' => 'active'],
            ['id' => 2, 'title' => 'React Development', 'status' => 'active'],
            ['id' => 3, 'title' => 'Data Science with Python', 'status' => 'active'],
            ['id' => 4, 'title' => 'UI/UX Design Basics', 'status' => 'draft'],
            ['id' => 5, 'title' => 'Mobile App Development', 'status' => 'active']
        ];
    }

    private function getSectionById($id) {
        // Dummy section data
        $sections = [
            1 => [
                'id' => 1,
                'title' => 'Getting Started',
                'slug' => 'getting-started',
                'description' => 'Introduction to the course and basic setup. This section covers the fundamental concepts and prerequisites.',
                'course_id' => 1,
                'course_title' => 'Laravel Fundamentals',
                'order' => 1,
                'status' => 'active',
                'lecture_count' => 5,
                'total_duration' => 120,
                'is_preview' => true,
                'created_at' => '2024-01-10',
                'updated_at' => '2024-03-15'
            ],
            2 => [
                'id' => 2,
                'title' => 'Laravel Basics',
                'slug' => 'laravel-basics',
                'description' => 'Core concepts and fundamentals of Laravel framework including routing, controllers, and views.',
                'course_id' => 1,
                'course_title' => 'Laravel Fundamentals',
                'order' => 2,
                'status' => 'active',
                'lecture_count' => 8,
                'total_duration' => 240,
                'is_preview' => false,
                'created_at' => '2024-01-12',
                'updated_at' => '2024-03-12'
            ]
        ];

        return $sections[$id] ?? null;
    }

    private function getLecturesBySection($sectionId) {
        // Dummy lectures data for this section
        return [
            [
                'id' => 1,
                'title' => 'Course Introduction',
                'duration' => 15,
                'status' => 'published',
                'order' => 1,
                'is_preview' => true
            ],
            [
                'id' => 2,
                'title' => 'Development Environment Setup',
                'duration' => 25,
                'status' => 'published',
                'order' => 2,
                'is_preview' => false
            ],
            [
                'id' => 3,
                'title' => 'Laravel Installation',
                'duration' => 30,
                'status' => 'published',
                'order' => 3,
                'is_preview' => false
            ]
        ];
    }

    private function slugExists($slug, $courseId, $excludeId = null) {
        // TODO: Check database for existing slug within the same course
        // For now, simulate check with dummy data
        $existingSlugs = ['getting-started', 'laravel-basics', 'database-management'];
        return in_array($slug, $existingSlugs);
    }

    private function courseExists($courseId) {
        // TODO: Check if course exists in database
        // For now, simulate with dummy data
        $validCourseIds = [1, 2, 3, 4, 5];
        return in_array($courseId, $validCourseIds);
    }
}