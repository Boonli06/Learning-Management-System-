<?php
// 数据现在由Controller传递，直接开始页面内容
ob_start();
?>

<!-- Settings Tabs -->
<div class="mb-6">
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-1">
        <nav class="flex space-x-1" role="tablist">
            <button class="tab-button active px-4 py-2 text-sm font-medium rounded-lg transition-colors duration-200" onclick="showTab('general')" id="tab-general">
                General
            </button>
            <button class="tab-button px-4 py-2 text-sm font-medium rounded-lg transition-colors duration-200" onclick="showTab('enrollment')" id="tab-enrollment">
                Enrollment
            </button>
            <button class="tab-button px-4 py-2 text-sm font-medium rounded-lg transition-colors duration-200" onclick="showTab('content')" id="tab-content">
                Content
            </button>
            <button class="tab-button px-4 py-2 text-sm font-medium rounded-lg transition-colors duration-200" onclick="showTab('certificates')" id="tab-certificates">
                Certificates
            </button>
            <button class="tab-button px-4 py-2 text-sm font-medium rounded-lg transition-colors duration-200" onclick="showTab('advanced')" id="tab-advanced">
                Advanced
            </button>
        </nav>
    </div>
</div>

<form id="settingsForm" class="space-y-8" method="POST" action="/instructor/courses/<?= $course['id'] ?>/settings">
    
    <!-- General Settings Tab -->
    <div id="general-tab" class="tab-content">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center mb-6">
                <div class="w-8 h-8 bg-black rounded-lg flex items-center justify-center mr-3">
                    <i class="fas fa-cog text-white"></i>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">General Settings</h3>
                    <p class="text-sm text-gray-500">Basic course configuration and visibility options</p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Course Slug -->
                <div>
                    <label for="slug" class="block text-sm font-medium text-gray-700 mb-2">
                        Course URL Slug
                    </label>
                    <div class="flex items-center">
                        <span class="text-sm text-gray-500 mr-2">tarumt-lms.com/courses/</span>
                        <input 
                            type="text" 
                            id="slug" 
                            name="slug" 
                            value="<?= htmlspecialchars($course['slug']) ?>"
                            class="flex-1 border border-gray-300 rounded-lg px-3 py-2 focus:ring-black focus:border-black transition-colors duration-200" 
                            pattern="[a-z0-9-]+"
                        >
                    </div>
                    <p class="mt-1 text-xs text-gray-500">Use lowercase letters, numbers, and hyphens only</p>
                </div>

                <!-- Course Status -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                        Course Status
                    </label>
                    <select 
                        id="status" 
                        name="status" 
                        class="block w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-black focus:border-black transition-colors duration-200"
                    >
                        <?php foreach ($statusOptions as $value => $label): ?>
                            <option value="<?= $value ?>" <?= $course['status'] === $value ? 'selected' : '' ?>>
                                <?= $label ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Visibility -->
                <div>
                    <label for="visibility" class="block text-sm font-medium text-gray-700 mb-2">
                        Course Visibility
                    </label>
                    <select 
                        id="visibility" 
                        name="visibility" 
                        class="block w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-black focus:border-black transition-colors duration-200"
                    >
                        <?php foreach ($visibilityOptions as $value => $label): ?>
                            <option value="<?= $value ?>" <?= $course['visibility'] === $value ? 'selected' : '' ?>>
                                <?= $label ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Course Language -->
                <div>
                    <label for="course_language" class="block text-sm font-medium text-gray-700 mb-2">
                        Primary Language
                    </label>
                    <select 
                        id="course_language" 
                        name="course_language" 
                        class="block w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-black focus:border-black transition-colors duration-200"
                    >
                        <?php foreach ($languageOptions as $value => $label): ?>
                            <option value="<?= $value ?>" <?= $course['course_language'] === $value ? 'selected' : '' ?>>
                                <?= $label ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Enrollment Settings Tab -->
    <div id="enrollment-tab" class="tab-content hidden">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center mb-6">
                <div class="w-8 h-8 bg-black rounded-lg flex items-center justify-center mr-3">
                    <i class="fas fa-users text-white"></i>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Enrollment Settings</h3>
                    <p class="text-sm text-gray-500">Control how students can enroll in your course</p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Enrollment Limit -->
                <div>
                    <label for="enrollment_limit" class="block text-sm font-medium text-gray-700 mb-2">
                        Enrollment Limit
                    </label>
                    <input 
                        type="number" 
                        id="enrollment_limit" 
                        name="enrollment_limit" 
                        value="<?= $course['enrollment_limit'] ?>"
                        class="block w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-black focus:border-black transition-colors duration-200" 
                        min="1"
                        max="10000"
                    >
                    <p class="mt-1 text-xs text-gray-500">Current enrollments: <?= $course['current_enrollments'] ?></p>
                </div>

                <!-- Course Preview -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Course Preview</label>
                    <div class="space-y-3">
                        <label class="flex items-center">
                            <input type="checkbox" name="allow_preview" value="1" <?= $course['allow_preview'] ? 'checked' : '' ?> class="text-black focus:ring-black" onchange="togglePreviewOptions()">
                            <span class="ml-2 text-sm text-gray-700">Allow course preview for non-enrolled students</span>
                        </label>
                        <div id="previewOptions" class="ml-6 <?= !$course['allow_preview'] ? 'hidden' : '' ?>">
                            <label for="preview_lectures_count" class="block text-sm text-gray-600 mb-1">
                                Number of preview lectures
                            </label>
                            <input 
                                type="number" 
                                id="preview_lectures_count" 
                                name="preview_lectures_count" 
                                value="<?= $course['preview_lectures_count'] ?>"
                                class="block w-32 border border-gray-300 rounded-lg px-3 py-2 focus:ring-black focus:border-black transition-colors duration-200" 
                                min="1"
                                max="10"
                            >
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Settings Tab -->
    <div id="content-tab" class="tab-content hidden">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center mb-6">
                <div class="w-8 h-8 bg-black rounded-lg flex items-center justify-center mr-3">
                    <i class="fas fa-play-circle text-white"></i>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Content Settings</h3>
                    <p class="text-sm text-gray-500">Configure content delivery and student interactions</p>
                </div>
            </div>

            <div class="space-y-6">
                <!-- Student Features -->
                <div>
                    <h4 class="text-sm font-medium text-gray-900 mb-3">Student Features</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <label class="flex items-center">
                            <input type="checkbox" name="enable_qa" value="1" <?= $course['enable_qa'] ? 'checked' : '' ?> class="text-black focus:ring-black">
                            <span class="ml-2 text-sm text-gray-700">Enable Q&A discussions</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="enable_announcements" value="1" <?= $course['enable_announcements'] ? 'checked' : '' ?> class="text-black focus:ring-black">
                            <span class="ml-2 text-sm text-gray-700">Enable announcements</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="enable_assignments" value="1" <?= $course['enable_assignments'] ? 'checked' : '' ?> class="text-black focus:ring-black">
                            <span class="ml-2 text-sm text-gray-700">Enable assignments</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="student_can_download" value="1" <?= $course['student_can_download'] ? 'checked' : '' ?> class="text-black focus:ring-black">
                            <span class="ml-2 text-sm text-gray-700">Allow content downloads</span>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Certificates Tab -->
    <div id="certificates-tab" class="tab-content hidden">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center mb-6">
                <div class="w-8 h-8 bg-black rounded-lg flex items-center justify-center mr-3">
                    <i class="fas fa-certificate text-white"></i>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Certificate Settings</h3>
                    <p class="text-sm text-gray-500">Configure completion certificates for students</p>
                </div>
            </div>

            <div class="space-y-6">
                <!-- Enable Certificates -->
                <div>
                    <label class="flex items-start">
                        <input type="checkbox" name="enable_certificates" value="1" <?= $course['enable_certificates'] ? 'checked' : '' ?> class="mt-1 text-black focus:ring-black" onchange="toggleCertificateOptions()">
                        <div class="ml-2">
                            <span class="text-sm font-medium text-gray-700">Enable completion certificates</span>
                            <p class="text-xs text-gray-500">Students will receive a certificate when they complete the course</p>
                        </div>
                    </label>
                </div>

                <div id="certificateOptions" class="<?= !$course['enable_certificates'] ? 'hidden' : '' ?> space-y-6">
                    <!-- Completion Criteria -->
                    <div>
                        <label for="course_completion_criteria" class="block text-sm font-medium text-gray-700 mb-2">
                            Completion Criteria
                        </label>
                        <select 
                            id="course_completion_criteria" 
                            name="course_completion_criteria" 
                            class="block w-full max-w-md border border-gray-300 rounded-lg px-3 py-2 focus:ring-black focus:border-black transition-colors duration-200"
                        >
                            <?php foreach ($completionCriteriaOptions as $value => $label): ?>
                                <option value="<?= $value ?>" <?= $course['course_completion_criteria'] === $value ? 'selected' : '' ?>>
                                    <?= $label ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Advanced Settings Tab -->
    <div id="advanced-tab" class="tab-content hidden">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center mb-6">
                <div class="w-8 h-8 bg-black rounded-lg flex items-center justify-center mr-3">
                    <i class="fas fa-tools text-white"></i>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Advanced Settings</h3>
                    <p class="text-sm text-gray-500">Advanced configuration options</p>
                </div>
            </div>

            <div class="space-y-6">
                <!-- Course Data -->
                <div>
                    <h4 class="text-sm font-medium text-gray-900 mb-3">Course Information</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                        <div class="flex justify-between py-2 border-b border-gray-200">
                            <span class="text-gray-600">Course ID:</span>
                            <span class="font-medium text-gray-900"><?= $course['id'] ?></span>
                        </div>
                        <div class="flex justify-between py-2 border-b border-gray-200">
                            <span class="text-gray-600">Created:</span>
                            <span class="font-medium text-gray-900"><?= date('M j, Y', strtotime($course['created_at'])) ?></span>
                        </div>
                    </div>
                </div>

                <!-- Danger Zone -->
                <div class="border border-red-200 rounded-lg p-4 bg-red-50">
                    <h4 class="text-sm font-medium text-red-900 mb-3">Danger Zone</h4>
                    <div class="space-y-3">
                        <button type="button" class="w-full sm:w-auto bg-white border border-red-300 text-red-700 px-4 py-2 rounded-lg text-sm font-medium hover:bg-red-50 transition-colors duration-200">
                            <i class="fas fa-copy mr-2"></i>
                            Duplicate Course
                        </button>
                        <button type="button" class="w-full sm:w-auto bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-red-700 transition-colors duration-200">
                            <i class="fas fa-trash mr-2"></i>
                            Delete Course
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Form Actions -->
    <div class="flex flex-col sm:flex-row gap-4 justify-between">
        <button 
            type="button" 
            class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors duration-200"
            onclick="window.location.href='/instructor/courses/<?= $course['id'] ?>/edit'"
        >
            <i class="fas fa-arrow-left mr-2"></i>
            Back to Course
        </button>
        <div class="flex gap-3">
            <button 
                type="button" 
                class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors duration-200"
                onclick="resetForm()"
            >
                Reset Changes
            </button>
            <button 
                type="submit" 
                class="px-6 py-3 bg-black text-white rounded-lg hover:bg-gray-800 transition-colors duration-200"
            >
                <i class="fas fa-save mr-2"></i>
                Save Settings
            </button>
        </div>
    </div>

