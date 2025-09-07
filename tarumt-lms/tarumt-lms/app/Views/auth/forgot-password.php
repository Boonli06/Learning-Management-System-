<?php
ob_start();
?>

<!-- Forgot Password Form -->
<form class="space-y-6" action="/forgot-password" method="POST" id="forgotPasswordForm">
    
    <!-- Info Card -->
    <div class="p-4 mb-6 text-sm text-blue-800 rounded-lg bg-blue-50 border border-blue-200" role="alert">
        <div class="flex items-center">
            <svg class="flex-shrink-0 inline w-4 h-4 mr-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
            </svg>
            <div>
                <span class="font-medium">Password Reset Instructions</span>
                <p class="mt-1">Enter your email address and we'll send you a link to reset your password.</p>
            </div>
        </div>
    </div>

    <!-- Email Input -->
    <div>
        <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Email address</label>
        <div class="relative">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 16">
                    <path d="m10.036 8.278 9.258-7.79A1.979 1.979 0 0 0 18 0H2A1.987 1.987 0 0 0 .641.541l9.395 7.737Z"/>
                    <path d="M11.241 9.817c-.36.275-.801.425-1.255.427-.428 0-.845-.138-1.187-.395L0 2.6V14a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V2.5l-8.759 7.317Z"/>
                </svg>
            </div>
            <input 
                type="email" 
                id="email" 
                name="email"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-black focus:border-black block w-full pl-10 p-2.5 transition-colors duration-200" 
                placeholder="Enter your email address" 
                required
            >
        </div>
        <p class="mt-2 text-xs text-gray-500">We'll send reset instructions to this email address.</p>
    </div>

    <!-- Submit Button -->
    <button 
        type="submit" 
        class="w-full text-white bg-black hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center transition-colors duration-200"
    >
        <span class="flex items-center justify-center">
            <svg class="w-4 h-4 mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 20">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 1v5h-5M2 19v-5h5m10-4a8 8 0 0 1-14.947 3.97M1 10a8 8 0 0 1 14.947-3.97"/>
            </svg>
            Send reset instructions
        </span>
    </button>

</form>

<!-- Back to Login -->
<div class="mt-8 text-center">
    <a href="/login" class="inline-flex items-center text-sm font-medium text-black hover:text-gray-700 transition-colors duration-200">
        <svg class="w-4 h-4 mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5H1m0 0l4 4M1 5l4-4"/>
        </svg>
        Back to sign in
    </a>
</div>

<!-- Help Section -->
<div class="mt-8 p-4 bg-gray-50 border border-gray-200 rounded-lg">
    <h4 class="text-sm font-medium text-gray-900 mb-2">Need help?</h4>
    <div class="space-y-2 text-sm text-gray-600">
        <p>• Check your spam/junk folder if you don't receive the email</p>
        <p>• Reset links expire after 24 hours for security</p>
        <p>• Contact support if you continue having issues</p>
    </div>
    <div class="mt-3">
        <a href="mailto:support@tarumt.edu" class="text-sm text-black hover:underline font-medium">
            Contact Support
        </a>
    </div>
</div>

<script>
// Form validation
document.getElementById('forgotPasswordForm').addEventListener('submit', function(e) {
    const email = document.getElementById('email').value.trim();
    
    if (!email) {
        e.preventDefault();
        alert('Please enter your email address');
        return false;
    }
    
    if (!email.includes('@')) {
        e.preventDefault();
        alert('Please enter a valid email address');
        return false;
    }
});

// Auto-focus email field on page load
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('email').focus();
});
</script>

<?php
$content = ob_get_clean();
include '../app/Views/layouts/auth.php';
?>