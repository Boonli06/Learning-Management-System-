<?php
ob_start();
?>

<!-- Course Hero Section -->
<div class="bg-white rounded-lg border border-gray-200 overflow-hidden mb-6">
    <div class="md:flex">
        <!-- Course Image -->
        <div class="md:flex-shrink-0">
            <img class="h-48 w-full object-cover md:h-full md:w-80" src="<?= htmlspecialchars($course['thumbnail']) ?>" alt="<?= htmlspecialchars($course['title']) ?>">
        </div>
        
        <!-- Course Details -->
        <div class="p-8 flex-1">
            <div class="flex justify-between items-start">
                <div class="flex-1">
                    <!-- Category Badge -->
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 mb-2">
                        <?= htmlspecialchars($course['category']) ?>
                    </span>
                    
                    <!-- Course Title -->
                    <h1 class="text-3xl font-bold text-gray-900 mb-4"><?= htmlspecialchars($course['title']) ?></h1>
                    
                    <!-- Course Description -->
                    <p class="text-lg text-gray-600 mb-6"><?= htmlspecialchars($course['description']) ?></p>
                    
                    <!-- Course Meta -->
                    <div class="flex flex-wrap items-center gap-6 mb-6">
                        <!-- Rating -->
                        <div class="flex items-center">
                            <div class="flex items-center">
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                    <i class="fas fa-star <?= $i <= floor($course['rating']) ? 'text-yellow-400' : 'text-gray-300' ?> text-sm"></i>
                                <?php endfor; ?>
                            </div>
                            <span class="ml-1 text-sm font-medium text-gray-900"><?= $course['rating'] ?></span>
                            <span class="ml-1 text-sm text-gray-500">(<?= number_format($course['students']) ?> students)</span>
                        </div>
                        
                        <!-- Duration -->
                        <div class="flex items-center text-sm text-gray-500">
                            <i class="fas fa-clock mr-1"></i>
                            <?= $course['duration'] ?> hours
                        </div>
                        
                        <!-- Level -->
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium <?= $course['level'] === 'beginner' ? 'bg-green-100 text-green-800' : ($course['level'] === 'intermediate' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') ?>">
                            <?= ucfirst($course['level']) ?>
                        </span>
                        
                        <!-- Last Updated -->
                        <div class="flex items-center text-sm text-gray-500">
                            <i class="fas fa-calendar mr-1"></i>
                            Updated <?= date('M Y', strtotime($course['updated_at'])) ?>
                        </div>
                    </div>
                    
                    <!-- Instructor -->
                    <div class="flex items-center">
                        <img class="h-10 w-10 rounded-full" src="<?= htmlspecialchars($course['instructor_avatar']) ?>" alt="<?= htmlspecialchars($course['instructor']) ?>">
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-900">Taught by <?= htmlspecialchars($course['instructor']) ?></p>
                            <p class="text-xs text-gray-500">Instructor</p>
                        </div>
                    </div>
                </div>
                
                <!-- Action Card -->
                <div class="ml-8 flex-shrink-0">
                    <div class="bg-gray-50 rounded-lg p-6 w-80">
                        <!-- Price -->
                        <div class="text-center mb-6">
                            <?php if ($course['price'] > 0): ?>
                                <div class="text-3xl font-bold text-gray-900">RM<?= number_format($course['price'], 2) ?></div>
                            <?php else: ?>
                                <div class="text-3xl font-bold text-green-600">Free</div>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="space-y-3">
                            <?php if ($isEnrolled): ?>
                                <button type="button" class="w-full bg-black text-white px-4 py-3 rounded-lg text-sm font-medium hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black transition-colors duration-200" onclick="window.location.href='/student/course/<?= $course['id'] ?>/learn'">
                                    <i class="fas fa-play mr-2"></i>
                                    Continue Learning
                                </button>
                            <?php else: ?>
                                <?php if (!$inCart): ?>
                                    <button type="button" class="w-full bg-black text-white px-4 py-3 rounded-lg text-sm font-medium hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black transition-colors duration-200" onclick="addToCart(<?= $course['id'] ?>)">
                                        <i class="fas fa-shopping-cart mr-2"></i>
                                        Add to Cart
                                    </button>
                                <?php else: ?>
                                    <button type="button" class="w-full bg-green-600 text-white px-4 py-3 rounded-lg text-sm font-medium cursor-default">
                                        <i class="fas fa-check mr-2"></i>
                                        In Cart
                                    </button>
                                <?php endif; ?>
                                
                                <button type="button" class="w-full bg-white border border-gray-300 text-gray-700 px-4 py-3 rounded-lg text-sm font-medium hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black transition-colors duration-200" onclick="<?= $inWishlist ? 'removeFromWishlist' : 'addToWishlist' ?>(<?= $course['id'] ?>)">
                                    <i class="fas fa-heart mr-2 <?= $inWishlist ? 'text-red-500' : '' ?>"></i>
                                    <?= $inWishlist ? 'Remove from Wishlist' : 'Add to Wishlist' ?>
                                </button>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Course Features -->
                        <div class="mt-6 pt-6 border-t border-gray-200">
                            <h4 class="text-sm font-medium text-gray-900 mb-3">This course includes:</h4>
                            <ul class="space-y-2">
                                <li class="flex items-center text-sm text-gray-600">
                                    <i class="fas fa-play-circle text-gray-400 mr-3"></i>
                                    <?= count(array_merge(...array_column($sections, 'lectures'))) ?> lectures
                                </li>
                                <li class="flex items-center text-sm text-gray-600">
                                    <i class="fas fa-clock text-gray-400 mr-3"></i>
                                    <?= $course['duration'] ?> hours of content
                                </li>
                                <li class="flex items-center text-sm text-gray-600">
                                    <i class="fas fa-mobile-alt text-gray-400 mr-3"></i>
                                    Access on mobile and desktop
                                </li>
                                <li class="flex items-center text-sm text-gray-600">
                                    <i class="fas fa-infinity text-gray-400 mr-3"></i>
                                    Lifetime access
                                </li>
                                <li class="flex items-center text-sm text-gray-600">
                                    <i class="fas fa-certificate text-gray-400 mr-3"></i>
                                    Certificate of completion
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Course Content Tabs -->
<div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
    <!-- Tab Navigation -->
    <div class="border-b border-gray-200">
        <nav class="-mb-px flex">
            <button type="button" class="py-4 px-6 border-b-2 border-black text-black font-medium text-sm" onclick="showTab('overview')" id="tab-overview">
                Course Overview
            </button>
            <button type="button" class="py-4 px-6 border-b-2 border-transparent text-gray-500 hover:text-gray-700 font-medium text-sm" onclick="showTab('curriculum')" id="tab-curriculum">
                Curriculum
            </button>
            <button type="button" class="py-4 px-6 border-b-2 border-transparent text-gray-500 hover:text-gray-700 font-medium text-sm" onclick="showTab('instructor')" id="tab-instructor">
                Instructor
            </button>
            <button type="button" class="py-4 px-6 border-b-2 border-transparent text-gray-500 hover:text-gray-700 font-medium text-sm" onclick="showTab('reviews')" id="tab-reviews">
                Reviews
            </button>
        </nav>
    </div>
    
    <!-- Tab Content -->
    <div class="p-6">
        <!-- Overview Tab -->
        <div id="content-overview">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- What You'll Learn -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">What you'll learn</h3>
                    <ul class="space-y-3">
                        <?php foreach ($course['what_you_learn'] as $item): ?>
                        <li class="flex items-start">
                            <i class="fas fa-check text-green-500 mt-1 mr-3 flex-shrink-0"></i>
                            <span class="text-gray-700"><?= htmlspecialchars($item) ?></span>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                
                <!-- Requirements -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Requirements</h3>
                    <ul class="space-y-3">
                        <?php foreach ($course['requirements'] as $item): ?>
                        <li class="flex items-start">
                            <i class="fas fa-dot-circle text-gray-400 mt-1 mr-3 flex-shrink-0 text-xs"></i>
                            <span class="text-gray-700"><?= htmlspecialchars($item) ?></span>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
        
        <!-- Curriculum Tab -->
        <div id="content-curriculum" class="hidden">
            <h3 class="text-lg font-semibold text-gray-900 mb-6">Course Curriculum</h3>
            <div class="space-y-4">
                <?php foreach ($sections as $sectionIndex => $section): ?>
                <div class="border border-gray-200 rounded-lg">
                    <button type="button" class="w-full px-6 py-4 text-left focus:outline-none focus:ring-2 focus:ring-black" onclick="toggleSection(<?= $sectionIndex ?>)">
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="text-sm font-medium text-gray-900"><?= htmlspecialchars($section['title']) ?></h4>
                                <p class="text-xs text-gray-500 mt-1"><?= count($section['lectures']) ?> lectures</p>
                            </div>
                            <i class="fas fa-chevron-down text-gray-400 transform transition-transform duration-200" id="icon-<?= $sectionIndex ?>"></i>
                        </div>
                    </button>
                    <div id="section-<?= $sectionIndex ?>" class="hidden border-t border-gray-200">
                        <?php foreach ($section['lectures'] as $lecture): ?>
                        <div class="px-6 py-3 border-b border-gray-100 last:border-b-0 flex items-center justify-between">
                            <div class="flex items-center">
                                <i class="fas fa-play-circle text-gray-400 mr-3"></i>
                                <div>
                                    <p class="text-sm text-gray-900"><?= htmlspecialchars($lecture['title']) ?></p>
                                    <?php if ($lecture['is_preview']): ?>
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800 mt-1">
                                            Preview
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="flex items-center space-x-3">
                                <span class="text-xs text-gray-500"><?= $lecture['duration'] ?></span>
                                <?php if ($lecture['is_preview'] || $isEnrolled): ?>
                                    <button type="button" class="text-blue-600 hover:text-blue-800 text-xs font-medium" onclick="playLecture(<?= $lecture['id'] ?>)">
                                        Play
                                    </button>
                                <?php else: ?>
                                    <i class="fas fa-lock text-gray-400 text-xs"></i>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        
        <!-- Instructor Tab -->
        <div id="content-instructor" class="hidden">
            <div class="flex items-start">
                <img class="h-24 w-24 rounded-full" src="<?= htmlspecialchars($course['instructor_avatar']) ?>" alt="<?= htmlspecialchars($course['instructor']) ?>">
                <div class="ml-6 flex-1">
                    <h3 class="text-xl font-semibold text-gray-900"><?= htmlspecialchars($course['instructor']) ?></h3>
                    <p class="text-sm text-gray-600 mt-1">Senior Web Developer & Instructor</p>
                    
                    <div class="mt-4 grid grid-cols-2 gap-4">
                        <div class="flex items-center">
                            <i class="fas fa-star text-yellow-400 mr-2"></i>
                            <span class="text-sm text-gray-700">4.8 Instructor Rating</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-award text-blue-400 mr-2"></i>
                            <span class="text-sm text-gray-700">15 Courses</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-users text-green-400 mr-2"></i>
                            <span class="text-sm text-gray-700">25,000+ Students</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-play text-purple-400 mr-2"></i>
                            <span class="text-sm text-gray-700">150+ Hours</span>
                        </div>
                    </div>
                    
                    <div class="mt-6">
                        <h4 class="text-sm font-medium text-gray-900 mb-2">About the Instructor</h4>
                        <p class="text-sm text-gray-700">
                            An experienced web developer with over 8 years of experience in building scalable web applications. 
                            Specializes in Laravel, React, and modern web development practices. Passionate about teaching and 
                            helping students achieve their coding goals.
                        </p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Reviews Tab -->
        <div id="content-reviews" class="hidden">
            <div class="mb-6">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900">Student Reviews</h3>
                    <div class="flex items-center">
                        <div class="flex items-center">
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <i class="fas fa-star <?= $i <= floor($course['rating']) ? 'text-yellow-400' : 'text-gray-300' ?> text-sm"></i>
                            <?php endfor; ?>
                        </div>
                        <span class="ml-2 text-sm font-medium text-gray-900"><?= $course['rating'] ?> out of 5</span>
                        <span class="ml-1 text-sm text-gray-500">(<?= number_format($course['students']) ?> ratings)</span>
                    </div>
                </div>
            </div>
            
            <!-- Sample Reviews -->
            <div class="space-y-6">
                <div class="border-b border-gray-200 pb-6">
                    <div class="flex items-start">
                        <img class="h-10 w-10 rounded-full" src="https://ui-avatars.com/api/?name=Sarah+Johnson&background=6b7280&color=ffffff" alt="Sarah Johnson">
                        <div class="ml-4 flex-1">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h4 class="text-sm font-medium text-gray-900">Sarah Johnson</h4>
                                    <div class="flex items-center mt-1">
                                        <?php for ($i = 1; $i <= 5; $i++): ?>
                                            <i class="fas fa-star text-yellow-400 text-xs"></i>
                                        <?php endfor; ?>
                                        <span class="ml-2 text-xs text-gray-500">2 weeks ago</span>
                                    </div>
                                </div>
                            </div>
                            <p class="mt-2 text-sm text-gray-700">
                                Excellent course! The instructor explains complex concepts in a very understandable way. 
                                The hands-on projects really helped me grasp the fundamentals of Laravel.
                            </p>
                        </div>
                    </div>
                </div>
                
                <div class="border-b border-gray-200 pb-6">
                    <div class="flex items-start">
                        <img class="h-10 w-10 rounded-full" src="https://ui-avatars.com/api/?name=Mike+Chen&background=6b7280&color=ffffff" alt="Mike Chen">
                        <div class="ml-4 flex-1">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h4 class="text-sm font-medium text-gray-900">Mike Chen</h4>
                                    <div class="flex items-center mt-1">
                                        <?php for ($i = 1; $i <= 4; $i++): ?>
                                            <i class="fas fa-star text-yellow-400 text-xs"></i>
                                        <?php endfor; ?>
                                        <i class="fas fa-star text-gray-300 text-xs"></i>
                                        <span class="ml-2 text-xs text-gray-500">1 month ago</span>
                                    </div>
                                </div>
                            </div>
                            <p class="mt-2 text-sm text-gray-700">
                                Great content and well-structured. I would have liked more advanced topics covered, 
                                but overall this is a solid introduction to Laravel development.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Related Courses -->
<?php if (!empty($relatedCourses)): ?>
<div class="mt-8">
    <h2 class="text-xl font-semibold text-gray-900 mb-6">Related Courses</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php foreach ($relatedCourses as $relatedCourse): ?>
        <div class="bg-white rounded-lg border border-gray-200 overflow-hidden hover:shadow-lg transition-shadow duration-200">
            <img class="h-48 w-full object-cover" src="<?= htmlspecialchars($relatedCourse['thumbnail']) ?>" alt="<?= htmlspecialchars($relatedCourse['title']) ?>">
            <div class="p-4">
                <h3 class="text-lg font-medium text-gray-900 mb-2"><?= htmlspecialchars($relatedCourse['title']) ?></h3>
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="flex items-center">
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <i class="fas fa-star <?= $i <= floor($relatedCourse['rating']) ? 'text-yellow-400' : 'text-gray-300' ?> text-xs"></i>
                            <?php endfor; ?>
                        </div>
                        <span class="ml-1 text-xs text-gray-500">(<?= number_format($relatedCourse['students']) ?>)</span>
                    </div>
                    <span class="text-lg font-bold text-gray-900">RM<?= number_format($relatedCourse['price'], 2) ?></span>
                </div>
                <button type="button" class="w-full mt-4 bg-black text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-800 transition-colors duration-200" onclick="window.location.href='/student/course/<?= $relatedCourse['id'] ?>'">
                    View Course
                </button>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>

<script>
// Tab functionality
function showTab(tabName) {
    // Hide all content
    document.querySelectorAll('[id^="content-"]').forEach(content => {
        content.classList.add('hidden');
    });
    
    // Remove active state from all tabs
    document.querySelectorAll('[id^="tab-"]').forEach(tab => {
        tab.classList.remove('border-black', 'text-black');
        tab.classList.add('border-transparent', 'text-gray-500');
    });
    
    // Show selected content
    document.getElementById('content-' + tabName).classList.remove('hidden');
    
    // Add active state to selected tab
    const activeTab = document.getElementById('tab-' + tabName);
    activeTab.classList.remove('border-transparent', 'text-gray-500');
    activeTab.classList.add('border-black', 'text-black');
}

// Section toggle functionality
function toggleSection(sectionIndex) {
    const section = document.getElementById('section-' + sectionIndex);
    const icon = document.getElementById('icon-' + sectionIndex);
    
    if (section.classList.contains('hidden')) {
        section.classList.remove('hidden');
        icon.classList.add('rotate-180');
    } else {
        section.classList.add('hidden');
        icon.classList.remove('rotate-180');
    }
}

// Action functions
function addToCart(courseId) {
    fetch('/student/cart/add', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ course_id: courseId })
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

function addToWishlist(courseId) {
    fetch('/student/wishlist/add', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ course_id: courseId })
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

function removeFromWishlist(courseId) {
    fetch('/student/wishlist/remove', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ course_id: courseId })
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

function playLecture(lectureId) {
    // For preview lectures or if enrolled
    <?php if ($isEnrolled): ?>
        window.location.href = `/student/course/<?= $course['id'] ?>/learn?lecture=${lectureId}`;
    <?php else: ?>
        // Open preview modal or redirect to preview
        window.open(`/student/course/<?= $course['id'] ?>/preview?lecture=${lectureId}`, '_blank');
    <?php endif; ?>
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