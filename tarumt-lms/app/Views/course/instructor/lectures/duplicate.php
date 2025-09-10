<?php
ob_start();

// Handle any errors from session
$errors = $_SESSION['errors'] ?? [];
$oldInput = $_SESSION['old_input'] ?? [];

// Combine lecture data with old input
$formData = array_merge($lecture ?? [], $oldInput);

// Clear session data
unset($_SESSION['errors'], $_SESSION['old_input']);
?>

<form id="duplicateLectureForm" class="space-y-8" method="POST" action="/instructor/lectures/<?= $originalLecture['id'] ?>/duplicate" enctype="multipart/form-data">
    
    <!-- Original Lecture Info -->
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
        <div class="flex items-center mb-4">
            <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center mr-3">
                <i class="fas fa-info-circle text-white text-sm"></i>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-blue-900">Duplicating from Original Lecture</h3>
                <p class="text-sm text-blue-700">Creating a copy of "<?= htmlspecialchars($originalLecture['title']) ?>"</p>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
            <div>
                <span class="text-blue-700 font-medium">Original Title:</span>
                <p class="text-blue-900"><?= htmlspecialchars($originalLecture['title']) ?></p>
            </div>
            <div>
                <span class="text-blue-700 font-medium">Section:</span>
                <p class="text-blue-900"><?= htmlspecialchars($originalLecture['section_title']) ?></p>
            </div>
            <div>
                <span class="text-blue-700 font-medium">Duration:</span>
                <p class="text-blue-900"><?= $originalLecture['duration'] ?> minutes</p>
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
                <h3 class="text-lg font-semibold text-gray-900">Basic Information</h3>
                <p class="text-sm text-gray-500">Essential details about your duplicated lecture</p>
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
                    placeholder="e.g., Copy of Development Environment Setup"
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
                        placeholder="development-environment-setup-copy"
                        required
                        pattern="[a-z0-9-]+"
                        title="Only lowercase letters, numbers, and hyphens allowed"
                    >
                </div>
                <p class="mt-1 text-xs text-gray-500">URL-friendly version of the title (auto-generated)</p>
            </div>

            <!-- Section Selection -->
            <div class="lg:col-span-2">
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
                            <?= ($formData['section_id'] ?? '') == $section['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($section['course_title']) ?> - <?= htmlspecialchars($section['title']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
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
                    placeholder="25"
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
                                <?= ($formData['status'] ?? 'draft') === $value ? 'checked' : '' ?>
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
                            <?= isset($formData['is_preview']) && $formData['is_preview'] ? 'checked' : '' ?>
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
            value="duplicate"
            class="px-6 py-3 bg-black text-white rounded-lg hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black transition-colors duration-200"
            id="duplicateBtn"
        >
            <span id="duplicateText">
                <i class="fas fa-copy mr-2"></i>
                Duplicate Lecture
            </span>
            <span id="duplicateLoading" class="hidden">
                <i class="fas fa-spinner fa-spin mr-2"></i>
                Duplicating...
            </span>
        </button>
    </div>

</form>

<script>
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

// Initialize description counter
document.addEventListener('DOMContentLoaded', function() {
    const descriptionField = document.getElementById('description');
    if (descriptionField.value) {
        descriptionField.dispatchEvent(new Event('input'));
    }
});

// Form submission handling
document.getElementById('duplicateLectureForm').addEventListener('submit', function(e) {
    const submitButton = e.submitter;
    
    if (submitButton && submitButton.id === 'duplicateBtn') {
        const duplicateText = document.getElementById('duplicateText');
        const duplicateLoading = document.getElementById('duplicateLoading');
        
        duplicateText.classList.add('hidden');
        duplicateLoading.classList.remove('hidden');
        submitButton.disabled = true;
        
        // Re-enable after a delay if form validation fails
        setTimeout(() => {
            duplicateText.classList.remove('hidden');
            duplicateLoading.classList.add('hidden');
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
</script>

<?php
$content = ob_get_clean();
include '../app/Views/layouts/instructor.php';
?>