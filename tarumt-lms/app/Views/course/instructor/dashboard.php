<?php
$title = 'Instructor Dashboard - TARUMT LMS';
$pageTitle = 'Dashboard';
$pageSubtitle = 'Welcome back, manage your courses and track student progress';
$currentPage = 'dashboard';
$breadcrumbs = [
    ['title' => 'Dashboard']
];

ob_start();
?>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 hover:shadow-md transition-shadow duration-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600">Total Courses</p>
                <p class="text-3xl font-bold text-gray-900">12</p>
                <p class="text-sm text-green-600 mt-1">
                    <i class="fas fa-arrow-up text-xs mr-1"></i>
                    +2 this month
                </p>
            </div>
            <div class="w-12 h-12 bg-black rounded-lg flex items-center justify-center">
                <i class="fas fa-book text-white"></i>
            </div>
        </div>
    </div>
    
    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 hover:shadow-md transition-shadow duration-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600">Total Students</p>
                <p class="text-3xl font-bold text-gray-900">234</p>
                <p class="text-sm text-green-600 mt-1">
                    <i class="fas fa-arrow-up text-xs mr-1"></i>
                    +18 this week
                </p>
            </div>
            <div class="w-12 h-12 bg-black rounded-lg flex items-center justify-center">
                <i class="fas fa-users text-white"></i>
            </div>
        </div>
    </div>
    
    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 hover:shadow-md transition-shadow duration-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600">Revenue</p>
                <p class="text-3xl font-bold text-gray-900">RM 15,420</p>
                <p class="text-sm text-green-600 mt-1">
                    <i class="fas fa-arrow-up text-xs mr-1"></i>
                    +12.5% this month
                </p>
            </div>
            <div class="w-12 h-12 bg-black rounded-lg flex items-center justify-center">
                <i class="fas fa-chart-line text-white"></i>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>
        <div class="space-y-3">
            <a href="/instructor/courses/create" class="flex items-center p-3 rounded-lg border border-gray-200 hover:bg-gray-50 transition-colors duration-200">
                <div class="w-8 h-8 bg-black rounded-lg flex items-center justify-center mr-3">
                    <i class="fas fa-plus text-white text-sm"></i>
                </div>
                <div>
                    <p class="font-medium text-gray-900">Create New Course</p>
                    <p class="text-sm text-gray-500">Start building your next course</p>
                </div>
            </a>
            <a href="/instructor/categories" class="flex items-center p-3 rounded-lg border border-gray-200 hover:bg-gray-50 transition-colors duration-200">
                <div class="w-8 h-8 bg-black rounded-lg flex items-center justify-center mr-3">
                    <i class="fas fa-tags text-white text-sm"></i>
                </div>
                <div>
                    <p class="font-medium text-gray-900">Manage Categories</p>
                    <p class="text-sm text-gray-500">Organize your course topics</p>
                </div>
            </a>
            <a href="/instructor/analytics" class="flex items-center p-3 rounded-lg border border-gray-200 hover:bg-gray-50 transition-colors duration-200">
                <div class="w-8 h-8 bg-black rounded-lg flex items-center justify-center mr-3">
                    <i class="fas fa-chart-bar text-white text-sm"></i>
                </div>
                <div>
                    <p class="font-medium text-gray-900">View Analytics</p>
                    <p class="text-sm text-gray-500">Track your course performance</p>
                </div>
            </a>
        </div>
    </div>
    
    <!-- Recent Activity -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Recent Activity</h3>
        <div class="space-y-4">
            <div class="flex items-start">
                <div class="w-2 h-2 bg-green-400 rounded-full mt-2 mr-3"></div>
                <div class="flex-1">
                    <p class="text-sm text-gray-900">New student enrolled in "Laravel Fundamentals"</p>
                    <p class="text-xs text-gray-500">2 hours ago</p>
                </div>
            </div>
            <div class="flex items-start">
                <div class="w-2 h-2 bg-blue-400 rounded-full mt-2 mr-3"></div>
                <div class="flex-1">
                    <p class="text-sm text-gray-900">Course "PHP Basics" was published</p>
                    <p class="text-xs text-gray-500">1 day ago</p>
                </div>
            </div>
            <div class="flex items-start">
                <div class="w-2 h-2 bg-yellow-400 rounded-full mt-2 mr-3"></div>
                <div class="flex-1">
                    <p class="text-sm text-gray-900">New review received (5 stars)</p>
                    <p class="text-xs text-gray-500">2 days ago</p>
                </div>
            </div>
            <div class="flex items-start">
                <div class="w-2 h-2 bg-purple-400 rounded-full mt-2 mr-3"></div>
                <div class="flex-1">
                    <p class="text-sm text-gray-900">Course section "Advanced Topics" created</p>
                    <p class="text-xs text-gray-500">3 days ago</p>
                </div>
            </div>
        </div>
        <div class="mt-4 pt-4 border-t border-gray-200">
            <a href="/instructor/activity" class="text-sm font-medium text-black hover:text-gray-700">View all activity</a>
        </div>
    </div>
</div>

<!-- Course Overview -->
<div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-semibold text-gray-900">Your Courses</h3>
        <a href="/instructor/courses" class="text-sm font-medium text-black hover:text-gray-700">View all courses</a>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        <div class="border border-gray-200 rounded-lg p-4 hover:shadow-sm transition-shadow duration-200">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded-full">Published</span>
                <i class="fas fa-ellipsis-h text-gray-400"></i>
            </div>
            <h4 class="font-medium text-gray-900 mb-1">Laravel Fundamentals</h4>
            <p class="text-sm text-gray-500 mb-3">45 students • 12 sections</p>
            <div class="flex items-center justify-between">
                <span class="text-sm font-medium text-gray-900">RM 199</span>
                <div class="flex items-center">
                    <i class="fas fa-star text-yellow-400 text-xs mr-1"></i>
                    <span class="text-sm text-gray-600">4.8</span>
                </div>
            </div>
        </div>
        
        <div class="border border-gray-200 rounded-lg p-4 hover:shadow-sm transition-shadow duration-200">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full">Draft</span>
                <i class="fas fa-ellipsis-h text-gray-400"></i>
            </div>
            <h4 class="font-medium text-gray-900 mb-1">PHP Advanced Topics</h4>
            <p class="text-sm text-gray-500 mb-3">0 students • 8 sections</p>
            <div class="flex items-center justify-between">
                <span class="text-sm font-medium text-gray-900">RM 299</span>
                <span class="text-sm text-gray-500">Not published</span>
            </div>
        </div>
        
        <div class="border border-gray-200 rounded-lg p-4 hover:shadow-sm transition-shadow duration-200">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded-full">Published</span>
                <i class="fas fa-ellipsis-h text-gray-400"></i>
            </div>
            <h4 class="font-medium text-gray-900 mb-1">Web Development Basics</h4>
            <p class="text-sm text-gray-500 mb-3">23 students • 6 sections</p>
            <div class="flex items-center justify-between">
                <span class="text-sm font-medium text-gray-900">RM 149</span>
                <div class="flex items-center">
                    <i class="fas fa-star text-yellow-400 text-xs mr-1"></i>
                    <span class="text-sm text-gray-600">4.6</span>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include '../app/Views/layouts/instructor.php';
?>