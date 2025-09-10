<?php

namespace App\Controllers\Course;

class CategoryController
{
    /**
     * Display categories listing for instructor
     */
    public function index()
    {
        // Get filters from request
        $search = $_GET['search'] ?? '';
        $status = $_GET['status'] ?? '';
        $sortBy = $_GET['sort'] ?? 'created_desc';
        $page = (int)($_GET['page'] ?? 1);
        $perPage = 10;

        // Dummy categories data with subcategories
        $allCategories = [
            [
                'id' => 1,
                'name' => 'Web Development',
                'slug' => 'web-development',
                'description' => 'Learn modern web development technologies and frameworks',
                'status' => 'active',
                'courses_count' => 15,
                'students_count' => 342,
                'created_at' => '2024-01-10',
                'updated_at' => '2024-03-15',
                'subcategories' => [
                    ['id' => 1, 'name' => 'Frontend Development', 'courses_count' => 8],
                    ['id' => 2, 'name' => 'Backend Development', 'courses_count' => 5],
                    ['id' => 3, 'name' => 'Full Stack Development', 'courses_count' => 2]
                ]
            ],
            [
                'id' => 2,
                'name' => 'Mobile Development',
                'slug' => 'mobile-development',
                'description' => 'Build mobile applications for iOS and Android platforms',
                'status' => 'active',
                'courses_count' => 8,
                'students_count' => 156,
                'created_at' => '2024-01-15',
                'updated_at' => '2024-03-10',
                'subcategories' => [
                    ['id' => 5, 'name' => 'iOS Development', 'courses_count' => 3],
                    ['id' => 6, 'name' => 'Android Development', 'courses_count' => 3],
                    ['id' => 7, 'name' => 'React Native', 'courses_count' => 1],
                    ['id' => 8, 'name' => 'Flutter', 'courses_count' => 1]
                ]
            ],
            [
                'id' => 3,
                'name' => 'Data Science',
                'slug' => 'data-science',
                'description' => 'Master data analysis, machine learning, and AI technologies',
                'status' => 'active',
                'courses_count' => 12,
                'students_count' => 234,
                'created_at' => '2024-01-20',
                'updated_at' => '2024-03-12',
                'subcategories' => [
                    ['id' => 9, 'name' => 'Machine Learning', 'courses_count' => 5],
                    ['id' => 10, 'name' => 'Data Analysis', 'courses_count' => 4],
                    ['id' => 11, 'name' => 'Data Visualization', 'courses_count' => 2],
                    ['id' => 12, 'name' => 'Big Data', 'courses_count' => 1]
                ]
            ],
            [
                'id' => 4,
                'name' => 'Design',
                'slug' => 'design',
                'description' => 'Learn UI/UX design, graphic design, and creative tools',
                'status' => 'active',
                'courses_count' => 6,
                'students_count' => 89,
                'created_at' => '2024-02-01',
                'updated_at' => '2024-03-08',
                'subcategories' => [
                    ['id' => 13, 'name' => 'UI/UX Design', 'courses_count' => 3],
                    ['id' => 14, 'name' => 'Graphic Design', 'courses_count' => 2],
                    ['id' => 15, 'name' => 'Web Design', 'courses_count' => 1]
                ]
            ],
            [
                'id' => 5,
                'name' => 'Business',
                'slug' => 'business',
                'description' => 'Develop business skills and entrepreneurship knowledge',
                'status' => 'active',
                'courses_count' => 4,
                'students_count' => 67,
                'created_at' => '2024-02-10',
                'updated_at' => '2024-03-05',
                'subcategories' => [
                    ['id' => 17, 'name' => 'Entrepreneurship', 'courses_count' => 2],
                    ['id' => 18, 'name' => 'Management', 'courses_count' => 1],
                    ['id' => 19, 'name' => 'Finance', 'courses_count' => 1]
                ]
            ],
            [
                'id' => 6,
                'name' => 'Marketing',
                'slug' => 'marketing',
                'description' => 'Master digital marketing and growth strategies',
                'status' => 'draft',
                'courses_count' => 2,
                'students_count' => 23,
                'created_at' => '2024-02-15',
                'updated_at' => '2024-02-20',
                'subcategories' => [
                    ['id' => 21, 'name' => 'Digital Marketing', 'courses_count' => 1],
                    ['id' => 22, 'name' => 'Content Marketing', 'courses_count' => 1]
                ]
            ]
        ];

        // Apply filters
        $filteredCategories = $allCategories;

        // Search filter
        if (!empty($search)) {
            $filteredCategories = array_filter($filteredCategories, function($category) use ($search) {
                return stripos($category['name'], $search) !== false || 
                       stripos($category['description'], $search) !== false;
            });
        }

        // Status filter
        if (!empty($status)) {
            $filteredCategories = array_filter($filteredCategories, function($category) use ($status) {
                return $category['status'] === $status;
            });
        }

        // Sort categories
        switch ($sortBy) {
            case 'created_asc':
                usort($filteredCategories, fn($a, $b) => strtotime($a['created_at']) - strtotime($b['created_at']));
                break;
            case 'name_asc':
                usort($filteredCategories, fn($a, $b) => strcmp($a['name'], $b['name']));
                break;
            case 'name_desc':
                usort($filteredCategories, fn($a, $b) => strcmp($b['name'], $a['name']));
                break;
            case 'courses_desc':
                usort($filteredCategories, fn($a, $b) => $b['courses_count'] - $a['courses_count']);
                break;
            default: // created_desc
                usort($filteredCategories, fn($a, $b) => strtotime($b['created_at']) - strtotime($a['created_at']));
                break;
        }

        // Pagination
        $totalCategories = count($filteredCategories);
        $totalPages = ceil($totalCategories / $perPage);
        $offset = ($page - 1) * $perPage;
        $categories = array_slice($filteredCategories, $offset, $perPage);

        // Statistics
        $stats = [
            'total' => count($allCategories),
            'active' => count(array_filter($allCategories, fn($c) => $c['status'] === 'active')),
            'draft' => count(array_filter($allCategories, fn($c) => $c['status'] === 'draft')),
            'total_courses' => array_sum(array_column($allCategories, 'courses_count')),
            'total_students' => array_sum(array_column($allCategories, 'students_count'))
        ];

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
            'name_asc' => 'Name A-Z',
            'name_desc' => 'Name Z-A',
            'courses_desc' => 'Most Courses'
        ];

