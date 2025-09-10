<?php

namespace App\Controllers\Course;

class AnalyticsController
{
    /**
     * Display analytics overview for instructor
     */
    public function analyticsOverview()
    {
        // Get filters from request
        $search = $_GET['search'] ?? '';
        $status = $_GET['status'] ?? '';
        $period = $_GET['period'] ?? '30';
        $sortBy = $_GET['sort'] ?? 'revenue_desc';
        $page = (int)($_GET['page'] ?? 1);
        $perPage = 10;

        // Get overall analytics data
        $analytics = $this->getOverallAnalytics();
        
        // Get top performing courses with filters
        $allCourses = $this->getAllCourses();
        $filteredCourses = $this->applyFilters($allCourses, $search, $status);
        $sortedCourses = $this->applySorting($filteredCourses, $sortBy);
        
        // Pagination
        $totalCourses = count($sortedCourses);
        $totalPages = ceil($totalCourses / $perPage);
        $offset = ($page - 1) * $perPage;
        $courses = array_slice($sortedCourses, $offset, $perPage);
        
        // Get top performing courses for sidebar
        $topCourses = $this->getTopPerformingCourses();
        
        // Get recent activity
        $recentActivity = $this->getRecentActivity();
        
        // Get revenue trend data for charts
        $revenueData = $this->getRevenueTrendData($period);
        
        // Get enrollment trend data for charts
        $enrollmentData = $this->getEnrollmentTrendData($period);
        
        // Page metadata
        $pageData = [
            'title' => 'Analytics Overview - TARUMT LMS',
            'pageTitle' => 'Analytics Overview',
            'pageSubtitle' => 'Track your teaching performance and revenue',
            'currentPage' => 'analytics',
            'breadcrumbs' => [
                ['title' => 'Analytics Overview']
            ]
        ];

        // Prepare data for view
        $data = [
            'analytics' => $analytics,
            'courses' => $courses,
            'topCourses' => $topCourses,
            'recentActivity' => $recentActivity,
            'revenueData' => $revenueData,
            'enrollmentData' => $enrollmentData,
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
                'period' => $period,
                'sort' => $sortBy
            ]
        ];

