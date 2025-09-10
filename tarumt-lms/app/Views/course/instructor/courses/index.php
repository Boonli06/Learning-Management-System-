<?php
// 数据现在由Controller传递，直接开始页面内容
ob_start();
?>

<!-- Filters and Search -->
<div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
        <!-- Search and Clear -->
        <div class="flex items-center gap-3">
            <div class="flex-1 max-w-md">
                <label for="search" class="sr-only">Search courses</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400"></i>
                    </div>
                    <input 
                        type="text" 
                        name="search" 
                        id="search" 
                        value="<?= htmlspecialchars($filters['search']) ?>"
                        class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-black focus:border-black sm:text-sm transition-colors duration-200" 
                        placeholder="Search your courses..."
                    >
                </div>
            </div>
            
            <!-- Clear Button -->
            <button type="button" class="bg-white border border-gray-300 text-gray-700 px-3 py-2 rounded-lg text-sm font-medium hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black transition-colors duration-200" onclick="window.location.href='/instructor/courses'">
                <i class="fas fa-times mr-1"></i>
                Clear
            </button>
        </div>

        <!-- Filters -->
        <div class="flex flex-wrap gap-3">
            <!-- Status Filter -->
            <select name="status" id="statusFilter" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-black focus:border-black transition-colors duration-200">
                <option value="">All Status</option>
                <?php foreach ($statusOptions as $value => $label): ?>
                    <option value="<?= $value ?>" <?= $filters['status'] == $value ? 'selected' : '' ?>>
                        <?= $label ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <!-- Category Filter -->
            <select name="category" id="categoryFilter" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-black focus:border-black transition-colors duration-200">
                <option value="">All Categories</option>
                <?php foreach ($categories as $category): ?>
                    <option value="<?= $category['id'] ?>" <?= $filters['category'] == $category['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($category['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <!-- Sort -->
            <select name="sort" id="sortFilter" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-black focus:border-black transition-colors duration-200">
                <option value="created_desc" <?= $filters['sort'] == 'created_desc' ? 'selected' : '' ?>>Newest First</option>
                <option value="created_asc" <?= $filters['sort'] == 'created_asc' ? 'selected' : '' ?>>Oldest First</option>
                <option value="title_asc" <?= $filters['sort'] == 'title_asc' ? 'selected' : '' ?>>Title A-Z</option>
                <option value="title_desc" <?= $filters['sort'] == 'title_desc' ? 'selected' : '' ?>>Title Z-A</option>
                <option value="students_desc" <?= $filters['sort'] == 'students_desc' ? 'selected' : '' ?>>Most Students</option>
            </select>
        </div>
    </div>
</div>

<!-- Bulk Actions (Hidden by default) -->
<div id="bulkActions" class="hidden bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
    <div class="flex items-center justify-between">
        <div class="flex items-center">
            <span class="text-sm font-medium text-blue-900" id="selectedCount">0 courses selected</span>
        </div>
        <div class="flex gap-2">
            <button type="button" class="bg-white border border-gray-300 text-gray-700 px-3 py-1 rounded text-sm hover:bg-gray-50 transition-colors duration-200">
                <i class="fas fa-eye mr-1"></i>
                Bulk Publish
            </button>
            <button type="button" class="bg-white border border-gray-300 text-gray-700 px-3 py-1 rounded text-sm hover:bg-gray-50 transition-colors duration-200">
                <i class="fas fa-eye-slash mr-1"></i>
                Bulk Unpublish
            </button>
            <button type="button" class="text-red-600 hover:text-red-700 px-3 py-1 text-sm transition-colors duration-200" onclick="clearSelection()">
                <i class="fas fa-times mr-1"></i>
                Clear
            </button>
        </div>
    </div>
</div>

<!-- Course Grid -->
<div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6 mb-8">
    
    <?php foreach ($courses as $course): ?>
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 hover:shadow-md transition-shadow duration-200">
            <!-- Course Thumbnail -->
            <div class="aspect-video bg-gradient-to-br <?= $course['thumbnail_class'] ?> flex items-center justify-center relative">
                <span class="text-white text-2xl font-bold"><?= $course['thumbnail_text'] ?></span>
                
                <!-- Status Badge -->
                <div class="absolute top-3 left-3">
                    <?php 
                    $badgeClass = '';
                    $statusText = '';
                    switch($course['status']) {
                        case 'published':
                            $badgeClass = 'bg-green-100 text-green-800';
                            $statusText = 'Published';
                            break;
                        case 'draft':
                            $badgeClass = 'bg-yellow-100 text-yellow-800';
                            $statusText = 'Draft';
                            break;
                        case 'pending':
                            $badgeClass = 'bg-blue-100 text-blue-800';
                            $statusText = 'Pending Review';
                            break;
                    }
                    ?>
                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium <?= $badgeClass ?>">
                        <div class="w-1.5 h-1.5 bg-current rounded-full mr-1 opacity-75"></div>
                        <?= $statusText ?>
                    </span>
                </div>
                
                <!-- Select Checkbox -->
                <div class="absolute top-3 right-3">
                    <input type="checkbox" class="w-4 h-4 text-black border-gray-300 rounded focus:ring-black course-checkbox" value="<?= $course['id'] ?>">
                </div>
            </div>
            
            <!-- Course Content -->
            <div class="p-6">
                <div class="flex items-start justify-between mb-3">
                    <h3 class="text-lg font-semibold text-gray-900 line-clamp-2"><?= htmlspecialchars($course['title']) ?></h3>
                </div>
                
                <!-- Course Stats -->
                <div class="grid grid-cols-3 gap-4 mb-4 text-center">
                    <div class="bg-gray-50 rounded-lg p-3">
                        <div class="text-lg font-bold text-gray-900"><?= $course['students_count'] ?></div>
                        <div class="text-xs text-gray-500">Students</div>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-3">
                        <div class="text-lg font-bold text-gray-900"><?= $course['sections_count'] ?></div>
                        <div class="text-xs text-gray-500">Sections</div>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-3">
                        <div class="text-lg font-bold text-gray-900"><?= $course['rating'] > 0 ? $course['rating'] : '-' ?></div>
                        <div class="text-xs text-gray-500">Rating</div>
                    </div>
                </div>

                <!-- Price and Revenue -->
                <div class="flex justify-between items-center mb-4">
                    <span class="text-xl font-bold text-gray-900">RM <?= number_format($course['price']) ?></span>
                    <?php if ($course['status'] === 'published' && $course['revenue'] > 0): ?>
                        <span class="text-sm text-green-600 font-medium">RM <?= number_format($course['revenue']) ?> earned</span>
                    <?php elseif ($course['status'] === 'draft'): ?>
                        <span class="text-sm text-gray-500">Not published</span>
                    <?php else: ?>
                        <span class="text-sm text-blue-600">Under review</span>
                    <?php endif; ?>
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-2">
                    <?php if ($course['status'] === 'pending'): ?>
                        <button class="flex-1 bg-gray-300 text-gray-500 px-3 py-2 rounded-lg text-sm font-medium cursor-not-allowed" disabled>
                            <i class="fas fa-clock mr-1"></i>
                            Awaiting Review
                        </button>
                    <?php else: ?>
                        <button class="flex-1 bg-black text-white px-3 py-2 rounded-lg text-sm font-medium hover:bg-gray-800 transition-colors duration-200" onclick="window.location.href='/instructor/courses/<?= $course['id'] ?>/edit'">
                            <i class="fas fa-edit mr-1"></i>
                            <?= $course['status'] === 'draft' ? 'Continue Editing' : 'Edit' ?>
                        </button>
                    <?php endif; ?>
                    
                    <button class="px-3 py-2 border border-gray-300 text-gray-700 rounded-lg text-sm hover:bg-gray-50 transition-colors duration-200" onclick="window.location.href='/instructor/courses/<?= $course['id'] ?>/preview'">
                        <i class="fas fa-eye"></i>
                    </button>
                    
                    <?php if ($course['status'] === 'published'): ?>
                        <button class="px-3 py-2 border border-gray-300 text-gray-700 rounded-lg text-sm hover:bg-gray-50 transition-colors duration-200" onclick="window.location.href='/instructor/courses/<?= $course['id'] ?>/analytics'">
                            <i class="fas fa-chart-bar"></i>
                        </button>
                    <?php endif; ?>
                    
                    <div class="relative">
                        <button class="px-3 py-2 border border-gray-300 text-gray-700 rounded-lg text-sm hover:bg-gray-50 transition-colors duration-200" onclick="toggleDropdown('course-<?= $course['id'] ?>-menu')">
                            <i class="fas fa-ellipsis-h"></i>
                        </button>
                        <div id="course-<?= $course['id'] ?>-menu" class="hidden absolute right-0 top-full mt-1 w-48 bg-white border border-gray-200 rounded-lg shadow-lg z-50">
                            <?php if ($course['status'] === 'draft'): ?>
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                    <i class="fas fa-upload mr-2"></i>Publish Course
                                </a>
                            <?php endif; ?>
                            <a href="/instructor/courses/<?= $course['id'] ?>/settings" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                <i class="fas fa-cog mr-2"></i>Settings
                            </a>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                <i class="fas fa-copy mr-2"></i>Duplicate
                            </a>
                            <?php if ($course['status'] === 'pending'): ?>
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                    <i class="fas fa-undo mr-2"></i>Withdraw Review
                                </a>
                            <?php else: ?>
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                    <i class="fas fa-download mr-2"></i>Export Data
                                </a>
                                <div class="border-t border-gray-100"></div>
                                <a href="#" class="block px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                    <i class="fas fa-trash mr-2"></i>Delete
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>

    <!-- Empty State Card (for when adding new courses) -->
    <div class="bg-white rounded-lg shadow-sm border-2 border-dashed border-gray-300 hover:border-gray-400 transition-colors duration-200 overflow-hidden">
        <div class="aspect-video flex items-center justify-center">
            <div class="text-center">
                <i class="fas fa-plus text-4xl text-gray-400 mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Create New Course</h3>
                <p class="text-sm text-gray-500 mb-4">Start building your next course</p>
                <button class="bg-black text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-800 transition-colors duration-200" onclick="window.location.href='/instructor/courses/create'">
                    Get Started
                </button>
            </div>
        </div>
    </div>

</div>

<!-- Pagination -->
<div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
    <div class="flex items-center justify-between">
        <div class="text-sm text-gray-700">
            Showing <span class="font-medium"><?= $pagination['start_item'] ?></span> to <span class="font-medium"><?= $pagination['end_item'] ?></span> of <span class="font-medium"><?= $pagination['total_items'] ?></span> courses
        </div>
        <div class="flex items-center space-x-2">
            <button class="relative inline-flex items-center px-3 py-2 border border-gray-300 text-sm font-medium text-gray-500 bg-white rounded-lg hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed transition-colors duration-200" <?= $pagination['current_page'] <= 1 ? 'disabled' : '' ?> onclick="<?= $pagination['current_page'] > 1 ? 'goToPage(' . ($pagination['current_page'] - 1) . ')' : '' ?>">
                <i class="fas fa-chevron-left mr-1"></i>
                Previous
            </button>
            
            <?php for ($i = 1; $i <= $pagination['total_pages']; $i++): ?>
                <button class="relative inline-flex items-center px-3 py-2 border text-sm font-medium rounded-lg transition-colors duration-200 <?= $i == $pagination['current_page'] ? 'border-black bg-black text-white' : 'border-gray-300 text-gray-700 bg-white hover:bg-gray-50' ?>" onclick="<?= $i != $pagination['current_page'] ? 'goToPage(' . $i . ')' : '' ?>">
                    <?= $i ?>
                </button>
            <?php endfor; ?>
            
            <button class="relative inline-flex items-center px-3 py-2 border border-gray-300 text-sm font-medium text-gray-700 bg-white rounded-lg hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed transition-colors duration-200" <?= $pagination['current_page'] >= $pagination['total_pages'] ? 'disabled' : '' ?> onclick="<?= $pagination['current_page'] < $pagination['total_pages'] ? 'goToPage(' . ($pagination['current_page'] + 1) . ')' : '' ?>">
                Next
                <i class="fas fa-chevron-right ml-1"></i>
            </button>
        </div>
    </div>
</div>

<!-- Course Statistics Summary -->
<div class="mt-8 bg-white rounded-lg shadow-sm border border-gray-200 p-6">
    <h3 class="text-lg font-semibold text-gray-900 mb-4">Course Overview</h3>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
        <div class="text-center">
            <div class="text-2xl font-bold text-gray-900"><?= $stats['total'] ?></div>
            <div class="text-sm text-gray-500">Total Courses</div>
        </div>
        <div class="text-center">
            <div class="text-2xl font-bold text-green-600"><?= $stats['published'] ?></div>
            <div class="text-sm text-gray-500">Published</div>
        </div>
        <div class="text-center">
            <div class="text-2xl font-bold text-yellow-600"><?= $stats['draft'] ?></div>
            <div class="text-sm text-gray-500">Drafts</div>
        </div>
        <div class="text-center">
            <div class="text-2xl font-bold text-blue-600"><?= $stats['pending'] ?></div>
            <div class="text-sm text-gray-500">Under Review</div>
        </div>
    </div>
</div>

<script>
// Search functionality with debounce
let searchTimeout;
document.getElementById('search').addEventListener('input', function() {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(() => {
        applyFilters();
    }, 500);
});

// Filter change handlers
document.getElementById('statusFilter').addEventListener('change', applyFilters);
document.getElementById('categoryFilter').addEventListener('change', applyFilters);
document.getElementById('sortFilter').addEventListener('change', applyFilters);

function applyFilters() {
    const search = document.getElementById('search').value;
    const status = document.getElementById('statusFilter').value;
    const category = document.getElementById('categoryFilter').value;
    const sort = document.getElementById('sortFilter').value;
    
    const params = new URLSearchParams();
    if (search) params.set('search', search);
    if (status) params.set('status', status);
    if (category) params.set('category', category);
    if (sort) params.set('sort', sort);
    
    window.location.href = '/instructor/courses?' + params.toString();
}

// Pagination functionality
function goToPage(page) {
    const search = document.getElementById('search').value;
    const status = document.getElementById('statusFilter').value;
    const category = document.getElementById('categoryFilter').value;
    const sort = document.getElementById('sortFilter').value;
    
    const params = new URLSearchParams();
    if (page > 1) params.set('page', page);
    if (search) params.set('search', search);
    if (status) params.set('status', status);
    if (category) params.set('category', category);
    if (sort) params.set('sort', sort);
    
    window.location.href = '/instructor/courses?' + params.toString();
}

// Dropdown toggle functionality
function toggleDropdown(id) {
    const dropdown = document.getElementById(id);
    const allDropdowns = document.querySelectorAll('[id$="-menu"]');
    
    // Close all other dropdowns
    allDropdowns.forEach(d => {
        if (d.id !== id) {
            d.classList.add('hidden');
        }
    });
    
    // Toggle current dropdown
    dropdown.classList.toggle('hidden');
}

// Close dropdowns when clicking outside
document.addEventListener('click', function(event) {
    if (!event.target.closest('button')) {
        const allDropdowns = document.querySelectorAll('[id$="-menu"]');
        allDropdowns.forEach(d => d.classList.add('hidden'));
    }
});

// Bulk selection functionality
const checkboxes = document.querySelectorAll('.course-checkbox');
const bulkActions = document.getElementById('bulkActions');
const selectedCount = document.getElementById('selectedCount');

checkboxes.forEach(checkbox => {
    checkbox.addEventListener('change', updateBulkActions);
});

function updateBulkActions() {
    const selected = document.querySelectorAll('.course-checkbox:checked');
    const count = selected.length;
    
    if (count > 0) {
        bulkActions.classList.remove('hidden');
        selectedCount.textContent = `${count} course${count !== 1 ? 's' : ''} selected`;
    } else {
        bulkActions.classList.add('hidden');
    }
}

function clearSelection() {
    checkboxes.forEach(checkbox => {
        checkbox.checked = false;
    });
    updateBulkActions();
}
</script>

<?php
$content = ob_get_clean();
include '../app/Views/layouts/instructor.php';