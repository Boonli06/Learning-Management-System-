<?php
ob_start();

// Handle any errors from session
$errors = $_SESSION['errors'] ?? [];
$oldInput = $_SESSION['old_input'] ?? [];

// Clear session data
unset($_SESSION['errors'], $_SESSION['old_input']);

// Use old input if available, otherwise use lecture data
$formData = !empty($oldInput) ? $oldInput : $lecture;
?>

<form id="editLectureForm" class="space-y-8" method="POST" action="/instructor/lectures/<?= $lecture['id'] ?>/edit" enctype="multipart/form-data">
    <input type="hidden" name="_method" value="PUT">
    
    <!-- Basic Information Card -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center mb-6">
            <div class="w-8 h-8 bg-black rounded-lg flex items-center justify-center mr-3">
                <span class="text-white text-sm font-bold">1</span>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-gray-900">Basic Information</h3>
                <p class="text-sm text-gray-500">Essential details about your lecture</p>
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
            <!-- Lecture Title -->
            <div class="lg:col-span-2">
                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                    Lecture Title <span class="text-red-500">*</span>
                </label>
                <input 
                    type="text" 
                    id="title" 
                    name="title" 
                    value="<?= htmlspecialchars($formData['title'] ?? '') ?>"
                    class="block w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-black focus:border-black transition-colors duration-200" 
                    placeholder="e.g., Introduction to Laravel Routing"
                    required
                    maxlength="100"
                    oninput="generateSlug()"
                >
                <p class="mt-1 text-xs text-gray-500">Keep it clear and descriptive (100 characters max)</p>
            </div>

            <!-- URL Slug -->
            <div class="lg:col-span-2">
                <label for="slug" class="block text-sm font-medium text-gray-700 mb-2">
                    URL Slug <span class="text-red-500">*</span>
                </label>
                <div class="flex rounded-lg shadow-sm">
                    <span class="inline-flex items-center px-3 rounded-l-lg border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">
                        /lectures/
                    </span>
                    <input 
                        type="text" 
                        id="slug" 
                        name="slug" 
                        value="<?= htmlspecialchars($formData['slug'] ?? '') ?>"
                        class="flex-1 block w-full rounded-none rounded-r-lg border border-gray-300 px-3 py-2 focus:ring-black focus:border-black transition-colors duration-200" 
                        placeholder="introduction-to-laravel-routing"
                        required
                        pattern="[a-z0-9-]+"
                        title="Only lowercase letters, numbers, and hyphens allowed"
                    >
                </div>
                <p class="mt-1 text-xs text-gray-500">URL-friendly version of the title</p>
            </div>

            <!-- Course Selection -->
            <div>
                <label for="course_id" class="block text-sm font-medium text-gray-700 mb-2">
                    Course <span class="text-red-500">*</span>
                </label>
                <select 
                    id="course_id" 
                    name="course_id" 
                    class="block w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-black focus:border-black transition-colors duration-200"
                    required
                    onchange="updateSections()"
                >
                    <option value="">Select a course</option>
                    <?php foreach ($courses as $course): ?>
                        <option value="<?= $course['id'] ?>" 
                            <?= ($formData['course_id'] ?? '') == $course['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($course['title']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Section Selection -->
            <div>
                <label for="section_id" class="block text-sm font-medium text-gray-700 mb-2">
                    Section <span class="text-red-500">*</span>
                </label>
                <select 
                    id="section_id" 
                    name="section_id" 
                    class="block w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-black focus:border-black transition-colors duration-200"
                    required
                >
                    <option value="">Select a section</option>
                    <?php foreach ($sections as $section): ?>
                        <option value="<?= $section['id'] ?>" 
                            data-course-id="<?= $section['course_id'] ?>"
                            <?= ($formData['section_id'] ?? '') == $section['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($section['title']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <p class="mt-1 text-xs text-gray-500">Section within the selected course</p>
            </div>

            <!-- Lecture Description -->
            <div class="lg:col-span-2">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                    Lecture Description <span class="text-red-500">*</span>
                </label>
                <textarea 
                    id="description" 
                    name="description" 
                    rows="4" 
                    class="block w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-black focus:border-black transition-colors duration-200" 
                    placeholder="Describe what students will learn in this lecture..."
                    required
                    maxlength="500"
                ><?= htmlspecialchars($formData['description'] ?? '') ?></textarea>
                <div class="flex justify-between mt-1">
                    <p class="text-xs text-gray-500">Clear description helps students understand the content</p>
                    <span class="text-xs text-gray-400" id="descCounter">0/500</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Lecture Content Card -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center mb-6">
            <div class="w-8 h-8 bg-black rounded-lg flex items-center justify-center mr-3">
                <span class="text-white text-sm font-bold">2</span>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-gray-900">Lecture Content</h3>
                <p class="text-sm text-gray-500">Video content and organization</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Video URL -->
            <div class="lg:col-span-2">
                <label for="video_url" class="block text-sm font-medium text-gray-700 mb-2">
                    Video URL <span class="text-red-500">*</span>
                </label>
                <input 
                    type="url" 
                    id="video_url" 
                    name="video_url" 
                    value="<?= htmlspecialchars($formData['video_url'] ?? '') ?>"
                    class="block w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-black focus:border-black transition-colors duration-200" 
                    placeholder="https://youtube.com/watch?v=... or https://vimeo.com/..."
                    required
                >
                <p class="mt-1 text-xs text-gray-500">YouTube, Vimeo, or direct video link</p>
            </div>

            <!-- Lecture Order -->
            <div>
                <label for="order" class="block text-sm font-medium text-gray-700 mb-2">
                    Lecture Order <span class="text-red-500">*</span>
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
                    max="999"
                >
                <p class="mt-1 text-xs text-gray-500">Position within the section</p>
            </div>

            <!-- Duration -->
            <div>
                <label for="duration" class="block text-sm font-medium text-gray-700 mb-2">
                    Duration (minutes) <span class="text-red-500">*</span>
                </label>
                <input 
                    type="number" 
                    id="duration" 
                    name="duration" 
                    value="<?= htmlspecialchars($formData['duration'] ?? '') ?>"
                    class="block w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-black focus:border-black transition-colors duration-200" 
                    placeholder="15"
                    required
                    min="1"
                    max="300"
                >
                <p class="mt-1 text-xs text-gray-500">Video length in minutes</p>
            </div>
        </div>
    </div>

    <!-- Analytics & Performance Card -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center mb-6">
            <div class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center mr-3">
                <i class="fas fa-chart-line text-gray-600 text-sm"></i>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-gray-900">Performance Overview</h3>
                <p class="text-sm text-gray-500">Current lecture statistics</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="bg-gray-50 rounded-lg p-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-eye text-blue-600 text-sm"></i>
                        </div>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-500">Views</p>
                        <p class="text-lg font-semibold text-gray-900"><?= number_format($lecture['view_count']) ?></p>
                    </div>
                </div>
            </div>

            <div class="bg-gray-50 rounded-lg p-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-check-circle text-green-600 text-sm"></i>
                        </div>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-500">Completion</p>
                        <p class="text-lg font-semibold text-gray-900"><?= number_format($lecture['completion_rate'], 1) ?>%</p>
                    </div>
                </div>
            </div>

            <div class="bg-gray-50 rounded-lg p-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-clock text-purple-600 text-sm"></i>
                        </div>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-500">Duration</p>
                        <p class="text-lg font-semibold text-gray-900"><?= $lecture['duration'] ?>m</p>
                    </div>
                </div>
            </div>

            <div class="bg-gray-50 rounded-lg p-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-calendar text-gray-600 text-sm"></i>
                        </div>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-500">Updated</p>
                        <p class="text-sm font-semibold text-gray-900"><?= date('M j, Y', strtotime($lecture['updated_at'])) ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Publishing Options Card -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center mb-6">
            <div class="w-8 h-8 bg-black rounded-lg flex items-center justify-center mr-3">
                <span class="text-white text-sm font-bold">3</span>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-gray-900">Publishing Options</h3>
                <p class="text-sm text-gray-500">Control lecture visibility and access</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Status -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Publication Status <span class="text-red-500">*</span>
                </label>
                <div class="space-y-3">
                    <?php foreach ($statusOptions as $value => $label): ?>
                        <label class="flex items-start">
                            <input 
                                type="radio" 
                                name="status" 
                                value="<?= $value ?>" 
                                class="mt-1 text-black focus:ring-black"
                                <?= ($formData['status'] ?? 'published') === $value ? 'checked' : '' ?>
                            >
                            <div class="ml-3">
                                <span class="text-sm font-medium text-gray-700"><?= $label ?></span>
                                <?php if ($value === 'draft'): ?>
                                    <p class="text-xs text-gray-500">Lecture will be saved but not visible to students</p>
                                <?php elseif ($value === 'published'): ?>
                                    <p class="text-xs text-gray-500">Lecture will be immediately available to enrolled students</p>
                                <?php elseif ($value === 'archived'): ?>
                                    <p class="text-xs text-gray-500">Lecture will be hidden but remain accessible via direct link</p>
                                <?php endif; ?>
                            </div>
                        </label>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Additional Options -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Additional Options</label>
                <div class="space-y-3">
                    <label class="flex items-center">
                        <input 
                            type="checkbox" 
                            name="is_preview" 
                            value="1" 
                            class="text-black focus:ring-black"
                            <?= ($formData['is_preview'] ?? false) ? 'checked' : '' ?>
                        >
                        <div class="ml-2">
                            <span class="text-sm text-gray-700">Free Preview</span>
                            <p class="text-xs text-gray-500">Allow non-enrolled students to watch this lecture</p>
                        </div>
                    </label>
                </div>

                <!-- Current Status Display -->
                <div class="mt-4 p-3 bg-gray-50 rounded-lg">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">Current Status:</span>
                        <?php if ($lecture['status'] === 'published'): ?>
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                <span class="w-1.5 h-1.5 bg-green-400 rounded-full mr-1"></span>
                                Published
                            </span>
                        <?php elseif ($lecture['status'] === 'draft'): ?>
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                <span class="w-1.5 h-1.5 bg-yellow-400 rounded-full mr-1"></span>
                                Draft
                            </span>
                        <?php else: ?>
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                <span class="w-1.5 h-1.5 bg-gray-400 rounded-full mr-1"></span>
                                Archived
                            </span>
                        <?php endif; ?>
                    </div>
                    <?php if ($lecture['is_preview']): ?>
                        <div class="mt-2 flex items-center">
                            <span class="text-sm text-gray-600">Preview:</span>
                            <span class="ml-2 inline-flex items-center px-1.5 py-0.5 rounded text-xs font-medium bg-orange-100 text-orange-800">
                                Enabled
                            </span>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Form Actions -->
    <div class="flex flex-col sm:flex-row gap-4 justify-between">
        <div class="flex flex-col sm:flex-row gap-4">
            <button 
                type="button" 
                class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black transition-colors duration-200"
                onclick="window.location.href='/instructor/lectures'"
            >
                <i class="fas fa-arrow-left mr-2"></i>
                Back to Lectures
            </button>
            <button 
                type="button" 
                class="px-6 py-3 border border-blue-300 text-blue-700 rounded-lg hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200"
                onclick="previewLecture()"
            >
                <i class="fas fa-eye mr-2"></i>
                Preview
            </button>
        </div>
        
        <div class="flex flex-col sm:flex-row gap-4">
            <button 
                type="submit" 
                name="action"
                value="draft"
                class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black transition-colors duration-200"
            >
                <i class="fas fa-save mr-2"></i>
                Save as Draft
            </button>
            <button 
                type="submit" 
                name="action"
                value="update"
                class="px-6 py-3 bg-black text-white rounded-lg hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black transition-colors duration-200"
                id="updateBtn"
            >
                <span id="updateText">
                    <i class="fas fa-save mr-2"></i>
                    Update Lecture
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
// Section data from PHP
const sectionsData = <?= json_encode($sections) ?>;

// Character counter for description
document.getElementById('description').addEventListener('input', function() {
    const counter = document.getElementById('descCounter');
    const length = this.value.length;
    counter.textContent = `${length}/500`;
    
    if (length > 450) {
        counter.classList.add('text-red-500');
        counter.classList.remove('text-gray-400');
    } else {
        counter.classList.remove('text-red-500');
        counter.classList.add('text-gray-400');
    }
});

// Auto-generate slug from title (only if manual changes haven't been made)
let slugManuallyChanged = false;
document.getElementById('slug').addEventListener('input', function() {
    slugManuallyChanged = true;
});

function generateSlug() {
    if (slugManuallyChanged) return;
    
    const title = document.getElementById('title').value;
    const slug = title
        .toLowerCase()
        .replace(/[^a-z0-9\s-]/g, '')
        .replace(/\s+/g, '-')
        .replace(/-+/g, '-')
        .replace(/^-|-$/g, '');
    
    document.getElementById('slug').value = slug;
}

// Update sections based on course selection
function updateSections() {
    const courseSelect = document.getElementById('course_id');
    const sectionSelect = document.getElementById('section_id');
    const courseId = courseSelect.value;
    const currentSectionId = sectionSelect.value;
    
    // Clear existing options
    sectionSelect.innerHTML = '<option value="">Select a section</option>';
    
    if (courseId) {
        sectionSelect.disabled = false;
        
        // Filter sections for selected course
        const courseSections = sectionsData.filter(section => 
            section.course_id == courseId
        );
        
        courseSections.forEach(section => {
            const option = document.createElement('option');
            option.value = section.id;
            option.textContent = section.title;
            if (section.id == currentSectionId) {
                option.selected = true;
            }
            sectionSelect.appendChild(option);
        });
        
        sectionSelect.parentElement.querySelector('p').textContent = 
            courseSections.length ? 'Section within the selected course' : 'No sections available for this course';
    } else {
        sectionSelect.disabled = true;
        sectionSelect.parentElement.querySelector('p').textContent = 'Choose a course first';
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    const courseSelect = document.getElementById('course_id');
    
    if (courseSelect.value) {
        updateSections();
    }
    
    // Update description counter
    const descriptionField = document.getElementById('description');
    if (descriptionField.value) {
        descriptionField.dispatchEvent(new Event('input'));
    }
});

// Form validation
const requiredFields = ['title', 'slug', 'description', 'course_id', 'section_id', 'video_url', 'order', 'duration'];

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
    } else {
        field.classList.remove('border-red-500');
        field.classList.add('border-gray-300');
    }
}

