<?php
$title = 'Create Course - TARUMT LMS';
$pageTitle = 'Create New Course';
$pageSubtitle = 'Build your course from the ground up';
$currentPage = 'create-course';
$breadcrumbs = [
    ['title' => 'Courses', 'url' => '/instructor/courses'],
    ['title' => 'Create Course']
];

ob_start();
?>

<form id="createCourseForm" class="space-y-8" method="POST" action="/instructor/courses" enctype="multipart/form-data">
    
    <!-- Basic Information Card -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center mb-6">
            <div class="w-8 h-8 bg-black rounded-lg flex items-center justify-center mr-3">
                <span class="text-white text-sm font-bold">1</span>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-gray-900">Basic Information</h3>
                <p class="text-sm text-gray-500">Essential details about your course</p>
            </div>
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
                    class="block w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-black focus:border-black transition-colors duration-200" 
                    placeholder="e.g., Complete Web Development Bootcamp"
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
                        <option value="<?= $category['id'] ?>"><?= htmlspecialchars($category['name']) ?></option>
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
                    disabled
                >
                    <option value="">Select a subcategory</option>
                </select>
                <p class="mt-1 text-xs text-gray-500">Choose a category first</p>
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
                    placeholder="Write a compelling summary of what students will learn..."
                    required
                    maxlength="200"
                ></textarea>
                <div class="flex justify-between mt-1">
                    <p class="text-xs text-gray-500">This appears in course listings and search results</p>
                    <span class="text-xs text-gray-400" id="shortDescCounter">0/200</span>
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
                <p class="text-sm text-gray-500">Upload thumbnail and promotional content</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Course Thumbnail -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Course Thumbnail <span class="text-red-500">*</span>
                </label>
                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-gray-400 transition-colors duration-200">
                    <div class="space-y-1 text-center">
                        <div id="thumbnailPreview" class="hidden">
                            <img id="thumbnailImage" class="mx-auto h-32 w-auto rounded-lg" src="" alt="Course thumbnail">
                        </div>
                        <div id="thumbnailUpload">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex text-sm text-gray-600">
                                <label for="thumbnail" class="relative cursor-pointer bg-white rounded-md font-medium text-black hover:text-gray-800 focus-within:outline-none">
                                    <span>Upload a file</span>
                                    <input id="thumbnail" name="thumbnail" type="file" class="sr-only" accept="image/*" onchange="previewThumbnail(this)">
                                </label>
                                <p class="pl-1">or drag and drop</p>
                            </div>
                            <p class="text-xs text-gray-500">PNG, JPG, GIF up to 10MB (1280x720 recommended)</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Promotional Video (Optional) -->
            <div>
                <label for="promo_video" class="block text-sm font-medium text-gray-700 mb-2">
                    Promotional Video URL (Optional)
                </label>
                <input 
                    type="url" 
                    id="promo_video" 
                    name="promo_video_url" 
                    class="block w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-black focus:border-black transition-colors duration-200" 
                    placeholder="https://youtube.com/watch?v=..."
                >
                <p class="mt-1 text-xs text-gray-500">YouTube, Vimeo, or direct video link</p>
            </div>
        </div>
    </div>

    <!-- Course Details Card -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center mb-6">
            <div class="w-8 h-8 bg-black rounded-lg flex items-center justify-center mr-3">
                <span class="text-white text-sm font-bold">3</span>
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
            <div class="border border-gray-300 rounded-lg overflow-hidden">
                <div class="bg-gray-50 border-b border-gray-300 px-3 py-2">
                    <div class="flex space-x-2">
                        <button type="button" class="p-1 text-gray-600 hover:text-gray-900" onclick="formatText('bold')">
                            <i class="fas fa-bold"></i>
                        </button>
                        <button type="button" class="p-1 text-gray-600 hover:text-gray-900" onclick="formatText('italic')">
                            <i class="fas fa-italic"></i>
                        </button>
                        <button type="button" class="p-1 text-gray-600 hover:text-gray-900" onclick="formatText('insertUnorderedList')">
                            <i class="fas fa-list-ul"></i>
                        </button>
                        <button type="button" class="p-1 text-gray-600 hover:text-gray-900" onclick="formatText('insertOrderedList')">
                            <i class="fas fa-list-ol"></i>
                        </button>
                    </div>
                </div>
                <textarea 
                    id="description" 
                    name="description" 
                    rows="8" 
                    class="block w-full border-0 resize-none focus:ring-0" 
                    placeholder="Provide a detailed description of your course. What will students learn? What projects will they build? What makes this course unique?"
                    required
                ></textarea>
            </div>
            <p class="mt-1 text-xs text-gray-500">Use this space to convince students why they should take your course</p>
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
                    placeholder="What should students know before taking this course?"
                ></textarea>
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
                    <option value="">Select difficulty level</option>
                    <?php foreach ($difficultyOptions as $value => $label): ?>
                        <option value="<?= $value ?>"><?= $label ?></option>
                    <?php endforeach; ?>
                </select>
                
                <!-- Language -->
                <label for="language" class="block text-sm font-medium text-gray-700 mb-2 mt-4">
                    Course Language <span class="text-red-500">*</span>
                </label>
                <select 
                    id="language" 
                    name="language" 
                    class="block w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-black focus:border-black transition-colors duration-200"
                    required
                >
                    <option value="">Select language</option>
                    <?php foreach ($languageOptions as $value => $label): ?>
                        <option value="<?= $value ?>"><?= $label ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
    </div>

    <!-- Pricing Card -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center mb-6">
            <div class="w-8 h-8 bg-black rounded-lg flex items-center justify-center mr-3">
                <span class="text-white text-sm font-bold">4</span>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-gray-900">Pricing & Availability</h3>
                <p class="text-sm text-gray-500">Set your course price and availability</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Pricing Type -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Pricing Type <span class="text-red-500">*</span>
                </label>
                <div class="space-y-2">
                    <label class="flex items-center">
                        <input type="radio" name="pricing_type" value="paid" class="text-black focus:ring-black" checked onchange="togglePricing()">
                        <span class="ml-2 text-sm text-gray-700">Paid Course</span>
                    </label>
                    <label class="flex items-center">
                        <input type="radio" name="pricing_type" value="free" class="text-black focus:ring-black" onchange="togglePricing()">
                        <span class="ml-2 text-sm text-gray-700">Free Course</span>
                    </label>
                </div>
            </div>

            <!-- Price -->
            <div id="priceSection">
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
                        class="block w-full pl-12 border border-gray-300 rounded-lg px-3 py-2 focus:ring-black focus:border-black transition-colors duration-200" 
                        placeholder="0.00"
                        min="0"
                        step="0.01"
                    >
                </div>
                <p class="mt-1 text-xs text-gray-500">Recommended: RM 99 - RM 499</p>
            </div>

            <!-- Estimated Duration -->
            <div>
                <label for="duration" class="block text-sm font-medium text-gray-700 mb-2">
                    Estimated Duration (Hours)
                </label>
                <input 
                    type="number" 
                    id="duration" 
                    name="estimated_duration" 
                    class="block w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-black focus:border-black transition-colors duration-200" 
                    placeholder="10"
                    min="1"
                    max="200"
                >
                <p class="mt-1 text-xs text-gray-500">Total course length in hours</p>
            </div>
        </div>
    </div>

    <!-- Publishing Options Card -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center mb-6">
            <div class="w-8 h-8 bg-black rounded-lg flex items-center justify-center mr-3">
                <span class="text-white text-sm font-bold">5</span>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-gray-900">Publishing Options</h3>
                <p class="text-sm text-gray-500">Choose how to publish your course</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Publication Status</label>
                <div class="space-y-3">
                    <label class="flex items-start">
                        <input type="radio" name="status" value="draft" class="mt-1 text-black focus:ring-black" checked>
                        <div class="ml-3">
                            <span class="text-sm font-medium text-gray-700">Save as Draft</span>
                            <p class="text-xs text-gray-500">Course will be saved but not visible to students</p>
                        </div>
                    </label>
                    <label class="flex items-start">
                        <input type="radio" name="status" value="pending" class="mt-1 text-black focus:ring-black">
                        <div class="ml-3">
                            <span class="text-sm font-medium text-gray-700">Submit for Review</span>
                            <p class="text-xs text-gray-500">Course will be reviewed before going live</p>
                        </div>
                    </label>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Additional Options</label>
                <div class="space-y-3">
                    <label class="flex items-center">
                        <input type="checkbox" name="allow_preview" value="1" class="text-black focus:ring-black">
                        <span class="ml-2 text-sm text-gray-700">Allow course preview</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" name="enable_qa" value="1" class="text-black focus:ring-black" checked>
                        <span class="ml-2 text-sm text-gray-700">Enable Q&A discussions</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" name="certificate_enabled" value="1" class="text-black focus:ring-black" checked>
                        <span class="ml-2 text-sm text-gray-700">Provide completion certificate</span>
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
            onclick="window.location.href='/instructor/courses'"
        >
            Cancel
        </button>
        <button 
            type="submit" 
            class="px-6 py-3 bg-black text-white rounded-lg hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black transition-colors duration-200"
            id="submitBtn"
        >
            <span id="submitText">Create Course</span>
            <span id="submitLoading" class="hidden">
                <i class="fas fa-spinner fa-spin mr-2"></i>
                Creating...
            </span>
        </button>
    </div>

