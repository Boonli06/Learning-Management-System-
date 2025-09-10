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
                placeholder="Search wishlist..." 
                class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg text-sm placeholder-gray-500 focus:outline-none focus:ring-1 focus:ring-black focus:border-black"
            >
        </div>

        <!-- Clear Button -->
        <button type="button" class="flex-shrink-0 bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black transition-colors duration-200" onclick="clearSearch()">
            <i class="fas fa-times mr-2"></i>
            Clear
        </button>
    </div>

    <div class="flex items-center space-x-3">
        <button type="button" class="flex-shrink-0 bg-black text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black transition-colors duration-200" onclick="window.location.href='/student/browse'">
            <i class="fas fa-plus mr-2"></i>
            Browse More Courses
        </button>
    </div>
</div>

<!-- Statistics -->
<div class="bg-white rounded-lg border border-gray-200 p-6 mb-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-lg font-medium text-gray-900">Wishlist Summary</h2>
            <p class="text-sm text-gray-600 mt-1">Courses you want to learn</p>
        </div>
        <div class="flex items-center space-x-6">
            <div class="text-center">
                <div class="text-2xl font-bold text-gray-900"><?= count($courses) ?></div>
                <div class="text-sm text-gray-500">Total Courses</div>
            </div>
            <div class="text-center">
                <div class="text-2xl font-bold text-green-600">RM<?= number_format(array_sum(array_column($courses, 'price')), 2) ?></div>
                <div class="text-sm text-gray-500">Total Value</div>
            </div>
        </div>
    </div>
</div>

<!-- Wishlist Grid -->
<div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200">
        <h3 class="text-lg font-medium text-gray-900">My Wishlist</h3>
    </div>

    <?php if (empty($courses)): ?>
    <div class="text-center py-12">
        <div class="w-24 h-24 mx-auto bg-gray-100 rounded-full flex items-center justify-center mb-4">
            <i class="fas fa-heart text-gray-400 text-2xl"></i>
        </div>
        <h3 class="text-lg font-medium text-gray-900 mb-2">Your wishlist is empty</h3>
        <p class="text-gray-500 mb-6">Save courses you're interested in to your wishlist for later.</p>
        <button type="button" class="bg-black text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-800" onclick="window.location.href='/student/browse'">
            <i class="fas fa-search mr-2"></i>
            Browse Courses
        </button>
    </div>
    <?php else: ?>
    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="courseGrid">
            <?php foreach ($courses as $course): ?>
            <div class="course-card border border-gray-200 rounded-lg overflow-hidden hover:shadow-lg transition-shadow duration-200" data-title="<?= strtolower($course['title']) ?>" data-instructor="<?= strtolower($course['instructor']) ?>">
                <!-- Course Image -->
                <div class="relative">
                    <img class="w-full h-48 object-cover" src="<?= htmlspecialchars($course['thumbnail']) ?>" alt="<?= htmlspecialchars($course['title']) ?>">
                    
                    <!-- Remove from Wishlist -->
                    <button type="button" class="absolute top-3 right-3 bg-white rounded-full p-2 shadow-lg hover:bg-gray-50 transition-colors duration-200" onclick="removeFromWishlist(<?= $course['id'] ?>)" title="Remove from Wishlist">
                        <i class="fas fa-heart text-red-500 hover:text-red-600"></i>
                    </button>
                </div>
                
                <!-- Course Info -->
                <div class="p-4">
                    <h3 class="text-lg font-medium text-gray-900 mb-2 hover:text-blue-600 cursor-pointer" onclick="viewCourse(<?= $course['id'] ?>)">
                        <?= htmlspecialchars($course['title']) ?>
                    </h3>
                    
                    <p class="text-sm text-gray-600 mb-3 line-clamp-2"><?= htmlspecialchars($course['description']) ?></p>
                    
                    <!-- Instructor -->
                    <div class="flex items-center mb-3">
                        <i class="fas fa-user-circle text-gray-400 mr-2"></i>
                        <span class="text-sm text-gray-600"><?= htmlspecialchars($course['instructor']) ?></span>
                    </div>
                    
                    <!-- Rating and Students -->
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center">
                            <div class="flex items-center">
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                    <i class="fas fa-star <?= $i <= floor($course['rating']) ? 'text-yellow-400' : 'text-gray-300' ?> text-xs"></i>
                                <?php endfor; ?>
                            </div>
                            <span class="ml-1 text-xs text-gray-500"><?= $course['rating'] ?> (<?= number_format($course['students']) ?>)</span>
                        </div>
                        
                        <!-- Added Date -->
                        <span class="text-xs text-gray-500">Added <?= date('M d', strtotime($course['added_to_wishlist'])) ?></span>
                    </div>
                    
                    <!-- Price and Actions -->
                    <div class="flex items-center justify-between">
                        <div>
                            <?php if ($course['price'] > 0): ?>
                                <span class="text-xl font-bold text-gray-900">RM<?= number_format($course['price'], 2) ?></span>
                            <?php else: ?>
                                <span class="text-xl font-bold text-green-600">Free</span>
                            <?php endif; ?>
                        </div>
                        
                        <div class="flex items-center space-x-2">
                            <button type="button" class="text-gray-600 hover:text-black transition-colors duration-200" onclick="viewCourse(<?= $course['id'] ?>)" title="View Details">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button type="button" class="bg-black text-white px-3 py-2 rounded-lg text-sm font-medium hover:bg-gray-800 transition-colors duration-200" onclick="addToCart(<?= $course['id'] ?>)">
                                <i class="fas fa-shopping-cart mr-1"></i>
                                Add to Cart
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>
</div>

