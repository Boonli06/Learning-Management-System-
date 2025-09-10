<?php
// Get course ID from URL parameter
$courseId = $_GET['id'] ?? 1;

// Dummy course data - in real app, fetch from database
$courseData = [
    'id' => $courseId,
    'title' => 'Laravel Fundamentals for Modern Web Development',
    'status' => 'published',
    'created_at' => '2024-01-15',
    'published_at' => '2024-02-01',
    'price' => 199,
    'description' => 'A comprehensive course covering Laravel fundamentals, from installation to advanced features. Perfect for developers looking to master modern PHP web development.',
    'thumbnail' => 'https://via.placeholder.com/400x225/1f2937/ffffff?text=Laravel',
    'category' => 'Web Development',
    'subcategory' => 'PHP Frameworks',
    'duration' => '8 hours 45 minutes',
    'sections' => 12,
    'lectures' => 48
];

$title = $courseData['title'] . ' - TARUMT LMS';
$pageTitle = $courseData['title'];
$pageSubtitle = 'Course Overview & Management';
$currentPage = 'courses';
$breadcrumbs = [
    ['title' => 'Courses', 'url' => '/instructor/courses'],
    ['title' => $courseData['title']]
];

// Page actions for header
ob_start();
?>
<div class="flex gap-3">
    <button type="button" class="bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-50 transition-colors duration-200" onclick="window.location.href='/instructor/courses/<?= $courseId ?>/preview'">
        <i class="fas fa-eye mr-2"></i>
        Preview
    </button>
    <button type="button" class="bg-black text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-800 transition-colors duration-200" onclick="window.location.href='/instructor/courses/<?= $courseId ?>/edit'">
        <i class="fas fa-edit mr-2"></i>
        Edit Course
    </button>
</div>
<?php
$pageActions = ob_get_clean();

ob_start();
?>

<!-- Course Header -->
<div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Course Thumbnail -->
        <div class="lg:col-span-1">
            <div class="aspect-video bg-gradient-to-br from-gray-900 to-gray-700 rounded-lg flex items-center justify-center relative">
                <span class="text-white text-2xl font-bold">Laravel</span>
                <!-- Status Badge -->
                <div class="absolute top-3 left-3">
                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                        <div class="w-1.5 h-1.5 bg-green-400 rounded-full mr-1"></div>
                        <?= ucfirst($courseData['status']) ?>
                    </span>
                </div>
            </div>
        </div>
        
        <!-- Course Info -->
        <div class="lg:col-span-2">
            <div class="mb-4">
                <div class="flex items-center gap-2 text-sm text-gray-500 mb-2">
                    <span><?= $courseData['category'] ?></span>
                    <i class="fas fa-chevron-right text-xs"></i>
                    <span><?= $courseData['subcategory'] ?></span>
                </div>
                <h1 class="text-2xl font-bold text-gray-900 mb-2"><?= $courseData['title'] ?></h1>
                <p class="text-gray-600 mb-4"><?= $courseData['description'] ?></p>
            </div>
            
            <!-- Course Stats -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4">
                <div class="text-center p-3 bg-gray-50 rounded-lg">
                    <div class="text-lg font-bold text-gray-900">45</div>
                    <div class="text-xs text-gray-500">Students</div>
                </div>
                <div class="text-center p-3 bg-gray-50 rounded-lg">
                    <div class="text-lg font-bold text-gray-900"><?= $courseData['sections'] ?></div>
                    <div class="text-xs text-gray-500">Sections</div>
                </div>
                <div class="text-center p-3 bg-gray-50 rounded-lg">
                    <div class="text-lg font-bold text-gray-900"><?= $courseData['lectures'] ?></div>
                    <div class="text-xs text-gray-500">Lectures</div>
                </div>
                <div class="text-center p-3 bg-gray-50 rounded-lg">
                    <div class="text-lg font-bold text-gray-900">4.8</div>
                    <div class="text-xs text-gray-500">Rating</div>
                </div>
            </div>
            
            <!-- Quick Actions -->
            <div class="flex flex-wrap gap-2">
                <span class="text-xl font-bold text-gray-900">RM <?= number_format($courseData['price']) ?></span>
                <span class="text-sm text-gray-500">• <?= $courseData['duration'] ?></span>
                <span class="text-sm text-gray-500">• Created <?= date('M j, Y', strtotime($courseData['created_at'])) ?></span>
            </div>
        </div>
    </div>
