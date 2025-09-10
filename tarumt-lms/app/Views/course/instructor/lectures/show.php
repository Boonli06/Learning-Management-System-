<?php
// Get lecture ID from URL or $_GET
$lectureId = $_GET['id'] ?? 1;

// Dummy lecture data (in real app, this would come from database)
$lecture = [
    'id' => $lectureId,
    'title' => 'Course Introduction',
    'slug' => 'course-introduction',
    'description' => 'Welcome to the course! In this introductory lecture, you\'ll learn what we will cover throughout the entire course, how to get started with the development environment, and what you can expect to achieve by the end. This lecture sets the foundation for all upcoming topics and provides you with a roadmap for success.',
    'section_id' => 1,
    'section_title' => 'Getting Started',
    'course_id' => 1,
    'course_title' => 'Laravel Fundamentals',
    'instructor_name' => 'John Doe',
    'order' => 1,
    'duration' => 15,
    'video_url' => 'https://youtube.com/watch?v=dQw4w9WgXcQ',
    'status' => 'published',
    'is_preview' => true,
    'view_count' => 245,
    'completion_rate' => 85.5,
    'avg_rating' => 4.7,
    'total_ratings' => 23,
    'created_at' => '2024-01-10',
    'updated_at' => '2024-03-15',
    'last_viewed' => '2024-03-18 14:30:00'
];

// Related lectures in the same section
$relatedLectures = [
    [
        'id' => 2,
        'title' => 'Development Environment Setup',
        'duration' => 25,
        'order' => 2,
        'status' => 'published',
        'is_preview' => false,
        'completion_rate' => 78.2
    ],
    [
        'id' => 3,
        'title' => 'Laravel Installation',
        'duration' => 30,
        'order' => 3,
        'status' => 'published',
        'is_preview' => false,
        'completion_rate' => 82.1
    ],
    [
        'id' => 4,
        'title' => 'Understanding MVC Architecture',
        'duration' => 45,
        'order' => 4,
        'status' => 'draft',
        'is_preview' => false,
        'completion_rate' => 0
    ]
];

// Recent student feedback
$recentFeedback = [
    [
        'student_name' => 'Alice Johnson',
        'rating' => 5,
        'comment' => 'Great introduction! Very clear and well-structured.',
        'date' => '2024-03-15'
    ],
    [
        'student_name' => 'Bob Smith',
        'rating' => 4,
        'comment' => 'Good overview, but could use more practical examples.',
        'date' => '2024-03-12'
    ],
    [
        'student_name' => 'Carol Davis',
        'rating' => 5,
        'comment' => 'Perfect starting point for beginners!',
        'date' => '2024-03-10'
    ]
];

ob_start();
?>

<!-- Lecture Header -->
<div class="bg-white rounded-lg border border-gray-200 p-6 mb-6">
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-4">
            <div class="w-12 h-12 bg-gradient-to-br from-gray-900 to-gray-700 rounded-lg flex items-center justify-center">
                <?php if ($lecture['is_preview']): ?>
                    <i class="fas fa-eye text-white text-lg"></i>
                <?php else: ?>
                    <i class="fas fa-play text-white text-lg"></i>
                <?php endif; ?>
            </div>
            <div>
                <div class="flex items-center space-x-3">
                    <h1 class="text-2xl font-bold text-gray-900"><?= htmlspecialchars($lecture['title']) ?></h1>
                    <?php if ($lecture['is_preview']): ?>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                            <i class="fas fa-eye mr-1"></i>
                            Preview Lecture
                        </span>
                    <?php endif; ?>
                    <?php if ($lecture['status'] === 'draft'): ?>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                            <i class="fas fa-edit mr-1"></i>
                            Draft
                        </span>
                    <?php elseif ($lecture['status'] === 'published'): ?>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            <i class="fas fa-check-circle mr-1"></i>
                            Published
                        </span>
                    <?php else: ?>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                            <i class="fas fa-archive mr-1"></i>
                            Archived
                        </span>
                    <?php endif; ?>
                </div>
                <div class="flex items-center text-sm text-gray-500 mt-1 space-x-4">
                    <span><i class="fas fa-book mr-1"></i><?= htmlspecialchars($lecture['course_title']) ?></span>
                    <span><i class="fas fa-layer-group mr-1"></i><?= htmlspecialchars($lecture['section_title']) ?></span>
                    <span><i class="fas fa-sort-numeric-up mr-1"></i>Lecture <?= $lecture['order'] ?></span>
                    <span><i class="fas fa-clock mr-1"></i><?= $lecture['duration'] ?> minutes</span>
                    <span><i class="fas fa-calendar mr-1"></i>Updated <?= date('M j, Y', strtotime($lecture['updated_at'])) ?></span>
                </div>
            </div>
        </div>
        
        <div class="flex items-center space-x-3">
            <button type="button" 
                    onclick="previewLecture()"
                    class="bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black transition-colors duration-200">
                <i class="fas fa-eye mr-2"></i>
                Preview
            </button>
            <button type="button" 
                    onclick="duplicateLecture()"
                    class="bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black transition-colors duration-200">
                <i class="fas fa-copy mr-2"></i>
                Duplicate
            </button>
            <button type="button" 
                    onclick="window.location.href='/instructor/lectures/<?= $lecture['id'] ?>/edit'"
                    class="bg-black text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black transition-colors duration-200">
                <i class="fas fa-edit mr-2"></i>
                Edit Lecture
            </button>
        </div>
    </div>
