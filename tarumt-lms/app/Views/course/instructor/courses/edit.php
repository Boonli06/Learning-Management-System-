<?php
// 数据现在由Controller传递，直接开始页面内容
$courseId = $course['id'];

// Page actions for header
ob_start();
?>
<div class="flex gap-3">
    <button type="button" class="bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black transition-colors duration-200" onclick="window.location.href='/instructor/courses/<?= $courseId ?>/preview'">
        <i class="fas fa-eye mr-2"></i>
        Preview
    </button>
    <button type="button" class="bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black transition-colors duration-200" onclick="window.location.href='/instructor/courses/<?= $courseId ?>/analytics'">
        <i class="fas fa-chart-bar mr-2"></i>
        Analytics
    </button>
    <button type="button" class="bg-black text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black transition-colors duration-200" onclick="document.getElementById('editCourseForm').submit()">
        <i class="fas fa-save mr-2"></i>
        Save Changes
    </button>
</div>
<?php
$pageActions = ob_get_clean();

ob_start();
?>

<!-- Course Status Banner -->
<?php if ($course['status'] === 'published'): ?>
<div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
    <div class="flex items-center justify-between">
        <div class="flex items-center">
            <div class="w-2 h-2 bg-green-400 rounded-full mr-2"></div>
            <span class="text-sm font-medium text-green-800">This course is live and visible to students</span>
        </div>
        <div class="flex items-center gap-2 text-sm text-green-700">
            <span>45 enrolled students</span>
            <span>•</span>
            <span>Last updated: <?= date('M j, Y', strtotime($course['created_at'])) ?></span>
        </div>
    </div>
</div>
<?php elseif ($course['status'] === 'draft'): ?>
<div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
    <div class="flex items-center justify-between">
        <div class="flex items-center">
            <div class="w-2 h-2 bg-yellow-400 rounded-full mr-2"></div>
            <span class="text-sm font-medium text-yellow-800">This course is in draft mode and not visible to students</span>
        </div>
        <button type="button" class="bg-yellow-600 text-white px-3 py-1 rounded text-sm hover:bg-yellow-700 transition-colors duration-200">
            Publish Course
        </button>
    </div>
</div>
<?php endif; ?>