</form>

<style>
    .tab-button.active {
        background-color: #000;
        color: #fff;
    }
    .tab-button:not(.active) {
        color: #6b7280;
    }
    .tab-button:not(.active):hover {
        background-color: #f9fafb;
        color: #374151;
    }
</style>

<script>
// Tab functionality
function showTab(tabName) {
    // Hide all tab contents
    document.querySelectorAll('.tab-content').forEach(tab => {
        tab.classList.add('hidden');
    });
    
    // Remove active class from all tab buttons
    document.querySelectorAll('.tab-button').forEach(button => {
        button.classList.remove('active');
    });
    
    // Show selected tab content
    document.getElementById(`${tabName}-tab`).classList.remove('hidden');
    
    // Add active class to selected tab button
    document.getElementById(`tab-${tabName}`).classList.add('active');
}

// Toggle functions
function togglePreviewOptions() {
    const checkbox = document.querySelector('input[name="allow_preview"]');
    const options = document.getElementById('previewOptions');
    
    if (checkbox.checked) {
        options.classList.remove('hidden');
    } else {
        options.classList.add('hidden');
    }
}

function toggleCertificateOptions() {
    const checkbox = document.querySelector('input[name="enable_certificates"]');
    const options = document.getElementById('certificateOptions');
    
    if (checkbox.checked) {
        options.classList.remove('hidden');
    } else {
        options.classList.add('hidden');
    }
}

// Reset form to original values
function resetForm() {
    if (confirm('Are you sure you want to reset all changes?')) {
        document.getElementById('settingsForm').reset();
        // Trigger change events to update dependent fields
        togglePreviewOptions();
        toggleCertificateOptions();
    }
}

// Form submission
document.getElementById('settingsForm').addEventListener('submit', function(e) {
    // In real application, form would submit normally
    // For demo, we'll prevent and show success message
    e.preventDefault();
    
    // Show loading state
    const submitBtn = document.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Saving...';
    submitBtn.disabled = true;
    
    // Simulate API call
    setTimeout(() => {
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
        alert('Settings saved successfully!');
    }, 1000);
});

// Initialize page
document.addEventListener('DOMContentLoaded', function() {
    // Set default active tab
    showTab('general');
    
    // Initialize toggle states
    togglePreviewOptions();
    toggleCertificateOptions();
});
</script>

<?php
$content = ob_get_clean();
include '../app/Views/layouts/instructor.php';