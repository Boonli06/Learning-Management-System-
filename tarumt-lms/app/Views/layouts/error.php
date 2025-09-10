<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Error - TARUMT LMS' ?></title>
    
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
        .error-animation {
            animation: float 3s ease-in-out infinite;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
    </style>
</head>
<body class="h-full bg-gray-50">
    <div class="min-h-full flex flex-col">
        <!-- Header with Logo -->
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
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-1 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
            <div class="max-w-md w-full text-center">
                <?= $content ?>
            </div>
        </main>

        <!-- Footer -->
        <footer class="bg-white border-t">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <div class="flex items-center space-x-6 mb-4 md:mb-0">
                        <a href="mailto:support@tarumt.edu" class="text-sm text-gray-600 hover:text-gray-900 transition-colors duration-200">
                            <i class="fas fa-envelope mr-2"></i>Support
                        </a>
                        <a href="tel:+60312345678" class="text-sm text-gray-600 hover:text-gray-900 transition-colors duration-200">
                            <i class="fas fa-phone mr-2"></i>Help Center
                        </a>
                    </div>
                    <div class="text-sm text-gray-500">
                        © <?= date('Y') ?> TARUMT. All rights reserved.
                    </div>
                </div>
            </div>
        </footer>
    </div>
</body>
</html>