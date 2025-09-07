<?php
$title = 'Student Dashboard - TARUMT LMS';
$pageTitle = 'Dashboard';
$pageSubtitle = 'Welcome back, continue your learning journey';
$currentPage = 'dashboard';
$breadcrumbs = [
    ['title' => 'Dashboard']
];

ob_start();
?>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 hover:shadow-md transition-shadow duration-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600">Enrolled Courses</p>
                <p class="text-3xl font-bold text-gray-900">5</p>
                <p class="text-sm text-blue-600 mt-1">
                    <i class="fas fa-arrow-up text-xs mr-1"></i>
                    2 new this month
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
                <p class="text-sm font-medium text-gray-600">Completed Courses</p>
                <p class="text-3xl font-bold text-gray-900">8</p>
                <p class="text-sm text-green-600 mt-1">
                    <i class="fas fa-arrow-up text-xs mr-1"></i>
                    3 completed this semester
                </p>
            </div>
            <div class="w-12 h-12 bg-black rounded-lg flex items-center justify-center">
                <i class="fas fa-graduation-cap text-white"></i>
            </div>
        </div>
    </div>
    
    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 hover:shadow-md transition-shadow duration-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600">Learning Hours</p>
                <p class="text-3xl font-bold text-gray-900">47.5</p>
                <p class="text-sm text-green-600 mt-1">
                    <i class="fas fa-arrow-up text-xs mr-1"></i>
                    +8.2 hours this week
                </p>
            </div>
            <div class="w-12 h-12 bg-black rounded-lg flex items-center justify-center">
                <i class="fas fa-clock text-white"></i>
            </div>
        </div>
    </div>
</div>

<!-- Continue Learning & Quick Actions -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <!-- Continue Learning -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Continue Learning</h3>
        <div class="space-y-4">
            <div class="flex items-center p-3 rounded-lg border border-gray-200 hover:bg-gray-50 transition-colors duration-200">
                <div class="w-15 h-10 bg-black rounded mr-4 flex items-center justify-center">
                    <span class="text-white text-xs font-bold">PHP</span>
                </div>
                <div class="flex-1">
                    <h4 class="font-medium text-gray-900">Laravel Fundamentals</h4>
                    <p class="text-sm text-gray-500">Progress: 65% • 2 hours left</p>
                    <div class="w-full bg-gray-200 rounded-full h-2 mt-2">
                        <div class="bg-black h-2 rounded-full" style="width: 65%"></div>
                    </div>
                </div>
                <button class="bg-black text-white px-4 py-2 rounded-lg text-sm hover:bg-gray-800 transition-colors duration-200">
                    Continue
                </button>
            </div>
            
            <div class="flex items-center p-3 rounded-lg border border-gray-200 hover:bg-gray-50 transition-colors duration-200">
                <div class="w-15 h-10 bg-black rounded mr-4 flex items-center justify-center">
                    <span class="text-white text-xs font-bold">JS</span>
                </div>
                <div class="flex-1">
                    <h4 class="font-medium text-gray-900">JavaScript Advanced</h4>
                    <p class="text-sm text-gray-500">Progress: 30% • 12 hours left</p>
                    <div class="w-full bg-gray-200 rounded-full h-2 mt-2">
                        <div class="bg-black h-2 rounded-full" style="width: 30%"></div>
                    </div>
                </div>
                <button class="bg-black text-white px-4 py-2 rounded-lg text-sm hover:bg-gray-800 transition-colors duration-200">
                    Continue
                </button>
            </div>
            
            <div class="flex items-center p-3 rounded-lg border border-gray-200 hover:bg-gray-50 transition-colors duration-200">
                <div class="w-15 h-10 bg-black rounded mr-4 flex items-center justify-center">
                    <span class="text-white text-xs font-bold">DB</span>
                </div>
                <div class="flex-1">
                    <h4 class="font-medium text-gray-900">Database Design</h4>
                    <p class="text-sm text-gray-500">Progress: 85% • 1 hour left</p>
                    <div class="w-full bg-gray-200 rounded-full h-2 mt-2">
                        <div class="bg-black h-2 rounded-full" style="width: 85%"></div>
                    </div>
                </div>
                <button class="bg-black text-white px-4 py-2 rounded-lg text-sm hover:bg-gray-800 transition-colors duration-200">
                    Continue
                </button>
            </div>
        </div>
    </div>
    
    <!-- Quick Actions -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>
        <div class="space-y-3">
            <a href="/courses" class="flex items-center p-3 rounded-lg border border-gray-200 hover:bg-gray-50 transition-colors duration-200">
                <div class="w-8 h-8 bg-black rounded-lg flex items-center justify-center mr-3">
                    <i class="fas fa-search text-white text-sm"></i>
                </div>
                <div>
                    <p class="font-medium text-gray-900">Browse Courses</p>
                    <p class="text-sm text-gray-500">Discover new learning opportunities</p>
                </div>
            </a>
            <a href="/student/wishlist" class="flex items-center p-3 rounded-lg border border-gray-200 hover:bg-gray-50 transition-colors duration-200">
                <div class="w-8 h-8 bg-black rounded-lg flex items-center justify-center mr-3">
                    <i class="fas fa-heart text-white text-sm"></i>
                </div>
                <div>
                    <p class="font-medium text-gray-900">My Wishlist</p>
                    <p class="text-sm text-gray-500">3 courses saved for later</p>
                </div>
            </a>
            <a href="/student/certificates" class="flex items-center p-3 rounded-lg border border-gray-200 hover:bg-gray-50 transition-colors duration-200">
                <div class="w-8 h-8 bg-black rounded-lg flex items-center justify-center mr-3">
                    <i class="fas fa-certificate text-white text-sm"></i>
                </div>
                <div>
                    <p class="font-medium text-gray-900">My Certificates</p>
                    <p class="text-sm text-gray-500">View your achievements</p>
                </div>
            </a>
        </div>
    </div>
