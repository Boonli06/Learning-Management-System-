<?php
$title = '405 - Method Not Allowed | TARUMT LMS';
ob_start();
?>

<div class="space-y-8">
    <!-- Error Icon -->
    <div class="error-animation">
        <div class="w-24 h-24 mx-auto bg-yellow-100 rounded-full flex items-center justify-center">
            <i class="fas fa-ban text-3xl text-yellow-500"></i>
        </div>
    </div>
    
    <!-- Error Code -->
    <div>
        <h1 class="text-6xl font-bold text-gray-900 mb-2">405</h1>
        <h2 class="text-2xl font-semibold text-gray-700 mb-4">Method Not Allowed</h2>
        <p class="text-gray-600 leading-relaxed">
            The request method is not supported for this page. Please try using a different approach or return to the homepage.
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