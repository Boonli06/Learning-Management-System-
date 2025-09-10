<?php
ob_start();
?>

<form id="categoryForm" method="POST" action="/instructor/categories/create" enctype="multipart/form-data" class="space-y-6">
    <!-- Basic Information -->
    <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Basic Information</h3>
            <p class="text-sm text-gray-500 mt-1">Provide the essential details for your category</p>
        </div>
        <div class="p-6 space-y-6">
            <!-- Category Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-900 mb-2">
                    Category Name <span class="text-red-500">*</span>
                </label>
                <input 
                    type="text" 
                    id="name" 
                    name="name" 
                    required
                    class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm placeholder-gray-500 focus:outline-none focus:ring-1 focus:ring-black focus:border-black"
                    placeholder="e.g. Web Development"
                >
                <p class="text-xs text-gray-500 mt-1">Choose a clear, descriptive name for your category</p>
            </div>

            <!-- Category Slug -->
            <div>
                <label for="slug" class="block text-sm font-medium text-gray-900 mb-2">
                    URL Slug <span class="text-red-500">*</span>
                </label>
                <div class="flex rounded-lg shadow-sm">
                    <span class="inline-flex items-center px-3 rounded-l-lg border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">
                        /categories/
                    </span>
                    <input 
                        type="text" 
                        id="slug" 
                        name="slug" 
                        required
                        class="flex-1 block w-full px-3 py-2 border border-gray-300 rounded-none rounded-r-lg text-sm placeholder-gray-500 focus:outline-none focus:ring-1 focus:ring-black focus:border-black"
                        placeholder="web-development"
                    >
                </div>
                <p class="text-xs text-gray-500 mt-1">URL-friendly version of the category name</p>
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
                    placeholder="Provide a clear description of what this category covers..."
                ></textarea>
                <p class="text-xs text-gray-500 mt-1">Help students understand what courses they'll find in this category</p>
            </div>

            <!-- Category Type -->
            <div>
                <label class="block text-sm font-medium text-gray-900 mb-3">Category Type</label>
                <div class="space-y-3">
                    <div class="flex items-center">
                        <input 
                            id="type_main" 
                            name="type" 
                            type="radio" 
                            value="main" 
                            checked
                            class="h-4 w-4 text-black focus:ring-black border-gray-300"
                        >
                        <label for="type_main" class="ml-3 block text-sm text-gray-900">
                            <span class="font-medium">Main Category</span>
                            <p class="text-gray-500">A top-level category that can contain subcategories</p>
                        </label>
                    </div>
                    <div class="flex items-center">
                        <input 
                            id="type_sub" 
                            name="type" 
                            type="radio" 
                            value="sub"
                            class="h-4 w-4 text-black focus:ring-black border-gray-300"
                        >
                        <label for="type_sub" class="ml-3 block text-sm text-gray-900">
                            <span class="font-medium">Subcategory</span>
                            <p class="text-gray-500">A category that belongs under a main category</p>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Parent Category (for subcategories) -->
            <div id="parentCategorySection" class="hidden">
                <label for="parent_id" class="block text-sm font-medium text-gray-900 mb-2">
                    Parent Category <span class="text-red-500">*</span>
                </label>
                <select 
                    id="parent_id" 
                    name="parent_id"
                    class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-1 focus:ring-black focus:border-black"
                >
                    <option value="">Select a parent category</option>
                    <?php foreach ($parentCategories as $parent): ?>
                        <option value="<?= $parent['id'] ?>"><?= htmlspecialchars($parent['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
    </div>

    <!-- Category Settings -->
    <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Category Settings</h3>
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
                        <option value="<?= $value ?>" <?= $value === 'active' ? 'selected' : '' ?>>
                            <?= $label ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <p class="text-xs text-gray-500 mt-1">Only active categories will be visible to students</p>
            </div>

            <!-- Featured -->
            <div class="flex items-center justify-between">
                <div>
                    <label for="is_featured" class="text-sm font-medium text-gray-900">Featured Category</label>
                    <p class="text-xs text-gray-500">Show this category prominently on the homepage</p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" id="is_featured" name="is_featured" value="1" class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-black/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-black"></div>
                </label>
            </div>

            <!-- Display Order -->
            <div>
                <label for="sort_order" class="block text-sm font-medium text-gray-900 mb-2">Display Order</label>
                <input 
                    type="number" 
                    id="sort_order" 
                    name="sort_order" 
                    min="0" 
                    value="0"
                    class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm placeholder-gray-500 focus:outline-none focus:ring-1 focus:ring-black focus:border-black"
                    placeholder="0"
                >
                <p class="text-xs text-gray-500 mt-1">Lower numbers appear first (0 = highest priority)</p>
            </div>
        </div>
    </div>

    <!-- Category Image -->
    <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Category Image</h3>
            <p class="text-sm text-gray-500 mt-1">Upload an image to represent this category</p>
        </div>
        <div class="p-6">
            <div class="flex items-center justify-center w-full">
                <label for="image" class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100">
                    <div class="flex flex-col items-center justify-center pt-5 pb-6" id="uploadArea">
                        <i class="fas fa-cloud-upload-alt text-gray-400 text-3xl mb-3"></i>
                        <p class="mb-2 text-sm text-gray-500">
                            <span class="font-semibold">Click to upload</span> or drag and drop
                        </p>
                        <p class="text-xs text-gray-500">PNG, JPG or JPEG (MAX. 2MB)</p>
                    </div>
                    <input id="image" name="image" type="file" class="hidden" accept="image/*">
                </label>
            </div>
            <div id="imagePreview" class="hidden mt-4">
                <img id="previewImg" src="" alt="Preview" class="max-w-full h-48 object-cover rounded-lg">
                <button type="button" onclick="removeImage()" class="mt-2 text-sm text-red-600 hover:text-red-800">
                    <i class="fas fa-trash mr-1"></i>Remove Image
                </button>
            </div>
        </div>
    </div>

    <!-- SEO Settings -->
    <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">SEO Settings</h3>
            <p class="text-sm text-gray-500 mt-1">Optimize this category for search engines</p>
        </div>
        <div class="p-6 space-y-6">
            <!-- Meta Title -->
            <div>
                <label for="meta_title" class="block text-sm font-medium text-gray-900 mb-2">Meta Title</label>
                <input 
                    type="text" 
                    id="meta_title" 
                    name="meta_title" 
                    maxlength="60"
                    class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm placeholder-gray-500 focus:outline-none focus:ring-1 focus:ring-black focus:border-black"
                    placeholder="Category name - TARUMT LMS"
                >
                <div class="flex justify-between text-xs text-gray-500 mt-1">
                    <span>Appears in search engine results</span>
                    <span id="metaTitleCount">0/60</span>
                </div>
            </div>

            <!-- Meta Description -->
            <div>
                <label for="meta_description" class="block text-sm font-medium text-gray-900 mb-2">Meta Description</label>
                <textarea 
                    id="meta_description" 
                    name="meta_description" 
                    rows="3" 
                    maxlength="160"
                    class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm placeholder-gray-500 focus:outline-none focus:ring-1 focus:ring-black focus:border-black"
                    placeholder="Brief description of this category for search engines..."
                ></textarea>
                <div class="flex justify-between text-xs text-gray-500 mt-1">
                    <span>Brief description for search results</span>
                    <span id="metaDescCount">0/160</span>
                </div>
            </div>

            <!-- Keywords -->
            <div>
                <label for="keywords" class="block text-sm font-medium text-gray-900 mb-2">Keywords</label>
                <input 
                    type="text" 
                    id="keywords" 
                    name="keywords" 
                    class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm placeholder-gray-500 focus:outline-none focus:ring-1 focus:ring-black focus:border-black"
                    placeholder="web development, programming, coding"
                >
                <p class="text-xs text-gray-500 mt-1">Comma-separated keywords related to this category</p>
            </div>
        </div>
    </div>

    <!-- Form Actions -->
    <div class="flex items-center justify-between space-x-4 pt-6 border-t border-gray-200">
        <button 
            type="button" 
            onclick="window.location.href='/instructor/categories'"
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
                value="publish"
                class="bg-black text-white px-6 py-2 rounded-lg text-sm font-medium hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black transition-colors duration-200"
            >
                <i class="fas fa-check mr-2"></i>
                Create Category
            </button>
        </div>
    </div>
</form>

<script>
// Auto-generate slug from name
document.getElementById('name').addEventListener('input', function() {
    const name = this.value;
    const slug = name.toLowerCase()
        .replace(/[^a-z0-9\s-]/g, '')
        .replace(/\s+/g, '-')
        .replace(/-+/g, '-')
        .trim('-');
    document.getElementById('slug').value = slug;
    
    // Auto-fill meta title if empty
    const metaTitle = document.getElementById('meta_title');
    if (!metaTitle.value) {
        metaTitle.value = name + ' - TARUMT LMS';
        updateMetaTitleCount();
    }
    
    // Auto-fill meta description if empty
    const metaDesc = document.getElementById('meta_description');
    const description = document.getElementById('description').value;
    if (!metaDesc.value && description) {
        metaDesc.value = description.substring(0, 160);
        updateMetaDescCount();
    }
});

// Toggle parent category section
document.querySelectorAll('input[name="type"]').forEach(radio => {
    radio.addEventListener('change', function() {
        const parentSection = document.getElementById('parentCategorySection');
        const parentSelect = document.getElementById('parent_id');
        
        if (this.value === 'sub') {
            parentSection.classList.remove('hidden');
            parentSelect.required = true;
        } else {
            parentSection.classList.add('hidden');
            parentSelect.required = false;
            parentSelect.value = '';
        }
    });
});

// Image upload handling
document.getElementById('image').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        // Validate file size (2MB)
        if (file.size > 2 * 1024 * 1024) {
            alert('File size must be less than 2MB');
            this.value = '';
            return;
        }
        
        // Validate file type
        if (!file.type.match('image.*')) {
            alert('Please select a valid image file');
            this.value = '';
            return;
        }
        
        // Show preview
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('previewImg').src = e.target.result;
            document.getElementById('uploadArea').classList.add('hidden');
            document.getElementById('imagePreview').classList.remove('hidden');
        };
        reader.readAsDataURL(file);
    }
});

