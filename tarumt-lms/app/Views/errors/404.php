<?php
$title = '404 - Page Not Found | TARUMT LMS';
ob_start();
?>

<div class="space-y-8">
    <!-- Error Icon -->
    <div class="error-animation">
        <div class="w-24 h-24 mx-auto bg-gray-100 rounded-full flex items-center justify-center">
            <i class="fas fa-search text-3xl text-gray-400"></i>
        </div>
    </div>
    
    <!-- Error Code -->
    <div>
        <h1 class="text-6xl font-bold text-gray-900 mb-2">404</h1>
        <h2 class="text-2xl font-semibold text-gray-700 mb-4">Page not found</h2>
        <p class="text-gray-600 leading-relaxed">
            Sorry, we couldn't find the page you're looking for. The page may have been moved, deleted, or the URL might be incorrect.
        </p>
    </div>

    <!-- Action Buttons -->
    <div class="space-y-4">
        <!-- Primary Action -->
        <a href="/" class="w-full inline-flex justify-center items-center px-6 py-3 border border-transparent text-base font-medium rounded-lg text-white bg-black hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black transition-colors duration-200">
            <i class="fas fa-home mr-2"></i>
            Go to Homepage
        </a>
        
        <!-- Secondary Actions -->
        <div class="flex flex-col sm:flex-row gap-3">
            <button onclick="goBack()" class="flex-1 inline-flex justify-center items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black transition-colors duration-200">
                <i class="fas fa-arrow-left mr-2"></i>
                Go Back
            </button>
            <a href="/login" class="flex-1 inline-flex justify-center items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black transition-colors duration-200">
                <i class="fas fa-sign-in-alt mr-2"></i>
                Sign In
            </a>
        </div>
    </div>

    <!-- Help Section -->
    <div class="mt-8 p-4 bg-gray-50 rounded-lg border border-gray-200">
        <h3 class="text-sm font-medium text-gray-900 mb-2">Looking for something specific?</h3>
        <div class="space-y-2 text-sm text-gray-600">
            <div class="flex items-center">
                <i class="fas fa-user-graduate w-4 mr-2 text-gray-400"></i>
                <a href="/login" class="text-black hover:underline">Student Portal</a>
            </div>
            <div class="flex items-center">
                <i class="fas fa-chalkboard-teacher w-4 mr-2 text-gray-400"></i>
                <a href="/login" class="text-black hover:underline">Instructor Dashboard</a>
            </div>
            <div class="flex items-center">
                <i class="fas fa-user-plus w-4 mr-2 text-gray-400"></i>
                <a href="/register" class="text-black hover:underline">Create Account</a>
            </div>
            <div class="flex items-center">
                <i class="fas fa-question-circle w-4 mr-2 text-gray-400"></i>
                <a href="mailto:support@tarumt.edu" class="text-black hover:underline">Contact Support</a>
            </div>
        </div>
    </div>
</div>

<script>
function goBack() {
    if (window.history.length > 1) {
        window.history.back();
    } else {
        window.location.href = '/';
    }
}
</script>

<?php
$content = ob_get_clean();
include '../app/Views/layouts/error.php';
?>