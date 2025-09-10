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

<form id="duplicateGoalForm" class="space-y-8" method="POST" action="/instructor/goals/<?= $originalGoal['id'] ?>/duplicate">
    
    <!-- Original Goal Info -->
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
        <div class="flex items-center mb-4">
            <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center mr-3">
                <i class="fas fa-info-circle text-white text-sm"></i>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-blue-900">Duplicating from Original Goal</h3>
                <p class="text-sm text-blue-700">Creating a copy of Goal #<?= $originalGoal['order'] ?> from "<?= htmlspecialchars($originalGoal['course_title']) ?>"</p>
            </div>
        </div>
        <div class="bg-white rounded-lg p-4 border border-blue-200">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                <div>
                    <span class="text-blue-700 font-medium">Original Goal:</span>
                    <p class="text-blue-900 mt-1"><?= htmlspecialchars($originalGoal['goal']) ?></p>
                </div>
                <div>
                    <span class="text-blue-700 font-medium">Course:</span>
                    <p class="text-blue-900 mt-1"><?= htmlspecialchars($originalGoal['course_title']) ?></p>
                </div>
                <div>
                    <span class="text-blue-700 font-medium">Original Order:</span>
                    <p class="text-blue-900 mt-1">Goal #<?= $originalGoal['order'] ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Basic Information Card -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center mb-6">
            <div class="w-8 h-8 bg-black rounded-lg flex items-center justify-center mr-3">
                <span class="text-white text-sm font-bold">1</span>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-gray-900">Duplicate Goal Information</h3>
                <p class="text-sm text-gray-500">Modify the duplicated learning objective as needed</p>
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
                <p class="mt-1 text-xs text-gray-500">You can duplicate to the same course or a different one</p>
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
                <p class="mt-1 text-xs text-gray-500">Position within the selected course</p>
            </div>

            <!-- Duplicate Options -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Duplicate Options</label>
                <div class="space-y-3">
                    <label class="flex items-center">
                        <input type="checkbox" 
                               id="modify_title" 
                               name="modify_title" 
                               value="1" 
                               checked
                               class="text-black focus:ring-black">
                        <div class="ml-2">
                            <span class="text-sm text-gray-700">Modify title</span>
                            <p class="text-xs text-gray-500">Add "Copy of" prefix to distinguish from original</p>
                        </div>
                    </label>
                </div>
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
                    placeholder="e.g., Copy of Master the fundamentals of Laravel framework architecture..."
                    required
                    minlength="10"
                    maxlength="500"
                ><?= htmlspecialchars($formData['goal'] ?? '') ?></textarea>
                <div class="flex justify-between mt-1">
                    <p class="text-xs text-gray-500">Modify as needed. Be specific and measurable.</p>
                    <span class="text-xs text-gray-400" id="goalCounter">0/500</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Duplication Settings Card -->
    <div class="bg-gray-50 rounded-lg border border-gray-200 p-6">
        <div class="flex items-center mb-4">
            <div class="w-8 h-8 bg-gray-600 rounded-lg flex items-center justify-center mr-3">
                <i class="fas fa-cog text-white text-sm"></i>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-gray-900">Duplication Settings</h3>
                <p class="text-sm text-gray-500">Configure how the goal should be duplicated</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h4 class="font-medium text-gray-900 mb-3">What will be copied:</h4>
                <ul class="space-y-2 text-sm text-gray-700">
                    <li class="flex items-center">
                        <i class="fas fa-check text-green-600 mr-2"></i>
                        Goal description (editable above)
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-check text-green-600 mr-2"></i>
                        Course assignment (changeable)
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-check text-green-600 mr-2"></i>
                        Goal order (adjustable)
                    </li>
                </ul>
            </div>
            <div>
                <h4 class="font-medium text-gray-900 mb-3">What will NOT be copied:</h4>
                <ul class="space-y-2 text-sm text-gray-700">
                    <li class="flex items-center">
                        <i class="fas fa-times text-red-600 mr-2"></i>
                        Original creation date
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-times text-red-600 mr-2"></i>
                        Goal ID (new ID will be assigned)
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-times text-red-600 mr-2"></i>
                        Update history
                    </li>
                </ul>
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
                <h3 class="text-lg font-semibold text-blue-900">Duplication Tips</h3>
                <p class="text-sm text-blue-700">Best practices for duplicating learning goals</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h4 class="font-medium text-blue-900 mb-2">Consider modifying:</h4>
                <ul class="space-y-2 text-sm text-blue-800">
                    <li class="flex items-start">
                        <i class="fas fa-arrow-right text-blue-600 mt-0.5 mr-2 flex-shrink-0"></i>
                        Technology or framework names
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-arrow-right text-blue-600 mt-0.5 mr-2 flex-shrink-0"></i>
                        Difficulty level or complexity
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-arrow-right text-blue-600 mt-0.5 mr-2 flex-shrink-0"></i>
                        Specific examples or use cases
                    </li>
                </ul>
            </div>
            <div>
                <h4 class="font-medium text-blue-900 mb-2">Keep consistent:</h4>
                <ul class="space-y-2 text-sm text-blue-800">
                    <li class="flex items-start">
                        <i class="fas fa-check text-green-600 mt-0.5 mr-2 flex-shrink-0"></i>
                        Action verb and structure
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check text-green-600 mt-0.5 mr-2 flex-shrink-0"></i>
                        Learning level and scope
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check text-green-600 mt-0.5 mr-2 flex-shrink-0"></i>
                        Measurable outcomes
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Form Actions -->
    <div class="flex flex-col sm:flex-row gap-4 justify-between">
        <div class="flex gap-3">
            <a href="/instructor/goals/<?= $originalGoal['id'] ?>" 
               class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black transition-colors duration-200">
                <i class="fas fa-eye mr-2"></i>View Original
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
                id="duplicateBtn"
            >
                <span id="duplicateText">
                    <i class="fas fa-copy mr-2"></i>
                    Duplicate Learning Goal
                </span>
                <span id="duplicateLoading" class="hidden">
                    <i class="fas fa-spinner fa-spin mr-2"></i>
                    Duplicating...
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