</div>

<!-- Recent Activity & Learning Progress -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <!-- Recent Activity -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Recent Activity</h3>
        <div class="space-y-4">
            <div class="flex items-start">
                <div class="w-2 h-2 bg-green-400 rounded-full mt-2 mr-3"></div>
                <div class="flex-1">
                    <p class="text-sm text-gray-900">Completed lecture "Advanced PHP Functions"</p>
                    <p class="text-xs text-gray-500">2 hours ago</p>
                </div>
            </div>
            <div class="flex items-start">
                <div class="w-2 h-2 bg-blue-400 rounded-full mt-2 mr-3"></div>
                <div class="flex-1">
                    <p class="text-sm text-gray-900">Submitted assignment for Database Design</p>
                    <p class="text-xs text-gray-500">1 day ago</p>
                </div>
            </div>
            <div class="flex items-start">
                <div class="w-2 h-2 bg-yellow-400 rounded-full mt-2 mr-3"></div>
                <div class="flex-1">
                    <p class="text-sm text-gray-900">Enrolled in "React.js Fundamentals"</p>
                    <p class="text-xs text-gray-500">2 days ago</p>
                </div>
            </div>
            <div class="flex items-start">
                <div class="w-2 h-2 bg-purple-400 rounded-full mt-2 mr-3"></div>
                <div class="flex-1">
                    <p class="text-sm text-gray-900">Earned certificate for "HTML & CSS Basics"</p>
                    <p class="text-xs text-gray-500">3 days ago</p>
                </div>
            </div>
        </div>
        <div class="mt-4 pt-4 border-t border-gray-200">
            <a href="/student/activity" class="text-sm font-medium text-black hover:text-gray-700">View all activity</a>
        </div>
    </div>
    
    <!-- Learning Progress This Week -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">This Week's Progress</h3>
        <div class="space-y-4">
            <div>
                <div class="flex justify-between items-center mb-2">
                    <span class="text-sm font-medium text-gray-600">Learning Goal</span>
                    <span class="text-sm text-gray-500">8.2 / 10 hours</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-3">
                    <div class="bg-green-500 h-3 rounded-full" style="width: 82%"></div>
                </div>
            </div>
            
            <div class="grid grid-cols-2 gap-4 pt-4">
                <div class="text-center">
                    <p class="text-2xl font-bold text-gray-900">12</p>
                    <p class="text-sm text-gray-500">Lectures Watched</p>
                </div>
                <div class="text-center">
                    <p class="text-2xl font-bold text-gray-900">3</p>
                    <p class="text-sm text-gray-500">Assignments Done</p>
                </div>
            </div>
            
            <div class="mt-4 p-3 bg-green-50 rounded-lg border border-green-200">
                <div class="flex items-center">
                    <i class="fas fa-trophy text-green-600 mr-2"></i>
                    <span class="text-sm text-green-800 font-medium">Great progress this week!</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recommended Courses -->
