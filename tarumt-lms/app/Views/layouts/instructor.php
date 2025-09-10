<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Instructor Dashboard - TARUMT LMS' ?></title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Flowbite CSS & JS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.js"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Inter', sans-serif; }
        .sidebar-scrollbar::-webkit-scrollbar {
            width: 4px;
        }
        .sidebar-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }
        .sidebar-scrollbar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 2px;
        }
    </style>
</head>
<body class="h-full bg-gray-50">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="hidden md:flex md:flex-shrink-0">
            <div class="flex flex-col w-64">
                <div class="flex flex-col flex-grow pt-5 pb-4 overflow-y-auto bg-black sidebar-scrollbar">
                    <!-- Logo -->
                    <div class="flex items-center flex-shrink-0 px-4 mb-6">
                        <div class="bg-white rounded-lg p-2 mr-3">
                            <i class="fas fa-graduation-cap text-black text-xl"></i>
                        </div>
                        <div>
                            <h1 class="text-lg font-bold text-white">TARUMT</h1>
                            <p class="text-xs text-gray-400">Instructor Portal</p>
                        </div>
                    </div>
                    
                    <!-- Navigation -->
                    <nav class="mt-5 flex-1 px-2 space-y-1">
                        <!-- Dashboard -->
                        <a href="/dashboard" class="<?= (isset($currentPage) && $currentPage === 'dashboard') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' ?> group flex items-center px-2 py-2 text-sm font-medium rounded-lg transition-colors duration-200">
                            <i class="fas fa-tachometer-alt mr-3 text-sm"></i>
                            Dashboard
                        </a>
                        
                        <!-- Course Management -->
                        <div class="space-y-1">
                            <div class="text-gray-400 text-xs font-semibold uppercase tracking-wider px-2 py-2">
                                Course Management
                            </div>
                            <a href="/instructor/courses" class="<?= (isset($currentPage) && $currentPage === 'courses') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' ?> group flex items-center px-2 py-2 text-sm font-medium rounded-lg transition-colors duration-200">
                                <i class="fas fa-book mr-3 text-sm"></i>
                                My Courses
                            </a>
                            <a href="/instructor/courses/create" class="<?= (isset($currentPage) && $currentPage === 'create-course') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' ?> group flex items-center px-2 py-2 text-sm font-medium rounded-lg transition-colors duration-200">
                                <i class="fas fa-plus mr-3 text-sm"></i>
                                Create Course
                            </a>
                            <a href="/instructor/categories" class="<?= (isset($currentPage) && $currentPage === 'categories') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' ?> group flex items-center px-2 py-2 text-sm font-medium rounded-lg transition-colors duration-200">
                                <i class="fas fa-tags mr-3 text-sm"></i>
                                Categories
                            </a>
                        </div>
                        
                        <!-- Content Management -->
                        <div class="space-y-1">
                            <div class="text-gray-400 text-xs font-semibold uppercase tracking-wider px-2 py-2">
                                Content
                            </div>
                            <a href="/instructor/sections" class="<?= (isset($currentPage) && $currentPage === 'sections') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' ?> group flex items-center px-2 py-2 text-sm font-medium rounded-lg transition-colors duration-200">
                                <i class="fas fa-list mr-3 text-sm"></i>
                                Course Sections
                            </a>
                            <a href="/instructor/lectures" class="<?= (isset($currentPage) && $currentPage === 'lectures') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' ?> group flex items-center px-2 py-2 text-sm font-medium rounded-lg transition-colors duration-200">
                                <i class="fas fa-play-circle mr-3 text-sm"></i>
                                Lectures
                            </a>
                            <a href="/instructor/goals" class="<?= (isset($currentPage) && $currentPage === 'goals') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' ?> group flex items-center px-2 py-2 text-sm font-medium rounded-lg transition-colors duration-200">
                                <i class="fas fa-target mr-3 text-sm"></i>
                                Learning Goals
                            </a>
                        </div>
                        
                        <!-- Analytics -->
                        <div class="space-y-1">
                            <div class="text-gray-400 text-xs font-semibold uppercase tracking-wider px-2 py-2">
                                Analytics
                            </div>
                            <a href="/instructor/analytics" class="<?= (isset($currentPage) && $currentPage === 'analytics') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' ?> group flex items-center px-2 py-2 text-sm font-medium rounded-lg transition-colors duration-200">
                                <i class="fas fa-chart-bar mr-3 text-sm"></i>
                                Course Analytics
                            </a>
                        </div>
                    </nav>
                    
                    <!-- User Profile Section -->
                    <div class="flex-shrink-0 px-4 py-4 border-t border-gray-700">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <img class="h-8 w-8 rounded-full" src="<?= $_SESSION['user']['avatar'] ?? 'https://ui-avatars.com/api/?name=Instructor&background=ffffff&color=000000' ?>" alt="Profile">
                            </div>
                            <div class="ml-3 flex-1">
                                <p class="text-sm font-medium text-white">
                                    <?= htmlspecialchars($_SESSION['user']['name'] ?? 'Dr. Jane Smith') ?>
                                </p>
                                <p class="text-xs text-gray-400">Instructor</p>
                            </div>
                            <div class="relative">
                                <button type="button" class="bg-gray-800 p-1 rounded-full text-gray-400 hover:text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white" onclick="toggleProfileMenu()">
                                    <i class="fas fa-cog text-sm"></i>
                                </button>
                                
                                <!-- Profile Dropdown -->
                                <div id="profileMenu" class="hidden absolute bottom-full left-0 mb-2 w-48 bg-white rounded-lg shadow-lg py-1 z-50">
                                    <a href="/instructor/profile" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-user mr-2"></i>Your Profile
                                    </a>
                                    <a href="/instructor/settings" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-cog mr-2"></i>Settings
                                    </a>
                                    <div class="border-t border-gray-100"></div>
                                    <a href="/logout" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-sign-out-alt mr-2"></i>Sign out
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Main Content -->
        <div class="flex flex-col w-0 flex-1 overflow-hidden">
            <!-- Top Navigation -->
            <div class="relative z-10 flex-shrink-0 flex h-16 bg-white shadow border-b border-gray-200">
                <!-- Mobile menu button -->
                <button type="button" class="px-4 border-r border-gray-200 text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-black md:hidden" onclick="toggleMobileMenu()">
                    <i class="fas fa-bars text-lg"></i>
                </button>
                
                <!-- Breadcrumb -->
                <div class="flex-1 px-4 flex justify-between items-center">
                    <div class="flex items-center">
                        <nav class="flex" aria-label="Breadcrumb">
                            <ol class="flex items-center space-x-4">
                                <li>
                                    <div>
                                        <a href="/dashboard" class="text-gray-400 hover:text-gray-500">
                                            <i class="fas fa-home text-sm"></i>
                                            <span class="sr-only">Home</span>
                                        </a>
                                    </div>
                                </li>
                                <?php if (isset($breadcrumbs) && is_array($breadcrumbs)): ?>
                                    <?php foreach ($breadcrumbs as $crumb): ?>
                                        <li>
                                            <div class="flex items-center">
                                                <i class="fas fa-chevron-right text-gray-300 text-xs mr-4"></i>
                                                <?php if (isset($crumb['url'])): ?>
                                                    <a href="<?= htmlspecialchars($crumb['url']) ?>" class="text-sm font-medium text-gray-500 hover:text-gray-700">
                                                        <?= htmlspecialchars($crumb['title']) ?>
                                                    </a>
                                                <?php else: ?>
                                                    <span class="text-sm font-medium text-gray-900">
                                                        <?= htmlspecialchars($crumb['title']) ?>
                                                    </span>
                                                <?php endif; ?>
                                            </div>
                                        </li>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </ol>
                        </nav>
                    </div>
                    
                    <!-- Right side controls -->
                    <div class="ml-4 flex items-center md:ml-6 space-x-3">
                        <!-- Quick Actions -->
                        <button type="button" class="bg-black text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black transition-colors duration-200" onclick="window.location.href='/instructor/courses/create'">
                            <i class="fas fa-plus mr-2"></i>
                            New Course
                        </button>
                        
                        <!-- Notifications -->
                        <button type="button" class="bg-white p-1 rounded-full text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black relative" onclick="toggleNotifications()">
                            <i class="fas fa-bell text-lg"></i>
                            <span class="absolute top-0 right-0 block h-2 w-2 rounded-full bg-red-400 ring-2 ring-white"></span>
                        </button>
                        
                        <!-- Notifications Dropdown -->
                        <div id="notificationsMenu" class="hidden absolute right-0 top-16 w-80 bg-white rounded-lg shadow-lg border border-gray-200 z-50">
                            <div class="p-4 border-b border-gray-200">
                                <h3 class="text-lg font-medium text-gray-900">Notifications</h3>
                            </div>
                            <div class="max-h-64 overflow-y-auto">
                                <div class="p-4 hover:bg-gray-50 border-b border-gray-100">
                                    <div class="flex">
                                        <div class="flex-shrink-0">
                                            <i class="fas fa-user-plus text-blue-500"></i>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm text-gray-900">New student enrolled in "Laravel Fundamentals"</p>
                                            <p class="text-xs text-gray-500">2 hours ago</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="p-4 hover:bg-gray-50 border-b border-gray-100">
                                    <div class="flex">
                                        <div class="flex-shrink-0">
                                            <i class="fas fa-star text-yellow-500"></i>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm text-gray-900">New 5-star review on your course</p>
                                            <p class="text-xs text-gray-500">5 hours ago</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="p-4 border-t border-gray-200">
                                <a href="/instructor/notifications" class="text-sm font-medium text-black hover:text-gray-700">View all notifications</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Page Content -->
            <main class="flex-1 relative overflow-y-auto focus:outline-none">
                <!-- Flash Messages -->
                <?php if (isset($_SESSION['success'])): ?>
                    <div id="alert-success" class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg m-4" role="alert">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-check-circle text-green-400"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium"><?= htmlspecialchars($_SESSION['success']) ?></p>
                            </div>
                            <div class="ml-auto pl-3">
                                <button type="button" class="inline-flex text-green-400 hover:text-green-600" onclick="this.parentElement.parentElement.parentElement.style.display='none'">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <?php unset($_SESSION['success']); ?>
                <?php endif; ?>

                <?php if (isset($_SESSION['error'])): ?>
                    <div id="alert-error" class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg m-4" role="alert">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-exclamation-circle text-red-400"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium"><?= htmlspecialchars($_SESSION['error']) ?></p>
                            </div>
                            <div class="ml-auto pl-3">
                                <button type="button" class="inline-flex text-red-400 hover:text-red-600" onclick="this.parentElement.parentElement.parentElement.style.display='none'">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <?php unset($_SESSION['error']); ?>
                <?php endif; ?>
                
                <!-- Page Header -->
                <?php if (isset($pageTitle)): ?>
                    <div class="bg-white shadow border-b border-gray-200">
                        <div class="px-4 sm:px-6 lg:px-8 py-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h1 class="text-2xl font-bold text-gray-900"><?= htmlspecialchars($pageTitle) ?></h1>
                                    <?php if (isset($pageSubtitle)): ?>
                                        <p class="mt-1 text-sm text-gray-500"><?= htmlspecialchars($pageSubtitle) ?></p>
                                    <?php endif; ?>
                                </div>
                                <?php if (isset($pageActions)): ?>
                                    <div class="flex space-x-3">
                                        <?= $pageActions ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                
                <!-- Page Content -->
                <div class="py-6">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <?= $content ?>
                    </div>
                </div>
            </main>
        </div>
    </div>
    
    <!-- Mobile Sidebar Overlay -->
    <div id="mobileOverlay" class="hidden fixed inset-0 flex z-40 md:hidden" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-gray-600 bg-opacity-75" onclick="toggleMobileMenu()"></div>
        <div class="relative flex-1 flex flex-col max-w-xs w-full bg-black">
            <!-- Mobile sidebar content would go here -->
        </div>
    </div>

    <script>
        // Toggle mobile menu
        function toggleMobileMenu() {
            const overlay = document.getElementById('mobileOverlay');
            overlay.classList.toggle('hidden');
        }
        
        // Toggle profile menu
        function toggleProfileMenu() {
            const menu = document.getElementById('profileMenu');
            menu.classList.toggle('hidden');
        }
        
        // Toggle notifications menu
        function toggleNotifications() {
            const menu = document.getElementById('notificationsMenu');
            menu.classList.toggle('hidden');
        }
        
        // Close dropdowns when clicking outside
        document.addEventListener('click', function(event) {
            const profileMenu = document.getElementById('profileMenu');
            const notificationsMenu = document.getElementById('notificationsMenu');
            
            if (!event.target.closest('[onclick="toggleProfileMenu()"]') && !profileMenu.contains(event.target)) {
                profileMenu.classList.add('hidden');
            }
            
            if (!event.target.closest('[onclick="toggleNotifications()"]') && !notificationsMenu.contains(event.target)) {
                notificationsMenu.classList.add('hidden');
            }
        });
        
        // Auto-hide flash messages after 5 seconds
        setTimeout(() => {
            const alerts = document.querySelectorAll('[id^="alert-"]');
            alerts.forEach(alert => {
                if (alert) {
                    alert.style.transition = 'opacity 0.5s';
                    alert.style.opacity = '0';
                    setTimeout(() => alert.remove(), 500);
                }
            });
        }, 5000);
    </script>
</body>
</html>