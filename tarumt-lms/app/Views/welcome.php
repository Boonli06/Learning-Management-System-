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
        .hero-gradient {
            background: linear-gradient(135deg, #000000 0%, #374151 50%, #000000 100%);
        }
    </style>
</head>
<body class="h-full antialiased">
    
    <!-- Header -->
    <header class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center">
                    <div class="bg-black rounded-lg p-2 mr-3">
                        <i class="fas fa-graduation-cap text-white text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-gray-900">TARUMT</h1>
                        <p class="text-xs text-gray-500">Learning Management</p>
                    </div>
                </div>
                
                <!-- Navigation -->
                <nav class="hidden md:flex space-x-6">
                    <a href="/login" class="bg-black text-white px-4 py-2 rounded-lg hover:bg-gray-800 transition-colors duration-200">
                        Sign In
                    </a>
                    <a href="/register" class="border border-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                        Register
                    </a>
                </nav>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero-gradient text-white py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-5xl font-bold mb-6">
                Empower Your Learning Journey
            </h1>
            <p class="text-xl mb-8 max-w-3xl mx-auto opacity-90">
                Join thousands of students and instructors in TARUMT's comprehensive learning management system. 
                Experience innovative education with cutting-edge technology.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="/register" class="bg-white text-black px-8 py-3 rounded-lg font-medium hover:bg-gray-100 transition-colors duration-200">
                    Get Started Today
                </a>
                <a href="/login" class="border border-white text-white px-8 py-3 rounded-lg font-medium hover:bg-white hover:text-black transition-colors duration-200">
                    Sign In
                </a>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Why Choose TARUMT LMS?</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">
                    Our learning management system provides everything you need for a successful educational experience.
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center p-6">
                    <div class="w-16 h-16 bg-black rounded-lg flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-users text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Interactive Learning</h3>
                    <p class="text-gray-600">
                        Engage with instructors and peers through discussions, assignments, and real-time collaboration.
                    </p>
                </div>
                
                <div class="text-center p-6">
                    <div class="w-16 h-16 bg-black rounded-lg flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-mobile-alt text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Mobile Friendly</h3>
                    <p class="text-gray-600">
                        Access your courses anytime, anywhere with our responsive design that works on all devices.
                    </p>
                </div>
                
                <div class="text-center p-6">
                    <div class="w-16 h-16 bg-black rounded-lg flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-chart-line text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Progress Tracking</h3>
                    <p class="text-gray-600">
                        Monitor your learning progress with detailed analytics and personalized recommendations.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                <div>
                    <div class="text-3xl font-bold text-gray-900 mb-2">10,000+</div>
                    <div class="text-gray-600">Active Students</div>
                </div>
                <div>
                    <div class="text-3xl font-bold text-gray-900 mb-2">500+</div>
                    <div class="text-gray-600">Courses Available</div>
                </div>
                <div>
                    <div class="text-3xl font-bold text-gray-900 mb-2">100+</div>
                    <div class="text-gray-600">Expert Instructors</div>
                </div>
                <div>
                    <div class="text-3xl font-bold text-gray-900 mb-2">95%</div>
                    <div class="text-gray-600">Satisfaction Rate</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Enhanced Footer -->
    <footer class="bg-gray-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- Logo and Description -->
                <div class="md:col-span-1">
                    <div class="flex items-center mb-4">
                        <div class="bg-white rounded-lg p-2 mr-3">
                            <i class="fas fa-graduation-cap text-black text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold">TARUMT</h3>
                            <p class="text-sm text-gray-400">Learning Management</p>
                        </div>
                    </div>
                    <p class="text-gray-400 text-sm">
                        Empowering students and educators with innovative learning solutions since 1969.
                    </p>
                </div>
                
                <!-- Quick Links -->
                <div>
                    <h4 class="text-lg font-semibold mb-4">Quick Links</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="/" class="text-gray-400 hover:text-white transition-colors duration-200">Home</a></li>
                        <li><a href="/login" class="text-gray-400 hover:text-white transition-colors duration-200">Sign In</a></li>
                        <li><a href="/register" class="text-gray-400 hover:text-white transition-colors duration-200">Register</a></li>
                        <li><a href="/dashboard" class="text-gray-400 hover:text-white transition-colors duration-200">Dashboard</a></li>
                    </ul>
                </div>
                
                <!-- Legal -->
                <div>
                    <h4 class="text-lg font-semibold mb-4">Legal</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="/terms" class="text-gray-400 hover:text-white transition-colors duration-200">Terms of Service</a></li>
                        <li><a href="/privacy" class="text-gray-400 hover:text-white transition-colors duration-200">Privacy Policy</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors duration-200">Cookie Policy</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors duration-200">Academic Integrity</a></li>
                    </ul>
                </div>
                
                <!-- Contact -->
                <div>
                    <h4 class="text-lg font-semibold mb-4">Contact Us</h4>
                    <div class="space-y-2 text-sm">
                        <div class="flex items-center">
                            <i class="fas fa-envelope w-4 mr-2 text-gray-400"></i>
                            <a href="mailto:support@tarumt.edu" class="text-gray-400 hover:text-white transition-colors duration-200">support@tarumt.edu</a>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-phone w-4 mr-2 text-gray-400"></i>
                            <a href="tel:+60312345678" class="text-gray-400 hover:text-white transition-colors duration-200">+603 1234 5678</a>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-map-marker-alt w-4 mr-2 text-gray-400"></i>
                            <span class="text-gray-400">Kuala Lumpur, Malaysia</span>
                        </div>
                    </div>
                    
                    <!-- Social Media -->
                    <div class="mt-4">
                        <h5 class="text-sm font-medium mb-2">Follow Us</h5>
                        <div class="flex space-x-3">
                            <a href="#" class="text-gray-400 hover:text-white transition-colors duration-200">
                                <i class="fab fa-facebook text-lg"></i>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-white transition-colors duration-200">
                                <i class="fab fa-twitter text-lg"></i>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-white transition-colors duration-200">
                                <i class="fab fa-linkedin text-lg"></i>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-white transition-colors duration-200">
                                <i class="fab fa-youtube text-lg"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Bottom Bar -->
            <div class="border-t border-gray-800 mt-8 pt-8 flex flex-col md:flex-row justify-between items-center">
                <div class="text-sm text-gray-400">
                    &copy; <?= date('Y') ?> Tunku Abdul Rahman University of Management and Technology. All rights reserved.
                </div>
                <div class="flex space-x-6 mt-4 md:mt-0">
                    <a href="/terms" class="text-sm text-gray-400 hover:text-white transition-colors duration-200">Terms</a>
                    <a href="/privacy" class="text-sm text-gray-400 hover:text-white transition-colors duration-200">Privacy</a>
                    <a href="#" class="text-sm text-gray-400 hover:text-white transition-colors duration-200">Accessibility</a>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>