<!-- Bulk Actions -->
<?php if (!empty($courses)): ?>
<div class="bg-white rounded-lg border border-gray-200 p-6 mt-6">
    <div class="flex items-center justify-between">
        <div>
            <h3 class="text-lg font-medium text-gray-900">Bulk Actions</h3>
            <p class="text-sm text-gray-600 mt-1">Perform actions on all wishlist items</p>
        </div>
        <div class="flex items-center space-x-3">
            <button type="button" class="bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-50 transition-colors duration-200" onclick="addAllToCart()">
                <i class="fas fa-cart-plus mr-2"></i>
                Add All to Cart
            </button>
            <button type="button" class="bg-white border border-red-300 text-red-700 px-4 py-2 rounded-lg text-sm font-medium hover:bg-red-50 transition-colors duration-200" onclick="clearWishlist()">
                <i class="fas fa-trash mr-2"></i>
                Clear Wishlist
            </button>
        </div>
    </div>
</div>
<?php endif; ?>

<script>
// Search functionality
document.getElementById('searchInput').addEventListener('input', function() {
    const searchTerm = this.value.toLowerCase();
    const courseCards = document.querySelectorAll('.course-card');
    
    courseCards.forEach(card => {
        const title = card.dataset.title;
        const instructor = card.dataset.instructor;
        
        if (title.includes(searchTerm) || instructor.includes(searchTerm)) {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });
    
    // Show/hide no results message
    const visibleCards = Array.from(courseCards).filter(card => card.style.display !== 'none');
    if (visibleCards.length === 0 && searchTerm) {
        showNoResultsMessage();
    } else {
        hideNoResultsMessage();
    }
});

function clearSearch() {
    document.getElementById('searchInput').value = '';
    document.querySelectorAll('.course-card').forEach(card => {
        card.style.display = 'block';
    });
    hideNoResultsMessage();
}

function showNoResultsMessage() {
    const existingMsg = document.getElementById('noResultsMessage');
    if (existingMsg) return;
    
    const grid = document.getElementById('courseGrid');
    const message = document.createElement('div');
    message.id = 'noResultsMessage';
    message.className = 'col-span-full text-center py-8';
    message.innerHTML = `
        <i class="fas fa-search text-gray-400 text-3xl mb-3"></i>
        <h3 class="text-lg font-medium text-gray-900 mb-2">No courses found</h3>
        <p class="text-gray-500">Try adjusting your search terms</p>
    `;
    grid.appendChild(message);
}

function hideNoResultsMessage() {
    const message = document.getElementById('noResultsMessage');
    if (message) {
        message.remove();
    }
}

// Action functions
function viewCourse(id) {
    window.location.href = `/student/course/${id}`;
}

function removeFromWishlist(id) {
    if (confirm('Remove this course from your wishlist?')) {
        fetch('/student/wishlist/remove', {
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
                setTimeout(() => location.reload(), 1000);
            } else {
                showNotification(data.message, 'error');
            }
        });
    }
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
        } else {
            showNotification(data.message, 'error');
        }
    });
}

function addAllToCart() {
    if (confirm('Add all wishlist courses to cart?')) {
        const courseIds = <?= json_encode(array_column($courses, 'id')) ?>;
        
        Promise.all(courseIds.map(id => 
            fetch('/student/cart/add', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ course_id: id })
            })
        ))
        .then(() => {
            showNotification(`Added ${courseIds.length} courses to cart!`, 'success');
        });
    }
}

function clearWishlist() {
    if (confirm('Are you sure you want to clear your entire wishlist? This action cannot be undone.')) {
        const courseIds = <?= json_encode(array_column($courses, 'id')) ?>;
        
        Promise.all(courseIds.map(id => 
            fetch('/student/wishlist/remove', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ course_id: id })
            })
        ))
        .then(() => {
            showNotification('Wishlist cleared successfully!', 'success');
            setTimeout(() => location.reload(), 1000);
        });
    }
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