<?php

namespace App\Controllers\Course;

class LectureController
{
    /**
     * Display lectures listing for instructor
     */
    public function index()
    {
        // Get filters from request
        $search = $_GET['search'] ?? '';
        $status = $_GET['status'] ?? '';
        $section_id = $_GET['section_id'] ?? '';
        $course_id = $_GET['course_id'] ?? '';
        $sortBy = $_GET['sort'] ?? 'created_desc';
        $page = (int)($_GET['page'] ?? 1);
        $perPage = 10;

        // Dummy lectures data
        $allLectures = [
            [
                'id' => 1,
                'title' => 'Course Introduction',
                'slug' => 'course-introduction',
                'description' => 'Welcome to the course! Learn what we will cover and how to get started.',
                'section_id' => 1,
                'section_title' => 'Getting Started',
                'course_id' => 1,
                'course_title' => 'Laravel Fundamentals',
                'order' => 1,
                'duration' => 15,
                'video_url' => 'https://example.com/video1.mp4',
                'status' => 'published',
                'is_preview' => true,
                'view_count' => 245,
                'completion_rate' => 85.5,
                'created_at' => '2024-01-10',
                'updated_at' => '2024-03-15'
            ],
            [
                'id' => 2,
                'title' => 'Development Environment Setup',
                'slug' => 'development-environment-setup',
                'description' => 'Set up your local development environment for Laravel development.',
                'section_id' => 1,
                'section_title' => 'Getting Started',
                'course_id' => 1,
                'course_title' => 'Laravel Fundamentals',
                'order' => 2,
                'duration' => 25,
                'video_url' => 'https://example.com/video2.mp4',
                'status' => 'published',
                'is_preview' => false,
                'view_count' => 198,
                'completion_rate' => 78.2,
                'created_at' => '2024-01-12',
                'updated_at' => '2024-03-12'
            ],
            [
                'id' => 3,
                'title' => 'Laravel Installation',
                'slug' => 'laravel-installation',
                'description' => 'Learn how to install Laravel using Composer and create your first project.',
                'section_id' => 1,
                'section_title' => 'Getting Started',
                'course_id' => 1,
                'course_title' => 'Laravel Fundamentals',
                'order' => 3,
                'duration' => 30,
                'video_url' => 'https://example.com/video3.mp4',
                'status' => 'published',
                'is_preview' => false,
                'view_count' => 167,
                'completion_rate' => 82.1,
                'created_at' => '2024-01-15',
                'updated_at' => '2024-03-10'
            ],
            [
                'id' => 4,
                'title' => 'Understanding MVC Architecture',
                'slug' => 'understanding-mvc-architecture',
                'description' => 'Deep dive into the Model-View-Controller pattern in Laravel.',
                'section_id' => 2,
                'section_title' => 'Laravel Basics',
                'course_id' => 1,
                'course_title' => 'Laravel Fundamentals',
                'order' => 1,
                'duration' => 45,
                'video_url' => 'https://example.com/video4.mp4',
                'status' => 'published',
                'is_preview' => false,
                'view_count' => 134,
                'completion_rate' => 76.8,
                'created_at' => '2024-01-18',
                'updated_at' => '2024-03-08'
            ],
            [
                'id' => 5,
                'title' => 'Creating Your First Route',
                'slug' => 'creating-your-first-route',
                'description' => 'Learn how to create and manage routes in Laravel applications.',
                'section_id' => 2,
                'section_title' => 'Laravel Basics',
                'course_id' => 1,
                'course_title' => 'Laravel Fundamentals',
                'order' => 2,
                'duration' => 35,
                'video_url' => 'https://example.com/video5.mp4',
                'status' => 'draft',
                'is_preview' => false,
                'view_count' => 0,
                'completion_rate' => 0,
                'created_at' => '2024-01-20',
                'updated_at' => '2024-02-20'
            ],
            [
                'id' => 6,
                'title' => 'React Components Basics',
                'slug' => 'react-components-basics',
                'description' => 'Introduction to creating and using React components.',
                'section_id' => 5,
                'section_title' => 'React Components',
                'course_id' => 2,
                'course_title' => 'React Development',
                'order' => 1,
                'duration' => 40,
                'video_url' => 'https://example.com/video6.mp4',
                'status' => 'published',
                'is_preview' => true,
                'view_count' => 89,
                'completion_rate' => 91.2,
                'created_at' => '2024-02-01',
                'updated_at' => '2024-03-05'
            ],
            [
                'id' => 7,
                'title' => 'State Management with Hooks',
                'slug' => 'state-management-with-hooks',
                'description' => 'Learn how to manage component state using React hooks.',
                'section_id' => 6,
                'section_title' => 'State Management',
                'course_id' => 2,
                'course_title' => 'React Development',
                'order' => 1,
                'duration' => 50,
                'video_url' => 'https://example.com/video7.mp4',
                'status' => 'published',
                'is_preview' => false,
                'view_count' => 72,
                'completion_rate' => 88.5,
                'created_at' => '2024-02-05',
                'updated_at' => '2024-03-02'
            ],
            [
                'id' => 8,
                'title' => 'Python Variables and Data Types',
                'slug' => 'python-variables-and-data-types',
                'description' => 'Understanding variables, data types, and basic operations in Python.',
                'section_id' => 8,
                'section_title' => 'Python Fundamentals',
                'course_id' => 3,
                'course_title' => 'Data Science with Python',
                'order' => 1,
                'duration' => 35,
                'video_url' => 'https://example.com/video8.mp4',
                'status' => 'published',
                'is_preview' => true,
                'view_count' => 156,
                'completion_rate' => 93.1,
                'created_at' => '2024-01-25',
                'updated_at' => '2024-03-01'
            ]
        ];

        // Apply filters
        $filteredLectures = $allLectures;

        // Search filter
        if (!empty($search)) {
            $filteredLectures = array_filter($filteredLectures, function($lecture) use ($search) {
                return stripos($lecture['title'], $search) !== false || 
                       stripos($lecture['description'], $search) !== false ||
                       stripos($lecture['section_title'], $search) !== false ||
                       stripos($lecture['course_title'], $search) !== false;
            });
        }

        // Status filter
        if (!empty($status)) {
            $filteredLectures = array_filter($filteredLectures, function($lecture) use ($status) {
                return $lecture['status'] === $status;
            });
        }

        // Section filter
        if (!empty($section_id)) {
            $filteredLectures = array_filter($filteredLectures, function($lecture) use ($section_id) {
                return $lecture['section_id'] == $section_id;
            });
        }

        // Course filter
        if (!empty($course_id)) {
            $filteredLectures = array_filter($filteredLectures, function($lecture) use ($course_id) {
                return $lecture['course_id'] == $course_id;
            });
        }

        // Sort lectures
        switch ($sortBy) {
            case 'created_asc':
                usort($filteredLectures, fn($a, $b) => strtotime($a['created_at']) - strtotime($b['created_at']));
                break;
            case 'title_asc':
                usort($filteredLectures, fn($a, $b) => strcmp($a['title'], $b['title']));
                break;
            case 'title_desc':
                usort($filteredLectures, fn($a, $b) => strcmp($b['title'], $a['title']));
                break;
            case 'duration_desc':
                usort($filteredLectures, fn($a, $b) => $b['duration'] - $a['duration']);
                break;
            case 'views_desc':
                usort($filteredLectures, fn($a, $b) => $b['view_count'] - $a['view_count']);
                break;
            case 'completion_desc':
                usort($filteredLectures, fn($a, $b) => $b['completion_rate'] - $a['completion_rate']);
                break;
            default: // created_desc
                usort($filteredLectures, fn($a, $b) => strtotime($b['created_at']) - strtotime($a['created_at']));
                break;
        }

        // Pagination
        $totalLectures = count($filteredLectures);
        $totalPages = ceil($totalLectures / $perPage);
        $offset = ($page - 1) * $perPage;
        $lectures = array_slice($filteredLectures, $offset, $perPage);

        // Statistics
        $stats = [
            'total' => count($allLectures),
            'published' => count(array_filter($allLectures, fn($l) => $l['status'] === 'published')),
            'draft' => count(array_filter($allLectures, fn($l) => $l['status'] === 'draft')),
            'total_duration' => array_sum(array_column($allLectures, 'duration')),
            'total_views' => array_sum(array_column($allLectures, 'view_count')),
            'avg_completion' => $allLectures ? round(array_sum(array_column($allLectures, 'completion_rate')) / count($allLectures), 1) : 0
        ];

        // Get filter options
        $courses = $this->getCoursesForFilter();
        $sections = $this->getSectionsForFilter();

        // Status options
        $statusOptions = [
            'published' => 'Published',
            'draft' => 'Draft',
            'archived' => 'Archived'
        ];

        // Sort options
        $sortOptions = [
            'created_desc' => 'Newest First',
            'created_asc' => 'Oldest First',
            'title_asc' => 'Title A-Z',
            'title_desc' => 'Title Z-A',
            'duration_desc' => 'Longest First',
            'views_desc' => 'Most Views',
            'completion_desc' => 'Best Completion Rate'
        ];

        // Prepare data for view
        $data = [
            'lectures' => $lectures,
            'pagination' => [
                'current_page' => $page,
                'total_pages' => $totalPages,
                'total_items' => $totalLectures,
                'start_item' => $totalLectures > 0 ? $offset + 1 : 0,
                'end_item' => min($offset + $perPage, $totalLectures),
                'per_page' => $perPage
            ],
            'filters' => [
                'search' => $search,
                'status' => $status,
                'section_id' => $section_id,
                'course_id' => $course_id,
                'sort' => $sortBy
            ],
            'stats' => $stats,
            'courses' => $courses,
            'sections' => $sections,
            'statusOptions' => $statusOptions,
            'sortOptions' => $sortOptions
        ];

        // Page metadata
        $pageData = [
            'title' => 'Lectures - TARUMT LMS',
            'pageTitle' => 'Lectures',
            'pageSubtitle' => 'Manage and organize your course lectures',
            'currentPage' => 'lectures',
            'breadcrumbs' => [
                ['title' => 'Lectures']
            ]
        ];
        
        // Include view file
        extract(array_merge($data, $pageData));
        include '../app/Views/course/instructor/lectures/index.php';
    }

