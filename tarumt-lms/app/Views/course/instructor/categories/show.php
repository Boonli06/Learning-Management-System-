<?php
ob_start();

// Page actions for header
ob_start();
?>
<div class="flex gap-3">
    <button type="button" class="bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-50 transition-colors duration-200" onclick="window.location.href='/instructor/categories'">
        <i class="fas fa-arrow-left mr-2"></i>
        Back to Categories
    </button>
    <button type="button" class="bg-black text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-800 transition-colors duration-200" onclick="window.location.href='/instructor/categories/<?= $category['id'] ?>/edit'">
        <i class="fas fa-edit mr-2"></i>
        Edit Category
    </button>
</div>
<?php
$pageActions = ob_get_clean();
?>

<!-- Category Header -->
<div class="bg-white rounded-lg border border-gray-200 overflow-hidden mb-6">
    <div class="px-6 py-6">
        <div class="flex items-start justify-between">
            <div class="flex items-start space-x-4">
                <!-- Category Icon -->
                <div class="w-16 h-16 bg-gradient-to-br from-gray-900 to-gray-700 rounded-lg flex items-center justify-center flex-shrink-0">
                    <i class="<?= $category['icon'] ?> text-white text-xl"></i>
                </div>
                
                <!-- Category Info -->
                <div class="flex-1">
                    <div class="flex items-center gap-3 mb-2">
                        <h1 class="text-2xl font-bold text-gray-900"><?= htmlspecialchars($category['name']) ?></h1>
                        
                        <!-- Status Badge -->
                        <?php if ($category['status'] === 'active'): ?>
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                <span class="w-1.5 h-1.5 bg-green-400 rounded-full mr-1.5"></span>
                                Active
                            </span>
                        <?php elseif ($category['status'] === 'draft'): ?>
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                <span class="w-1.5 h-1.5 bg-yellow-400 rounded-full mr-1.5"></span>
                                Draft
                            </span>
                        <?php endif; ?>
                        
                        <!-- Featured Badge -->
                        <?php if ($category['is_featured']): ?>
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                <i class="fas fa-star text-xs mr-1"></i>
                                Featured
                            </span>
                        <?php endif; ?>
                    </div>
                    
                    <p class="text-gray-600 mb-3"><?= htmlspecialchars($category['description']) ?></p>
                    
                    <div class="flex items-center space-x-4 text-sm text-gray-500">
                        <span>Created <?= date('M j, Y', strtotime($category['created_at'])) ?></span>
                        <span>•</span>
                        <span>Updated <?= date('M j, Y', strtotime($category['updated_at'])) ?></span>
                        <span>•</span>
                        <span>Sort Order: <?= $category['sort_order'] ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white p-6 rounded-lg border border-gray-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600">Total Courses</p>
                <p class="text-2xl font-bold text-gray-900"><?= $stats['total_courses'] ?></p>
            </div>
            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-book text-blue-600"></i>
            </div>
        </div>
    </div>
    
    <div class="bg-white p-6 rounded-lg border border-gray-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600">Total Students</p>
                <p class="text-2xl font-bold text-gray-900"><?= $stats['total_students'] ?></p>
            </div>
            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-users text-green-600"></i>
            </div>
        </div>
    </div>
    
    <div class="bg-white p-6 rounded-lg border border-gray-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600">Total Revenue</p>
                <p class="text-2xl font-bold text-gray-900">RM <?= number_format($stats['total_revenue']) ?></p>
            </div>
            <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-dollar-sign text-purple-600"></i>
            </div>
        </div>
    </div>
    
    <div class="bg-white p-6 rounded-lg border border-gray-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600">Avg Rating</p>
                <p class="text-2xl font-bold text-gray-900"><?= $stats['avg_rating'] ?></p>
            </div>
            <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-star text-yellow-600"></i>
            </div>
        </div>
    </div>
</div>

<!-- Content Tabs -->
<div class="bg-white rounded-lg border border-gray-200 mb-6">
    <div class="border-b border-gray-200">
        <nav class="flex space-x-8 px-6">
            <button onclick="showTab('courses')" id="courses-tab" class="tab-button border-b-2 border-black text-black py-4 px-1 text-sm font-medium">
                Courses (<?= count($courses) ?>)
            </button>
            <?php if ($category['type'] === 'main' && !empty($subcategories)): ?>
            <button onclick="showTab('subcategories')" id="subcategories-tab" class="tab-button border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 py-4 px-1 text-sm font-medium transition-colors duration-200">
                Subcategories (<?= count($subcategories) ?>)
            </button>
            <?php endif; ?>
            <button onclick="showTab('seo')" id="seo-tab" class="tab-button border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 py-4 px-1 text-sm font-medium transition-colors duration-200">
                SEO Information
            </button>
        </nav>
    </div>
</div>

