<?php
ob_start();
?>

<!-- Login Form -->
<form class="space-y-6" action="/login" method="POST" id="loginForm">
    
    <!-- Email Input using Flowbite -->
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
                placeholder="name@tarumt.edu" 
                value="student@tarumt.edu"
                required
            >
        </div>
    </div>

    <!-- Password Input using Flowbite -->
    <div>
        <label for="password" class="block mb-2 text-sm font-medium text-gray-900">Password</label>
        <div class="relative">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 20">
                    <path d="M14 7h-1V4a5 5 0 1 0-10 0v3H2a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2ZM5 4a3 3 0 1 1 6 0v3H5V4Z"/>
                </svg>
            </div>
            <input 
                type="password" 
                id="password" 
                name="password"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-black focus:border-black block w-full pl-10 pr-10 p-2.5 transition-colors duration-200" 
                placeholder="••••••••" 
                value="password"
                required
            >
            <button 
                type="button" 
                class="absolute inset-y-0 right-0 flex items-center pr-3.5"
                onclick="togglePasswordVisibility()"
            >
                <svg id="eyeIcon" class="w-4 h-4 text-gray-500 hover:text-gray-700 cursor-pointer" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 14">
                    <g stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                        <path d="M10 10a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"/>
                        <path d="M10 13c4.97 0 9-2.686 9-6s-4.03-6-9-6-9 2.686-9 6 4.03 6 9 6Z"/>
                    </g>
                </svg>
            </button>
        </div>
    </div>

    <!-- Remember Me & Forgot Password -->
    <div class="flex items-center justify-between">
        <div class="flex items-start">
            <div class="flex items-center h-5">
                <input 
                    id="remember" 
                    name="remember"
                    type="checkbox" 
                    value="" 
                    class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-gray-300 text-black"
                >
            </div>
            <label for="remember" class="ml-2 text-sm font-medium text-gray-900">Remember me</label>
        </div>
        <a href="/forgot-password" class="text-sm text-black hover:underline font-medium">Forgot password?</a>
    </div>

    <!-- Submit Button using Flowbite -->
    <button 
        type="submit" 
        class="w-full text-white bg-black hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center transition-colors duration-200"
    >
        <span class="flex items-center justify-center">
            <svg class="w-4 h-4 mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
            </svg>
            Sign in
        </span>
    </button>

    <!-- Divider -->
    <div class="flex items-center my-6">
        <div class="flex-1 border-t border-gray-300"></div>
        <div class="px-3 text-gray-500 text-sm">Or continue with</div>
        <div class="flex-1 border-t border-gray-300"></div>
    </div>

    <!-- Google OAuth Button using Flowbite -->
    <button 
        type="button" 
        class="w-full text-gray-900 bg-white hover:bg-gray-100 border border-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center justify-center transition-colors duration-200"
        onclick="handleGoogleLogin()"
    >
        <svg class="w-4 h-4 mr-2" viewBox="0 0 24 24">
            <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
            <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
            <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
            <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
</svg>
        Continue with Google
    </button>

</form>

<!-- Sign Up Link -->
<div class="mt-8 text-center">
    <p class="text-sm text-gray-600">
        Don't have an account? 
        <a href="/register" class="font-medium text-black hover:text-gray-700 underline">
            Create account
        </a>
    </p>
</div>

<!-- Demo Credentials Card using Flowbite -->
<div class="mt-6 p-4 bg-gray-50 border border-gray-200 rounded-lg">
    <div class="flex items-center mb-2">
        <svg class="w-4 h-4 text-gray-500 mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
        </svg>
        <h4 class="text-sm font-medium text-gray-700">Demo Credentials</h4>
    </div>
    <div class="space-y-2 text-xs text-gray-600">
        <div class="flex justify-between">
            <span class="font-medium">Student:</span>
            <span class="font-mono">student@tarumt.edu</span>
        </div>
        <div class="flex justify-between">
            <span class="font-medium">Instructor:</span>
            <span class="font-mono">instructor@tarumt.edu</span>
        </div>
        <div class="flex justify-between">
            <span class="font-medium">Admin:</span>
            <span class="font-mono">admin@tarumt.edu</span>
        </div>
        <div class="flex justify-between">
            <span class="font-medium">Password:</span>
            <span class="font-mono">password</span>
        </div>
    </div>
</div>

<script>
function togglePasswordVisibility() {
    const passwordInput = document.getElementById('password');
    const eyeIcon = document.getElementById('eyeIcon');
    
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        eyeIcon.innerHTML = `<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1l6 6m0 0l6 6M7 7l6-6M7 7l-6 6"/><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1l18 18"/>`;
    } else {
        passwordInput.type = 'password';
        eyeIcon.innerHTML = `<g stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><path d="M10 10a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"/><path d="M10 13c4.97 0 9-2.686 9-6s-4.03-6-9-6-9 2.686-9 6 4.03 6 9 6Z"/></g>`;
    }
}

function handleGoogleLogin() {
    // Placeholder for Google OAuth integration
    alert('Google OAuth integration would be implemented here');
}

// Auto-focus email field on page load
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('email').focus();
});

// Form validation
document.getElementById('loginForm').addEventListener('submit', function(e) {
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
    
    if (!email || !password) {
        e.preventDefault();
        alert('Please fill in all fields');
        return false;
    }
    
    if (!email.includes('@')) {
        e.preventDefault();
        alert('Please enter a valid email address');
        return false;
    }
});
</script>

<?php
$content = ob_get_clean();
include '../app/Views/layouts/auth.php';
?>