</div>

<!-- Navigation Tabs -->
<div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
    <div class="border-b border-gray-200">
        <nav class="flex space-x-8 px-6">
            <a href="/instructor/courses/<?= $courseId ?>" class="border-b-2 border-black text-black py-4 px-1 text-sm font-medium">
                Overview
            </a>
            <a href="/instructor/courses/<?= $courseId ?>/edit" class="border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 py-4 px-1 text-sm font-medium transition-colors duration-200">
                Edit Content
            </a>
            <a href="/instructor/courses/<?= $courseId ?>/analytics" class="border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 py-4 px-1 text-sm font-medium transition-colors duration-200">
                Analytics
            </a>
            <a href="/instructor/courses/<?= $courseId ?>/settings" class="border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 py-4 px-1 text-sm font-medium transition-colors duration-200">
                Settings
            </a>
            <a href="/instructor/courses/<?= $courseId ?>/pricing" class="border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 py-4 px-1 text-sm font-medium transition-colors duration-200">
                Pricing
            </a>
        </nav>
    </div>
</div>

<!-- Performance Overview -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600">Total Revenue</p>
                <p class="text-2xl font-bold text-gray-900">RM 8,955</p>
                <p class="text-sm text-green-600 mt-1">
                    <i class="fas fa-arrow-up text-xs mr-1"></i>
                    +15.3%
                </p>
            </div>
            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-dollar-sign text-green-600"></i>
            </div>
        </div>
    </div>
    
    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600">Enrollments</p>
                <p class="text-2xl font-bold text-gray-900">45</p>
                <p class="text-sm text-green-600 mt-1">
                    <i class="fas fa-arrow-up text-xs mr-1"></i>
                    +3 this month
                </p>
            </div>
            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-users text-blue-600"></i>
            </div>
        </div>
    </div>
    
    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600">Completion</p>
                <p class="text-2xl font-bold text-gray-900">68%</p>
                <p class="text-sm text-red-600 mt-1">
                    <i class="fas fa-arrow-down text-xs mr-1"></i>
                    -2.1%
                </p>
            </div>
            <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-graduation-cap text-purple-600"></i>
            </div>
        </div>
    </div>
    
    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600">Rating</p>
                <p class="text-2xl font-bold text-gray-900">4.8</p>
                <p class="text-sm text-green-600 mt-1">
                    <i class="fas fa-arrow-up text-xs mr-1"></i>
                    +0.2
                </p>
            </div>
            <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-star text-yellow-600"></i>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions Grid -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <!-- Course Management -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Course Management</h3>
        <div class="space-y-3">
            <a href="/instructor/courses/<?= $courseId ?>/edit" class="flex items-center p-3 rounded-lg border border-gray-200 hover:bg-gray-50 transition-colors duration-200">
                <div class="w-8 h-8 bg-black rounded-lg flex items-center justify-center mr-3">
                    <i class="fas fa-edit text-white text-sm"></i>
                </div>
                <div>
                    <p class="font-medium text-gray-900">Edit Course Content</p>
                    <p class="text-sm text-gray-500">Manage sections, lectures, and course materials</p>
                </div>
            </a>
            <a href="/instructor/sections?course_id=<?= $courseId ?>" class="flex items-center p-3 rounded-lg border border-gray-200 hover:bg-gray-50 transition-colors duration-200">
                <div class="w-8 h-8 bg-black rounded-lg flex items-center justify-center mr-3">
                    <i class="fas fa-list text-white text-sm"></i>
                </div>
                <div>
                    <p class="font-medium text-gray-900">Manage Sections</p>
                    <p class="text-sm text-gray-500">Organize course content into sections</p>
                </div>
            </a>
            <a href="/instructor/lectures?course_id=<?= $courseId ?>" class="flex items-center p-3 rounded-lg border border-gray-200 hover:bg-gray-50 transition-colors duration-200">
                <div class="w-8 h-8 bg-black rounded-lg flex items-center justify-center mr-3">
                    <i class="fas fa-play text-white text-sm"></i>
                </div>
                <div>
                    <p class="font-medium text-gray-900">Manage Lectures</p>
                    <p class="text-sm text-gray-500">Add and edit individual lectures</p>
                </div>
            </a>
        </div>
    </div>
    
    <!-- Analytics & Insights -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Analytics & Insights</h3>
        <div class="space-y-3">
            <a href="/instructor/courses/<?= $courseId ?>/analytics" class="flex items-center p-3 rounded-lg border border-gray-200 hover:bg-gray-50 transition-colors duration-200">
                <div class="w-8 h-8 bg-black rounded-lg flex items-center justify-center mr-3">
                    <i class="fas fa-chart-bar text-white text-sm"></i>
                </div>
                <div>
                    <p class="font-medium text-gray-900">Course Analytics</p>
                    <p class="text-sm text-gray-500">View detailed performance metrics</p>
                </div>
            </a>
            <a href="/instructor/courses/<?= $courseId ?>/students" class="flex items-center p-3 rounded-lg border border-gray-200 hover:bg-gray-50 transition-colors duration-200">
                <div class="w-8 h-8 bg-black rounded-lg flex items-center justify-center mr-3">
                    <i class="fas fa-users text-white text-sm"></i>
                </div>
                <div>
                    <p class="font-medium text-gray-900">Student Progress</p>
                    <p class="text-sm text-gray-500">Track individual student progress</p>
                </div>
            </a>
            <a href="/instructor/courses/<?= $courseId ?>/reviews" class="flex items-center p-3 rounded-lg border border-gray-200 hover:bg-gray-50 transition-colors duration-200">
                <div class="w-8 h-8 bg-black rounded-lg flex items-center justify-center mr-3">
                    <i class="fas fa-star text-white text-sm"></i>
                </div>
                <div>
                    <p class="font-medium text-gray-900">Reviews & Ratings</p>
                    <p class="text-sm text-gray-500">View and respond to student feedback</p>
                </div>
            </a>
        </div>
    </div>
