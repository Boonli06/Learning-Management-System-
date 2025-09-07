<?php
$title = 'Coming Soon | TARUMT LMS';
$feature = $feature ?? 'Feature';
ob_start();
?>

<div class="space-y-8">
    <!-- Feature Icon -->
    <div class="error-animation">
        <div class="w-24 h-24 mx-auto bg-blue-100 rounded-full flex items-center justify-center">
            <i class="fas fa-rocket text-3xl text-blue-500"></i>
        </div>
    </div>
    
    <!-- Coming Soon Message -->
    <div>
        <h1 class="text-4xl font-bold text-gray-900 mb-2"><?= htmlspecialchars($feature) ?></h1>
        <h2 class="text-xl font-semibold text-gray-700 mb-4">Coming Soon</h2>
        <p class="text-gray-600 leading-relaxed">
            We're working hard to bring you this feature. The <?= strtolower(htmlspecialchars($feature)) ?> will be available soon with exciting new capabilities.
        </p>
    </div>

    <!-- Progress Indicator -->
    <div class="w-full bg-gray-200 rounded-full h-3">
        <div class="bg-blue-500 h-3 rounded-full transition-all duration-1000" style="width: 75%"></div>
    </div>
    <p class="text-sm text-gray-500">Development Progress: 75% Complete</p>

    <!-- Action Buttons -->
    <div class="space-y-4">
        <!-- Primary Action -->
        <a href="/login" class="w-full inline-flex justify-center items-center px-6 py-3 border border-transparent text-base font-medium rounded-lg text-white bg-black hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black transition-colors duration-200">
            <i class="fas fa-sign-in-alt mr-2"></i>
            Continue to Sign In
        </a>
        
        <!-- Secondary Actions -->
        <div class="flex flex-col sm:flex-row gap-3">
            <button onclick="goBack()" class="flex-1 inline-flex justify-center items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black transition-colors duration-200">
                <i class="fas fa-arrow-left mr-2"></i>
                Go Back
            </button>
            <a href="/" class="flex-1 inline-flex justify-center items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black transition-colors duration-200">
                <i class="fas fa-home mr-2"></i>
                Homepage
            </a>
        </div>
    </div>

    <!-- Newsletter Signup -->
    <div class="mt-8 p-6 bg-gray-50 rounded-lg border border-gray-200">
        <h3 class="text-lg font-medium text-gray-900 mb-2">Get notified when it's ready</h3>
        <p class="text-sm text-gray-600 mb-4">
            Be the first to know when the <?= strtolower(htmlspecialchars($feature)) ?> launches.
        </p>
        <form class="flex flex-col sm:flex-row gap-3" onsubmit="subscribeNotification(event)">
            <input 
                type="email" 
                placeholder="Enter your email"
                class="flex-1 bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-black focus:border-black block w-full p-2.5 transition-colors duration-200"
                required
            >
            <button 
                type="submit"
                class="px-6 py-2.5 text-sm font-medium text-white bg-black rounded-lg hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300 transition-colors duration-200"
            >
                <i class="fas fa-bell mr-2"></i>
                Notify Me
            </button>
        </form>
    </div>

    <!-- Expected Features -->
    <div class="mt-6 p-4 bg-blue-50 rounded-lg border border-blue-200">
        <h3 class="text-sm font-medium text-blue-900 mb-2">What to expect:</h3>
        <div class="space-y-2 text-sm text-blue-800">
            <div class="flex items-center">
                <i class="fas fa-check w-4 mr-2 text-blue-600"></i>
                <span>Seamless integration with existing systems</span>
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

function subscribeNotification(event) {
    event.preventDefault();
    const email = event.target.querySelector('input[type="email"]').value;
    
    // Simulate API call
    const button = event.target.querySelector('button[type="submit"]');
    const originalText = button.innerHTML;
    
    button.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Subscribing...';
    button.disabled = true;
    
    setTimeout(() => {
        button.innerHTML = '<i class="fas fa-check mr-2"></i>Subscribed!';
        button.classList.remove('bg-black', 'hover:bg-gray-800');
        button.classList.add('bg-green-500');
        
        // Show success message
        showToast('Successfully subscribed! You\'ll be notified when this feature launches.', 'success');
        
        // Reset form
        setTimeout(() => {
            event.target.reset();
            button.innerHTML = originalText;
            button.disabled = false;
            button.classList.remove('bg-green-500');
            button.classList.add('bg-black', 'hover:bg-gray-800');
        }, 3000);
    }, 1500);
}

function showToast(message, type) {
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
    
    setTimeout(() => {
        toast.classList.remove('translate-x-full');
    }, 100);
    
    setTimeout(() => {
        toast.classList.add('translate-x-full');
        setTimeout(() => {
            document.body.removeChild(toast);
        }, 300);
    }, 3000);
}
</script>

<?php
$content = ob_get_clean();
include '../app/Views/layouts/error.php';
?>