</div>

<!-- Main Content Grid -->
<div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
    <!-- Left Column - Main Content -->
    <div class="xl:col-span-2 space-y-6">
        
        <!-- Lecture Details Card -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Lecture Details</h2>
            
            <div class="space-y-4">
                <div>
                    <h3 class="text-sm font-medium text-gray-700 mb-2">Description</h3>
                    <p class="text-gray-600 leading-relaxed"><?= nl2br(htmlspecialchars($lecture['description'])) ?></p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-4 border-t border-gray-200">
                    <div>
                        <h3 class="text-sm font-medium text-gray-700 mb-2">Video URL</h3>
                        <div class="flex items-center space-x-2">
                            <a href="<?= htmlspecialchars($lecture['video_url']) ?>" target="_blank" class="text-blue-600 hover:text-blue-800 text-sm truncate flex-1">
                                <?= htmlspecialchars($lecture['video_url']) ?>
                            </a>
                            <button type="button" onclick="copyToClipboard('<?= htmlspecialchars($lecture['video_url']) ?>')" class="text-gray-400 hover:text-gray-600 p-1" title="Copy URL">
                                <i class="fas fa-copy text-sm"></i>
                            </button>
                        </div>
                    </div>
                    
                    <div>
                        <h3 class="text-sm font-medium text-gray-700 mb-2">Slug</h3>
                        <div class="flex items-center space-x-2">
                            <code class="bg-gray-100 px-2 py-1 rounded text-sm text-gray-800 flex-1 truncate">/lectures/<?= htmlspecialchars($lecture['slug']) ?></code>
                            <button type="button" onclick="copyToClipboard('/lectures/<?= htmlspecialchars($lecture['slug']) ?>')" class="text-gray-400 hover:text-gray-600 p-1" title="Copy Slug">
                                <i class="fas fa-copy text-sm"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Performance Analytics Card -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-lg font-semibold text-gray-900">Performance Analytics</h2>
                <button type="button" class="text-sm text-blue-600 hover:text-blue-800" onclick="viewDetailedAnalytics()">
                    View Detailed Analytics <i class="fas fa-arrow-right ml-1"></i>
                </button>
            </div>
            
            <!-- Stats Grid -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-eye text-blue-600 text-sm"></i>
                            </div>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-500">Total Views</p>
                            <p class="text-lg font-semibold text-gray-900"><?= number_format($lecture['view_count']) ?></p>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-check-circle text-green-600 text-sm"></i>
                            </div>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-500">Completion Rate</p>
                            <p class="text-lg font-semibold text-gray-900"><?= number_format($lecture['completion_rate'], 1) ?>%</p>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-yellow-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-star text-yellow-600 text-sm"></i>
                            </div>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-500">Avg Rating</p>
                            <p class="text-lg font-semibold text-gray-900"><?= number_format($lecture['avg_rating'], 1) ?>/5</p>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-comments text-purple-600 text-sm"></i>
                            </div>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-500">Reviews</p>
                            <p class="text-lg font-semibold text-gray-900"><?= $lecture['total_ratings'] ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Progress Bar -->
            <div class="space-y-3">
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">Student Completion Progress</span>
                    <span class="text-gray-900 font-medium"><?= number_format($lecture['completion_rate'], 1) ?>%</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-3">
                    <div class="bg-green-600 h-3 rounded-full transition-all duration-300" style="width: <?= $lecture['completion_rate'] ?>%"></div>
                </div>
                <div class="flex justify-between text-xs text-gray-500">
                    <span>0%</span>
                    <span>50%</span>
                    <span>100%</span>
                </div>
            </div>
        </div>

        <!-- Recent Student Feedback -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-lg font-semibold text-gray-900">Recent Student Feedback</h2>
                <button type="button" class="text-sm text-blue-600 hover:text-blue-800" onclick="viewAllFeedback()">
                    View All Feedback <i class="fas fa-arrow-right ml-1"></i>
                </button>
            </div>
            
            <div class="space-y-4">
                <?php foreach ($recentFeedback as $feedback): ?>
                <div class="border-b border-gray-200 pb-4 last:border-b-0 last:pb-0">
                    <div class="flex items-start space-x-3">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center">
                                <span class="text-sm font-medium text-gray-600"><?= substr($feedback['student_name'], 0, 1) ?></span>
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center space-x-2 mb-1">
                                <span class="text-sm font-medium text-gray-900"><?= htmlspecialchars($feedback['student_name']) ?></span>
                                <div class="flex items-center">
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <i class="fas fa-star text-xs <?= $i <= $feedback['rating'] ? 'text-yellow-400' : 'text-gray-300' ?>"></i>
                                    <?php endfor; ?>
                                </div>
                                <span class="text-xs text-gray-500"><?= date('M j, Y', strtotime($feedback['date'])) ?></span>
                            </div>
                            <p class="text-sm text-gray-600"><?= htmlspecialchars($feedback['comment']) ?></p>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- Right Column - Sidebar -->
    <div class="space-y-6">
        
        <!-- Quick Actions Card -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>
            <div class="space-y-3">
                <button type="button" class="w-full flex items-center px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black transition-colors duration-200" onclick="window.location.href='/instructor/lectures/<?= $lecture['id'] ?>/edit'">
                    <i class="fas fa-edit text-gray-400 mr-3"></i>
                    <span class="text-sm text-gray-700">Edit Lecture</span>
                </button>
                <button type="button" class="w-full flex items-center px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black transition-colors duration-200" onclick="duplicateLecture()">
                    <i class="fas fa-copy text-gray-400 mr-3"></i>
                    <span class="text-sm text-gray-700">Duplicate Lecture</span>
                </button>
                <button type="button" class="w-full flex items-center px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black transition-colors duration-200" onclick="exportAnalytics()">
                    <i class="fas fa-download text-gray-400 mr-3"></i>
                    <span class="text-sm text-gray-700">Export Analytics</span>
                </button>
                <div class="border-t border-gray-200 pt-3">
                    <button type="button" class="w-full flex items-center px-4 py-2 border border-red-300 text-red-700 rounded-lg hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-200" onclick="deleteLecture()">
                        <i class="fas fa-trash text-red-400 mr-3"></i>
                        <span class="text-sm">Delete Lecture</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Section Navigation -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Other Lectures in Section</h3>
            <div class="space-y-2">
                <?php foreach ($relatedLectures as $relatedLecture): ?>
                <div class="flex items-center p-3 rounded-lg hover:bg-gray-50 cursor-pointer" onclick="window.location.href='/instructor/lectures/<?= $relatedLecture['id'] ?>'">
                    <div class="flex-shrink-0 w-6 h-6">
                        <div class="w-6 h-6 bg-gray-100 rounded flex items-center justify-center">
                            <span class="text-xs font-medium text-gray-600"><?= $relatedLecture['order'] ?></span>
                        </div>
                    </div>
                    <div class="ml-3 flex-1 min-w-0">
                        <div class="flex items-center justify-between">
                            <p class="text-sm font-medium text-gray-900 truncate"><?= htmlspecialchars($relatedLecture['title']) ?></p>
                            <?php if ($relatedLecture['status'] === 'published'): ?>
                                <span class="ml-2 w-2 h-2 bg-green-400 rounded-full"></span>
                            <?php elseif ($relatedLecture['status'] === 'draft'): ?>
                                <span class="ml-2 w-2 h-2 bg-yellow-400 rounded-full"></span>
                            <?php endif; ?>
                        </div>
                        <div class="flex items-center space-x-2 mt-1">
                            <span class="text-xs text-gray-500"><?= $relatedLecture['duration'] ?>m</span>
                            <?php if ($relatedLecture['completion_rate'] > 0): ?>
                                <span class="text-xs text-gray-500">•</span>
                                <span class="text-xs text-gray-500"><?= number_format($relatedLecture['completion_rate'], 1) ?>% completion</span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            
            <div class="mt-4 pt-4 border-t border-gray-200">
                <button type="button" class="w-full text-center text-sm text-blue-600 hover:text-blue-800" onclick="window.location.href='/instructor/sections/<?= $lecture['section_id'] ?>/lectures'">
                    View All Section Lectures <i class="fas fa-arrow-right ml-1"></i>
                </button>
            </div>
        </div>

        <!-- Lecture Info Card -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Lecture Information</h3>
            <dl class="space-y-3">
                <div>
                    <dt class="text-sm font-medium text-gray-500">Created</dt>
                    <dd class="text-sm text-gray-900"><?= date('F j, Y', strtotime($lecture['created_at'])) ?></dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Last Updated</dt>
                    <dd class="text-sm text-gray-900"><?= date('F j, Y \a\t g:i A', strtotime($lecture['updated_at'])) ?></dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Last Viewed</dt>
                    <dd class="text-sm text-gray-900"><?= date('F j, Y \a\t g:i A', strtotime($lecture['last_viewed'])) ?></dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Instructor</dt>
                    <dd class="text-sm text-gray-900"><?= htmlspecialchars($lecture['instructor_name']) ?></dd>
                </div>
            </dl>
        </div>
    </div>