// Modify title checkbox functionality
document.getElementById('modify_title').addEventListener('change', function() {
    const goalField = document.getElementById('goal');
    const originalGoal = <?= json_encode($originalGoal['goal']) ?>;
    
    if (this.checked) {
        if (goalField.value === originalGoal) {
            goalField.value = 'Copy of ' + originalGoal;
            goalField.dispatchEvent(new Event('input'));
        }
    } else {
        if (goalField.value === 'Copy of ' + originalGoal) {
            goalField.value = originalGoal;
            goalField.dispatchEvent(new Event('input'));
        }
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
document.getElementById('duplicateGoalForm').addEventListener('submit', function(e) {
    const duplicateText = document.getElementById('duplicateText');
    const duplicateLoading = document.getElementById('duplicateLoading');
    const duplicateBtn = document.getElementById('duplicateBtn');
    
    duplicateText.classList.add('hidden');
    duplicateLoading.classList.remove('hidden');
    duplicateBtn.disabled = true;
    
    // Re-enable after a delay if form validation fails
    setTimeout(() => {
        duplicateText.classList.remove('hidden');
        duplicateLoading.classList.add('hidden');
        duplicateBtn.disabled = false;
    }, 3000);
});

// Initialize character counter and modify title
document.addEventListener('DOMContentLoaded', function() {
    const goalField = document.getElementById('goal');
    if (goalField.value) {
        goalField.dispatchEvent(new Event('input'));
    }
    
    // Trigger modify title if checkbox is checked
    const modifyTitleCheckbox = document.getElementById('modify_title');
    if (modifyTitleCheckbox.checked) {
        modifyTitleCheckbox.dispatchEvent(new Event('change'));
    }
});
</script>

<?php
$content = ob_get_clean();
include '../app/Views/layouts/instructor.php';
?>