    public function indexForSection($sectionId)
    {
        // Get section info
        $section = $this->getSectionById($sectionId);
        
        if (!$section) {
            $_SESSION['error'] = 'Section not found';
            header('Location: /instructor/sections');
            exit;
        }

        // Get lectures for this section
        $allLectures = $this->getAllLectures();
        $lectures = array_filter($allLectures, fn($l) => $l['section_id'] == $sectionId);
        
        // Sort by order
        usort($lectures, fn($a, $b) => $a['order'] - $b['order']);

        // Page metadata
        $pageData = [
            'title' => 'Lectures - ' . $section['title'] . ' - TARUMT LMS',
            'pageTitle' => 'Lectures in ' . $section['title'],
            'pageSubtitle' => 'Manage lectures for this section',
            'currentPage' => 'sections',
            'breadcrumbs' => [
                ['title' => 'Sections', 'url' => '/instructor/sections'],
                ['title' => $section['title'], 'url' => '/instructor/sections/' . $sectionId],
                ['title' => 'Lectures']
            ]
        ];

        // Include view
        extract(array_merge([
            'section' => $section,
            'lectures' => $lectures
        ], $pageData));
        include '../app/Views/course/instructor/sections/lectures.php';
    }

    public function create()
    {
        // Get available sections and courses
        $sections = $this->getAvailableSections();
        $courses = $this->getAvailableCourses();

        // Status options
        $statusOptions = [
            'published' => 'Published',
            'draft' => 'Draft'
        ];

        // Page metadata
        $pageData = [
            'title' => 'Create Lecture - TARUMT LMS',
            'pageTitle' => 'Create Lecture',
            'pageSubtitle' => 'Add a new lecture to your course content',
            'currentPage' => 'lectures',
            'breadcrumbs' => [
                ['title' => 'Lectures', 'url' => '/instructor/lectures'],
                ['title' => 'Create Lecture']
            ]
        ];

        $data = [
            'sections' => $sections,
            'courses' => $courses,
            'statusOptions' => $statusOptions
        ];

        // Include view file
        extract(array_merge($data, $pageData));
        include '../app/Views/course/instructor/lectures/create.php';
    }

