<?php
ob_start();
?>

<!-- Email Verification Content -->
<div class="text-center space-y-6">
    
    <!-- Icon -->
    <div class="mx-auto w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center">
        <svg class="w-10 h-10 text-gray-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8l4 4L19 2M1 13l4 4L15 7"/>
        </svg>
    </div>
    
    <!-- Main Message -->
    <div>
        <h3 class="text-xl font-semibold text-gray-900 mb-2">Verification email sent!</h3>
        <p class="text-gray-600 leading-relaxed">
            We've sent a verification link to your email address. Please check your inbox and click the link to verify your account.
        </p>
    </div>

    <!-- Email Info Card -->
    <div class="p-4 bg-blue-50 border border-blue-200 rounded-lg">
        <div class="flex items-center justify-center">
            <svg class="w-4 h-4 text-blue-600 mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 16">
                <path d="m10.036 8.278 9.258-7.79A1.979 1.979 0 0 0 18 0H2A1.987 1.987 0 0 0 .641.541l9.395 7.737Z"/>
                <path d="M11.241 9.817c-.36.275-.801.425-1.255.427-.428 0-.845-.138-1.187-.395L0 2.6V14a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V2.5l-8.759 7.317Z"/>
            </svg>
            <span class="text-sm font-medium text-blue-800">
                Sent to: <?= htmlspecialchars($_SESSION['user']['email'] ?? 'your email') ?>
            </span>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="space-y-3">
        <!-- Resend Email Button -->
        <button 
            type="button" 
            id="resendButton"
            onclick="resendVerificationEmail()"
            class="w-full text-white bg-black hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center transition-colors duration-200"
        >
            <span class="flex items-center justify-center">
                <svg class="w-4 h-4 mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 1v5h-5M2 19v-5h5m10-4a8 8 0 0 1-14.947 3.97M1 10a8 8 0 0 1 14.947-3.97"/>
                </svg>
                <span id="resendText">Resend verification email</span>
            </span>
        </button>

        <!-- Skip for Now (if user is logged in) -->
        <?php if (isset($_SESSION['user'])): ?>
        <button 
            type="button" 
            onclick="skipVerification()"
            class="w-full text-gray-700 bg-white hover:bg-gray-50 border border-gray-300 focus:ring-4 focus:outline-none focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 text-center transition-colors duration-200"
        >
            Continue without verification
        </button>
        <?php endif; ?>
    </div>

    <!-- Instructions -->
    <div class="mt-8 p-4 bg-gray-50 border border-gray-200 rounded-lg text-left">
        <h4 class="text-sm font-medium text-gray-900 mb-3">Next steps:</h4>
        <div class="space-y-3 text-sm text-gray-600">
            <div class="flex items-start">
                <div class="flex-shrink-0 w-6 h-6 bg-gray-200 rounded-full flex items-center justify-center mr-3 mt-0.5">
                    <span class="text-xs font-medium text-gray-600">1</span>
                </div>
                <div>
                    <p class="font-medium text-gray-700">Check your email inbox</p>
                    <p class="text-xs text-gray-500">Look for an email from TARUMT LMS</p>
                </div>
            </div>
            
            <div class="flex items-start">
                <div class="flex-shrink-0 w-6 h-6 bg-gray-200 rounded-full flex items-center justify-center mr-3 mt-0.5">
                    <span class="text-xs font-medium text-gray-600">2</span>
                </div>
                <div>
                    <p class="font-medium text-gray-700">Click the verification link</p>
                    <p class="text-xs text-gray-500">This will activate your account</p>
                </div>
            </div>
            
            <div class="flex items-start">
                <div class="flex-shrink-0 w-6 h-6 bg-gray-200 rounded-full flex items-center justify-center mr-3 mt-0.5">
                    <span class="text-xs font-medium text-gray-600">3</span>
                </div>
                <div>
                    <p class="font-medium text-gray-700">Start learning!</p>
                    <p class="text-xs text-gray-500">Access all courses and features</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Help Section -->
    <div class="mt-6 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
        <div class="flex items-start">
            <svg class="flex-shrink-0 w-4 h-4 text-yellow-600 mr-3 mt-0.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM10 15a1 1 0 1 1 0-2 1 1 0 0 1 0 2Zm0-4a1 1 0 0 1-1-1V6a1 1 0 0 1 2 0v4a1 1 0 0 1-1 1Z"/>
            </svg>
            <div class="text-left">
                <h4 class="text-sm font-medium text-yellow-800 mb-1">Didn't receive the email?</h4>
                <ul class="text-xs text-yellow-700 space-y-1">
                    <li>• Check your spam/junk folder</li>
                    <li>• Make sure you entered the correct email address</li>
                    <li>• Wait a few minutes for delivery</li>
                    <li>• Try resending the verification email</li>
                </ul>
            </div>
        </div>
    </div>