        // Include view file
        extract(array_merge($data, $pageData));
        include '../app/Views/course/instructor/analytics/overview.php';
    }

    /**
     * Display analytics for a specific course
     */
    public function analytics($courseId)
    {
        // Get course data
        $course = $this->getCourseById($courseId);
        
        if (!$course) {
            $_SESSION['error'] = 'Course not found';
            header('Location: /instructor/analytics');
            exit;
        }

        // Get course-specific analytics
        $courseAnalytics = $this->getCourseAnalytics($courseId);
        
        // Get student analytics for this course
        $studentAnalytics = $this->getStudentAnalytics($courseId);
        
        // Get revenue analytics for this course
        $revenueAnalytics = $this->getCourseRevenueAnalytics($courseId);
        
        // Get engagement analytics
        $engagementAnalytics = $this->getEngagementAnalytics($courseId);
        
        // Get completion analytics
        $completionAnalytics = $this->getCompletionAnalytics($courseId);
        
        // Page metadata
        $pageData = [
            'title' => $course['title'] . ' - Analytics - TARUMT LMS',
            'pageTitle' => $course['title'],
            'pageSubtitle' => 'Course performance and student analytics',
            'currentPage' => 'analytics',
            'breadcrumbs' => [
                ['title' => 'Analytics Overview', 'url' => '/instructor/analytics'],
                ['title' => $course['title']]
            ]
        ];

        // Prepare data for view
        $data = [
            'course' => $course,
            'courseAnalytics' => $courseAnalytics,
            'studentAnalytics' => $studentAnalytics,
            'revenueAnalytics' => $revenueAnalytics,
            'engagementAnalytics' => $engagementAnalytics,
            'completionAnalytics' => $completionAnalytics
        ];

        // Include view file
        extract(array_merge($data, $pageData));
        include '../app/Views/course/instructor/analytics/course-details.php';
    }

    // Private helper methods for overview analytics
    private function getOverallAnalytics()
    {
        // In a real application, this would fetch from database
        return [
            'total_revenue' => 24590,
            'monthly_revenue_growth' => 12.5,
            'total_students' => 140,
            'weekly_student_growth' => 18,
            'active_courses' => 5,
            'published_courses' => 3,
            'draft_courses' => 2,
            'avg_rating' => 4.7,
            'total_reviews' => 82
        ];
    }

    private function getTopPerformingCourses()
    {
        // In a real application, this would fetch from database
        return [
            [
                'id' => 3,
                'title' => 'Node.js Backend',
                'revenue' => 10063,
                'students' => 67,
                'rating' => 4.9,
                'growth' => 18.7
            ],
            [
                'id' => 1,
                'title' => 'Laravel Fundamentals',
                'revenue' => 8955,
                'students' => 45,
                'rating' => 4.8,
                'growth' => 8.2
            ],
            [
                'id' => 2,
                'title' => 'React Advanced',
                'revenue' => 5572,
                'students' => 28,
                'rating' => 4.5,
                'growth' => 12.5
            ]
        ];
    }

    private function getRecentActivity()
    {
        // In a real application, this would fetch from database
        return [
            [
                'type' => 'enrollment',
                'message' => 'New student enrolled in "Node.js Backend"',
                'time' => '1 hour ago',
                'color' => 'green'
            ],
            [
                'type' => 'update',
                'message' => 'Course "React Advanced" updated',
                'time' => '3 hours ago',
                'color' => 'blue'
            ],
            [
                'type' => 'review',
                'message' => 'New 5-star review received',
                'time' => '6 hours ago',
                'color' => 'yellow'
            ],
            [
                'type' => 'enrollment',
                'message' => '3 students completed "Laravel Fundamentals"',
                'time' => '1 day ago',
                'color' => 'green'
            ]
        ];
    }

    private function getRevenueTrendData($period = '30')
    {
        // In a real application, this would fetch from database based on period
        switch($period) {
            case '7':
                return [
                    'labels' => ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                    'data' => [1800, 2100, 1950, 2300, 2150, 1900, 2200]
                ];
            case '90':
                return [
                    'labels' => ['3 months ago', '2 months ago', '1 month ago'],
                    'data' => [65000, 72000, 24590]
                ];
            case '365':
                return [
                    'labels' => ['Q1', 'Q2', 'Q3', 'Q4'],
                    'data' => [68000, 75000, 82000, 24590]
                ];
            default: // 30 days
                return [
                    'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                    'data' => [12000, 18500, 22000, 19500, 24000, 24590]
                ];
        }
    }

    private function getEnrollmentTrendData($period = '30')
    {
        // In a real application, this would fetch from database based on period
        switch($period) {
            case '7':
                return [
                    'labels' => ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                    'data' => [8, 12, 6, 15, 9, 4, 11]
                ];
            case '90':
                return [
                    'labels' => ['Month 1', 'Month 2', 'Month 3'],
                    'data' => [120, 145, 187]
                ];
            default: // 30 days
                return [
                    'labels' => ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
                    'data' => [45, 62, 38, 42]
                ];
        }
    }

    private function getAllCourses()
    {
        // In a real application, this would fetch from database
        return [
            [
                'id' => 3,
                'title' => 'Node.js Backend',
                'status' => 'published',
                'revenue' => 10063,
                'students' => 67,
                'monthly_growth' => 22,
                'rating' => 4.9,
                'reviews' => 41,
                'growth' => 18.7,
                'updated_at' => '2024-03-05'
            ],
            [
                'id' => 1,
                'title' => 'Laravel Fundamentals',
                'status' => 'published',
                'revenue' => 8955,
                'students' => 45,
                'monthly_growth' => 12,
                'rating' => 4.8,
                'reviews' => 23,
                'growth' => 8.2,
                'updated_at' => '2024-03-15'
            ],
            [
                'id' => 2,
                'title' => 'React Advanced',
                'status' => 'published',
                'revenue' => 5572,
                'students' => 28,
                'monthly_growth' => 8,
                'rating' => 4.5,
                'reviews' => 18,
                'growth' => 12.5,
                'updated_at' => '2024-03-10'
            ],
            [
                'id' => 4,
                'title' => 'UI/UX Design Basics',
                'status' => 'draft',
                'revenue' => 0,
                'students' => 0,
                'monthly_growth' => 0,
                'rating' => 0,
                'reviews' => 0,
                'growth' => 0,
                'updated_at' => '2024-02-20'
            ],
            [
                'id' => 5,
                'title' => 'Mobile App Development',
                'status' => 'pending',
                'revenue' => 3200,
                'students' => 15,
                'monthly_growth' => 5,
                'rating' => 4.2,
                'reviews' => 8,
                'growth' => 5.3,
                'updated_at' => '2024-02-25'
            ]
        ];
    }

    private function applyFilters($courses, $search, $status)
    {
        $filtered = $courses;

        // Search filter
        if (!empty($search)) {
            $filtered = array_filter($filtered, function($course) use ($search) {
                return stripos($course['title'], $search) !== false;
            });
        }

        // Status filter
        if (!empty($status)) {
            $filtered = array_filter($filtered, function($course) use ($status) {
                return $course['status'] === $status;
            });
        }

        return array_values($filtered);
    }

    private function applySorting($courses, $sortBy)
    {
        switch ($sortBy) {
            case 'students_desc':
                usort($courses, fn($a, $b) => $b['students'] - $a['students']);
                break;
            case 'rating_desc':
                usort($courses, fn($a, $b) => $b['rating'] <=> $a['rating']);
                break;
            case 'created_desc':
                usort($courses, fn($a, $b) => strtotime($b['updated_at']) - strtotime($a['updated_at']));
                break;
            case 'title_asc':
                usort($courses, fn($a, $b) => strcmp($a['title'], $b['title']));
                break;
            default: // revenue_desc
                usort($courses, fn($a, $b) => $b['revenue'] - $a['revenue']);
                break;
        }

        return $courses;
    }

    // Private helper methods for course-specific analytics
    private function getCourseById($id)
    {
        // In a real application, this would fetch from database
        $courses = [
            1 => [
                'id' => 1,
                'title' => 'Laravel Fundamentals',
                'slug' => 'laravel-fundamentals',
                'description' => 'Master the Laravel framework from basics to advanced concepts',
                'thumbnail' => '/assets/images/courses/laravel.jpg',
                'price' => 199.00,
                'status' => 'published',
                'sections_count' => 12,
                'lectures_count' => 48,
                'total_duration' => 1440, // minutes
                'created_at' => '2024-01-10',
                'updated_at' => '2024-03-15'
            ],
            2 => [
                'id' => 2,
                'title' => 'React Advanced',
                'slug' => 'react-advanced',
                'description' => 'Advanced React patterns and best practices',
                'thumbnail' => '/assets/images/courses/react.jpg',
                'price' => 249.00,
                'status' => 'published',
                'sections_count' => 8,
                'lectures_count' => 32,
                'total_duration' => 960,
                'created_at' => '2024-01-15',
                'updated_at' => '2024-03-10'
            ],
            3 => [
                'id' => 3,
                'title' => 'Node.js Backend',
                'slug' => 'nodejs-backend',
                'description' => 'Build scalable backend applications with Node.js',
                'thumbnail' => '/assets/images/courses/nodejs.jpg',
                'price' => 299.00,
                'status' => 'published',
                'sections_count' => 15,
                'lectures_count' => 62,
                'total_duration' => 1800,
                'created_at' => '2024-02-01',
                'updated_at' => '2024-03-05'
            ]
        ];

        return $courses[$id] ?? null;
    }

    private function getCourseAnalytics($courseId)
    {
        // In a real application, this would fetch from database based on courseId
        $analytics = [
            1 => [
                'total_students' => 45,
                'active_students' => 38,
                'completion_rate' => 78.5,
                'avg_progress' => 65.2,
                'total_revenue' => 8955,
                'monthly_revenue' => 2150,
                'avg_rating' => 4.8,
                'total_reviews' => 23,
                'watch_time_hours' => 1240
            ],
            2 => [
                'total_students' => 28,
                'active_students' => 24,
                'completion_rate' => 85.2,
                'avg_progress' => 72.8,
                'total_revenue' => 5572,
                'monthly_revenue' => 1820,
                'avg_rating' => 4.5,
                'total_reviews' => 18,
                'watch_time_hours' => 890
            ],
            3 => [
                'total_students' => 67,
                'active_students' => 58,
                'completion_rate' => 71.3,
                'avg_progress' => 58.9,
                'total_revenue' => 10063,
                'monthly_revenue' => 3200,
                'avg_rating' => 4.9,
                'total_reviews' => 41,
                'watch_time_hours' => 2180
            ]
        ];

        return $analytics[$courseId] ?? [];
    }

    private function getStudentAnalytics($courseId)
    {
        // In a real application, this would fetch from database
        return [
            'enrollment_trend' => [
                'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                'data' => [5, 8, 12, 7, 9, 15]
            ],
            'demographics' => [
                'age_groups' => [
                    '18-25' => 35,
                    '26-35' => 45,
                    '36-45' => 15,
                    '46+' => 5
                ],
                'countries' => [
                    'Malaysia' => 60,
                    'Singapore' => 20,
                    'Thailand' => 15,
                    'Others' => 5
                ]
            ]
        ];
    }

    private function getCourseRevenueAnalytics($courseId)
    {
        // In a real application, this would fetch from database
        return [
            'monthly_trend' => [
                'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                'data' => [1200, 2100, 1800, 2400, 2150, 2100]
            ],
            'payment_methods' => [
                'Credit Card' => 65,
                'PayPal' => 25,
                'Bank Transfer' => 10
            ]
        ];
    }

    private function getEngagementAnalytics($courseId)
    {
        // In a real application, this would fetch from database
        return [
            'watch_time_trend' => [
                'labels' => ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
                'data' => [120, 150, 98, 180]
            ],
            'section_completion' => [
                [
                    'section_title' => 'Getting Started',
                    'completion_rate' => 95.2
                ],
                [
                    'section_title' => 'Laravel Basics',
                    'completion_rate' => 87.5
                ],
                [
                    'section_title' => 'Database Management',
                    'completion_rate' => 78.9
                ],
                [
                    'section_title' => 'Advanced Features',
                    'completion_rate' => 65.3
                ]
            ]
        ];
    }

    private function getCompletionAnalytics($courseId)
    {
        // In a real application, this would fetch from database
        return [
            'completion_funnel' => [
                'Started Course' => 100,
                'Completed 25%' => 85,
                'Completed 50%' => 72,
                'Completed 75%' => 65,
                'Completed Course' => 58
            ],
            'average_time_to_complete' => 45, // days
            'drop_off_points' => [
                [
                    'lecture_title' => 'Advanced Eloquent Relationships',
                    'drop_off_rate' => 15.2
                ],
                [
                    'lecture_title' => 'API Authentication',
                    'drop_off_rate' => 12.8
                ],
                [
                    'lecture_title' => 'Testing Strategies',
                    'drop_off_rate' => 11.5
                ]
            ]
        ];
    }
}