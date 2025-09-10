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
                placeholder="Search my courses..." 
                value="<?= htmlspecialchars($filters['search']) ?>"
                class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg text-sm placeholder-gray-500 focus:outline-none focus:ring-1 focus:ring-black focus:border-black"
            >
        </div>

        <!-- Status Filter -->
        <select id="statusFilter" class="flex-shrink-0 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-black focus:border-black">
            <?php foreach ($statusOptions as $value => $label): ?>
                <option value="<?= $value ?>" <?= $filters['status'] === $value ? 'selected' : '' ?>>
                    <?= $label ?>
                </option>
            <?php endforeach; ?>
        </select>

        <!-- Clear Button -->
        <button type="button" class="flex-shrink-0 bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black transition-colors duration-200" onclick="clearFilters()">
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

<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-lg border border-gray-200 p-4">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-book text-blue-600 text-sm"></i>
                </div>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-gray-500">Total Enrolled</p>
                <p class="text-lg font-semibold text-gray-900"><?= count($courses) ?></p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg border border-gray-200 p-4">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-check-circle text-green-600 text-sm"></i>
                </div>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-gray-500">Completed</p>
                <p class="text-lg font-semibold text-gray-900"><?= count(array_filter($courses, function($c) { return $c['progress_status'] === 'completed'; })) ?></p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg border border-gray-200 p-4">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="w-8 h-8 bg-yellow-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-play-circle text-yellow-600 text-sm"></i>
                </div>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-gray-500">In Progress</p>
                <p class="text-lg font-semibold text-gray-900"><?= count(array_filter($courses, function($c) { return $c['progress_status'] === 'in_progress'; })) ?></p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg border border-gray-200 p-4">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-clock text-gray-600 text-sm"></i>
                </div>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-gray-500">Not Started</p>
                <p class="text-lg font-semibold text-gray-900"><?= count(array_filter($courses, function($c) { return $c['progress_status'] === 'not_started'; })) ?></p>
            </div>
        </div>
    </div>
</div>

<!-- Courses List -->
<div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200">
        <h3 class="text-lg font-medium text-gray-900">My Courses</h3>
    </div>

    <?php if (empty($courses)): ?>
    <div class="text-center py-12">
        <div class="w-24 h-24 mx-auto bg-gray-100 rounded-full flex items-center justify-center mb-4">
            <i class="fas fa-graduation-cap text-gray-400 text-2xl"></i>
        </div>
        <h3 class="text-lg font-medium text-gray-900 mb-2">No courses enrolled yet</h3>
        <p class="text-gray-500 mb-6">Start your learning journey by enrolling in your first course.</p>
        <button type="button" class="bg-black text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-800" onclick="window.location.href='/student/browse'">
            <i class="fas fa-search mr-2"></i>
            Browse Courses
        </button>
    </div>
    <?php else: ?>
    <div class="divide-y divide-gray-200">
        <?php foreach ($courses as $course): ?>
        <div class="p-6 hover:bg-gray-50 transition-colors duration-200">
            <div class="flex items-center justify-between">
                <div class="flex items-center flex-1">
                    <!-- Course Thumbnail -->
                    <div class="flex-shrink-0">
                        <img class="w-20 h-20 rounded-lg object-cover" src="<?= htmlspecialchars($course['thumbnail']) ?>" alt="<?= htmlspecialchars($course['title']) ?>">
                    </div>
                    
                    <!-- Course Info -->
                    <div class="ml-6 flex-1">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <h3 class="text-lg font-medium text-gray-900 mb-1"><?= htmlspecialchars($course['title']) ?></h3>
                                
                                <!-- Course Meta -->
                                <div class="flex items-center space-x-4 text-sm text-gray-500 mb-3">
                                    <span>Enrolled: <?= date('M d, Y', strtotime($course['enrolled_at'])) ?></span>
                                    <span>Last accessed: <?= date('M d, Y', strtotime($course['last_accessed'])) ?></span>
                                    <?php if ($course['progress_status'] === 'completed' && isset($course['completed_at'])): ?>
                                        <span>Completed: <?= date('M d, Y', strtotime($course['completed_at'])) ?></span>
                                    <?php endif; ?>
                                </div>
                                
                                <!-- Progress Bar -->
                                <div class="max-w-md">
                                    <div class="flex items-center justify-between text-sm text-gray-600 mb-1">
                                        <span>Progress</span>
                                        <span><?= $course['progress'] ?>% complete</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div class="bg-blue-600 h-2 rounded-full transition-all duration-300" style="width: <?= $course['progress'] ?>%"></div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Status Badge -->
                            <div class="ml-4">
                                <?php
                                $statusClasses = [
                                    'completed' => 'bg-green-100 text-green-800',
                                    'in_progress' => 'bg-blue-100 text-blue-800',
                                    'not_started' => 'bg-gray-100 text-gray-800'
                                ];
                                $statusLabels = [
                                    'completed' => 'Completed',
                                    'in_progress' => 'In Progress',
                                    'not_started' => 'Not Started'
                                ];
                                ?>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?= $statusClasses[$course['progress_status']] ?>">
                                    <?= $statusLabels[$course['progress_status']] ?>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Action Buttons -->
                <div class="ml-6 flex items-center space-x-3">
                    <button type="button" class="text-gray-600 hover:text-black transition-colors duration-200" onclick="viewCourse(<?= $course['id'] ?>)" title="View Course">
                        <i class="fas fa-eye"></i>
                    </button>
                    
                    <?php if ($course['progress_status'] === 'completed'): ?>
                        <button type="button" class="text-gray-600 hover:text-green-600 transition-colors duration-200" onclick="downloadCertificate(<?= $course['id'] ?>)" title="Download Certificate">
                            <i class="fas fa-certificate"></i>
                        </button>
                    <?php endif; ?>
                    
                    <button type="button" class="bg-black text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-800 transition-colors duration-200" onclick="continueLearning(<?= $course['id'] ?>)">
                        <?php if ($course['progress_status'] === 'completed'): ?>
                            <i class="fas fa-redo mr-2"></i>Review
                        <?php elseif ($course['progress_status'] === 'not_started'): ?>
                            <i class="fas fa-play mr-2"></i>Start
                        <?php else: ?>
                            <i class="fas fa-play mr-2"></i>Continue
                        <?php endif; ?>
                    </button>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</div>

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
document.getElementById('statusFilter').addEventListener('change', applyFilters);

function applyFilters() {
    const search = document.getElementById('searchInput').value;
    const status = document.getElementById('statusFilter').value;
    
    const params = new URLSearchParams();
    if (search) params.set('search', search);
    if (status && status !== 'all') params.set('status', status);
    
    window.location.href = '/student/dashboard/mycourses?' + params.toString();
}

function clearFilters() {
    window.location.href = '/student/dashboard/mycourses';
}

// Action functions
function viewCourse(id) {
    window.location.href = `/student/course/${id}`;
}

function continueLearning(id) {
    window.location.href = `/student/course/${id}/learn`;
}

function downloadCertificate(id) {
    // Open certificate in new window/tab
    window.open(`/student/course/${id}/certificate`, '_blank');
    showNotification('Certificate download started', 'success');
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