</div>

<script>
// Copy to clipboard function
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        // Show success message
        showToast('Copied to clipboard!', 'success');
    }, function(err) {
        console.error('Could not copy text: ', err);
        showToast('Failed to copy', 'error');
    });
}

// Toast notification function
function showToast(message, type = 'info') {
    const toast = document.createElement('div');
    toast.className = `fixed top-4 right-4 px-4 py-2 rounded-lg text-white text-sm font-medium z-50 transition-opacity duration-300 ${
        type === 'success' ? 'bg-green-600' : 
        type === 'error' ? 'bg-red-600' : 
        'bg-blue-600'
    }`;
    toast.textContent = message;
    
    document.body.appendChild(toast);
    
    setTimeout(() => {
        toast.style.opacity = '0';
        setTimeout(() => {
            document.body.removeChild(toast);
        }, 300);
    }, 2000);
}

// Action functions
function previewLecture() {
    window.location.href = `/lectures/<?= $lecture['id'] ?>/preview`;
}

function duplicateLecture() {
    if (confirm('Do you want to create a copy of this lecture?')) {
        // In a real application, this would send an AJAX request
        showToast('Lecture duplicated successfully!', 'success');
        setTimeout(() => {
            window.location.href = '/instructor/lectures';
        }, 1500);
    }
}

function deleteLecture() {
    if (confirm('Are you sure you want to delete this lecture? This action cannot be undone.')) {
        if (confirm('This will permanently delete the lecture and all associated data. Continue?')) {
            // In a real application, this would send a DELETE request
            showToast('Lecture deleted successfully', 'success');
            setTimeout(() => {
                window.location.href = '/instructor/lectures';
            }, 1500);
        }
    }
}

function viewDetailedAnalytics() {
    window.location.href = `/instructor/analytics?lecture_id=<?= $lecture['id'] ?>`;
}

function viewAllFeedback() {
    window.location.href = `/instructor/lectures/<?= $lecture['id'] ?>/feedback`;
}

function exportAnalytics() {
    // In a real application, this would trigger a download
    showToast('Analytics export started...', 'info');
}

// Auto-refresh analytics every 30 seconds
setInterval(() => {
    // In a real application, this would update the analytics via AJAX
    console.log('Refreshing analytics...');
}, 30000);
</script>

<?php
$content = ob_get_clean();
include '../app/Views/layouts/instructor.php';
?>