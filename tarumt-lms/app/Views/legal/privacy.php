<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'TARUMT LMS' ?></title>
    
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
        .prose { max-width: none; }
        .prose h2 { margin-top: 2rem; margin-bottom: 1rem; }
        .prose h3 { margin-top: 1.5rem; margin-bottom: 0.75rem; }
    </style>
</head>
<body class="h-full antialiased">
    <!-- Header -->
    <header class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center">
                    <a href="/" class="flex items-center">
                        <div class="bg-black rounded-lg p-2 mr-3">
                            <i class="fas fa-graduation-cap text-white text-xl"></i>
                        </div>
                        <div>
                            <h1 class="text-xl font-bold text-gray-900">TARUMT</h1>
                            <p class="text-xs text-gray-500">Learning Management</p>
                        </div>
                    </a>
                </div>
                
                <!-- Navigation Links -->
                <nav class="hidden md:flex space-x-6">
                    <a href="/" class="text-gray-600 hover:text-gray-900 transition-colors duration-200">Home</a>
                    <a href="/login" class="text-gray-600 hover:text-gray-900 transition-colors duration-200">Sign In</a>
                    <a href="/register" class="text-gray-600 hover:text-gray-900 transition-colors duration-200">Register</a>
                </nav>
                
                <!-- Mobile menu button -->
                <button type="button" class="md:hidden p-2 rounded-md text-gray-400 hover:text-gray-500" onclick="toggleMobileMenu()">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
            
            <!-- Mobile menu -->
            <div id="mobile-menu" class="hidden md:hidden pb-4">
                <div class="space-y-2">
                    <a href="/" class="block px-3 py-2 text-gray-600 hover:text-gray-900">Home</a>
                    <a href="/login" class="block px-3 py-2 text-gray-600 hover:text-gray-900">Sign In</a>
                    <a href="/register" class="block px-3 py-2 text-gray-600 hover:text-gray-900">Register</a>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-5xl mx-auto py-8 px-4 sm:px-6 lg:px-8" style="max-width: 80%;">
        <!-- Breadcrumb -->
        <nav class="flex mb-8" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="/" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-black">
                        <i class="fas fa-home mr-2"></i>
                        Home
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                        <span class="text-sm font-medium text-gray-500"><?= $pageTitle ?? 'Legal' ?></span>
                    </div>
                </li>
            </ol>
        </nav>

        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2"><?= $pageTitle ?? 'Legal Document' ?></h1>
            <p class="text-gray-600"><?= $pageSubtitle ?? 'Important legal information' ?></p>
            <div class="mt-4 text-sm text-gray-500">
                Last updated: <?= date('F j, Y') ?>
            </div>
        </div>

        <!-- Content -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-8">
            <div class="prose prose-gray max-w-none">
                <?= $content ?>
            </div>
        </div>

        <!-- Quick Links -->
        <div class="mt-8 bg-gray-50 rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Related Documents</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <a href="/terms" class="flex items-center p-3 bg-white rounded-lg border border-gray-200 hover:border-gray-300 transition-colors duration-200">
                    <i class="fas fa-file-contract text-gray-400 mr-3"></i>
                    <div>
                        <div class="text-sm font-medium text-gray-900">Terms of Service</div>
                        <div class="text-xs text-gray-500">User agreements and terms</div>
                    </div>
                </a>
                <a href="/privacy" class="flex items-center p-3 bg-white rounded-lg border border-gray-200 hover:border-gray-300 transition-colors duration-200">
                    <i class="fas fa-shield-alt text-gray-400 mr-3"></i>
                    <div>
                        <div class="text-sm font-medium text-gray-900">Privacy Policy</div>
                        <div class="text-xs text-gray-500">Data protection and privacy</div>
                    </div>
                </a>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t mt-12">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="flex items-center space-x-6 mb-4 md:mb-0">
                    <a href="mailto:legal@tarumt.edu" class="text-sm text-gray-600 hover:text-gray-900 transition-colors duration-200">
                        <i class="fas fa-envelope mr-2"></i>Legal Team
                    </a>
                    <a href="mailto:support@tarumt.edu" class="text-sm text-gray-600 hover:text-gray-900 transition-colors duration-200">
                        <i class="fas fa-life-ring mr-2"></i>Support
                    </a>
                </div>
                <div class="text-sm text-gray-500">
                    &copy; <?= date('Y') ?> TARUMT. All rights reserved.
                </div>
            </div>
        </div>
    </footer>

    <script>
    function toggleMobileMenu() {
        const menu = document.getElementById('mobile-menu');
        menu.classList.toggle('hidden');
    }
    </script>
</body>
</html>