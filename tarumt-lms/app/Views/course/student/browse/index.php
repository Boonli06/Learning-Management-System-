<?php
ob_start();
?>

<!-- Header Actions -->
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
    <div class="flex items-center space-x-4">
        <!-- Search -->
        <div class="relative w-64">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="fas fa-search text-gray-400"></i>
            </div>
            <input 
                type="text" 
                id="searchInput" 
                placeholder="Search courses..." 
                value="<?= htmlspecialchars($filters['search']) ?>"
                class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg text-sm placeholder-gray-500 focus:outline-none focus:ring-1 focus:ring-black focus:border-black"
            >
        </div>

        <!-- Clear Button -->
        <button type="button" class="flex-shrink-0 bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black transition-colors duration-200" onclick="clearFilters()">
            <i class="fas fa-times mr-2"></i>
            Clear
        </button>

        <!-- Category Filter -->
        <select id="categoryFilter" class="flex-shrink-0 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-black focus:border-black">
            <option value="">All Categories</option>
            <?php foreach ($categories as $category): ?>
                <option value="<?= $category['id'] ?>" <?= $filters['category_id'] == $category['id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($category['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <!-- Level Filter -->
        <select id="levelFilter" class="flex-shrink-0 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-black focus:border-black">
            <option value="">All Levels</option>
            <?php foreach ($levels as $value => $label): ?>
                <option value="<?= $value ?>" <?= $filters['level'] === $value ? 'selected' : '' ?>>
                    <?= $label ?>
                </option>
            <?php endforeach; ?>
        </select>

        <!-- Price Filter -->
        <select id="priceFilter" class="flex-shrink-0 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-black focus:border-black">
            <option value="">All Prices</option>
            <?php foreach ($priceRanges as $value => $label): ?>
                <option value="<?= $value ?>" <?= $filters['price'] === $value ? 'selected' : '' ?>>
                    <?= $label ?>
                </option>
            <?php endforeach; ?>
        </select>

        <!-- Sort -->
        <select id="sortFilter" class="flex-shrink-0 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-black focus:border-black">
            <?php foreach ($sortOptions as $value => $label): ?>
                <option value="<?= $value ?>" <?= $filters['sortBy'] === $value ? 'selected' : '' ?>>
                    <?= $label ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="flex items-center space-x-3">
        <button type="button" class="flex-shrink-0 bg-black text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black transition-colors duration-200" onclick="window.location.href='/student/dashboard/mycourses'">
            <i class="fas fa-graduation-cap mr-2"></i>
            My Courses
        </button>
    </div>
</div>

<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-lg border border-gray-200 p-4">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-book text-blue-600 text-sm"></i>
                </div>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-gray-500">My Enrolled</p>
                <p class="text-lg font-semibold text-gray-900">3</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg border border-gray-200 p-4">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-chart-line text-green-600 text-sm"></i>
                </div>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-gray-500">Progress</p>
                <p class="text-lg font-semibold text-gray-900">65%</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg border border-gray-200 p-4">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-heart text-purple-600 text-sm"></i>
                </div>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-gray-500">Wishlist</p>
                <p class="text-lg font-semibold text-gray-900">5</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg border border-gray-200 p-4">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-search text-orange-600 text-sm"></i>
                </div>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-gray-500">Available</p>
                <p class="text-lg font-semibold text-gray-900"><?= $pagination['total_items'] ?></p>
            </div>
        </div>
    </div>
</div>

<!-- Courses Table -->
<div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200">
        <h3 class="text-lg font-medium text-gray-900">Available Courses</h3>
    </div>

    <?php if (empty($courses)): ?>
    <div class="text-center py-12">
        <div class="w-24 h-24 mx-auto bg-gray-100 rounded-full flex items-center justify-center mb-4">
            <i class="fas fa-search text-gray-400 text-2xl"></i>
        </div>
        <h3 class="text-lg font-medium text-gray-900 mb-2">No courses found</h3>
        <p class="text-gray-500 mb-6">Try adjusting your search criteria or browse all courses.</p>
        <button type="button" class="bg-black text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-800" onclick="clearFilters()">
            <i class="fas fa-times mr-2"></i>
            Clear Filters
        </button>
    </div>
    <?php else: ?>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Course</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Instructor</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Level</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Duration</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Students</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Rating</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php foreach ($courses as $course): ?>
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-4">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 w-12 h-12">
                                <img class="w-12 h-12 rounded-lg object-cover" src="<?= htmlspecialchars($course['thumbnail']) ?>" alt="<?= htmlspecialchars($course['title']) ?>">
                            </div>
                            <div class="ml-3 min-w-0 flex-1">
                                <div class="text-sm font-medium text-gray-900 truncate"><?= htmlspecialchars($course['title']) ?></div>
                                <div class="text-xs text-gray-500 truncate"><?= htmlspecialchars($course['category']) ?></div>
                            </div>
                        </div>
                    </td>
                    <td class="px-3 py-4">
                        <div class="text-sm text-gray-900"><?= htmlspecialchars($course['instructor']) ?></div>
                    </td>
                    <td class="px-3 py-4 text-center">
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium <?= $course['level'] === 'beginner' ? 'bg-green-100 text-green-800' : ($course['level'] === 'intermediate' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') ?>">
                            <?= ucfirst($course['level']) ?>
                        </span>
                    </td>
                    <td class="px-3 py-4 text-center text-sm text-gray-900">
                        <div class="flex items-center justify-center">
                            <i class="fas fa-clock text-gray-400 text-xs mr-1"></i>
                            <?= $course['duration'] ?>h
                        </div>
                    </td>
                    <td class="px-3 py-4 text-center text-sm text-gray-900">
                        <div class="flex items-center justify-center">
                            <i class="fas fa-users text-gray-400 text-xs mr-1"></i>
                            <?= number_format($course['students']) ?>
                        </div>
                    </td>
                    <td class="px-3 py-4 text-center">
                        <div class="flex items-center justify-center">
                            <i class="fas fa-star text-yellow-400 text-xs mr-1"></i>
                            <span class="text-sm text-gray-900"><?= $course['rating'] ?></span>
                        </div>
                    </td>
                    <td class="px-3 py-4 text-center">
                        <?php if ($course['price'] > 0): ?>
                            <span class="text-sm font-medium text-gray-900">RM<?= number_format($course['price'], 2) ?></span>
                        <?php else: ?>
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                Free
                            </span>
                        <?php endif; ?>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <div class="flex items-center justify-center space-x-4">
                            <button type="button" class="text-gray-600 hover:text-red-600 transition-colors duration-200" onclick="addToWishlist(<?= $course['id'] ?>)" title="Add to Wishlist">
                                <i class="fas fa-heart"></i>
                            </button>
                            <button type="button" class="text-gray-600 hover:text-green-600 transition-colors duration-200" onclick="addToCart(<?= $course['id'] ?>)" title="Add to Cart">
                                <i class="fas fa-shopping-cart"></i>
                            </button>
                            <button type="button" class="text-blue-600 hover:text-blue-800 transition-colors duration-200" onclick="previewCourse(<?= $course['id'] ?>)" title="Preview Course">
                                <i class="fas fa-play"></i>
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

<!-- Pagination -->
<?php if ($pagination['total_items'] > 0): ?>
<div class="bg-white rounded-lg border border-gray-200 p-6 mt-6">
    <div class="flex items-center justify-between">
        <div class="text-sm text-gray-700">
            Showing <span class="font-medium"><?= ($pagination['current_page'] - 1) * $pagination['per_page'] + 1 ?></span> to <span class="font-medium"><?= min($pagination['current_page'] * $pagination['per_page'], $pagination['total_items']) ?></span> of <span class="font-medium"><?= $pagination['total_items'] ?></span> courses
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
<?php endif; ?>

<script>
// Search functionality
let searchTimeout;
document.getElementById('searchInput').addEventListener('input', function() {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(() => {
        applyFilters();
    }, 500);
});

// Filter change handlers
document.getElementById('categoryFilter').addEventListener('change', applyFilters);
document.getElementById('levelFilter').addEventListener('change', applyFilters);
document.getElementById('priceFilter').addEventListener('change', applyFilters);
document.getElementById('sortFilter').addEventListener('change', applyFilters);

function applyFilters() {
    const search = document.getElementById('searchInput').value;
    const category_id = document.getElementById('categoryFilter').value;
    const level = document.getElementById('levelFilter').value;
    const price = document.getElementById('priceFilter').value;
    const sort = document.getElementById('sortFilter').value;
    
    const params = new URLSearchParams();
    if (search) params.set('search', search);
    if (category_id) params.set('category', category_id);
    if (level) params.set('level', level);
    if (price) params.set('price', price);
    if (sort) params.set('sort', sort);
    
    window.location.href = '/student/browse?' + params.toString();
}

function clearFilters() {
    window.location.href = '/student/browse';
}

function goToPage(page) {
    const params = new URLSearchParams(window.location.search);
    params.set('page', page);
    window.location.href = '/student/browse?' + params.toString();
}

// Action functions
function previewCourse(id) {
    window.location.href = `/student/course/${id}`;
}

function addToWishlist(id) {
    fetch('/student/wishlist/add', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ course_id: id })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification(data.message, 'success');
        } else {
            showNotification(data.message, 'error');
        }
    });
}

function addToCart(id) {
    fetch('/student/cart/add', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ course_id: id })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification(data.message, 'success');
            // Update cart count if needed
            location.reload();
        } else {
            showNotification(data.message, 'error');
        }
    });
}

function showNotification(message, type = 'success') {
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 p-4 rounded-lg text-white z-50 ${type === 'success' ? 'bg-green-600' : 'bg-red-600'}`;
    notification.textContent = message;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.remove();
    }, 3000);
}
</script>

<?php
$content = ob_get_clean();
include '../app/Views/layouts/student.php';
?>