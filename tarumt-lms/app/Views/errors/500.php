<?php
$title = '500 - Server Error | TARUMT LMS';
ob_start();
?>

<div class="space-y-8">
    <!-- Error Icon -->
    <div class="error-animation">
        <div class="w-24 h-24 mx-auto bg-red-100 rounded-full flex items-center justify-center">
            <i class="fas fa-exclamation-triangle text-3xl text-red-500"></i>
        </div>
    </div>
    
    <!-- Error Code -->
    <div>
        <h1 class="text-6xl font-bold text-gray-900 mb-2">500</h1>
        <h2 class="text-2xl font-semibold text-gray-700 mb-4">Internal Server Error</h2>
        <p class="text-gray-600 leading-relaxed">
            Something went wrong on our servers. We're working to fix this issue. Please try again in a few moments.
        </p>
    </div>

    <!-- Error Details (Development Mode) -->
    <?php if (isset($exception) && ini_get('display_errors')): ?>
    <div class="mt-6 p-4 bg-red-50 border border-red-200 rounded-lg text-left">
        <h3 class="text-sm font-medium text-red-800 mb-2">Error Details (Development Mode)</h3>
        <div class="text-xs text-red-700 font-mono">
            <p><strong>Message:</strong> <?= htmlspecialchars($exception->getMessage()) ?></p>
            <p><strong>File:</strong> <?= htmlspecialchars($exception->getFile()) ?></p>
            <p><strong>Line:</strong> <?= htmlspecialchars($exception->getLine()) ?></p>
        </div>
    </div>
    <?php endif; ?>

    <!-- Action Buttons -->
    <div class="space-y-4">
        <!-- Primary Action -->
        <button onclick="retryPage()" class="w-full inline-flex justify-center items-center px-6 py-3 border border-transparent text-base font-medium rounded-lg text-white bg-black hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black transition-colors duration-200">
            <i class="fas fa-redo mr-2"></i>
            Try Again
        </button>
        
        <!-- Secondary Actions -->
        <div class="flex flex-col sm:flex-row gap-3">
            <a href="/" class="flex-1 inline-flex justify-center items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black transition-colors duration-200">
                <i class="fas fa-home mr-2"></i>
                Go Home
            </a>
            <a href="mailto:support@tarumt.edu?subject=500 Error Report" class="flex-1 inline-flex justify-center items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black transition-colors duration-200">
                <i class="fas fa-bug mr-2"></i>
                Report Issue
            </a>
        </div>
    </div>

    <!-- Support Information -->
    <div class="mt-8 p-4 bg-gray-50 rounded-lg border border-gray-200">
        <h3 class="text-sm font-medium text-gray-900 mb-2">Need immediate assistance?</h3>
        <div class="space-y-2 text-sm text-gray-600">
            <div class="flex items-center">
                <i class="fas fa-envelope w-4 mr-2 text-gray-400"></i>
                <a href="mailto:support@tarumt.edu" class="text-black hover:underline">support@tarumt.edu</a>
            </div>
            <div class="flex items-center">
                <i class="fas fa-phone w-4 mr-2 text-gray-400"></i>
                <a href="tel:+60312345678" class="text-black hover:underline">+603 1234 5678</a>
            </div>
            <div class="flex items-center">
                <i class="fas fa-clock w-4 mr-2 text-gray-400"></i>
                <span>Support Hours: Mon-Fri 9AM-6PM MYT</span>
            </div>
        </div>
    </div>
</div>

<script>
function retryPage() {
    location.reload();
}

// Auto-retry after 5 seconds
let countdownElement = null;
let countdown = 10;

function startAutoRetry() {
    if (countdownElement) return; // Already started
    
    const retryButton = document.querySelector('button[onclick="retryPage()"]');
    countdownElement = document.createElement('span');
    countdownElement.className = 'text-sm text-gray-400 ml-2';
    countdownElement.textContent = `(Auto-retry in ${countdown}s)`;
    retryButton.appendChild(countdownElement);
    
    const interval = setInterval(() => {
        countdown--;
        countdownElement.textContent = `(Auto-retry in ${countdown}s)`;
        
        if (countdown <= 0) {
            clearInterval(interval);
            retryPage();
        }
    }, 1000);
}

// Start auto-retry after 2 seconds
setTimeout(startAutoRetry, 2000);
</script>

<?php
$content = ob_get_clean();
include '../app/Views/layouts/error.php';
?>