<form id="editCourseForm" class="space-y-8" method="POST" action="/instructor/courses/<?= $courseId ?>" enctype="multipart/form-data">
    <input type="hidden" name="_method" value="PUT">
    
    <!-- Basic Information Card -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center">
                <div class="w-8 h-8 bg-black rounded-lg flex items-center justify-center mr-3">
                    <span class="text-white text-sm font-bold">1</span>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Basic Information</h3>
                    <p class="text-sm text-gray-500">Essential details about your course</p>
                </div>
            </div>
            <span class="text-xs text-gray-500">Last saved: Just now</span>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Course Title -->
            <div class="lg:col-span-2">
                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                    Course Title <span class="text-red-500">*</span>
                </label>
                <input 
                    type="text" 
                    id="title" 
                    name="title" 
                    value="<?= htmlspecialchars($course['title']) ?>"
                    class="block w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-black focus:border-black transition-colors duration-200" 
                    required
                    maxlength="100"
                >
                <p class="mt-1 text-xs text-gray-500">Keep it clear and descriptive (100 characters max)</p>
            </div>

            <!-- Category -->
            <div>
                <label for="category" class="block text-sm font-medium text-gray-700 mb-2">
                    Category <span class="text-red-500">*</span>
                </label>
                <select 
                    id="category" 
                    name="category_id" 
                    class="block w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-black focus:border-black transition-colors duration-200"
                    required
                    onchange="updateSubcategories()"
                >
                    <option value="">Select a category</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= $category['id'] ?>" <?= $course['category_id'] == $category['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($category['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Subcategory -->
            <div>
                <label for="subcategory" class="block text-sm font-medium text-gray-700 mb-2">
                    Subcategory <span class="text-red-500">*</span>
                </label>
                <select 
                    id="subcategory" 
                    name="subcategory_id" 
                    class="block w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-black focus:border-black transition-colors duration-200"
                    required
                >
                    <option value="">Select a subcategory</option>
                    <?php 
                    // Find current category's subcategories
                    $currentSubcategories = [];
                    foreach ($categories as $category) {
                        if ($category['id'] == $course['category_id']) {
                            $currentSubcategories = $category['subcategories'];
                            break;
                        }
                    }
                    foreach ($currentSubcategories as $subcategory): 
                    ?>
                        <option value="<?= $subcategory['id'] ?>" <?= $course['subcategory_id'] == $subcategory['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($subcategory['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Short Description -->
            <div class="lg:col-span-2">
                <label for="short_description" class="block text-sm font-medium text-gray-700 mb-2">
                    Short Description <span class="text-red-500">*</span>
                </label>
                <textarea 
                    id="short_description" 
                    name="short_description" 
                    rows="3" 
                    class="block w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-black focus:border-black transition-colors duration-200" 
                    required
                    maxlength="200"
                ><?= htmlspecialchars($course['short_description']) ?></textarea>
                <div class="flex justify-between mt-1">
                    <p class="text-xs text-gray-500">This appears in course listings and search results</p>
                    <span class="text-xs text-gray-400" id="shortDescCounter"><?= strlen($course['short_description']) ?>/200</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Course Media Card -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center mb-6">
            <div class="w-8 h-8 bg-black rounded-lg flex items-center justify-center mr-3">
                <span class="text-white text-sm font-bold">2</span>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-gray-900">Course Media</h3>
                <p class="text-sm text-gray-500">Update thumbnail and promotional content</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Current Thumbnail -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Course Thumbnail
                </label>
                <div class="mb-4">
                    <div class="aspect-video bg-gradient-to-br from-gray-900 to-gray-700 rounded-lg flex items-center justify-center relative">
                        <span class="text-white text-2xl font-bold">Laravel</span>
                        <div class="absolute top-3 right-3">
                            <button type="button" class="bg-black bg-opacity-50 text-white p-2 rounded-lg hover:bg-opacity-70 transition-colors duration-200" onclick="document.getElementById('thumbnailInput').click()">
                                <i class="fas fa-edit text-sm"></i>
                            </button>
                        </div>
                    </div>
                    <input type="file" id="thumbnailInput" name="thumbnail" class="hidden" accept="image/*" onchange="previewThumbnail(this)">
                </div>
                <button type="button" class="w-full bg-gray-50 border border-gray-300 text-gray-700 px-3 py-2 rounded-lg text-sm hover:bg-gray-100 transition-colors duration-200" onclick="document.getElementById('thumbnailInput').click()">
                    <i class="fas fa-upload mr-2"></i>
                    Change Thumbnail
                </button>
            </div>

            <!-- Promotional Video -->
            <div>
                <label for="promo_video" class="block text-sm font-medium text-gray-700 mb-2">
                    Promotional Video URL
                </label>
                <input 
                    type="url" 
                    id="promo_video" 
                    name="promo_video_url" 
                    value="<?= htmlspecialchars($course['promo_video_url']) ?>"
                    class="block w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-black focus:border-black transition-colors duration-200 mb-4" 
                    placeholder="https://youtube.com/watch?v=..."
                >
                <div class="bg-gray-50 rounded-lg p-4">
                    <h4 class="text-sm font-medium text-gray-900 mb-2">Video Guidelines:</h4>
                    <ul class="text-xs text-gray-600 space-y-1">
                        <li>• Keep it under 2 minutes for best engagement</li>
                        <li>• Show course highlights and outcomes</li>
                        <li>• Use clear audio and good lighting</li>
                        <li>• Include a call-to-action</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Course Content Management -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center">
                <div class="w-8 h-8 bg-black rounded-lg flex items-center justify-center mr-3">
                    <span class="text-white text-sm font-bold">3</span>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Course Content</h3>
                    <p class="text-sm text-gray-500">Manage sections, lectures, and course structure</p>
                </div>
            </div>
            <button type="button" class="bg-black text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-800 transition-colors duration-200" onclick="window.location.href='/instructor/courses/<?= $courseId ?>/sections'">
                <i class="fas fa-edit mr-2"></i>
                Manage Content
            </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <div class="bg-gray-50 rounded-lg p-4 text-center">
                <div class="text-2xl font-bold text-gray-900">12</div>
                <div class="text-sm text-gray-500">Sections</div>
            </div>
            <div class="bg-gray-50 rounded-lg p-4 text-center">
                <div class="text-2xl font-bold text-gray-900">48</div>
                <div class="text-sm text-gray-500">Lectures</div>
            </div>
            <div class="bg-gray-50 rounded-lg p-4 text-center">
                <div class="text-2xl font-bold text-gray-900">25h</div>
                <div class="text-sm text-gray-500">Total Duration</div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-3">
            <button type="button" class="flex items-center justify-center p-3 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors duration-200" onclick="window.location.href='/instructor/courses/<?= $courseId ?>/sections/create'">
                <i class="fas fa-plus mr-2 text-gray-600"></i>
                <span class="text-sm font-medium text-gray-700">Add Section</span>
            </button>
            <button type="button" class="flex items-center justify-center p-3 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors duration-200" onclick="window.location.href='/instructor/courses/<?= $courseId ?>/lectures/create'">
                <i class="fas fa-video mr-2 text-gray-600"></i>
                <span class="text-sm font-medium text-gray-700">Add Lecture</span>
            </button>
            <button type="button" class="flex items-center justify-center p-3 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors duration-200" onclick="window.location.href='/instructor/courses/<?= $courseId ?>/goals'">
                <i class="fas fa-bullseye mr-2 text-gray-600"></i>
                <span class="text-sm font-medium text-gray-700">Learning Goals</span>
            </button>
            <button type="button" class="flex items-center justify-center p-3 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors duration-200" onclick="window.location.href='/instructor/courses/<?= $courseId ?>/settings'">
                <i class="fas fa-cog mr-2 text-gray-600"></i>
                <span class="text-sm font-medium text-gray-700">Settings</span>
            </button>
        </div>
    </div>

    <!-- Course Details Card -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center mb-6">
            <div class="w-8 h-8 bg-black rounded-lg flex items-center justify-center mr-3">
                <span class="text-white text-sm font-bold">4</span>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-gray-900">Course Details</h3>
                <p class="text-sm text-gray-500">Detailed description and requirements</p>
            </div>
        </div>

        <!-- Full Description -->
        <div class="mb-6">
            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                Course Description <span class="text-red-500">*</span>
            </label>
            <textarea 
                id="description" 
                name="description" 
                rows="8" 
                class="block w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-black focus:border-black transition-colors duration-200" 
                required
            ><?= htmlspecialchars($course['description']) ?></textarea>
        </div>

        <!-- Prerequisites and Level -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div>
                <label for="prerequisites" class="block text-sm font-medium text-gray-700 mb-2">
                    Prerequisites
                </label>
                <textarea 
                    id="prerequisites" 
                    name="prerequisites" 
                    rows="4" 
                    class="block w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-black focus:border-black transition-colors duration-200" 
                ><?= htmlspecialchars($course['prerequisites']) ?></textarea>
            </div>

            <div>
                <label for="difficulty_level" class="block text-sm font-medium text-gray-700 mb-2">
                    Difficulty Level <span class="text-red-500">*</span>
                </label>
                <select 
                    id="difficulty_level" 
                    name="difficulty_level" 
                    class="block w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-black focus:border-black transition-colors duration-200"
                    required
                >
                    <?php foreach ($difficultyOptions as $value => $label): ?>
                        <option value="<?= $value ?>" <?= $course['difficulty_level'] === $value ? 'selected' : '' ?>>
                            <?= $label ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                
                <label for="language" class="block text-sm font-medium text-gray-700 mb-2 mt-4">
                    Course Language <span class="text-red-500">*</span>
                </label>
               <select 
                    id="language" 
                    name="language" 
                    class="block w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-black focus:border-black transition-colors duration-200"
                    required
                >
                    <?php foreach ($languageOptions as $value => $label): ?>
                        <option value="<?= $value ?>" <?= $course['language'] === $value ? 'selected' : '' ?>>
                            <?= $label ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
    </div>

    <!-- Pricing Card -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center">
                <div class="w-8 h-8 bg-black rounded-lg flex items-center justify-center mr-3">
                    <span class="text-white text-sm font-bold">5</span>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Pricing & Settings</h3>
                    <p class="text-sm text-gray-500">Course price and availability options</p>
                </div>
            </div>
            <button type="button" class="text-sm text-black hover:text-gray-700 font-medium" onclick="window.location.href='/instructor/courses/<?= $courseId ?>/pricing'">
                Advanced Pricing <i class="fas fa-arrow-right ml-1"></i>
            </button>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Price -->
            <div>
                <label for="price" class="block text-sm font-medium text-gray-700 mb-2">
                    Course Price (RM) <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <span class="text-gray-500 sm:text-sm">RM</span>
                    </div>
                    <input 
                        type="number" 
                        id="price" 
                        name="price" 
                        value="<?= $course['price'] ?>"
                        class="block w-full pl-12 border border-gray-300 rounded-lg px-3 py-2 focus:ring-black focus:border-black transition-colors duration-200" 
                        min="0"
                        step="0.01"
                    >
                </div>
            </div>

            <!-- Duration -->
            <div>
                <label for="duration" class="block text-sm font-medium text-gray-700 mb-2">
                    Duration (Hours)
                </label>
                <input 
                    type="number" 
                    id="duration" 
                    name="estimated_duration" 
                    value="<?= $course['estimated_duration'] ?>"
                    class="block w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-black focus:border-black transition-colors duration-200" 
                    min="1"
                >
            </div>

            <!-- Course Options -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Course Options</label>
                <div class="space-y-2">
                    <label class="flex items-center">
                        <input type="checkbox" name="allow_preview" value="1" <?= $course['allow_preview'] ? 'checked' : '' ?> class="text-black focus:ring-black">
                        <span class="ml-2 text-sm text-gray-700">Allow preview</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" name="enable_qa" value="1" <?= $course['enable_qa'] ? 'checked' : '' ?> class="text-black focus:ring-black">
                        <span class="ml-2 text-sm text-gray-700">Enable Q&A</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" name="certificate_enabled" value="1" <?= $course['certificate_enabled'] ? 'checked' : '' ?> class="text-black focus:ring-black">
                        <span class="ml-2 text-sm text-gray-700">Provide certificate</span>
                    </label>
                </div>
            </div>
        </div>
    </div>

    <!-- Form Actions -->
    <div class="flex flex-col sm:flex-row gap-4 justify-between">
        <div class="flex gap-3">
            <button 
                type="button" 
                class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors duration-200"
                onclick="window.location.href='/instructor/courses'"
            >
                Cancel
            </button>
            <button 
                type="button" 
                class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors duration-200"
                onclick="saveDraft()"
            >
                Save as Draft
            </button>
        </div>
        <button 
            type="submit" 
            class="px-6 py-3 bg-black text-white rounded-lg hover:bg-gray-800 transition-colors duration-200"
        >
            <i class="fas fa-save mr-2"></i>
            Update Course
        </button>
    </div>

</form>

<script>
// Subcategory data from PHP
const subcategories = <?= json_encode(array_column($categories, 'subcategories', 'id')) ?>;

// Update subcategories based on category selection
function updateSubcategories() {
    const categorySelect = document.getElementById('category');
    const subcategorySelect = document.getElementById('subcategory');
    const categoryId = categorySelect.value;
    
    // Clear existing options
    subcategorySelect.innerHTML = '<option value="">Select a subcategory</option>';
    
    if (categoryId && subcategories[categoryId]) {
        subcategorySelect.disabled = false;
        subcategories[categoryId].forEach(sub => {
            const option = document.createElement('option');
            option.value = sub.id;
            option.textContent = sub.name;
            subcategorySelect.appendChild(option);
        });
    } else {
        subcategorySelect.disabled = true;
    }
}

// Character counter for short description
document.getElementById('short_description').addEventListener('input', function() {
    const counter = document.getElementById('shortDescCounter');
    const length = this.value.length;
    counter.textContent = `${length}/200`;
    
    if (length > 180) {
        counter.classList.add('text-red-500');
        counter.classList.remove('text-gray-400');
    } else {
        counter.classList.remove('text-red-500');
        counter.classList.add('text-gray-400');
    }
});

// Thumbnail preview
function previewThumbnail(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            // Update the preview (in real app, you'd update the image src)
            console.log('Thumbnail updated');
        };
        reader.readAsDataURL(input.files[0]);
    }
}