// URL validation for video
document.getElementById('video_url').addEventListener('blur', function() {
    const url = this.value.trim();
    if (url) {
        try {
            const urlObj = new URL(url);
            const isValid = urlObj.protocol === 'http:' || urlObj.protocol === 'https:';
            
            if (!isValid) {
                this.classList.add('border-red-500');
                this.classList.remove('border-gray-300');
            } else {
                this.classList.remove('border-red-500');
                this.classList.add('border-gray-300');
            }
        } catch {
            this.classList.add('border-red-500');
            this.classList.remove('border-gray-300');
        }
    }
});

// Form submission handling
document.getElementById('editLectureForm').addEventListener('submit', function(e) {
    const submitButton = e.submitter;
    
    if (submitButton && submitButton.id === 'updateBtn') {
        const updateText = document.getElementById('updateText');
        const updateLoading = document.getElementById('updateLoading');
        
        updateText.classList.add('hidden');
        updateLoading.classList.remove('hidden');
        submitButton.disabled = true;
        
        // Re-enable after a delay if form validation fails
        setTimeout(() => {
            updateText.classList.remove('hidden');
            updateLoading.classList.add('hidden');
            submitButton.disabled = false;
        }, 3000);
    }
});

// Slug validation
document.getElementById('slug').addEventListener('input', function() {
    let value = this.value;
    
    // Remove invalid characters
    value = value.toLowerCase().replace(/[^a-z0-9-]/g, '');
    
    // Replace multiple hyphens with single hyphen
    value = value.replace(/-+/g, '-');
    
    // Remove leading/trailing hyphens
    value = value.replace(/^-|-$/g, '');
    
    this.value = value;
});