<div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-semibold text-gray-900">Recommended for You</h3>
        <a href="/courses" class="text-sm font-medium text-black hover:text-gray-700">View all courses</a>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        <div class="border border-gray-200 rounded-lg p-4 hover:shadow-sm transition-shadow duration-200">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded-full">New</span>
                <i class="fas fa-heart text-gray-300 hover:text-red-500 cursor-pointer"></i>
            </div>
            <div class="w-full h-32 bg-black rounded mb-3 flex items-center justify-center">
                <span class="text-white font-bold">React.js</span>
            </div>
            <h4 class="font-medium text-gray-900 mb-1">React.js Fundamentals</h4>
            <p class="text-sm text-gray-500 mb-3">Learn modern React development</p>
            <div class="flex items-center justify-between">
                <span class="text-sm font-medium text-gray-900">RM 299</span>
                <div class="flex items-center">
                    <i class="fas fa-star text-yellow-400 text-xs mr-1"></i>
                    <span class="text-sm text-gray-600">4.9</span>
                    <span class="text-xs text-gray-500 ml-1">(156)</span>
                </div>
            </div>
        </div>
        
        <div class="border border-gray-200 rounded-lg p-4 hover:shadow-sm transition-shadow duration-200">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded-full">Popular</span>
                <i class="fas fa-heart text-gray-300 hover:text-red-500 cursor-pointer"></i>
            </div>
            <div class="w-full h-32 bg-black rounded mb-3 flex items-center justify-center">
                <span class="text-white font-bold">Node.js</span>
            </div>
            <h4 class="font-medium text-gray-900 mb-1">Node.js Backend Development</h4>
            <p class="text-sm text-gray-500 mb-3">Build scalable backend applications</p>
            <div class="flex items-center justify-between">
                <span class="text-sm font-medium text-gray-900">RM 399</span>
                <div class="flex items-center">
                    <i class="fas fa-star text-yellow-400 text-xs mr-1"></i>
                    <span class="text-sm text-gray-600">4.7</span>
                    <span class="text-xs text-gray-500 ml-1">(89)</span>
                </div>
            </div>
        </div>
        
        <div class="border border-gray-200 rounded-lg p-4 hover:shadow-sm transition-shadow duration-200">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs bg-purple-100 text-purple-800 px-2 py-1 rounded-full">Advanced</span>
                <i class="fas fa-heart text-gray-300 hover:text-red-500 cursor-pointer"></i>
            </div>
            <div class="w-full h-32 bg-black rounded mb-3 flex items-center justify-center">
                <span class="text-white font-bold">DevOps</span>
            </div>
            <h4 class="font-medium text-gray-900 mb-1">DevOps Fundamentals</h4>
            <p class="text-sm text-gray-500 mb-3">Docker, CI/CD, and cloud deployment</p>
            <div class="flex items-center justify-between">
                <span class="text-sm font-medium text-gray-900">RM 499</span>
                <div class="flex items-center">
                    <i class="fas fa-star text-yellow-400 text-xs mr-1"></i>
                    <span class="text-sm text-gray-600">4.8</span>
                    <span class="text-xs text-gray-500 ml-1">(203)</span>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include '../app/Views/layouts/student.php';
?>