        // Prepare data for view
        $data = [
            'categories' => $categories,
            'pagination' => [
                'current_page' => $page,
                'total_pages' => $totalPages,
                'total_items' => $totalCategories,
                'start_item' => $totalCategories > 0 ? $offset + 1 : 0,
                'end_item' => min($offset + $perPage, $totalCategories),
                'per_page' => $perPage
            ],
            'filters' => [
                'search' => $search,
                'status' => $status,
                'sort' => $sortBy
            ],
            'stats' => $stats,
            'statusOptions' => $statusOptions,
            'sortOptions' => $sortOptions
        ];

        // Page metadata
        $pageData = [
            'title' => 'Categories - TARUMT LMS',
            'pageTitle' => 'Categories',
            'pageSubtitle' => 'Organize your courses into categories and subcategories',
            'currentPage' => 'categories',
            'breadcrumbs' => [
                ['title' => 'Categories']
            ]
        ];
        
        // Include view file
        extract(array_merge($data, $pageData));
        include '../app/Views/course/instructor/categories/index.php';
    }

    public function create() {
        // Parent categories for subcategory selection (dummy data)
        $parentCategories = [
            ['id' => 1, 'name' => 'Web Development'],
            ['id' => 2, 'name' => 'Mobile Development'], 
            ['id' => 3, 'name' => 'Data Science'],
            ['id' => 4, 'name' => 'Design'],
            ['id' => 5, 'name' => 'Business']
        ];

        // Status options
        $statusOptions = [
            'active' => 'Active',
            'draft' => 'Draft'
        ];

        // Page metadata
        $pageData = [
            'title' => 'Create Category - TARUMT LMS',
            'pageTitle' => 'Create Category',
            'pageSubtitle' => 'Add a new category to organize your courses',
            'currentPage' => 'categories',
            'breadcrumbs' => [
                ['title' => 'Categories', 'url' => '/instructor/categories'],
                ['title' => 'Create Category']
            ]
        ];

        $data = [
            'parentCategories' => $parentCategories,
            'statusOptions' => $statusOptions
        ];

        // Include view file
        extract(array_merge($data, $pageData));
        include '../app/Views/course/instructor/categories/create.php';
    }

    public function store() {
        // Validate form data
        $name = trim($_POST['name'] ?? '');
        $slug = trim($_POST['slug'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $type = $_POST['type'] ?? 'main';
        $parent_id = $_POST['parent_id'] ?? null;
        $status = $_POST['status'] ?? 'active';
        $is_featured = isset($_POST['is_featured']) ? 1 : 0;
        $sort_order = (int)($_POST['sort_order'] ?? 0);
        $icon = $_POST['icon'] ?? 'fas fa-folder';
        $meta_title = trim($_POST['meta_title'] ?? '');
        $meta_description = trim($_POST['meta_description'] ?? '');
        $keywords = trim($_POST['keywords'] ?? '');
        $action = $_POST['action'] ?? 'publish';

        // Basic validation
        $errors = [];
        
        if (empty($name)) {
            $errors[] = 'Category name is required';
        }
        
        if (empty($slug)) {
            $errors[] = 'URL slug is required';
        }
        
        if (empty($description)) {
            $errors[] = 'Description is required';
        }
        
        if ($type === 'sub' && empty($parent_id)) {
            $errors[] = 'Parent category is required for subcategories';
        }

        // Check if slug already exists
        if ($this->slugExists($slug)) {
            $errors[] = 'URL slug already exists. Please choose a different one.';
        }

        // Handle image upload
        $imagePath = null;
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $uploadResult = $this->handleImageUpload($_FILES['image']);
            if ($uploadResult['success']) {
                $imagePath = $uploadResult['path'];
            } else {
                $errors[] = $uploadResult['error'];
            }
        }

        // If there are validation errors, redirect back with errors
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old_input'] = $_POST;
            header('Location: /instructor/categories/create');
            exit;
        }

        // Set final status based on action
        if ($action === 'draft') {
            $status = 'draft';
        }

        // TODO: Save to database
        // For now, simulate success
        $categoryId = rand(100, 999);

        // Clear any old input data
        unset($_SESSION['old_input'], $_SESSION['errors']);

        // Success message
        if ($action === 'draft') {
            $_SESSION['success'] = "Category '{$name}' has been saved as draft.";
        } else {
            $_SESSION['success'] = "Category '{$name}' has been created successfully!";
        }

        header('Location: /instructor/categories');
        exit;
    }

    private function slugExists($slug, $excludeId = null) {
        // TODO: Check database for existing slug
        // For now, simulate check with dummy data
        $existingSlugs = ['web-development', 'mobile-development', 'data-science'];
        return in_array($slug, $existingSlugs);
    }

    private function handleImageUpload($file) {
        // Validate file
        if ($file['size'] > 2 * 1024 * 1024) { // 2MB limit
            return ['success' => false, 'error' => 'Image size must be less than 2MB'];
        }

        $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
        if (!in_array($file['type'], $allowedTypes)) {
            return ['success' => false, 'error' => 'Only JPG, JPEG and PNG images are allowed'];
        }

        // TODO: Implement actual file upload
        // For now, return dummy path
        $filename = 'category_' . time() . '_' . uniqid() . '.jpg';
        $uploadPath = '/uploads/categories/' . $filename;
        
        return ['success' => true, 'path' => $uploadPath];
    }

    public function edit($id) {
    // Get category data (dummy data based on ID)
    $category = $this->getCategoryById($id);
    
    if (!$category) {
        $_SESSION['error'] = 'Category not found';
        header('Location: /instructor/categories');
        exit;
    }

    // Parent categories for subcategory selection (exclude current category and its children)
    $parentCategories = [
        ['id' => 1, 'name' => 'Web Development'],
        ['id' => 2, 'name' => 'Mobile Development'],
        ['id' => 3, 'name' => 'Data Science'],
        ['id' => 4, 'name' => 'Design'],
        ['id' => 5, 'name' => 'Business']
    ];
    
    // Remove current category from parent options if it's a main category
    $parentCategories = array_filter($parentCategories, function($parent) use ($id) {
        return $parent['id'] != $id;
    });

    // Status options
    $statusOptions = [
        'active' => 'Active',
        'draft' => 'Draft',
        'archived' => 'Archived'
    ];

    // Page metadata
    $pageData = [
        'title' => 'Edit Category - TARUMT LMS',
        'pageTitle' => 'Edit Category',
        'pageSubtitle' => 'Update category information and settings',
        'currentPage' => 'categories',
        'breadcrumbs' => [
            ['title' => 'Categories', 'url' => '/instructor/categories'],
            ['title' => 'Edit: ' . $category['name']]
        ]
    ];

    // Include view
    extract(array_merge([
        'category' => $category,
        'parentCategories' => $parentCategories, 
        'statusOptions' => $statusOptions
    ], $pageData));
    include '../app/Views/course/instructor/categories/edit.php';
}

    private function getCategoryById($id) {
        // Dummy category data - replace with actual database query later
        $categories = [
            1 => [
                'id' => 1,
                'name' => 'Web Development',
                'slug' => 'web-development',
                'description' => 'Learn modern web development technologies and frameworks',
                'type' => 'main',
                'parent_id' => null,
                'status' => 'active',
                'is_featured' => true,
                'sort_order' => 1,
                'icon' => 'fas fa-code',
                'image' => '/images/categories/web-dev.jpg',
                'meta_title' => 'Web Development Courses - TARUMT LMS',
                'meta_description' => 'Master web development with our comprehensive courses covering frontend, backend, and full-stack development.',
                'keywords' => 'web development, programming, javascript, php, html, css',
                'created_at' => '2024-01-10',
                'updated_at' => '2024-03-15'
            ],
            2 => [
                'id' => 2,
                'name' => 'Mobile Development',
                'slug' => 'mobile-development',
                'description' => 'Build mobile applications for iOS and Android platforms',
                'type' => 'main',
                'parent_id' => null,
                'status' => 'active',
                'is_featured' => false,
                'sort_order' => 2,
                'icon' => 'fas fa-mobile-alt',
                'image' => null,
                'meta_title' => 'Mobile Development Courses - TARUMT LMS',
                'meta_description' => 'Learn to build native and cross-platform mobile applications.',
                'keywords' => 'mobile development, ios, android, react native, flutter',
                'created_at' => '2024-01-15',
                'updated_at' => '2024-03-10'
            ]
        ];

        return $categories[$id] ?? null;
    }

    public function update($id) {
        // Get existing category data
        $existingCategory = $this->getCategoryById($id);
        
        if (!$existingCategory) {
            $_SESSION['error'] = 'Category not found';
            header('Location: /instructor/categories');
            exit;
        }

        // Validate form data
        $name = trim($_POST['name'] ?? '');
        $slug = trim($_POST['slug'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $type = $_POST['type'] ?? 'main';
        $parent_id = $_POST['parent_id'] ?? null;
        $status = $_POST['status'] ?? 'active';
        $is_featured = isset($_POST['is_featured']) ? 1 : 0;
        $sort_order = (int)($_POST['sort_order'] ?? 0);
        $icon = $_POST['icon'] ?? 'fas fa-folder';
        $meta_title = trim($_POST['meta_title'] ?? '');
        $meta_description = trim($_POST['meta_description'] ?? '');
        $keywords = trim($_POST['keywords'] ?? '');
        $action = $_POST['action'] ?? 'update';

        // Basic validation
        $errors = [];
        
        if (empty($name)) {
            $errors[] = 'Category name is required';
        }
        
        if (empty($slug)) {
            $errors[] = 'URL slug is required';
        }
        
        if (empty($description)) {
            $errors[] = 'Description is required';
        }
        
        if ($type === 'sub' && empty($parent_id)) {
            $errors[] = 'Parent category is required for subcategories';
        }

        // Check if slug already exists (excluding current category)
        if ($this->slugExists($slug, $id)) {
            $errors[] = 'URL slug already exists. Please choose a different one.';
        }

        // Validate parent category (prevent circular reference)
        if ($type === 'sub' && $parent_id) {
            if ($parent_id == $id) {
                $errors[] = 'A category cannot be its own parent';
            }
            
            // Check if trying to set a child category as parent
            if ($this->wouldCreateCircularReference($id, $parent_id)) {
                $errors[] = 'Cannot set a subcategory as parent - this would create a circular reference';
            }
        }

        // Handle image upload
        $imagePath = $existingCategory['image']; // Keep existing image by default
        
        // Check if user wants to remove current image
        if (isset($_POST['remove_current_image']) && $_POST['remove_current_image'] === '1') {
            $imagePath = null;
        }
        
        // Handle new image upload
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $uploadResult = $this->handleImageUpload($_FILES['image']);
            if ($uploadResult['success']) {
                $imagePath = $uploadResult['path'];
            } else {
                $errors[] = $uploadResult['error'];
            }
        }

        // If there are validation errors, redirect back with errors
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old_input'] = $_POST;
            header('Location: /instructor/categories/' . $id . '/edit');
            exit;
        }

        // Set final status based on action
        if ($action === 'draft') {
            $status = 'draft';
        }

        // TODO: Update in database
        // In real implementation:
        // $this->updateCategory($id, [
        //     'name' => $name,
        //     'slug' => $slug,
        //     'description' => $description,
        //     'type' => $type,
        //     'parent_id' => $parent_id,
        //     'status' => $status,
        //     'is_featured' => $is_featured,
        //     'sort_order' => $sort_order,
        //     'icon' => $icon,
        //     'image' => $imagePath,
        //     'meta_title' => $meta_title,
        //     'meta_description' => $meta_description,
        //     'keywords' => $keywords,
        //     'updated_at' => date('Y-m-d H:i:s')
        // ]);

        // Clear any old input data
        unset($_SESSION['old_input'], $_SESSION['errors']);

        // Success message
        if ($action === 'draft') {
            $_SESSION['success'] = "Category '{$name}' has been saved as draft.";
        } else {
            $_SESSION['success'] = "Category '{$name}' has been updated successfully!";
        }

        header('Location: /instructor/categories');
        exit;
    }

    private function wouldCreateCircularReference($categoryId, $parentId) {
        // TODO: Implement proper circular reference checking
        // For now, simple check - in real implementation, would need to traverse the tree
        $subcategories = $this->getSubcategoriesByParent($categoryId);
        
        foreach ($subcategories as $sub) {
            if ($sub['id'] == $parentId) {
                return true;
            }
        }
        
        return false;
    }

    public function show($id) {
        // Get category data
        $category = $this->getCategoryById($id);
        
        if (!$category) {
            $_SESSION['error'] = 'Category not found';
            header('Location: /instructor/categories');
            exit;
        }

        // Get courses in this category (dummy data)
        $courses = $this->getCoursesByCategory($id);
        
        // Get subcategories if this is a main category
        $subcategories = [];
        if ($category['type'] === 'main') {
            $subcategories = $this->getSubcategoriesByParent($id);
        }

        // Category statistics
        $stats = [
            'total_courses' => count($courses),
            'total_students' => array_sum(array_column($courses, 'students_count')),
            'total_revenue' => array_sum(array_column($courses, 'revenue')),
            'avg_rating' => $courses ? round(array_sum(array_column($courses, 'rating')) / count($courses), 1) : 0
        ];

        // Page metadata
        $pageData = [
            'title' => $category['name'] . ' - Category Details - TARUMT LMS',
            'pageTitle' => $category['name'],
            'pageSubtitle' => 'Category overview and management',
            'currentPage' => 'categories',
            'breadcrumbs' => [
                ['title' => 'Categories', 'url' => '/instructor/categories'],
                ['title' => $category['name']]
            ]
        ];

        // Include view
        extract(array_merge([
            'category' => $category,
            'courses' => $courses,
            'subcategories' => $subcategories,
            'stats' => $stats
        ], $pageData));
        include '../app/Views/course/instructor/categories/show.php';
    }

    private function getCoursesByCategory($categoryId) {
        // Dummy courses data for this category
        return [
            [
                'id' => 1,
                'title' => 'Laravel Fundamentals',
                'price' => 199,
                'students_count' => 45,
                'rating' => 4.8,
                'revenue' => 8955,
                'status' => 'published',
                'created_at' => '2024-01-10'
            ],
            [
                'id' => 2,
                'title' => 'Advanced PHP Techniques',
                'price' => 299,
                'students_count' => 32,
                'rating' => 4.6,
                'revenue' => 9568,
                'status' => 'published',
                'created_at' => '2024-02-15'
            ]
        ];
    }

    private function getSubcategoriesByParent($parentId) {
        // Return dummy subcategories
        $allSubcategories = [
            1 => [
                ['id' => 1, 'name' => 'Frontend Development', 'courses_count' => 8, 'students_count' => 156],
                ['id' => 2, 'name' => 'Backend Development', 'courses_count' => 5, 'students_count' => 98],
                ['id' => 3, 'name' => 'Full Stack Development', 'courses_count' => 2, 'students_count' => 67]
            ]
        ];
        
        return $allSubcategories[$parentId] ?? [];
    }

    public function destroy($id) {
        $category = $this->getCategoryById($id);
        
        if (!$category) {
            $_SESSION['error'] = 'Category not found';
            header('Location: /instructor/categories');
            exit;
        }

        // Check if category has courses
        $courses = $this->getCoursesByCategory($id);
        if (!empty($courses)) {
            $_SESSION['error'] = 'Cannot delete category that contains courses. Please move or delete all courses first.';
            header('Location: /instructor/categories/' . $id);
            exit;
        }

        // Check if category has subcategories
        if ($category['type'] === 'main') {
            $subcategories = $this->getSubcategoriesByParent($id);
            if (!empty($subcategories)) {
                $_SESSION['error'] = 'Cannot delete category that has subcategories. Please delete all subcategories first.';
                header('Location: /instructor/categories/' . $id);
                exit;
            }
        }

        // TODO: Actual database deletion would go here
        $categoryName = $category['name'];
        
        $_SESSION['success'] = "Category '{$categoryName}' has been successfully deleted.";
        header('Location: /instructor/categories');
        exit;
    }

}