function removeImage() {
    document.getElementById('image').value = '';
    document.getElementById('uploadArea').classList.remove('hidden');
    document.getElementById('imagePreview').classList.add('hidden');
}

// Character count for meta fields
function updateMetaTitleCount() {
    const input = document.getElementById('meta_title');
    const count = document.getElementById('metaTitleCount');
    count.textContent = `${input.value.length}/60`;
    count.className = input.value.length > 60 ? 'text-red-500' : 'text-gray-500';
}

function updateMetaDescCount() {
    const input = document.getElementById('meta_description');
    const count = document.getElementById('metaDescCount');
    count.textContent = `${input.value.length}/160`;
    count.className = input.value.length > 160 ? 'text-red-500' : 'text-gray-500';
}

document.getElementById('meta_title').addEventListener('input', updateMetaTitleCount);
document.getElementById('meta_description').addEventListener('input', updateMetaDescCount);

// Icon selection handling
document.querySelectorAll('.icon-option').forEach(button => {
    button.addEventListener('click', function() {
        // Remove active state from all icons
        document.querySelectorAll('.icon-option').forEach(btn => {
            btn.classList.remove('bg-black', 'border-black');
            btn.classList.add('border-gray-300');
            btn.querySelector('i').classList.remove('text-white');
            btn.querySelector('i').classList.add('text-gray-600');
        });
        
        // Add active state to selected icon
        this.classList.remove('border-gray-300');
        this.classList.add('bg-black', 'border-black');
        this.querySelector('i').classList.remove('text-gray-600');
        this.querySelector('i').classList.add('text-white');
        
        // Set selected icon value
        document.getElementById('selectedIcon').value = this.getAttribute('data-icon');
    });
});

// Set default icon selection
document.querySelector('.icon-option[data-icon="fas fa-folder"]').click();

// Form validation
document.getElementById('categoryForm').addEventListener('submit', function(e) {
    const name = document.getElementById('name').value.trim();
    const slug = document.getElementById('slug').value.trim();
    const description = document.getElementById('description').value.trim();
    const type = document.querySelector('input[name="type"]:checked').value;
    const parentId = document.getElementById('parent_id').value;
    
    if (!name || !slug || !description) {
        e.preventDefault();
        alert('Please fill in all required fields');
        return;
    }
    
    if (type === 'sub' && !parentId) {
        e.preventDefault();
        alert('Please select a parent category for subcategories');
        return;
    }
    
    // Show loading state
    const submitBtns = this.querySelectorAll('button[type="submit"]');
    submitBtns.forEach(btn => {
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Creating...';
    });
});

// Auto-fill description into meta description
document.getElementById('description').addEventListener('input', function() {
    const metaDesc = document.getElementById('meta_description');
    if (!metaDesc.value) {
        metaDesc.value = this.value.substring(0, 160);
        updateMetaDescCount();
    }
});
</script>

<?php
$content = ob_get_clean();
include '../app/Views/layouts/instructor.php';
?>