<!-- Courses Tab Content -->
<div id="courses-content" class="tab-content">
    <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-medium text-gray-900">Courses in this Category</h3>
                <button type="button" class="bg-black text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-800" onclick="window.location.href='/instructor/courses/create?category_id=<?= $category['id'] ?>'">
                    <i class="fas fa-plus mr-2"></i>
                    Add Course
                </button>
            </div>
        </div>
        
        <?php if (empty($courses)): ?>
        <div class="text-center py-12">
            <div class="w-24 h-24 mx-auto bg-gray-100 rounded-full flex items-center justify-center mb-4">
                <i class="fas fa-book-open text-gray-400 text-2xl"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mb-2">No courses yet</h3>
            <p class="text-gray-500 mb-6">This category doesn't have any courses. Create your first course to get started.</p>
            <button type="button" class="bg-black text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-800" onclick="window.location.href='/instructor/courses/create?category_id=<?= $category['id'] ?>'">
                <i class="fas fa-plus mr-2"></i>
                Create Course
            </button>
        </div>
        <?php else: ?>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Course</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Students</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rating</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Revenue</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php foreach ($courses as $course): ?>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900"><?= htmlspecialchars($course['title']) ?></div>
                            <div class="text-sm text-gray-500">Created <?= date('M j, Y', strtotime($course['created_at'])) ?></div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            RM <?= number_format($course['price']) ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <?= $course['students_count'] ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <i class="fas fa-star text-yellow-400 text-sm mr-1"></i>
                                <span class="text-sm text-gray-900"><?= $course['rating'] ?></span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            RM <?= number_format($course['revenue']) ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                Published
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex items-center justify-end space-x-2">
                                <button type="button" class="text-gray-400 hover:text-gray-600" onclick="window.location.href='/instructor/courses/<?= $course['id'] ?>'" title="View">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button type="button" class="text-gray-400 hover:text-gray-600" onclick="window.location.href='/instructor/courses/<?= $course['id'] ?>/edit'" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>
    </div>
</div>

<!-- Subcategories Tab Content -->
<?php if ($category['type'] === 'main' && !empty($subcategories)): ?>
<div id="subcategories-content" class="tab-content hidden">
    <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-medium text-gray-900">Subcategories</h3>
                <button type="button" class="bg-black text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-800" onclick="window.location.href='/instructor/categories/create?parent_id=<?= $category['id'] ?>'">
                    <i class="fas fa-plus mr-2"></i>
                    Add Subcategory
                </button>
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 p-6">
            <?php foreach ($subcategories as $subcategory): ?>
            <div class="border border-gray-200 rounded-lg p-4 hover:border-gray-300 transition-colors">
                <div class="flex items-center justify-between mb-3">
                    <h4 class="font-medium text-gray-900"><?= htmlspecialchars($subcategory['name']) ?></h4>
                    <div class="flex space-x-1">
                        <button type="button" class="text-gray-400 hover:text-gray-600" onclick="window.location.href='/instructor/categories/<?= $subcategory['id'] ?>'" title="View">
                            <i class="fas fa-eye text-sm"></i>
                        </button>
                        <button type="button" class="text-gray-400 hover:text-gray-600" onclick="window.location.href='/instructor/categories/<?= $subcategory['id'] ?>/edit'" title="Edit">
                            <i class="fas fa-edit text-sm"></i>
                        </button>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-3 text-sm">
                    <div>
                        <span class="text-gray-500">Courses:</span>
                        <span class="font-medium text-gray-900"><?= $subcategory['courses_count'] ?></span>
                    </div>
                    <div>
                        <span class="text-gray-500">Students:</span>
                        <span class="font-medium text-gray-900"><?= $subcategory['students_count'] ?></span>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- SEO Tab Content -->
<div id="seo-content" class="tab-content hidden">
    <div class="bg-white rounded-lg border border-gray-200 p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-6">SEO Information</h3>
        
        <div class="space-y-6">
            <!-- Meta Title -->
            <div>
                <label class="block text-sm font-medium text-gray-900 mb-2">Meta Title</label>
                <div class="p-3 bg-gray-50 rounded-lg">
                    <p class="text-sm text-gray-900"><?= htmlspecialchars($category['meta_title']) ?: 'No meta title set' ?></p>
                </div>
            </div>
            
            <!-- Meta Description -->
            <div>
                <label class="block text-sm font-medium text-gray-900 mb-2">Meta Description</label>
                <div class="p-3 bg-gray-50 rounded-lg">
                    <p class="text-sm text-gray-900"><?= htmlspecialchars($category['meta_description']) ?: 'No meta description set' ?></p>
                </div>
            </div>
            
            <!-- Keywords -->
            <div>
                <label class="block text-sm font-medium text-gray-900 mb-2">Keywords</label>
                <div class="p-3 bg-gray-50 rounded-lg">
                    <?php if (!empty($category['keywords'])): ?>
                        <div class="flex flex-wrap gap-2">
                            <?php foreach (explode(',', $category['keywords']) as $keyword): ?>
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    <?= htmlspecialchars(trim($keyword)) ?>
                                </span>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <p class="text-sm text-gray-500">No keywords set</p>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- URL Slug -->
            <div>
                <label class="block text-sm font-medium text-gray-900 mb-2">URL Slug</label>
                <div class="p-3 bg-gray-50 rounded-lg">
                    <p class="text-sm text-gray-900 font-mono">/categories/<?= htmlspecialchars($category['slug']) ?></p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function showTab(tabName) {
    // Hide all tab contents
    document.querySelectorAll('.tab-content').forEach(content => {
        content.classList.add('hidden');
    });
    
    // Remove active state from all tabs
    document.querySelectorAll('.tab-button').forEach(tab => {
        tab.classList.remove('border-black', 'text-black');
        tab.classList.add('border-transparent', 'text-gray-500');
    });
    
    // Show selected tab content
    document.getElementById(tabName + '-content').classList.remove('hidden');
    
    // Add active state to selected tab
    const activeTab = document.getElementById(tabName + '-tab');
    activeTab.classList.remove('border-transparent', 'text-gray-500');
    activeTab.classList.add('border-black', 'text-black');
}

// Initialize first tab as active
document.addEventListener('DOMContentLoaded', function() {
    showTab('courses');
});
</script>

<?php
$content = ob_get_clean();
include '../app/Views/layouts/instructor.php';
?>