</div>

<!-- Recent Activity -->
<div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-semibold text-gray-900">Recent Activity</h3>
        <a href="/instructor/courses/<?= $courseId ?>/activity" class="text-sm text-black hover:text-gray-700">View all</a>
    </div>
    <div class="space-y-4">
        <div class="flex items-start">
            <div class="w-2 h-2 bg-green-400 rounded-full mt-2 mr-3"></div>
            <div class="flex-1">
                <p class="text-sm text-gray-900">New student "John Doe" enrolled in the course</p>
                <p class="text-xs text-gray-500">2 hours ago</p>
            </div>
        </div>
        <div class="flex items-start">
            <div class="w-2 h-2 bg-blue-400 rounded-full mt-2 mr-3"></div>
            <div class="flex-1">
                <p class="text-sm text-gray-900">Course content was updated - "Laravel Basics" section</p>
                <p class="text-xs text-gray-500">1 day ago</p>
            </div>
        </div>
        <div class="flex items-start">
            <div class="w-2 h-2 bg-yellow-400 rounded-full mt-2 mr-3"></div>
            <div class="flex-1">
                <p class="text-sm text-gray-900">New 5-star review received from "Sarah Wilson"</p>
                <p class="text-xs text-gray-500">2 days ago</p>
            </div>
        </div>
        <div class="flex items-start">
            <div class="w-2 h-2 bg-purple-400 rounded-full mt-2 mr-3"></div>
            <div class="flex-1">
                <p class="text-sm text-gray-900">Course pricing was updated to RM <?= number_format($courseData['price']) ?></p>
                <p class="text-xs text-gray-500">3 days ago</p>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include '../app/Views/layouts/instructor.php';
?>