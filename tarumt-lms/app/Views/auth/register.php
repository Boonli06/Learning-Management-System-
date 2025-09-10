<?php
ob_start();
?>

<!-- Registration Form -->
<form class="space-y-5" action="/register" method="POST" id="registerForm">
    
    <!-- Name Fields Row -->
    <div class="grid grid-cols-2 gap-4">
        <!-- First Name -->
        <div>
            <label for="first_name" class="block mb-2 text-sm font-medium text-gray-900">First name</label>
            <input 
                type="text" 
                id="first_name" 
                name="first_name"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-black focus:border-black block w-full p-2.5 transition-colors duration-200" 
                placeholder="John" 
                required
            >
        </div>
        
        <!-- Last Name -->
        <div>
            <label for="last_name" class="block mb-2 text-sm font-medium text-gray-900">Last name</label>
            <input 
                type="text" 
                id="last_name" 
                name="last_name"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-black focus:border-black block w-full p-2.5 transition-colors duration-200" 
                placeholder="Doe" 
                required
            >
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
                placeholder="name@tarumt.edu" 
                required
            >
        </div>
    </div>

    <!-- Role Selection using Flowbite -->
    <div>
        <label for="role" class="block mb-2 text-sm font-medium text-gray-900">I am a</label>
        <select 
            id="role" 
            name="role"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-black focus:border-black block w-full p-2.5 transition-colors duration-200"
            required
        >
            <option value="student" selected>Student</option>
            <option value="instructor">Instructor</option>
        </select>
    </div>

    <!-- Password Fields -->
    <div class="grid grid-cols-1 gap-4">
        <!-- Password -->
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
                    required
                    minlength="8"
                >
                <button 
                    type="button" 
                    class="absolute inset-y-0 right-0 flex items-center pr-3.5"
                    onclick="togglePasswordVisibility('password')"
                >
                    <svg id="passwordEyeIcon" class="w-4 h-4 text-gray-500 hover:text-gray-700 cursor-pointer" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 14">
                        <g stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                            <path d="M10 10a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"/>
                            <path d="M10 13c4.97 0 9-2.686 9-6s-4.03-6-9-6-9 2.686-9 6 4.03 6 9 6Z"/>
                        </g>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="confirm_password" class="block mb-2 text-sm font-medium text-gray-900">Confirm password</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 20">
                        <path d="M14 7h-1V4a5 5 0 1 0-10 0v3H2a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2ZM5 4a3 3 0 1 1 6 0v3H5V4Z"/>
                    </svg>
                </div>
                <input 
                    type="password" 
                    id="confirm_password" 
                    name="confirm_password"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-black focus:border-black block w-full pl-10 pr-10 p-2.5 transition-colors duration-200" 
                    placeholder="••••••••" 
                    required
                    minlength="8"
                >
                <button 
                    type="button" 
                    class="absolute inset-y-0 right-0 flex items-center pr-3.5"
                    onclick="togglePasswordVisibility('confirm_password')"
                >
                    <svg id="confirmPasswordEyeIcon" class="w-4 h-4 text-gray-500 hover:text-gray-700 cursor-pointer" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 14">
                        <g stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                            <path d="M10 10a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"/>
                            <path d="M10 13c4.97 0 9-2.686 9-6s-4.03-6-9-6-9 2.686-9 6 4.03 6 9 6Z"/>
                        </g>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Password Requirements -->
    <div class="p-3 bg-gray-50 rounded-lg border border-gray-200">
        <p class="text-xs text-gray-600 mb-2 font-medium">Password requirements:</p>
        <ul class="text-xs text-gray-500 space-y-1">
            <li class="flex items-center">
                <svg class="w-3 h-3 text-gray-400 mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 12">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5.917 5.724 10.5 15 1.5"/>
                </svg>
                At least 8 characters long
            </li>
            <li class="flex items-center">
                <svg class="w-3 h-3 text-gray-400 mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 12">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5.917 5.724 10.5 15 1.5"/>
                </svg>
                Contains uppercase and lowercase letters
            </li>
            <li class="flex items-center">
                <svg class="w-3 h-3 text-gray-400 mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 12">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5.917 5.724 10.5 15 1.5"/>
                </svg>
                Contains at least one number
            </li>
        </ul>
    </div>

    <!-- Terms Agreement -->
    <div class="flex items-start">
        <div class="flex items-center h-5">
            <input 
                id="terms" 
                name="terms"
                type="checkbox" 
                value="" 
                class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-gray-300 text-black"
                required
            >
        </div>
        <label for="terms" class="ml-2 text-sm font-medium text-gray-900">
            I agree to the 
            <a href="#" class="text-black hover:underline font-medium" onclick="openTermsModal()">Terms of Service</a> 
            and 
            <a href="#" class="text-black hover:underline font-medium" onclick="openPrivacyModal()">Privacy Policy</a>
        </label>
    </div>

    <!-- Submit Button -->
    <button 
        type="submit" 
        class="w-full text-white bg-black hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center transition-colors duration-200"
    >
        <span class="flex items-center justify-center">
            <svg class="w-4 h-4 mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 15">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 7.5h11m0 0L8 3.786M12 7.5l-4 3.714M12 1h3c.53 0 1.04.196 1.414.544.375.348.586.82.586 1.313v9.286c0 .492-.21.965-.586 1.313A2.081 2.081 0 0 1 15 14h-3"/>
            </svg>
            Create account
        </span>
    </button>

    <!-- Divider -->
    <div class="flex items-center my-6">
        <div class="flex-1 border-t border-gray-300"></div>
        <div class="px-3 text-gray-500 text-sm">Or sign up with</div>
        <div class="flex-1 border-t border-gray-300"></div>
    </div>

    <!-- Google OAuth Button -->
    <button 
        type="button" 
        class="w-full text-gray-900 bg-white hover:bg-gray-100 border border-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center justify-center transition-colors duration-200"
        onclick="handleGoogleSignup()"
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