</div>

<!-- Back to Login -->
<div class="mt-8 text-center">
    <a href="/login" class="inline-flex items-center text-sm font-medium text-black hover:text-gray-700 transition-colors duration-200">
        <svg class="w-4 h-4 mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5H1m0 0l4 4M1 5l4-4"/>
        </svg>
        Back to sign in
    </a>
</div>

<script>
let resendCooldown = false;

function resendVerificationEmail() {
    if (resendCooldown) return;
    
    const button = document.getElementById('resendButton');
    const buttonText = document.getElementById('resendText');
    
    // Show loading state
    button.disabled = true;
    button.classList.add('opacity-75');
    buttonText.textContent = 'Sending...';
    
    // Simulate API call
    setTimeout(() => {
        // Show success message
        buttonText.textContent = 'Email sent!';
        
        // Start cooldown
        resendCooldown = true;
        let countdown = 30;
        
        const countdownInterval = setInterval(() => {
            countdown--;
            buttonText.textContent = `Resend in ${countdown}s`;
            
            if (countdown <= 0) {
                clearInterval(countdownInterval);
                button.disabled = false;
                button.classList.remove('opacity-75');
                buttonText.textContent = 'Resend verification email';
                resendCooldown = false;
            }
        }, 1000);
        
        // Show toast notification
        showToast('Verification email sent successfully!', 'success');
        
    }, 1500);
}

function skipVerification() {
    if (confirm('Are you sure you want to continue without verifying your email? Some features may be limited.')) {
        window.location.href = '/dashboard';
    }
}

function showToast(message, type) {
    // Create toast element
    const toast = document.createElement('div');
    toast.className = `fixed top-4 right-4 p-4 rounded-lg shadow-lg z-50 transition-all duration-300 transform translate-x-full ${
        type === 'success' ? 'bg-green-500 text-white' : 'bg-red-500 text-white'
    }`;
    toast.innerHTML = `
        <div class="flex items-center">
            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                ${type === 'success' ? 
                    '<path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>' :
                    '<path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>'
                }
            </svg>
            <span>${message}</span>
        </div>
    `;
    
    document.body.appendChild(toast);
    
    // Animate in
    setTimeout(() => {
        toast.classList.remove('translate-x-full');
    }, 100);
    
    // Remove after 3 seconds
    setTimeout(() => {
        toast.classList.add('translate-x-full');
        setTimeout(() => {
            document.body.removeChild(toast);
        }, 300);
    }, 3000);
}

// Auto-check for verification status (simulate)
let checkCount = 0;
const checkInterval = setInterval(() => {
    checkCount++;
    
    // Simulate random verification after some time
    if (checkCount > 10 && Math.random() > 0.8) {
        clearInterval(checkInterval);
        showToast('Email verified successfully! Redirecting...', 'success');
        setTimeout(() => {
            window.location.href = '/dashboard';
        }, 2000);
    }
    
    // Stop checking after 2 minutes
    if (checkCount > 24) {
        clearInterval(checkInterval);
    }
}, 5000);
</script>

<?php
$content = ob_get_clean();
include '../app/Views/layouts/auth.php';
?>