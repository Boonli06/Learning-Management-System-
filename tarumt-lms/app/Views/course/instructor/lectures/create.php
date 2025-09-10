<?php
ob_start();

// Handle any errors from session
$errors = $_SESSION['errors'] ?? [];
$oldInput = $_SESSION['old_input'] ?? [];
$preFill = $_SESSION['pre_fill'] ?? [];

// Clear session data
unset($_SESSION['errors'], $_SESSION['old_input'], $_SESSION['pre_fill']);
?>

<form id="createLectureForm" class="space-y-8" method="POST" action="/instructor/lectures/create" enctype="multipart/form-data">
    
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
                    value="<?= htmlspecialchars($oldInput['title'] ?? '') ?>"
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
                        value="<?= htmlspecialchars($oldInput['slug'] ?? '') ?>"
                        class="flex-1 block w-full rounded-none rounded-r-lg border border-gray-300 px-3 py-2 focus:ring-black focus:border-black transition-colors duration-200" 
                        placeholder="introduction-to-laravel-routing"
                        required
                        pattern="[a-z0-9-]+"
                        title="Only lowercase letters, numbers, and hyphens allowed"
                    >
                </div>
                <p class="mt-1 text-xs text-gray-500">URL-friendly version of the title (auto-generated)</p>
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
                            <?= ($oldInput['course_id'] ?? $preFill['course_id'] ?? '') == $course['id'] ? 'selected' : '' ?>>
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
                    disabled
                >
                    <option value="">Select a section</option>
                    <?php foreach ($sections as $section): ?>
                        <option value="<?= $section['id'] ?>" 
                            data-course-id="<?= $section['course_id'] ?>"
                            <?= ($oldInput['section_id'] ?? $preFill['section_id'] ?? '') == $section['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($section['title']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <p class="mt-1 text-xs text-gray-500">Choose a course first</p>
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
                ><?= htmlspecialchars($oldInput['description'] ?? '') ?></textarea>
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
                    value="<?= htmlspecialchars($oldInput['video_url'] ?? '') ?>"
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
                    value="<?= htmlspecialchars($oldInput['order'] ?? '1') ?>"
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
                    value="<?= htmlspecialchars($oldInput['duration'] ?? '') ?>"
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
                                <?= ($oldInput['status'] ?? 'published') === $value ? 'checked' : '' ?>
                            >
                            <div class="ml-3">
                                <span class="text-sm font-medium text-gray-700"><?= $label ?></span>
                                <?php if ($value === 'draft'): ?>
                                    <p class="text-xs text-gray-500">Lecture will be saved but not visible to students</p>
                                <?php elseif ($value === 'published'): ?>
                                    <p class="text-xs text-gray-500">Lecture will be immediately available to enrolled students</p>
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
                            <?= isset($oldInput['is_preview']) && $oldInput['is_preview'] ? 'checked' : '' ?>
                        >
                        <div class="ml-2">
                            <span class="text-sm text-gray-700">Free Preview</span>
                            <p class="text-xs text-gray-500">Allow non-enrolled students to watch this lecture</p>
                        </div>
                    </label>
                </div>
            </div>
        </div>
    </div>

    <!-- Form Actions -->
    <div class="flex flex-col sm:flex-row gap-4 justify-end">
        <button 
            type="button" 
            class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black transition-colors duration-200"
            onclick="window.location.href='/instructor/lectures'"
        >
            Cancel
        </button>
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
            value="publish"
            class="px-6 py-3 bg-black text-white rounded-lg hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black transition-colors duration-200"
            id="publishBtn"
        >
            <span id="publishText">
                <i class="fas fa-upload mr-2"></i>
                Create Lecture
            </span>
            <span id="publishLoading" class="hidden">
                <i class="fas fa-spinner fa-spin mr-2"></i>
                Creating...
            </span>
        </button>
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

// Auto-generate slug from title
function generateSlug() {
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
            sectionSelect.appendChild(option);
        });
        
        sectionSelect.parentElement.querySelector('p').textContent = 
            courseSections.length ? 'Choose a section within this course' : 'No sections available for this course';
    } else {
        sectionSelect.disabled = true;
        sectionSelect.parentElement.querySelector('p').textContent = 'Choose a course first';
    }
}

// Initialize sections if course is pre-selected
document.addEventListener('DOMContentLoaded', function() {
    const courseSelect = document.getElementById('course_id');
    const sectionSelect = document.getElementById('section_id');
    
    if (courseSelect.value) {
        updateSections();
        
        // If section is pre-filled, select it
        const preSelectedSection = '<?= $oldInput['section_id'] ?? $preFill['section_id'] ?? '' ?>';
        if (preSelectedSection) {
            sectionSelect.value = preSelectedSection;
        }
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
document.getElementById('createLectureForm').addEventListener('submit', function(e) {
    const submitButton = e.submitter;
    
    if (submitButton && submitButton.id === 'publishBtn') {
        const publishText = document.getElementById('publishText');
        const publishLoading = document.getElementById('publishLoading');
        
        publishText.classList.add('hidden');
        publishLoading.classList.remove('hidden');
        submitButton.disabled = true;
        
        // Re-enable after a delay if form validation fails
        setTimeout(() => {
            publishText.classList.remove('hidden');
            publishLoading.classList.add('hidden');
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
</script>

<?php
$content = ob_get_clean();
include '../app/Views/layouts/instructor.php';
?>