    public function createForSection($sectionId)
    {
        // Get section info
        $section = $this->getSectionById($sectionId);
        
        if (!$section) {
            $_SESSION['error'] = 'Section not found';
            header('Location: /instructor/sections');
            exit;
        }

        // Pre-fill section data
        $_SESSION['pre_fill'] = [
            'section_id' => $sectionId,
            'course_id' => $section['course_id']
        ];

        // Redirect to regular create with pre-filled data
        header('Location: /instructor/lectures/create');
        exit;
    }

    public function store()
    {
        // Validate form data
        $title = trim($_POST['title'] ?? '');
        $slug = trim($_POST['slug'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $section_id = (int)($_POST['section_id'] ?? 0);
        $order = (int)($_POST['order'] ?? 1);
        $duration = (int)($_POST['duration'] ?? 0);
        $video_url = trim($_POST['video_url'] ?? '');
        $status = $_POST['status'] ?? 'published';
        $is_preview = isset($_POST['is_preview']) ? 1 : 0;
        $action = $_POST['action'] ?? 'publish';

        // Basic validation
        $errors = [];
        
        if (empty($title)) {
            $errors[] = 'Lecture title is required';
        }
        
        if (empty($slug)) {
            $errors[] = 'URL slug is required';
        }
        
        if (empty($description)) {
            $errors[] = 'Description is required';
        }
        
        if (empty($section_id)) {
            $errors[] = 'Section selection is required';
        }

        if ($order < 1) {
            $errors[] = 'Lecture order must be at least 1';
        }

        if ($duration < 1) {
            $errors[] = 'Duration must be at least 1 minute';
        }

        if (empty($video_url)) {
            $errors[] = 'Video URL is required';
        }

        // Check if slug already exists
        if ($this->slugExists($slug, $section_id)) {
            $errors[] = 'URL slug already exists in this section. Please choose a different one.';
        }

        // Validate section exists
        if (!$this->sectionExists($section_id)) {
            $errors[] = 'Selected section does not exist';
        }

        // If there are validation errors, redirect back with errors
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old_input'] = $_POST;
            header('Location: /instructor/lectures/create');
            exit;
        }

        // Set final status based on action
        if ($action === 'draft') {
            $status = 'draft';
        }

        // TODO: Save to database
        // For now, simulate success
        $lectureId = rand(100, 999);

        // Clear any old input data
        unset($_SESSION['old_input'], $_SESSION['errors'], $_SESSION['pre_fill']);

        // Success message
        if ($action === 'draft') {
            $_SESSION['success'] = "Lecture '{$title}' has been saved as draft.";
        } else {
            $_SESSION['success'] = "Lecture '{$title}' has been created successfully!";
        }

        header('Location: /instructor/lectures');
        exit;
    }

    public function edit($id)
    {
        // Get lecture data
        $lecture = $this->getLectureById($id);
        
        if (!$lecture) {
            $_SESSION['error'] = 'Lecture not found';
            header('Location: /instructor/lectures');
            exit;
        }

        // Get available sections and courses
        $sections = $this->getAvailableSections();
        $courses = $this->getAvailableCourses();

        // Status options
        $statusOptions = [
            'published' => 'Published',
            'draft' => 'Draft',
            'archived' => 'Archived'
        ];

        // Page metadata
        $pageData = [
            'title' => 'Edit Lecture - TARUMT LMS',
            'pageTitle' => 'Edit Lecture',
            'pageSubtitle' => 'Update lecture information and settings',
            'currentPage' => 'lectures',
            'breadcrumbs' => [
                ['title' => 'Lectures', 'url' => '/instructor/lectures'],
                ['title' => 'Edit: ' . $lecture['title']]
            ]
        ];

        // Include view
        extract(array_merge([
            'lecture' => $lecture,
            'sections' => $sections,
            'courses' => $courses,
            'statusOptions' => $statusOptions
        ], $pageData));
        include '../app/Views/course/instructor/lectures/edit.php';
    }

    public function update($id)
    {
        // Get existing lecture data
        $existingLecture = $this->getLectureById($id);
        
        if (!$existingLecture) {
            $_SESSION['error'] = 'Lecture not found';
            header('Location: /instructor/lectures');
            exit;
        }

        // Validate form data (same as store method)
        $title = trim($_POST['title'] ?? '');
        $slug = trim($_POST['slug'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $section_id = (int)($_POST['section_id'] ?? 0);
        $order = (int)($_POST['order'] ?? 1);
        $duration = (int)($_POST['duration'] ?? 0);
        $video_url = trim($_POST['video_url'] ?? '');
        $status = $_POST['status'] ?? 'published';
        $is_preview = isset($_POST['is_preview']) ? 1 : 0;
        $action = $_POST['action'] ?? 'update';

        // Basic validation (same as store)
        $errors = [];
        
        if (empty($title)) {
            $errors[] = 'Lecture title is required';
        }
        
        if (empty($slug)) {
            $errors[] = 'URL slug is required';
        }
        
        if (empty($description)) {
            $errors[] = 'Description is required';
        }
        
        if (empty($section_id)) {
            $errors[] = 'Section selection is required';
        }

        if ($order < 1) {
            $errors[] = 'Lecture order must be at least 1';
        }

        if ($duration < 1) {
            $errors[] = 'Duration must be at least 1 minute';
        }

        if (empty($video_url)) {
            $errors[] = 'Video URL is required';
        }

        // Check if slug already exists (excluding current lecture)
        if ($this->slugExists($slug, $section_id, $id)) {
            $errors[] = 'URL slug already exists in this section. Please choose a different one.';
        }

        // Validate section exists
        if (!$this->sectionExists($section_id)) {
            $errors[] = 'Selected section does not exist';
        }

        // If there are validation errors, redirect back with errors
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old_input'] = $_POST;
            header('Location: /instructor/lectures/' . $id . '/edit');
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
            $_SESSION['success'] = "Lecture '{$title}' has been saved as draft.";
        } else {
            $_SESSION['success'] = "Lecture '{$title}' has been updated successfully!";
        }

        header('Location: /instructor/lectures');
        exit;
    }

    public function destroy($id)
    {
        $lecture = $this->getLectureById($id);
        
        if (!$lecture) {
            $_SESSION['error'] = 'Lecture not found';
            header('Location: /instructor/lectures');
            exit;
        }

        // TODO: Actual database deletion would go here
        $lectureTitle = $lecture['title'];
        
        $_SESSION['success'] = "Lecture '{$lectureTitle}' has been successfully deleted.";
        header('Location: /instructor/lectures');
        exit;
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

    private function getSectionsForFilter()
    {
        return [
            ['id' => '', 'title' => 'All Sections'],
            ['id' => 1, 'title' => 'Getting Started'],
            ['id' => 2, 'title' => 'Laravel Basics'],
            ['id' => 3, 'title' => 'Database Management'],
            ['id' => 5, 'title' => 'React Components'],
            ['id' => 6, 'title' => 'State Management'],
            ['id' => 8, 'title' => 'Python Fundamentals']
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

    private function getAvailableSections()
    {
        return [
            ['id' => 1, 'title' => 'Getting Started', 'course_id' => 1, 'course_title' => 'Laravel Fundamentals'],
            ['id' => 2, 'title' => 'Laravel Basics', 'course_id' => 1, 'course_title' => 'Laravel Fundamentals'],
            ['id' => 3, 'title' => 'Database Management', 'course_id' => 1, 'course_title' => 'Laravel Fundamentals'],
            ['id' => 5, 'title' => 'React Components', 'course_id' => 2, 'course_title' => 'React Development'],
            ['id' => 6, 'title' => 'State Management', 'course_id' => 2, 'course_title' => 'React Development'],
            ['id' => 8, 'title' => 'Python Fundamentals', 'course_id' => 3, 'course_title' => 'Data Science with Python']
        ];
    }

    private function getAllLectures()
    {
        // Return the same dummy data as in index method
        return [
            [
                'id' => 1,
                'title' => 'Course Introduction',
                'slug' => 'course-introduction',
                'description' => 'Welcome to the course! Learn what we will cover and how to get started.',
                'section_id' => 1,
                'section_title' => 'Getting Started',
                'course_id' => 1,
                'course_title' => 'Laravel Fundamentals',
                'order' => 1,
                'duration' => 15,
                'video_url' => 'https://example.com/video1.mp4',
                'status' => 'published',
                'is_preview' => true,
                'view_count' => 245,
                'completion_rate' => 85.5,
                'created_at' => '2024-01-10',
                'updated_at' => '2024-03-15'
            ],
            [
                'id' => 2,
                'title' => 'Development Environment Setup',
                'slug' => 'development-environment-setup',
                'description' => 'Set up your local development environment for Laravel development.',
                'section_id' => 1,
                'section_title' => 'Getting Started',
                'course_id' => 1,
                'course_title' => 'Laravel Fundamentals',
                'order' => 2,
                'duration' => 25,
                'video_url' => 'https://example.com/video2.mp4',
                'status' => 'published',
                'is_preview' => false,
                'view_count' => 198,
                'completion_rate' => 78.2,
                'created_at' => '2024-01-12',
                'updated_at' => '2024-03-12'
            ],
            [
                'id' => 3,
                'title' => 'Laravel Installation',
                'slug' => 'laravel-installation',
                'description' => 'Learn how to install Laravel using Composer and create your first project.',
                'section_id' => 1,
                'section_title' => 'Getting Started',
                'course_id' => 1,
                'course_title' => 'Laravel Fundamentals',
                'order' => 3,
                'duration' => 30,
                'video_url' => 'https://example.com/video3.mp4',
                'status' => 'published',
                'is_preview' => false,
                'view_count' => 167,
                'completion_rate' => 82.1,
                'created_at' => '2024-01-15',
                'updated_at' => '2024-03-10'
            ]
            // ... additional lecture data
        ];
    }

    private function getSectionById($id)
    {
        $sections = [
            1 => [
                'id' => 1,
                'title' => 'Getting Started',
                'course_id' => 1,
                'course_title' => 'Laravel Fundamentals'
            ],
            2 => [
                'id' => 2,
                'title' => 'Laravel Basics',
                'course_id' => 1,
                'course_title' => 'Laravel Fundamentals'
            ]
        ];

        return $sections[$id] ?? null;
    }

    private function getLectureById($id)
    {
        $lectures = [
            1 => [
                'id' => 1,
                'title' => 'Course Introduction',
                'slug' => 'course-introduction',
                'description' => 'Welcome to the course! Learn what we will cover and how to get started.',
                'section_id' => 1,
                'section_title' => 'Getting Started',
                'course_id' => 1,
                'course_title' => 'Laravel Fundamentals',
                'order' => 1,
                'duration' => 15,
                'video_url' => 'https://example.com/video1.mp4',
                'status' => 'published',
                'is_preview' => true,
                'view_count' => 245,
                'completion_rate' => 85.5,
                'created_at' => '2024-01-10',
                'updated_at' => '2024-03-15'
            ],
            2 => [
                'id' => 2,
                'title' => 'Development Environment Setup',
                'slug' => 'development-environment-setup',
                'description' => 'Set up your local development environment for Laravel development.',
                'section_id' => 1,
                'section_title' => 'Getting Started',
                'course_id' => 1,
                'course_title' => 'Laravel Fundamentals',
                'order' => 2,
                'duration' => 25,
                'video_url' => 'https://example.com/video2.mp4',
                'status' => 'published',
                'is_preview' => false,
                'view_count' => 198,
                'completion_rate' => 78.2,
                'created_at' => '2024-01-12',
                'updated_at' => '2024-03-12'
            ]
        ];

        return $lectures[$id] ?? null;
    }

    public function show($id)
    {
        // Get lecture data
        $lecture = $this->getLectureById($id);
        
        if (!$lecture) {
            $_SESSION['error'] = 'Lecture not found';
            header('Location: /instructor/lectures');
            exit;
        }

        // Page metadata
        $pageData = [
            'title' => $lecture['title'] . ' - TARUMT LMS',
            'pageTitle' => 'Lecture Details',
            'pageSubtitle' => 'View and manage lecture information',
            'currentPage' => 'lectures',
            'breadcrumbs' => [
                ['title' => 'Lectures', 'url' => '/instructor/lectures'],
                ['title' => $lecture['title']]
            ]
        ];

        // Include view
        extract(array_merge(['lecture' => $lecture], $pageData));
        include '../app/Views/course/instructor/lectures/show.php';
    }

    /**
 * Show duplicate lecture form
 */
public function duplicate($id)
{
    // Get original lecture data
    $originalLecture = $this->getLectureById($id);
    
    if (!$originalLecture) {
        $_SESSION['error'] = 'Lecture not found';
        header('Location: /instructor/lectures');
        exit;
    }

    // Get available sections and courses
    $sections = $this->getAvailableSections();
    $courses = $this->getAvailableCourses();

    // Status options
    $statusOptions = [
        'published' => 'Published',
        'draft' => 'Draft'
    ];

    // Prepare duplicate data (modify title and slug)
    $duplicateData = $originalLecture;
    $duplicateData['title'] = 'Copy of ' . $originalLecture['title'];
    $duplicateData['slug'] = $originalLecture['slug'] . '-copy';
    $duplicateData['status'] = 'draft'; // Default to draft for safety
    $duplicateData['is_preview'] = false; // Reset preview status
    
    // Get next order number in the same section
    $duplicateData['order'] = $this->getNextOrderInSection($originalLecture['section_id']);

    // Page metadata
    $pageData = [
        'title' => 'Duplicate Lecture - TARUMT LMS',
        'pageTitle' => 'Duplicate Lecture',
        'pageSubtitle' => 'Create a copy of "' . $originalLecture['title'] . '"',
        'currentPage' => 'lectures',
        'breadcrumbs' => [
            ['title' => 'Lectures', 'url' => '/instructor/lectures'],
            ['title' => $originalLecture['title'], 'url' => '/instructor/lectures/' . $id],
            ['title' => 'Duplicate']
        ]
    ];

    $data = [
        'originalLecture' => $originalLecture,
        'lecture' => $duplicateData, // Use duplicateData as lecture for form
        'sections' => $sections,
        'courses' => $courses,
        'statusOptions' => $statusOptions,
        'isDuplicate' => true
    ];

    // Include duplicate view file
    extract(array_merge($data, $pageData));
    include '../app/Views/course/instructor/lectures/duplicate.php';
}

    /**
     * Store duplicated lecture
     */
    public function storeDuplicate($originalId)
    {
        // Get original lecture for reference
        $originalLecture = $this->getLectureById($originalId);
        
        if (!$originalLecture) {
            $_SESSION['error'] = 'Original lecture not found';
            header('Location: /instructor/lectures');
            exit;
        }

        // Validate form data (same validation as store)
        $title = trim($_POST['title'] ?? '');
        $slug = trim($_POST['slug'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $section_id = (int)($_POST['section_id'] ?? 0);
        $order = (int)($_POST['order'] ?? 1);
        $duration = (int)($_POST['duration'] ?? 0);
        $video_url = trim($_POST['video_url'] ?? '');
        $status = $_POST['status'] ?? 'draft';
        $is_preview = isset($_POST['is_preview']) ? 1 : 0;
        $action = $_POST['action'] ?? 'duplicate';

        // Basic validation
        $errors = [];
        
        if (empty($title)) {
            $errors[] = 'Lecture title is required';
        }
        
        if (empty($slug)) {
            $errors[] = 'URL slug is required';
        }
        
        if (empty($description)) {
            $errors[] = 'Description is required';
        }
        
        if (empty($section_id)) {
            $errors[] = 'Section selection is required';
        }

        if ($order < 1) {
            $errors[] = 'Lecture order must be at least 1';
        }

        if ($duration < 1) {
            $errors[] = 'Duration must be at least 1 minute';
        }

        if (empty($video_url)) {
            $errors[] = 'Video URL is required';
        }

        // Check if slug already exists
        if ($this->slugExists($slug, $section_id)) {
            $errors[] = 'URL slug already exists in this section. Please choose a different one.';
        }

        // Validate section exists
        if (!$this->sectionExists($section_id)) {
            $errors[] = 'Selected section does not exist';
        }

        // If there are validation errors, redirect back with errors
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old_input'] = $_POST;
            header('Location: /instructor/lectures/' . $originalId . '/duplicate');
            exit;
        }

        // Set final status based on action
        if ($action === 'draft') {
            $status = 'draft';
        }

        // TODO: Save duplicated lecture to database
        // For now, simulate success
        $newLectureId = rand(100, 999);

        // Clear any old input data
        unset($_SESSION['old_input'], $_SESSION['errors']);

        // Success message
        if ($action === 'draft') {
            $_SESSION['success'] = "Lecture '{$title}' has been duplicated and saved as draft.";
        } else {
            $_SESSION['success'] = "Lecture '{$title}' has been duplicated successfully from '{$originalLecture['title']}'!";
        }

        header('Location: /instructor/lectures');
        exit;
    }

    /**
     * Get next order number for a section
     */
    private function getNextOrderInSection($sectionId)
    {
        $allLectures = $this->getAllLectures();
        $sectionLectures = array_filter($allLectures, fn($l) => $l['section_id'] == $sectionId);
        
        if (empty($sectionLectures)) {
            return 1;
        }
        
        $maxOrder = max(array_column($sectionLectures, 'order'));
        return $maxOrder + 1;
    }

    private function slugExists($slug, $sectionId, $excludeId = null)
    {
        // TODO: Check database for existing slug within the same section
        // For now, simulate check with dummy data
        $existingSlugs = ['course-introduction', 'development-environment-setup', 'laravel-installation'];
        return in_array($slug, $existingSlugs);
    }

    private function sectionExists($sectionId)
    {
        // TODO: Check if section exists in database
        // For now, simulate with dummy data
        $validSectionIds = [1, 2, 3, 5, 6, 8];
        return in_array($sectionId, $validSectionIds);
    }
}