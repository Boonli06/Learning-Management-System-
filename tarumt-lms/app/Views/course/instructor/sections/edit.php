<?php
ob_start();
?>

<!-- Error Messages -->
<?php if (isset($_SESSION['errors']) && !empty($_SESSION['errors'])): ?>
<div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
    <div class="flex">
        <div class="flex-shrink-0">
            <i class="fas fa-exclamation-circle text-red-400"></i>
        </div>
        <div class="ml-3">
            <h3 class="text-sm font-medium text-red-800">Please correct the following errors:</h3>
            <div class="mt-2 text-sm text-red-700">
                <ul class="list-disc pl-5 space-y-1">
                    <?php foreach ($_SESSION['errors'] as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</div>
<?php 
unset($_SESSION['errors']);
endif; 
?>

<form id="sectionForm" method="POST" action="/instructor/sections/<?= $section['id'] ?>/edit" class="space-y-6">
    <!-- Basic Information -->
    <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Basic Information</h3>
            <p class="text-sm text-gray-500 mt-1">Update the essential details for your section</p>
        </div>
        <div class="p-6 space-y-6">
            <!-- Section Title -->
            <div>
                <label for="title" class="block text-sm font-medium text-gray-900 mb-2">
                    Section Title <span class="text-red-500">*</span>
                </label>
                <input 
                    type="text" 
                    id="title" 
                    name="title" 
                    value="<?= htmlspecialchars($_SESSION['old_input']['title'] ?? $section['title']) ?>"
                    required
                    class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm placeholder-gray-500 focus:outline-none focus:ring-1 focus:ring-black focus:border-black"
                    placeholder="e.g., Getting Started, Laravel Basics, Advanced Features"
                    maxlength="100"
                >
                <p class="text-xs text-gray-500 mt-1">Choose a clear, descriptive title for your section</p>
            </div>

            <!-- Section Slug -->
            <div>
                <label for="slug" class="block text-sm font-medium text-gray-900 mb-2">
                    URL Slug <span class="text-red-500">*</span>
                </label>
                <div class="flex rounded-lg shadow-sm">
                    <span class="inline-flex items-center px-3 rounded-l-lg border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">
                        /sections/
                    </span>
                    <input 
                        type="text" 
                        id="slug" 
                        name="slug" 
                        value="<?= htmlspecialchars($_SESSION['old_input']['slug'] ?? $section['slug']) ?>"
                        required
                        class="flex-1 block w-full px-3 py-2 border border-gray-300 rounded-none rounded-r-lg text-sm placeholder-gray-500 focus:outline-none focus:ring-1 focus:ring-black focus:border-black"
                        placeholder="getting-started"
                        pattern="[a-z0-9-]+"
                        maxlength="100"
                    >
                </div>
                <p class="text-xs text-gray-500 mt-1">URL-friendly version of the section title</p>
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-sm font-medium text-gray-900 mb-2">
                    Description <span class="text-red-500">*</span>
                </label>
                <textarea 
                    id="description" 
                    name="description" 
                    rows="4" 
                    required
                    class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm placeholder-gray-500 focus:outline-none focus:ring-1 focus:ring-black focus:border-black"
                    placeholder="Describe what students will learn in this section..."
                    maxlength="500"
                ><?= htmlspecialchars($_SESSION['old_input']['description'] ?? $section['description']) ?></textarea>
                <div class="flex justify-between text-xs text-gray-500 mt-1">
                    <span>Provide a clear overview of this section's content</span>
                    <span id="descriptionCount">0/500</span>
                </div>
            </div>

            <!-- Course Selection -->
            <div>
                <label for="course_id" class="block text-sm font-medium text-gray-900 mb-2">
                    Course <span class="text-red-500">*</span>
                </label>
                <select 
                    id="course_id" 
                    name="course_id" 
                    required
                    class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-1 focus:ring-black focus:border-black"
                >
                    <option value="">Select a course...</option>
                    <?php foreach ($courses as $course): ?>
                        <option value="<?= $course['id'] ?>" 
                                <?php 
                                $selectedCourseId = $_SESSION['old_input']['course_id'] ?? $section['course_id'];
                                echo ($selectedCourseId == $course['id']) ? 'selected' : '';
                                ?>>
                            <?= htmlspecialchars($course['title']) ?>
                            <?php if ($course['status'] !== 'active'): ?>
                                (<?= ucfirst($course['status']) ?>)
                            <?php endif; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <p class="text-xs text-gray-500 mt-1">Select the course this section belongs to</p>
            </div>

            <!-- Section Order -->
            <div>
                <label for="order" class="block text-sm font-medium text-gray-900 mb-2">
                    Section Order <span class="text-red-500">*</span>
                </label>
                <input 
                    type="number" 
                    id="order" 
                    name="order" 
                    value="<?= htmlspecialchars($_SESSION['old_input']['order'] ?? $section['order']) ?>"
                    min="1" 
                    max="999"
                    required
                    class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm placeholder-gray-500 focus:outline-none focus:ring-1 focus:ring-black focus:border-black"
                    placeholder="1"
                >
                <p class="text-xs text-gray-500 mt-1">Position in the course (1 = first section)</p>
            </div>
        </div>
    </div>

    <!-- Section Settings -->
    <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Section Settings</h3>
            <p class="text-sm text-gray-500 mt-1">Configure visibility and display options</p>
        </div>
        <div class="p-6 space-y-6">
            <!-- Status -->
            <div>
                <label for="status" class="block text-sm font-medium text-gray-900 mb-2">Status</label>
                <select 
                    id="status" 
                    name="status"
                    class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-1 focus:ring-black focus:border-black"
                >
                    <?php foreach ($statusOptions as $value => $label): ?>
                        <option value="<?= $value ?>" 
                                <?php 
                                $selectedStatus = $_SESSION['old_input']['status'] ?? $section['status'];
                                echo ($selectedStatus === $value) ? 'selected' : '';
                                ?>>
                            <?= $label ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <p class="text-xs text-gray-500 mt-1">Only active sections will be visible to students</p>
            </div>

            <!-- Preview Section -->
            <div class="flex items-center justify-between">
                <div>
                    <label for="is_preview" class="text-sm font-medium text-gray-900">Preview Section</label>
                    <p class="text-xs text-gray-500">Allow non-enrolled students to preview this section</p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" id="is_preview" name="is_preview" value="1" 
                           <?php 
                           $isPreview = $_SESSION['old_input']['is_preview'] ?? $section['is_preview'];
                           echo $isPreview ? 'checked' : '';
                           ?>
                           class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-black/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-black"></div>
                </label>
            </div>
        </div>
    </div>

    <!-- Section Statistics -->
    <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Section Statistics</h3>
            <p class="text-sm text-gray-500 mt-1">Current performance and content metrics</p>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="text-center">
                    <div class="text-2xl font-bold text-gray-900"><?= $section['lecture_count'] ?></div>
                    <div class="text-sm text-gray-500">Total Lectures</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-gray-900"><?= floor($section['total_duration'] / 60) ?>h <?= $section['total_duration'] % 60 ?>m</div>
                    <div class="text-sm text-gray-500">Total Duration</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-gray-900"><?= $section['order'] ?></div>
                    <div class="text-sm text-gray-500">Section Order</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Quick Actions</h3>
            <p class="text-sm text-gray-500 mt-1">Manage section content and settings</p>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <button type="button" 
                        onclick="window.location.href='/instructor/sections/<?= $section['id'] ?>'"
                        class="flex items-center justify-center px-4 py-3 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black transition-colors duration-200">
                    <i class="fas fa-eye mr-2"></i>
                    View Section
                </button>
                <button type="button" 
                        onclick="window.location.href='/instructor/sections/<?= $section['id'] ?>/lectures'"
                        class="flex items-center justify-center px-4 py-3 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black transition-colors duration-200">
                    <i class="fas fa-play mr-2"></i>
                    Manage Lectures
                </button>
                <button type="button" 
                        onclick="duplicateSection(<?= $section['id'] ?>)"
                        class="flex items-center justify-center px-4 py-3 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black transition-colors duration-200">
                    <i class="fas fa-copy mr-2"></i>
                    Duplicate Section
                </button>
            </div>
        </div>
    </div>

    <!-- Form Actions -->
    <div class="flex items-center justify-between space-x-4 pt-6 border-t border-gray-200">
        <button 
            type="button" 
            onclick="window.location.href='/instructor/sections'"
            class="bg-white border border-gray-300 text-gray-700 px-6 py-2 rounded-lg text-sm font-medium hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black transition-colors duration-200"
        >
            Cancel
        </button>
        
        <div class="flex space-x-3">
            <button 
                type="submit" 
                name="action" 
                value="draft"
                class="bg-gray-600 text-white px-6 py-2 rounded-lg text-sm font-medium hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-600 transition-colors duration-200"
            >
                <i class="fas fa-save mr-2"></i>
                Save as Draft
            </button>
            <button 
                type="submit" 
                name="action" 
                value="update"
                class="bg-black text-white px-6 py-2 rounded-lg text-sm font-medium hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black transition-colors duration-200"
            >
                <i class="fas fa-check mr-2"></i>
                Update Section
            </button>
        </div>
    </div>
</form>

<script>
// Auto-generate slug from title (only if slug is empty or matches old title pattern)
let originalSlug = '<?= $section['slug'] ?>';
let originalTitle = '<?= $section['title'] ?>';

document.getElementById('title').addEventListener('input', function() {
    const currentSlug = document.getElementById('slug').value;
    const expectedSlug = originalTitle.toLowerCase()
        .replace(/[^a-z0-9\s-]/g, '')
        .replace(/\s+/g, '-')
        .replace(/-+/g, '-')
        .replace(/^-|-$/g, '');
    
    // Auto-update slug only if it hasn't been manually changed
    if (currentSlug === originalSlug || currentSlug === expectedSlug) {
        const title = this.value;
        const slug = title.toLowerCase()
            .replace(/[^a-z0-9\s-]/g, '')
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-')
            .replace(/^-|-$/g, '');
        document.getElementById('slug').value = slug;
    }
});

// Character counter for description
function updateDescriptionCount() {
    const input = document.getElementById('description');
    const count = document.getElementById('descriptionCount');
    count.textContent = `${input.value.length}/500`;
    
    if (input.value.length > 450) {
        count.classList.add('text-orange-500');
        count.classList.remove('text-gray-500');
    } else {
        count.classList.remove('text-orange-500');
        count.classList.add('text-gray-500');
    }
    
    if (input.value.length >= 500) {
        count.classList.add('text-red-500');
        count.classList.remove('text-orange-500');
    } else {
        count.classList.remove('text-red-500');
    }
}

document.getElementById('description').addEventListener('input', updateDescriptionCount);

// Initialize character counter on page load
document.addEventListener('DOMContentLoaded', function() {
    updateDescriptionCount();
});

// Form validation
document.getElementById('sectionForm').addEventListener('submit', function(e) {
    const title = document.getElementById('title').value.trim();
    const slug = document.getElementById('slug').value.trim();
    const description = document.getElementById('description').value.trim();
    const courseId = document.getElementById('course_id').value;
    const order = document.getElementById('order').value;
    
    let errors = [];
    
    if (!title) {
        errors.push('Section title is required');
    }
    
    if (!slug) {
        errors.push('URL slug is required');
    } else if (!/^[a-z0-9-]+$/.test(slug)) {
        errors.push('URL slug can only contain lowercase letters, numbers, and hyphens');
    }
    
    if (!description) {
        errors.push('Description is required');
    }
    
    if (!courseId) {
        errors.push('Course selection is required');
    }
    
    if (!order || order < 1) {
        errors.push('Section order must be at least 1');
    }
    
    if (errors.length > 0) {
        e.preventDefault();
        alert('Please fix the following errors:\n\n' + errors.join('\n'));
        return false;
    }
    
    // Show loading state
    const submitBtns = this.querySelectorAll('button[type="submit"]');
    submitBtns.forEach(btn => {
        btn.disabled = true;
        const originalText = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Updating...';
    });
});

// Preview section toggle with warning
document.getElementById('is_preview').addEventListener('change', function() {
    // Remove existing warning
    const existingWarning = document.querySelector('.preview-warning');
    if (existingWarning) {
        existingWarning.remove();
    }
    
    if (this.checked) {
        // Show warning about preview sections
        const warning = document.createElement('div');
        warning.className = 'preview-warning mt-2 p-3 bg-orange-50 border border-orange-200 rounded-lg text-sm text-orange-700';
        warning.innerHTML = '<i class="fas fa-info-circle mr-2"></i>Preview sections will be visible to all visitors, even non-enrolled students.';
        
        this.closest('.flex').parentNode.appendChild(warning);
    }
});

// Quick action functions
function duplicateSection(sectionId) {
    if (confirm('Do you want to create a copy of this section? The new section will be created as a draft.')) {
        // In a real application, this would send an AJAX request
        fetch(`/instructor/sections/${sectionId}/duplicate`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        }).then(response => {
            if (response.ok) {
                alert('Section duplicated successfully!');
                window.location.href = '/instructor/sections';
            } else {
                alert('Failed to duplicate section. Please try again.');
            }
        }).catch(error => {
            console.log('Duplicate function placeholder - would duplicate section', sectionId);
            alert('Duplicate functionality would be implemented here');
        });
    }
}

// Initialize preview warning if section is already set as preview
document.addEventListener('DOMContentLoaded', function() {
    if (document.getElementById('is_preview').checked) {
        document.getElementById('is_preview').dispatchEvent(new Event('change'));
    }
});
</script>

<?php
// Clear old input data after displaying
unset($_SESSION['old_input']);
$content = ob_get_clean();
include '../app/Views/layouts/instructor.php';
?>