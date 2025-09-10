<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Student Portal - TARUMT LMS' ?></title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Flowbite CSS & JS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.js"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
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
                            <p class="text-xs text-gray-400">Student Portal</p>
                        </div>
                    </div>
                    
                    <!-- Navigation -->
                    <nav class="mt-5 flex-1 px-2 space-y-1">
                        <!-- Dashboard -->
                        <a href="/dashboard" class="<?= (isset($currentPage) && $currentPage === 'dashboard') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' ?> group flex items-center px-2 py-2 text-sm font-medium rounded-lg transition-colors duration-200">
                            <i class="fas fa-tachometer-alt mr-3 text-sm"></i>
                            Dashboard
                        </a>
                        
                        <!-- Learning -->
                        <div class="space-y-1">
                            <div class="text-gray-400 text-xs font-semibold uppercase tracking-wider px-2 py-2">
                                Learning
                            </div>
                            <a href="/student/browse" class="<?= (isset($currentPage) && $currentPage === 'browse') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' ?> group flex items-center px-2 py-2 text-sm font-medium rounded-lg transition-colors duration-200">
                                <i class="fas fa-search mr-3 text-sm"></i>
                                Browse Courses
                            </a>
                            <a href="/student/dashboard/mycourses" class="<?= (isset($currentPage) && $currentPage === 'mycourses') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' ?> group flex items-center px-2 py-2 text-sm font-medium rounded-lg transition-colors duration-200">
                                <i class="fas fa-book mr-3 text-sm"></i>
                                My Courses
                            </a>
                            <a href="/student/dashboard/wishlist" class="<?= (isset($currentPage) && $currentPage === 'wishlist') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' ?> group flex items-center px-2 py-2 text-sm font-medium rounded-lg transition-colors duration-200">
                                <i class="fas fa-heart mr-3 text-sm"></i>
                                Wishlist
                            </a>
                            <a href="/student/dashboard/progress" class="<?= (isset($currentPage) && $currentPage === 'progress') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' ?> group flex items-center px-2 py-2 text-sm font-medium rounded-lg transition-colors duration-200">
                                <i class="fas fa-chart-line mr-3 text-sm"></i>
                                Progress
                            </a>
                        </div>
                        
                        <!-- Shopping -->
                        <div class="space-y-1">
                            <div class="text-gray-400 text-xs font-semibold uppercase tracking-wider px-2 py-2">
                                Shopping
                            </div>
                            <a href="/student/cart" class="<?= (isset($currentPage) && $currentPage === 'cart') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' ?> group flex items-center px-2 py-2 text-sm font-medium rounded-lg transition-colors duration-200">
                                <i class="fas fa-shopping-cart mr-3 text-sm"></i>
                                Cart
                                <?php if (isset($cartCount) && $cartCount > 0): ?>
                                    <span class="ml-auto bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                                        <?= $cartCount ?>
                                    </span>
                                <?php endif; ?>
                            </a>
                            <a href="/student/orders" class="<?= (isset($currentPage) && $currentPage === 'orders') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' ?> group flex items-center px-2 py-2 text-sm font-medium rounded-lg transition-colors duration-200">
                                <i class="fas fa-receipt mr-3 text-sm"></i>
                                Order History
                            </a>
                        </div>
                        
                        <!-- Community -->
                        <div class="space-y-1">
                            <div class="text-gray-400 text-xs font-semibold uppercase tracking-wider px-2 py-2">
                                Community
                            </div>
                            <a href="/student/discussions" class="<?= (isset($currentPage) && $currentPage === 'discussions') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' ?> group flex items-center px-2 py-2 text-sm font-medium rounded-lg transition-colors duration-200">
                                <i class="fas fa-comments mr-3 text-sm"></i>
                                Discussions
                            </a>
                            <a href="/student/certificates" class="<?= (isset($currentPage) && $currentPage === 'certificates') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' ?> group flex items-center px-2 py-2 text-sm font-medium rounded-lg transition-colors duration-200">
                                <i class="fas fa-certificate mr-3 text-sm"></i>
                                Certificates
                            </a>
                        </div>
                    </nav>
                    
                    <!-- User Profile Section - Moved to bottom -->
                    <div class="flex-shrink-0 px-4 py-4 border-t border-gray-700 mt-auto">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <img class="h-8 w-8 rounded-full" src="<?= $_SESSION['user']['avatar'] ?? 'https://ui-avatars.com/api/?name=John+Doe&background=ffffff&color=000000' ?>" alt="Profile">
                            </div>
                            <div class="ml-3 flex-1">
                                <p class="text-sm font-medium text-white">
                                    <?= htmlspecialchars($_SESSION['user']['name'] ?? 'John Doe') ?>
                                </p>
                                <p class="text-xs text-gray-400">Student</p>
                            </div>
                            <div class="relative">
                                <button type="button" class="bg-gray-800 p-1 rounded-full text-gray-400 hover:text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white" onclick="toggleProfileMenu()">
                                    <i class="fas fa-cog text-sm"></i>
                                </button>
                                
                                <!-- Profile Dropdown -->
                                <div id="profileMenu" class="hidden absolute bottom-full left-0 mb-2 w-48 bg-white rounded-lg shadow-lg py-1 z-50">
                                    <a href="/student/profile" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-user mr-2"></i>Your Profile
                                    </a>
                                    <a href="/student/settings" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
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
                    <div class="flex items-center space-x-3">
                        <!-- Cart -->
                        <a href="/student/cart" class="bg-white p-2 rounded-full text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black relative">
                            <i class="fas fa-shopping-cart text-lg"></i>
                            <?php if (isset($cartCount) && $cartCount > 0): ?>
                                <span class="absolute -top-1 -right-1 block h-4 w-4 rounded-full bg-red-500 text-white text-xs flex items-center justify-center">
                                    <?= $cartCount ?>
                                </span>
                            <?php endif; ?>
                        </a>
                        
                        <!-- Notifications -->
                        <button type="button" class="bg-white p-2 rounded-full text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black relative" onclick="toggleNotifications()">
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
                                            <i class="fas fa-play-circle text-blue-500"></i>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm text-gray-900">New lecture available in "Laravel Fundamentals"</p>
                                            <p class="text-xs text-gray-500">1 hour ago</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="p-4 hover:bg-gray-50 border-b border-gray-100">
                                    <div class="flex">
                                        <div class="flex-shrink-0">
                                            <i class="fas fa-certificate text-green-500"></i>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm text-gray-900">Course completed! Certificate available</p>
                                            <p class="text-xs text-gray-500">2 days ago</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="p-4 border-t border-gray-200">
                                <a href="/student/notifications" class="text-sm font-medium text-black hover:text-gray-700">View all notifications</a>
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
            <div class="absolute top-0 right-0 -mr-12 pt-2">
                <button type="button" class="ml-1 flex items-center justify-center h-10 w-10 rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white" onclick="toggleMobileMenu()">
                    <i class="fas fa-times text-white"></i>
                </button>
            </div>
            
            <!-- Mobile Navigation -->
            <div class="flex-1 h-0 pt-5 pb-4 overflow-y-auto">
                <!-- Logo -->
                <div class="flex items-center flex-shrink-0 px-4 mb-6">
                    <div class="bg-white rounded-lg p-2 mr-3">
                        <i class="fas fa-graduation-cap text-black text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-lg font-bold text-white">TARUMT</h1>
                        <p class="text-xs text-gray-400">Student Portal</p>
                    </div>
                </div>
                
                <!-- Mobile Menu Items -->
                <nav class="mt-5 px-2 space-y-1">
                    <!-- Dashboard -->
                    <a href="/dashboard" class="text-gray-300 hover:bg-gray-700 hover:text-white group flex items-center px-2 py-2 text-base font-medium rounded-lg">
                        <i class="fas fa-tachometer-alt mr-4 text-sm"></i>
                        Dashboard
                    </a>
                    
                    <!-- Learning Section -->
                    <div class="pt-4">
                        <div class="text-gray-400 text-xs font-semibold uppercase tracking-wider px-2 pb-2">Learning</div>
                        <a href="/student/browse" class="text-gray-300 hover:bg-gray-700 hover:text-white group flex items-center px-2 py-2 text-base font-medium rounded-lg">
                            <i class="fas fa-search mr-4 text-sm"></i>
                            Browse Courses
                        </a>
                        <a href="/student/dashboard/mycourses" class="text-gray-300 hover:bg-gray-700 hover:text-white group flex items-center px-2 py-2 text-base font-medium rounded-lg">
                            <i class="fas fa-book mr-4 text-sm"></i>
                            My Courses
                        </a>
                        <a href="/student/dashboard/wishlist" class="text-gray-300 hover:bg-gray-700 hover:text-white group flex items-center px-2 py-2 text-base font-medium rounded-lg">
                            <i class="fas fa-heart mr-4 text-sm"></i>
                            Wishlist
                        </a>
                        <a href="/student/dashboard/progress" class="text-gray-300 hover:bg-gray-700 hover:text-white group flex items-center px-2 py-2 text-base font-medium rounded-lg">
                            <i class="fas fa-chart-line mr-4 text-sm"></i>
                            Progress
                        </a>
                    </div>
                    
                    <!-- Shopping Section -->
                    <div class="pt-4">
                        <div class="text-gray-400 text-xs font-semibold uppercase tracking-wider px-2 pb-2">Shopping</div>
                        <a href="/student/cart" class="text-gray-300 hover:bg-gray-700 hover:text-white group flex items-center px-2 py-2 text-base font-medium rounded-lg">
                            <i class="fas fa-shopping-cart mr-4 text-sm"></i>
                            <span class="flex-1">Cart</span>
                            <?php if (isset($cartCount) && $cartCount > 0): ?>
                                <span class="bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                                    <?= $cartCount ?>
                                </span>
                            <?php endif; ?>
                        </a>
                        <a href="/student/orders" class="text-gray-300 hover:bg-gray-700 hover:text-white group flex items-center px-2 py-2 text-base font-medium rounded-lg">
                            <i class="fas fa-receipt mr-4 text-sm"></i>
                            Order History
                        </a>
                    </div>
                    
                    <!-- Community Section -->
                    <div class="pt-4">
                        <div class="text-gray-400 text-xs font-semibold uppercase tracking-wider px-2 pb-2">Community</div>
                        <a href="/student/discussions" class="text-gray-300 hover:bg-gray-700 hover:text-white group flex items-center px-2 py-2 text-base font-medium rounded-lg">
                            <i class="fas fa-comments mr-4 text-sm"></i>
                            Discussions
                        </a>
                        <a href="/student/certificates" class="text-gray-300 hover:bg-gray-700 hover:text-white group flex items-center px-2 py-2 text-base font-medium rounded-lg">
                            <i class="fas fa-certificate mr-4 text-sm"></i>
                            Certificates
                        </a>
                    </div>
                </nav>
            </div>
            
            <!-- Mobile Profile Section -->
            <div class="flex-shrink-0 flex border-t border-gray-700 p-4">
                <div class="flex items-center w-full">
                    <div class="flex-shrink-0">
                        <img class="h-10 w-10 rounded-full" src="<?= $_SESSION['user']['avatar'] ?? 'https://ui-avatars.com/api/?name=John+Doe&background=ffffff&color=000000' ?>" alt="Profile">
                    </div>
                    <div class="ml-3 flex-1">
                        <p class="text-base font-medium text-white"><?= htmlspecialchars($_SESSION['user']['name'] ?? 'John Doe') ?></p>
                        <p class="text-sm font-medium text-gray-400">Student</p>
                    </div>
                    <a href="/logout" class="bg-gray-800 p-2 rounded-lg text-gray-400 hover:text-white focus:outline-none focus:ring-2 focus:ring-white">
                        <i class="fas fa-sign-out-alt"></i>
                    </a>
                </div>
            </div>
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