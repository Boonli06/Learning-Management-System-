<?php
ob_start();
?>

<!-- Reset Password Form -->
<form class="space-y-6" action="/reset-password" method="POST" id="resetPasswordForm">
    
    <!-- Hidden Token Field -->
    <input type="hidden" name="token" value="<?= htmlspecialchars($token ?? '') ?>">
    
    <!-- Success Info Card -->
    <div class="p-4 mb-6 text-sm text-green-800 rounded-lg bg-green-50 border border-green-200" role="alert">
        <div class="flex items-center">
            <svg class="flex-shrink-0 inline w-4 h-4 mr-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
            </svg>
            <div>
                <span class="font-medium">Valid Reset Link</span>
                <p class="mt-1">Your password reset link is valid. Please enter your new password below.</p>
            </div>
        </div>
    </div>

    <!-- New Password Field -->
    <div>
        <label for="password" class="block mb-2 text-sm font-medium text-gray-900">New password</label>
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
                placeholder="Enter your new password" 
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

    <!-- Confirm New Password Field -->
    <div>
        <label for="confirm_password" class="block mb-2 text-sm font-medium text-gray-900">Confirm new password</label>
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
                placeholder="Confirm your new password" 
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

    <!-- Password Requirements -->
    <div class="p-3 bg-gray-50 rounded-lg border border-gray-200">
        <p class="text-xs text-gray-600 mb-2 font-medium">Password requirements:</p>
        <ul class="text-xs text-gray-500 space-y-1">
            <li id="length-check" class="flex items-center">
                <svg class="w-3 h-3 text-gray-400 mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 12">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5.917 5.724 10.5 15 1.5"/>
                </svg>
                At least 8 characters long
            </li>
            <li id="uppercase-check" class="flex items-center">
                <svg class="w-3 h-3 text-gray-400 mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 12">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5.917 5.724 10.5 15 1.5"/>
                </svg>
                Contains uppercase letter
            </li>
            <li id="lowercase-check" class="flex items-center">
                <svg class="w-3 h-3 text-gray-400 mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 12">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5.917 5.724 10.5 15 1.5"/>
                </svg>
                Contains lowercase letter
            </li>
            <li id="number-check" class="flex items-center">
                <svg class="w-3 h-3 text-gray-400 mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 12">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5.917 5.724 10.5 15 1.5"/>
                </svg>
                Contains at least one number
            </li>
        </ul>
    </div>

    <!-- Password Strength Indicator -->
    <div>
        <div class="flex justify-between items-center mb-1">
            <span class="text-xs font-medium text-gray-700">Password strength</span>
            <span id="strength-text" class="text-xs text-gray-500">Enter password</span>
        </div>
        <div class="w-full bg-gray-200 rounded-full h-2">
            <div id="strength-bar" class="h-2 rounded-full transition-all duration-300 bg-gray-300" style="width: 0%"></div>
        </div>
    </div>

    <!-- Submit Button -->
    <button 
        type="submit" 
        id="submitButton"
        class="w-full text-white bg-black hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center transition-colors duration-200 disabled:opacity-50 disabled:cursor-not-allowed"
        disabled
    >
        <span class="flex items-center justify-center">
            <svg class="w-4 h-4 mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 20">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 1v5h-5M2 19v-5h5m10-4a8 8 0 0 1-14.947 3.97M1 10a8 8 0 0 1 14.947-3.97"/>
            </svg>
            Reset password
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

<!-- Security Notice -->
<div class="mt-6 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
    <div class="flex items-center">
        <svg class="flex-shrink-0 w-4 h-4 text-yellow-600 mr-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM10 15a1 1 0 1 1 0-2 1 1 0 0 1 0 2Zm0-4a1 1 0 0 1-1-1V6a1 1 0 0 1 2 0v4a1 1 0 0 1-1 1Z"/>
        </svg>
        <div>
            <h4 class="text-sm font-medium text-yellow-800">Security Notice</h4>
            <p class="text-xs text-yellow-700 mt-1">
                After resetting your password, you'll be signed out of all devices for security.
            </p>
        </div>
    </div>
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