<!-- Sign In Link -->
<div class="mt-8 text-center">
    <p class="text-sm text-gray-600">
        Already have an account? 
        <a href="/login" class="font-medium text-black hover:text-gray-700 underline">
            Sign in here
        </a>
    </p>
</div>

<script>
function togglePasswordVisibility(fieldId) {
    const passwordInput = document.getElementById(fieldId);
    const eyeIcon = document.getElementById(fieldId === 'password' ? 'passwordEyeIcon' : 'confirmPasswordEyeIcon');
    
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        eyeIcon.innerHTML = `<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1l6 6m0 0l6 6M7 7l6-6M7 7l-6 6"/><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1l18 18"/>`;
    } else {
        passwordInput.type = 'password';
        eyeIcon.innerHTML = `<g stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><path d="M10 10a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"/><path d="M10 13c4.97 0 9-2.686 9-6s-4.03-6-9-6-9 2.686-9 6 4.03 6 9 6Z"/></g>`;
    }
}

function handleGoogleSignup() {
    alert('Google OAuth integration would be implemented here');
}

// Real-time password validation
function checkPasswordRequirements(password) {
    const requirements = {
        length: password.length >= 8,
        uppercase: /[A-Z]/.test(password),
        lowercase: /[a-z]/.test(password),
        number: /\d/.test(password)
    };
    
    // Update visual indicators
    Object.keys(requirements).forEach(req => {
        const element = document.getElementById(req + '-check');
        const svg = element.querySelector('svg');
        const text = element.querySelector('svg').nextSibling;
        
        if (requirements[req]) {
            element.classList.add('text-green-600');
            element.classList.remove('text-gray-500');
            svg.classList.add('text-green-600');
            svg.classList.remove('text-gray-400');
        } else {
            element.classList.remove('text-green-600');
            element.classList.add('text-gray-500');
            svg.classList.remove('text-green-600');
            svg.classList.add('text-gray-400');
        }
    });
    
    return Object.values(requirements).every(Boolean);
}

// Password input event listener
document.addEventListener('DOMContentLoaded', function() {
    const passwordInput = document.getElementById('password');
    const confirmPasswordInput = document.getElementById('confirm_password');
    
    passwordInput.addEventListener('input', function() {
        checkPasswordRequirements(this.value);
        
        // Also check confirm password if it has a value
        if (confirmPasswordInput.value) {
            validatePasswordMatch();
        }
    });
    
    // Auto-focus first name field on page load
    document.getElementById('first_name').focus();
});

// Form validation
document.getElementById('registerForm').addEventListener('submit', function(e) {
    const firstName = document.getElementById('first_name').value.trim();
    const lastName = document.getElementById('last_name').value.trim();
    const email = document.getElementById('email').value.trim();
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirm_password').value;
    const terms = document.getElementById('terms').checked;
    
    // Basic validation
    if (!firstName || !lastName || !email || !password || !confirmPassword) {
        e.preventDefault();
        alert('Please fill in all fields');
        return false;
    }
    
    if (!email.includes('@')) {
        e.preventDefault();
        alert('Please enter a valid email address');
        return false;
    }
    
    if (password.length < 8) {
        e.preventDefault();
        alert('Password must be at least 8 characters long');
        return false;
    }
    
    if (password !== confirmPassword) {
        e.preventDefault();
        alert('Passwords do not match');
        return false;
    }
    
    if (!terms) {
        e.preventDefault();
        alert('Please agree to the Terms of Service and Privacy Policy');
        return false;
    }
});

// Real-time password confirmation validation
document.getElementById('confirm_password').addEventListener('input', function() {
    const password = document.getElementById('password').value;
    const confirmPassword = this.value;
    
    if (confirmPassword && password !== confirmPassword) {
        this.setCustomValidity('Passwords do not match');
        this.classList.add('border-red-500');
        this.classList.remove('border-gray-300');
    } else {
        this.setCustomValidity('');
        this.classList.remove('border-red-500');
        this.classList.add('border-gray-300');
    }
});

// Auto-focus first name field on page load
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('first_name').focus();
});
</script>

<?php
$content = ob_get_clean();
include '../app/Views/layouts/auth.php';
?>