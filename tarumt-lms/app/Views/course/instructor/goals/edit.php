<?php
ob_start();

// Handle any errors from session
$errors = $_SESSION['errors'] ?? [];
$oldInput = $_SESSION['old_input'] ?? [];

// Combine goal data with old input
$formData = array_merge($goal ?? [], $oldInput);

// Clear session data
unset($_SESSION['errors'], $_SESSION['old_input']);
?>

<form id="editGoalForm" class="space-y-8" method="POST" action="/instructor/goals/<?= $goal['id'] ?>/edit">
    
    <!-- Current Goal Info -->
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
        <div class="flex items-center mb-4">
            <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center mr-3">
                <i class="fas fa-info-circle text-white text-sm"></i>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-blue-900">Editing Learning Goal</h3>
                <p class="text-sm text-blue-700">Goal #<?= $goal['order'] ?> in <?= htmlspecialchars($goal['course_title']) ?></p>
            </div>
        </div>
        <div class="bg-white rounded-lg p-4 border border-blue-200">
            <p class="text-sm text-gray-600 font-medium mb-2">Current Goal:</p>
            <p class="text-gray-900"><?= htmlspecialchars($goal['goal']) ?></p>
        </div>
    </div>

    <!-- Basic Information Card -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center mb-6">
            <div class="w-8 h-8 bg-black rounded-lg flex items-center justify-center mr-3">
                <span class="text-white text-sm font-bold">1</span>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-gray-900">Learning Goal Information</h3>
                <p class="text-sm text-gray-500">Update the learning objective details</p>
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
                            <?= ($formData['course_id'] ?? '') == $course['id'] ? 'selected' : '' ?>>
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
                    value="<?= htmlspecialchars($formData['order'] ?? '1') ?>"
                    class="block w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-black focus:border-black transition-colors duration-200" 
                    placeholder="1"
                    required
                    min="1"
                    max="99"
                >
                <p class="mt-1 text-xs text-gray-500">Order of this goal within the course</p>
            </div>

            <!-- Last Updated -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Last Updated</label>
                <div class="block w-full border border-gray-300 rounded-lg px-3 py-2 bg-gray-50 text-gray-500">
                    <?= date('M j, Y \a\t g:i A', strtotime($goal['updated_at'])) ?>
                </div>
                <p class="mt-1 text-xs text-gray-500">When this goal was last modified</p>
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
                ><?= htmlspecialchars($formData['goal'] ?? '') ?></textarea>
                <div class="flex justify-between mt-1">
                    <p class="text-xs text-gray-500">Be specific and measurable. Start with action verbs like "Master", "Create", "Understand", "Apply"</p>
                    <span class="text-xs text-gray-400" id="goalCounter">0/500</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Change Summary Card -->
    <div class="bg-gray-50 rounded-lg border border-gray-200 p-6">
        <div class="flex items-center mb-4">
            <div class="w-8 h-8 bg-gray-600 rounded-lg flex items-center justify-center mr-3">
                <i class="fas fa-history text-white text-sm"></i>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-gray-900">Goal History</h3>
                <p class="text-sm text-gray-500">Track changes to this learning objective</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
            <div>
                <span class="text-gray-600 font-medium">Created:</span>
                <p class="text-gray-900"><?= date('M j, Y', strtotime($goal['created_at'])) ?></p>
            </div>
            <div>
                <span class="text-gray-600 font-medium">Last Modified:</span>
                <p class="text-gray-900"><?= date('M j, Y', strtotime($goal['updated_at'])) ?></p>
            </div>
            <div>
                <span class="text-gray-600 font-medium">Goal ID:</span>
                <p class="text-gray-900">#<?= $goal['id'] ?></p>
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
    <div class="flex flex-col sm:flex-row gap-4 justify-between">
        <div class="flex gap-3">
            <a href="/instructor/goals/<?= $goal['id'] ?>" 
               class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black transition-colors duration-200">
                <i class="fas fa-eye mr-2"></i>View Goal
            </a>
            <a href="/instructor/goals/<?= $goal['id'] ?>/duplicate" 
               class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black transition-colors duration-200">
                <i class="fas fa-copy mr-2"></i>Duplicate
            </a>
        </div>
        <div class="flex gap-3">
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
                id="updateBtn"
            >
                <span id="updateText">
                    <i class="fas fa-save mr-2"></i>
                    Update Learning Goal
                </span>
                <span id="updateLoading" class="hidden">
                    <i class="fas fa-spinner fa-spin mr-2"></i>
                    Updating...
                </span>
            </button>
        </div>
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
document.getElementById('editGoalForm').addEventListener('submit', function(e) {
    const updateText = document.getElementById('updateText');
    const updateLoading = document.getElementById('updateLoading');
    const updateBtn = document.getElementById('updateBtn');
    
    updateText.classList.add('hidden');
    updateLoading.classList.remove('hidden');
    updateBtn.disabled = true;
    
    // Re-enable after a delay if form validation fails
    setTimeout(() => {
        updateText.classList.remove('hidden');
        updateLoading.classList.add('hidden');
        updateBtn.disabled = false;
    }, 3000);
});

// Initialize character counter
document.addEventListener('DOMContentLoaded', function() {
    const goalField = document.getElementById('goal');
    if (goalField.value) {
        goalField.dispatchEvent(new Event('input'));
    }
});

// Highlight changes
document.addEventListener('DOMContentLoaded', function() {
    const originalGoal = <?= json_encode($goal['goal']) ?>;
    const goalField = document.getElementById('goal');
    
    goalField.addEventListener('input', function() {
        if (this.value.trim() !== originalGoal.trim()) {
            this.classList.add('border-yellow-400');
            this.classList.remove('border-gray-300');
        } else {
            this.classList.remove('border-yellow-400');
            this.classList.add('border-gray-300');
        }
    });
});
</script>

<?php
$content = ob_get_clean();
include '../app/Views/layouts/instructor.php';
?>