// Auto-save functionality
let autoSaveTimer;
const form = document.getElementById('editCourseForm');
const formInputs = form.querySelectorAll('input, textarea, select');

formInputs.forEach(input => {
    input.addEventListener('input', function() {
        clearTimeout(autoSaveTimer);
        autoSaveTimer = setTimeout(autoSave, 3000); // Auto-save after 3 seconds of inactivity
    });
});

function autoSave() {
    // In real app, this would send an AJAX request to save the form
    console.log('Auto-saving...');
    
    // Show auto-save indicator
    const indicator = document.createElement('div');
    indicator.className = 'fixed top-4 right-4 bg-green-500 text-white px-3 py-2 rounded-lg text-sm';
    indicator.textContent = 'Changes saved';
    document.body.appendChild(indicator);
    
    setTimeout(() => {
        indicator.remove();
    }, 2000);
}

function saveDraft() {
    const formData = new FormData(form);
    formData.set('status', 'draft');
    
    // In real app, this would send the form data
    console.log('Saving as draft...');
    alert('Course saved as draft');
}

// Form submission
form.addEventListener('submit', function(e) {
    e.preventDefault();
    
    // In real app, this would submit the form
    console.log('Updating course...');
    alert('Course updated successfully!');
});
</script>

<?php
$content = ob_get_clean();
include '../app/Views/layouts/instructor.php';
?>