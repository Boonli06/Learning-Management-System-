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
        .logo-gradient {
            background: linear-gradient(135deg, #000000 0%, #374151 100%);
        }
    </style>
</head>
<body class="h-full antialiased">
    <div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4">
        <!-- Left Panel - Form -->
        <div class="w-full max-w-4xl bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="grid grid-cols-1 lg:grid-cols-2 min-h-[600px]">
            <div class="p-8 lg:p-12">
                <div class="w-full">
                
                <!-- Logo Section -->
                <div class="flex flex-col items-center mb-8">
                    <div class="flex items-center mb-4">
                        <div class="logo-gradient rounded-xl p-3 mr-3">
                            <i class="fas fa-graduation-cap text-white text-2xl"></i>
                        </div>
                        <div class="text-left">
                            <h1 class="text-2xl font-bold text-gray-900">TARUMT</h1>
                            <p class="text-sm text-gray-500 font-medium">Learning Management</p>
                        </div>
                    </div>
                </div>

                <!-- Alert Messages using Flowbite -->
                <?php if (isset($_SESSION['error'])): ?>
                    <div id="alert-error" class="flex items-center p-4 mb-4 text-red-800 rounded-lg bg-red-50 border border-red-200" role="alert">
                        <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                        </svg>
                        <span class="sr-only">Error</span>
                        <div class="ml-3 text-sm font-medium">
                            <?= htmlspecialchars($_SESSION['error']) ?>
                        </div>
                        <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-red-50 text-red-500 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-red-200 inline-flex items-center justify-center h-8 w-8" data-dismiss-target="#alert-error" aria-label="Close">
                            <span class="sr-only">Close</span>
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                            </svg>
                        </button>
                    </div>
                    <?php unset($_SESSION['error']); ?>
                <?php endif; ?>

                <?php if (isset($_SESSION['success'])): ?>
                    <div id="alert-success" class="flex items-center p-4 mb-4 text-green-800 rounded-lg bg-green-50 border border-green-200" role="alert">
                        <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM10 15a1 1 0 1 1 0-2 1 1 0 0 1 0 2Zm0-4a1 1 0 0 1-1-1V6a1 1 0 0 1 2 0v4a1 1 0 0 1-1 1Z"/>
                        </svg>
                        <span class="sr-only">Success</span>
                        <div class="ml-3 text-sm font-medium">
                            <?= htmlspecialchars($_SESSION['success']) ?>
                        </div>
                        <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex items-center justify-center h-8 w-8" data-dismiss-target="#alert-success" aria-label="Close">
                            <span class="sr-only">Close</span>
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                            </svg>
                        </button>
                    </div>
                    <?php unset($_SESSION['success']); ?>
                <?php endif; ?>

                <!-- Page Title -->
                <div class="mb-8">
                    <h2 class="text-3xl font-bold text-gray-900 tracking-tight"><?= $pageTitle ?? 'Welcome' ?></h2>
                    <p class="mt-2 text-sm text-gray-600"><?= $pageSubtitle ?? 'Please sign in to continue' ?></p>
                </div>

                <!-- Main Content -->
                <?= $content ?>
                
                </div>
            </div>
            
            <!-- 右侧信息区域 -->
            <div class="bg-gray-50 p-8 lg:p-12 flex flex-col justify-center">
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Welcome to TARUMT LMS</h3>
                <p class="text-gray-600 mb-6">Join our comprehensive learning management system designed for modern education.</p>
                
                <div class="space-y-4">
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-black rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-check text-white text-sm"></i>
                        </div>
                        <span class="text-gray-700">Interactive learning experiences</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-black rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-check text-white text-sm"></i>
                        </div>
                        <span class="text-gray-700">Expert instructors and mentors</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-black rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-check text-white text-sm"></i>
                        </div>
                        <span class="text-gray-700">Flexible learning schedules</span>
                    </div>
                </div>
                
                <div class="mt-8 pt-6 border-t border-gray-200">
                    <p class="text-sm text-gray-500 mb-2">Need help?</p>
                    <p class="text-sm text-gray-700">Contact us at <a href="mailto:support@tarumt.edu" class="text-black underline">support@tarumt.edu</a></p>
                </div>
            </div>
        </div>

    </div>
</body>
</html>