</form>

<script>
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
        subcategorySelect.parentElement.querySelector('p').textContent = 'Choose a specific area within this category';
    } else {
        subcategorySelect.disabled = true;
        subcategorySelect.parentElement.querySelector('p').textContent = 'Choose a category first';
    }
}

// Toggle pricing section based on pricing type
function togglePricing() {
    const pricingType = document.querySelector('input[name="pricing_type"]:checked').value;
    const priceSection = document.getElementById('priceSection');
    const priceInput = document.getElementById('price');
    
    if (pricingType === 'free') {
        priceSection.style.opacity = '0.5';
        priceInput.disabled = true;
        priceInput.value = '0';
        priceInput.removeAttribute('required');
    } else {
        priceSection.style.opacity = '1';
        priceInput.disabled = false;
        priceInput.setAttribute('required', 'required');
    }
}

// Thumbnail preview
function previewThumbnail(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('thumbnailImage').src = e.target.result;
            document.getElementById('thumbnailPreview').classList.remove('hidden');
            document.getElementById('thumbnailUpload').classList.add('hidden');
        };
        reader.readAsDataURL(input.files[0]);
    }
}

// Basic text formatting for description
function formatText(command) {
    document.execCommand(command, false, null);
    document.getElementById('description').focus();
}

// Form submission
document.getElementById('createCourseForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const submitBtn = document.getElementById('submitBtn');
    const submitText = document.getElementById('submitText');
    const submitLoading = document.getElementById('submitLoading');
    
    // Show loading state
    submitText.classList.add('hidden');
    submitLoading.classList.remove('hidden');
    submitBtn.disabled = true;
    
    // Simulate form submission (replace with actual submission logic)
    setTimeout(() => {
        // Reset button state
        submitText.classList.remove('hidden');
        submitLoading.classList.add('hidden');
        submitBtn.disabled = false;
        
        // Show success message and redirect
        alert('Course created successfully!');
        window.location.href = '/instructor/courses';
    }, 2000);
});

// Form validation
const requiredFields = ['title', 'category', 'subcategory', 'short_description', 'description', 'difficulty_level', 'language'];

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

// Auto-save draft (every 30 seconds)
setInterval(() => {
    const formData = new FormData(document.getElementById('createCourseForm'));
    formData.set('status', 'draft');
    
    // Auto-save logic would go here
    console.log('Auto-saving draft...');
}, 30000);
</script>

<?php
$content = ob_get_clean();
include '../app/Views/layouts/instructor.php';
?>