// Video URL helper text
document.getElementById('video_url').addEventListener('input', function() {
    const url = this.value.trim();
    const helpText = this.parentElement.querySelector('p');
    
    if (url.includes('youtube.com') || url.includes('youtu.be')) {
        helpText.textContent = 'YouTube video detected - ensure it\'s publicly accessible';
        helpText.className = 'mt-1 text-xs text-blue-600';
    } else if (url.includes('vimeo.com')) {
        helpText.textContent = 'Vimeo video detected - ensure it\'s publicly accessible';
        helpText.className = 'mt-1 text-xs text-blue-600';
    } else if (url && (url.includes('.mp4') || url.includes('.webm') || url.includes('.ogg'))) {
        helpText.textContent = 'Direct video file detected';
        helpText.className = 'mt-1 text-xs text-green-600';
    } else {
        helpText.textContent = 'YouTube, Vimeo, or direct video link';
        helpText.className = 'mt-1 text-xs text-gray-500';
    }
});

// Preview function
function previewLecture() {
    window.open(`/lectures/<?= $lecture['id'] ?>/preview`, '_blank');
}

// Unsaved changes warning
let formChanged = false;
const form = document.getElementById('editLectureForm');
const originalFormData = new FormData(form);

form.addEventListener('input', function() {
    formChanged = true;
});

window.addEventListener('beforeunload', function(e) {
    if (formChanged) {
        e.preventDefault();
        e.returnValue = '';
    }
});

// Reset form changed flag when submitting
form.addEventListener('submit', function() {
    formChanged = false;
});
</script>

<?php
$content = ob_get_clean();
include '../app/Views/layouts/instructor.php';
?>