function checkPasswordStrength(password) {
    let score = 0;
    const checks = {
        length: password.length >= 8,
        uppercase: /[A-Z]/.test(password),
        lowercase: /[a-z]/.test(password),
        number: /\d/.test(password)
    };
    
    // Update visual indicators
    Object.keys(checks).forEach(check => {
        const element = document.getElementById(check + '-check');
        const svg = element.querySelector('svg');
        if (checks[check]) {
            element.classList.add('text-green-600');
            element.classList.remove('text-gray-500');
            svg.classList.add('text-green-600');
            svg.classList.remove('text-gray-400');
            score++;
        } else {
            element.classList.remove('text-green-600');
            element.classList.add('text-gray-500');
            svg.classList.remove('text-green-600');
            svg.classList.add('text-gray-400');
        }
    });
    
    // Update strength bar
    const strengthBar = document.getElementById('strength-bar');
    const strengthText = document.getElementById('strength-text');
    const submitButton = document.getElementById('submitButton');
    
    const width = (score / 4) * 100;
    strengthBar.style.width = width + '%';
    
    if (score === 0) {
        strengthBar.className = 'h-2 rounded-full transition-all duration-300 bg-gray-300';
        strengthText.textContent = 'Enter password';
        strengthText.className = 'text-xs text-gray-500';
    } else if (score === 1) {
        strengthBar.className = 'h-2 rounded-full transition-all duration-300 bg-red-500';
        strengthText.textContent = 'Weak';
        strengthText.className = 'text-xs text-red-500';
    } else if (score === 2) {
        strengthBar.className = 'h-2 rounded-full transition-all duration-300 bg-yellow-500';
        strengthText.textContent = 'Fair';
        strengthText.className = 'text-xs text-yellow-500';
    } else if (score === 3) {
        strengthBar.className = 'h-2 rounded-full transition-all duration-300 bg-blue-500';
        strengthText.textContent = 'Good';
        strengthText.className = 'text-xs text-blue-500';
    } else {
        strengthBar.className = 'h-2 rounded-full transition-all duration-300 bg-green-500';
        strengthText.textContent = 'Strong';
        strengthText.className = 'text-xs text-green-500';
    }
    
    // Enable submit button only if password meets requirements
    submitButton.disabled = score < 4;
}

// Real-time password validation
document.getElementById('password').addEventListener('input', function() {
    checkPasswordStrength(this.value);
    
    // Check password match
    const confirmPassword = document.getElementById('confirm_password');
    if (confirmPassword.value) {
        validatePasswordMatch();
    }
});

// Real-time password confirmation validation
document.getElementById('confirm_password').addEventListener('input', validatePasswordMatch);

function validatePasswordMatch() {
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirm_password').value;
    const submitButton = document.getElementById('submitButton');
    
    if (confirmPassword && password !== confirmPassword) {
        document.getElementById('confirm_password').setCustomValidity('Passwords do not match');
        document.getElementById('confirm_password').classList.add('border-red-500');
        document.getElementById('confirm_password').classList.remove('border-gray-300');
        submitButton.disabled = true;
    } else {
        document.getElementById('confirm_password').setCustomValidity('');
        document.getElementById('confirm_password').classList.remove('border-red-500');
        document.getElementById('confirm_password').classList.add('border-gray-300');
        
        // Re-check if all requirements are met
        const password = document.getElementById('password').value;
        const score = [
            password.length >= 8,
            /[A-Z]/.test(password),
            /[a-z]/.test(password),
            /\d/.test(password)
        ].filter(Boolean).length;
        
        submitButton.disabled = score < 4 || !confirmPassword;
    }
}

// Form validation
document.getElementById('resetPasswordForm').addEventListener('submit', function(e) {
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirm_password').value;
    
    if (password !== confirmPassword) {
        e.preventDefault();
        alert('Passwords do not match');
        return false;
    }
    
    if (password.length < 8) {
        e.preventDefault();
        alert('Password must be at least 8 characters long');
        return false;
    }
});

// Auto-focus password field on page load
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('password').focus();
});
</script>

<?php
$content = ob_get_clean();
include '../app/Views/layouts/auth.php';
?>