<?php
ob_start();

// Handle any errors from session
$errors = $_SESSION['errors'] ?? [];
$oldInput = $_SESSION['old_input'] ?? [];
$preFill = $_SESSION['pre_fill'] ?? [];

// Clear session data
unset($_SESSION['errors'], $_SESSION['old_input'], $_SESSION['pre_fill']);
?>

<form id="createGoalForm" class="space-y-8" method="POST" action="/instructor/goals/create">
    
    <!-- Basic Information Card -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center mb-6">
            <div class="w-8 h-8 bg-black rounded-lg flex items-center justify-center mr-3">
                <span class="text-white text-sm font-bold">1</span>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-gray-900">Learning Goal Information</h3>
                <p class="text-sm text-gray-500">Define what students will achieve in your course</p>
            </div>
        </div>

        <?php if (!empty($errors)): ?>
        <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-circle text-red-400"></i>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-red-800">Please correct the following errors:</h3>
                    <div class="mt-2 text-sm text-red-700">
                        <ul class="list-disc pl-5 space-y-1">
                            <?php foreach ($errors as $error): ?>
                                <li><?= htmlspecialchars($error) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Course Selection -->
            <div class="lg:col-span-2">
                <label for="course_id" class="block text-sm font-medium text-gray-700 mb-2">
                    Course <span class="text-red-500">*</span>
                </label>
                <select 
                    id="course_id" 
                    name="course_id" 
                    class="block w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-black focus:border-black transition-colors duration-200"
                    required
                >
                    <option value="">Select a course</option>
                    <?php foreach ($courses as $course): ?>
                        <option value="<?= $course['id'] ?>" 
                            <?= ($oldInput['course_id'] ?? $preFill['course_id'] ?? '') == $course['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($course['title']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <p class="mt-1 text-xs text-gray-500">Choose the course this learning goal belongs to</p>
            </div>

            <!-- Goal Order -->
            <div>
                <label for="order" class="block text-sm font-medium text-gray-700 mb-2">
                    Goal Order <span class="text-red-500">*</span>
                </label>
                <input 
                    type="number" 
                    id="order" 
                    name="order" 
                    value="<?= htmlspecialchars($oldInput['order'] ?? '1') ?>"
                    class="block w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-black focus:border-black transition-colors duration-200" 
                    placeholder="1"
                    required
                    min="1"
                    max="99"
                >
                <p class="mt-1 text-xs text-gray-500">Order of this goal within the course</p>
            </div>

            <!-- Goal Description -->
            <div class="lg:col-span-2">
                <label for="goal" class="block text-sm font-medium text-gray-700 mb-2">
                    Learning Goal Description <span class="text-red-500">*</span>
                </label>
                <textarea 
                    id="goal" 
                    name="goal" 
                    rows="4" 
                    class="block w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-black focus:border-black transition-colors duration-200" 
                    placeholder="e.g., Master the fundamentals of Laravel framework architecture and MVC pattern..."
                    required
                    minlength="10"
                    maxlength="500"
                ><?= htmlspecialchars($oldInput['goal'] ?? '') ?></textarea>
                <div class="flex justify-between mt-1">
                    <p class="text-xs text-gray-500">Be specific and measurable. Start with action verbs like "Master", "Create", "Understand", "Apply"</p>
                    <span class="text-xs text-gray-400" id="goalCounter">0/500</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Goal Examples Card -->
    <div class="bg-blue-50 rounded-lg border border-blue-200 p-6">
        <div class="flex items-center mb-4">
            <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center mr-3">
                <i class="fas fa-lightbulb text-white text-sm"></i>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-blue-900">Writing Effective Learning Goals</h3>
                <p class="text-sm text-blue-700">Examples and best practices for creating clear objectives</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h4 class="font-medium text-blue-900 mb-2">Good Examples:</h4>
                <ul class="space-y-2 text-sm text-blue-800">
                    <li class="flex items-start">
                        <i class="fas fa-check text-green-600 mt-0.5 mr-2 flex-shrink-0"></i>
                        Master the fundamentals of Laravel framework architecture
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check text-green-600 mt-0.5 mr-2 flex-shrink-0"></i>
                        Build and deploy a complete web application using React
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check text-green-600 mt-0.5 mr-2 flex-shrink-0"></i>
                        Apply machine learning algorithms to real-world datasets
                    </li>
                </ul>
            </div>
            <div>
                <h4 class="font-medium text-blue-900 mb-2">Tips:</h4>
                <ul class="space-y-2 text-sm text-blue-800">
                    <li class="flex items-start">
                        <i class="fas fa-star text-yellow-500 mt-0.5 mr-2 flex-shrink-0"></i>
                        Start with action verbs (Master, Create, Understand, Apply)
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-star text-yellow-500 mt-0.5 mr-2 flex-shrink-0"></i>
                        Be specific and measurable
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-star text-yellow-500 mt-0.5 mr-2 flex-shrink-0"></i>
                        Focus on what students will be able to do
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Form Actions -->
    <div class="flex flex-col sm:flex-row gap-4 justify-end">
        <button 
            type="button" 
            class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black transition-colors duration-200"
            onclick="window.location.href='/instructor/goals'"
        >
            Cancel
        </button>
        <button 
            type="submit" 
            class="px-6 py-3 bg-black text-white rounded-lg hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black transition-colors duration-200"
            id="createBtn"
        >
            <span id="createText">
                <i class="fas fa-plus mr-2"></i>
                Create Learning Goal
            </span>
            <span id="createLoading" class="hidden">
                <i class="fas fa-spinner fa-spin mr-2"></i>
                Creating...
            </span>
        </button>
    </div>

</form>

<script>
// Character counter for goal description
document.getElementById('goal').addEventListener('input', function() {
    const counter = document.getElementById('goalCounter');
    const length = this.value.length;
    counter.textContent = `${length}/500`;
    
    if (length > 450) {
        counter.classList.add('text-red-500');
        counter.classList.remove('text-gray-400');
    } else if (length < 10) {
        counter.classList.add('text-yellow-500');
        counter.classList.remove('text-gray-400', 'text-red-500');
    } else {
        counter.classList.remove('text-red-500', 'text-yellow-500');
        counter.classList.add('text-gray-400');
    }
});

// Form validation
const requiredFields = ['course_id', 'goal', 'order'];

requiredFields.forEach(fieldName => {
    const field = document.querySelector(`[name="${fieldName}"]`);
    if (field) {
        field.addEventListener('blur', validateField);
        field.addEventListener('change', validateField);
    }
});

function validateField(e) {
    const field = e.target;
    const value = field.value.trim();
    
    if (field.hasAttribute('required') && !value) {
        field.classList.add('border-red-500');
        field.classList.remove('border-gray-300');
    } else if (field.name === 'goal' && value.length < 10) {
        field.classList.add('border-yellow-500');
        field.classList.remove('border-gray-300', 'border-red-500');
    } else {
        field.classList.remove('border-red-500', 'border-yellow-500');
        field.classList.add('border-gray-300');
    }
}

// Form submission handling
document.getElementById('createGoalForm').addEventListener('submit', function(e) {
    const createText = document.getElementById('createText');
    const createLoading = document.getElementById('createLoading');
    const createBtn = document.getElementById('createBtn');
    
    createText.classList.add('hidden');
    createLoading.classList.remove('hidden');
    createBtn.disabled = true;
    
    // Re-enable after a delay if form validation fails
    setTimeout(() => {
        createText.classList.remove('hidden');
        createLoading.classList.add('hidden');
        createBtn.disabled = false;
    }, 3000);
});

// Initialize character counter
document.addEventListener('DOMContentLoaded', function() {
    const goalField = document.getElementById('goal');
    if (goalField.value) {
        goalField.dispatchEvent(new Event('input'));
    }
});

// Goal writing helper
document.getElementById('goal').addEventListener('focus', function() {
    const examples = [
        'Master the fundamentals of ',
        'Build and deploy a complete ',
        'Understand and apply ',
        'Create dynamic and interactive ',
        'Implement and configure ',
        'Design and develop ',
        'Analyze and interpret ',
        'Solve complex problems using '
    ];
    
    if (!this.value) {
        const randomExample = examples[Math.floor(Math.random() * examples.length)];
        this.placeholder = `e.g., ${randomExample}...`;
    }
});
</script>

<?php
$content = ob_get_clean();
include '../app/Views/layouts/instructor.php';
?>