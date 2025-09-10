<?php
ob_start();
?>

<!-- Header Actions -->
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
    <div class="flex items-center space-x-4">
        <!-- Search -->
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="fas fa-search text-gray-400"></i>
            </div>
            <input 
                type="text" 
                id="searchInput" 
                placeholder="Search courses..." 
                value="<?= htmlspecialchars($filters['search'] ?? '') ?>"
                class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg text-sm placeholder-gray-500 focus:outline-none focus:ring-1 focus:ring-black focus:border-black"
            >
        </div>

        <!-- Clear Button -->
        <button type="button" class="bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black transition-colors duration-200" onclick="window.location.href='/instructor/analytics'">
            <i class="fas fa-times mr-2"></i>
            Clear
        </button>

        <!-- Date Range Filter -->
        <select id="dateRangeFilter" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-black focus:border-black">
            <option value="7" <?= ($filters['period'] ?? '30') === '7' ? 'selected' : '' ?>>Last 7 days</option>
            <option value="30" <?= ($filters['period'] ?? '30') === '30' ? 'selected' : '' ?>>Last 30 days</option>
            <option value="90" <?= ($filters['period'] ?? '30') === '90' ? 'selected' : '' ?>>Last 90 days</option>
            <option value="365" <?= ($filters['period'] ?? '30') === '365' ? 'selected' : '' ?>>Last year</option>
        </select>

        <!-- Status Filter -->
        <select id="statusFilter" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-black focus:border-black">
            <option value="">All Status</option>
            <option value="published" <?= ($filters['status'] ?? '') === 'published' ? 'selected' : '' ?>>Published</option>
            <option value="draft" <?= ($filters['status'] ?? '') === 'draft' ? 'selected' : '' ?>>Draft</option>
            <option value="pending" <?= ($filters['status'] ?? '') === 'pending' ? 'selected' : '' ?>>Pending Review</option>
        </select>

        <!-- Sort -->
        <select id="sortFilter" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-black focus:border-black">
            <option value="revenue_desc" <?= ($filters['sort'] ?? 'revenue_desc') === 'revenue_desc' ? 'selected' : '' ?>>Highest Revenue</option>
            <option value="students_desc" <?= ($filters['sort'] ?? 'revenue_desc') === 'students_desc' ? 'selected' : '' ?>>Most Students</option>
            <option value="rating_desc" <?= ($filters['sort'] ?? 'revenue_desc') === 'rating_desc' ? 'selected' : '' ?>>Highest Rating</option>
            <option value="created_desc" <?= ($filters['sort'] ?? 'revenue_desc') === 'created_desc' ? 'selected' : '' ?>>Newest First</option>
            <option value="title_asc" <?= ($filters['sort'] ?? 'revenue_desc') === 'title_asc' ? 'selected' : '' ?>>Title A-Z</option>
        </select>
    </div>

    <div class="flex items-center space-x-3">
        <button type="button" class="bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black transition-colors duration-200" onclick="refreshAnalytics()">
            <i class="fas fa-refresh mr-2"></i>
            Refresh
        </button>
        <button type="button" class="bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black transition-colors duration-200" onclick="exportAnalytics()">
            <i class="fas fa-download mr-2"></i>
            Export
        </button>
    </div>
</div>

<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-lg border border-gray-200 p-4">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-chart-line text-green-600 text-sm"></i>
                </div>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-gray-500">Total Revenue</p>
                <p class="text-lg font-semibold text-gray-900">RM <?= number_format($analytics['total_revenue']) ?></p>
            </div>
        </div>
        <div class="mt-2">
            <p class="text-sm text-green-600">
                <i class="fas fa-arrow-up text-xs mr-1"></i>
                +<?= $analytics['monthly_revenue_growth'] ?>% this month
            </p>
        </div>
    </div>

    <div class="bg-white rounded-lg border border-gray-200 p-4">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-users text-blue-600 text-sm"></i>
                </div>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-gray-500">Total Students</p>
                <p class="text-lg font-semibold text-gray-900"><?= number_format($analytics['total_students']) ?></p>
            </div>
        </div>
        <div class="mt-2">
            <p class="text-sm text-green-600">
                <i class="fas fa-arrow-up text-xs mr-1"></i>
                +<?= $analytics['weekly_student_growth'] ?> this week
            </p>
        </div>
    </div>

    <div class="bg-white rounded-lg border border-gray-200 p-4">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-book text-purple-600 text-sm"></i>
                </div>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-gray-500">Active Courses</p>
                <p class="text-lg font-semibold text-gray-900"><?= $analytics['active_courses'] ?></p>
            </div>
        </div>
        <div class="mt-2">
            <p class="text-sm text-blue-600">
                <i class="fas fa-book text-xs mr-1"></i>
                <?= $analytics['published_courses'] ?> published, <?= $analytics['draft_courses'] ?> drafts
            </p>
        </div>
    </div>

    <div class="bg-white rounded-lg border border-gray-200 p-4">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="w-8 h-8 bg-yellow-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-star text-yellow-600 text-sm"></i>
                </div>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-gray-500">Avg. Rating</p>
                <p class="text-lg font-semibold text-gray-900"><?= $analytics['avg_rating'] ?></p>
            </div>
        </div>
        <div class="mt-2">
            <p class="text-sm text-gray-600">
                Based on <?= $analytics['total_reviews'] ?> reviews
            </p>
        </div>
    </div>
</div>

<!-- Charts Section -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
    <!-- Revenue Trends -->
    <div class="bg-white rounded-lg border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-medium text-gray-900">Revenue Trends</h3>
            <select class="border border-gray-300 rounded-lg px-3 py-1 text-sm focus:ring-black focus:border-black" onchange="updateRevenueChart(this.value)">
                <option value="7">Last 7 days</option>
                <option value="30" selected>Last 30 days</option>
                <option value="90">Last 90 days</option>
                <option value="365">Last year</option>
            </select>
        </div>
        <div class="h-64">
            <canvas id="revenueChart"></canvas>
        </div>
    </div>

    <!-- Student Enrollment -->
    <div class="bg-white rounded-lg border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-medium text-gray-900">Student Enrollment</h3>
            <select class="border border-gray-300 rounded-lg px-3 py-1 text-sm focus:ring-black focus:border-black" onchange="updateEnrollmentChart(this.value)">
                <option value="7">Last 7 days</option>
                <option value="30" selected>Last 30 days</option>
                <option value="90">Last 90 days</option>
            </select>
        </div>
        <div class="h-64">
            <canvas id="enrollmentChart"></canvas>
        </div>
    </div>
</div>

<!-- Course Performance Table -->
<div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200">
        <h3 class="text-lg font-medium text-gray-900">Course Performance</h3>
    </div>

    <?php if (empty($courses)): ?>
    <div class="text-center py-12">
        <div class="w-24 h-24 mx-auto bg-gray-100 rounded-full flex items-center justify-center mb-4">
            <i class="fas fa-chart-bar text-gray-400 text-2xl"></i>
        </div>
        <h3 class="text-lg font-medium text-gray-900 mb-2">No course data found</h3>
        <p class="text-gray-500 mb-6">Start creating courses to see your performance analytics.</p>
        <button type="button" class="bg-black text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-800" onclick="window.location.href='/instructor/courses/create'">
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
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Students</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Revenue</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Rating</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php foreach ($courses as $course): ?>
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-4">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 w-8 h-8">
                                <div class="w-8 h-8 bg-gradient-to-br from-gray-900 to-gray-700 rounded-lg flex items-center justify-center">
                                    <span class="text-white text-xs font-bold"><?= strtoupper(substr($course['title'], 0, 2)) ?></span>
                                </div>
                            </div>
                            <div class="ml-3 min-w-0 flex-1">
                                <div class="text-sm font-medium text-gray-900 truncate"><?= htmlspecialchars($course['title']) ?></div>
                                <div class="text-xs text-gray-500 truncate">Updated <?= date('M j', strtotime($course['updated_at'])) ?></div>
                            </div>
                        </div>
                    </td>
                    <td class="px-3 py-4 text-center">
                        <div class="text-sm text-gray-900"><?= $course['students'] ?></div>
                        <div class="text-xs text-green-600">+<?= $course['monthly_growth'] ?> this month</div>
                    </td>
                    <td class="px-3 py-4 text-center">
                        <div class="text-sm font-medium text-gray-900">RM <?= number_format($course['revenue']) ?></div>
                        <div class="text-xs text-green-600">+<?= $course['growth'] ?>%</div>
                    </td>
                    <td class="px-3 py-4 text-center">
                        <div class="flex items-center justify-center">
                            <div class="flex text-yellow-400 text-xs mr-1">
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                    <i class="fas fa-star<?= $i <= floor($course['rating']) ? '' : ($i - 0.5 <= $course['rating'] ? '-half-alt' : ' far') ?>"></i>
                                <?php endfor; ?>
                            </div>
                            <span class="text-sm text-gray-900"><?= $course['rating'] ?></span>
                        </div>
                        <div class="text-xs text-gray-500">(<?= $course['reviews'] ?> reviews)</div>
                    </td>
                    <td class="px-3 py-4 text-center">
                        <?php if ($course['status'] === 'published'): ?>
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                <span class="w-1.5 h-1.5 bg-green-400 rounded-full mr-1"></span>
                                Published
                            </span>
                        <?php elseif ($course['status'] === 'draft'): ?>
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                <span class="w-1.5 h-1.5 bg-yellow-400 rounded-full mr-1"></span>
                                Draft
                            </span>
                        <?php else: ?>
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                <span class="w-1.5 h-1.5 bg-blue-400 rounded-full mr-1"></span>
                                Pending Review
                            </span>
                        <?php endif; ?>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <div class="flex items-center justify-center space-x-3">
                            <button type="button" class="text-gray-600 hover:text-black transition-colors duration-200" onclick="viewCourseAnalytics(<?= $course['id'] ?>)" title="View Analytics">
                                <i class="fas fa-chart-bar"></i>
                            </button>
                            <button type="button" class="text-gray-600 hover:text-black transition-colors duration-200" onclick="editCourse(<?= $course['id'] ?>)" title="Edit Course">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button type="button" class="text-gray-600 hover:text-black transition-colors duration-200" onclick="previewCourse(<?= $course['id'] ?>)" title="Preview Course">
                                <i class="fas fa-eye"></i>
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
            Showing <span class="font-medium"><?= $pagination['start_item'] ?></span> to <span class="font-medium"><?= $pagination['end_item'] ?></span> of <span class="font-medium"><?= $pagination['total_items'] ?></span> courses
        </div>
        <div class="flex items-center space-x-2">
            <button class="relative inline-flex items-center px-3 py-2 border border-gray-300 text-sm font-medium text-gray-500 bg-white rounded-lg hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed transition-colors duration-200" <?= $pagination['current_page'] <= 1 ? 'disabled' : '' ?> onclick="<?= $pagination['current_page'] > 1 ? 'changePage(' . ($pagination['current_page'] - 1) . ')' : '' ?>">
                <i class="fas fa-chevron-left mr-1"></i>
                Previous
            </button>
            
            <?php for ($i = 1; $i <= $pagination['total_pages']; $i++): ?>
                <button class="relative inline-flex items-center px-3 py-2 border text-sm font-medium rounded-lg transition-colors duration-200 <?= $i == $pagination['current_page'] ? 'border-black bg-black text-white' : 'border-gray-300 text-gray-700 bg-white hover:bg-gray-50' ?>" onclick="<?= $i != $pagination['current_page'] ? 'changePage(' . $i . ')' : '' ?>">
                    <?= $i ?>
                </button>
            <?php endfor; ?>
            
            <button class="relative inline-flex items-center px-3 py-2 border border-gray-300 text-sm font-medium text-gray-700 bg-white rounded-lg hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed transition-colors duration-200" <?= $pagination['current_page'] >= $pagination['total_pages'] ? 'disabled' : '' ?> onclick="<?= $pagination['current_page'] < $pagination['total_pages'] ? 'changePage(' . ($pagination['current_page'] + 1) . ')' : '' ?>">
                Next
                <i class="fas fa-chevron-right ml-1"></i>
            </button>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- Additional Analytics Cards -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-6">
    <!-- Top Performing Courses -->
    <div class="bg-white rounded-lg border border-gray-200 p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Top Performing Courses</h3>
        <div class="space-y-3">
            <?php foreach (array_slice($topCourses, 0, 3) as $course): ?>
            <div class="flex items-center justify-between">
                <span class="text-sm text-gray-900 truncate"><?= htmlspecialchars($course['title']) ?></span>
                <span class="text-sm font-medium text-green-600">RM <?= number_format($course['revenue']) ?></span>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="bg-white rounded-lg border border-gray-200 p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Recent Activity</h3>
        <div class="space-y-3">
            <?php foreach ($recentActivity as $activity): ?>
            <div class="flex items-start">
                <div class="w-2 h-2 bg-<?= $activity['color'] ?>-400 rounded-full mt-2 mr-3"></div>
                <div class="flex-1">
                    <p class="text-sm text-gray-900"><?= htmlspecialchars($activity['message']) ?></p>
                    <p class="text-xs text-gray-500"><?= htmlspecialchars($activity['time']) ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="bg-white rounded-lg border border-gray-200 p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Quick Stats</h3>
        <div class="space-y-4">
            <div class="flex items-center justify-between">
                <span class="text-sm text-gray-600">Completion Rate</span>
                <span class="text-sm font-medium text-gray-900">78%</span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-2">
                <div class="bg-green-500 h-2 rounded-full" style="width: 78%"></div>
            </div>
            
            <div class="flex items-center justify-between">
                <span class="text-sm text-gray-600">Active Students</span>
                <span class="text-sm font-medium text-gray-900"><?= number_format($analytics['total_students'] * 0.85) ?></span>
            </div>
            
            <div class="flex items-center justify-between">
                <span class="text-sm text-gray-600">Total Watch Time</span>
                <span class="text-sm font-medium text-gray-900">2,847 hrs</span>
            </div>
        </div>
    </div>
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
document.getElementById('dateRangeFilter').addEventListener('change', applyFilters);
document.getElementById('statusFilter').addEventListener('change', applyFilters);
document.getElementById('sortFilter').addEventListener('change', applyFilters);

function applyFilters() {
    const search = document.getElementById('searchInput').value;
    const period = document.getElementById('dateRangeFilter').value;
    const status = document.getElementById('statusFilter').value;
    const sort = document.getElementById('sortFilter').value;
    
    const params = new URLSearchParams();
    if (search) params.set('search', search);
    if (period) params.set('period', period);
    if (status) params.set('status', status);
    if (sort) params.set('sort', sort);
    
    window.location.href = '/instructor/analytics?' + params.toString();
}

function changePage(page) {
    const search = document.getElementById('searchInput').value;
    const period = document.getElementById('dateRangeFilter').value;
    const status = document.getElementById('statusFilter').value;
    const sort = document.getElementById('sortFilter').value;
    
    const params = new URLSearchParams();
    if (search) params.set('search', search);
    if (period) params.set('period', period);
    if (status) params.set('status', status);
    if (sort) params.set('sort', sort);
    params.set('page', page);
    
    window.location.href = '/instructor/analytics?' + params.toString();
}

// Initialize Charts
document.addEventListener('DOMContentLoaded', function() {
    // Revenue Chart
    const revenueCtx = document.getElementById('revenueChart').getContext('2d');
    window.revenueChart = new Chart(revenueCtx, {
        type: 'line',
        data: {
            labels: <?= json_encode($revenueData['labels']) ?>,
            datasets: [{
                label: 'Revenue (RM)',
                data: <?= json_encode($revenueData['data']) ?>,
                borderColor: '#000000',
                backgroundColor: 'rgba(0, 0, 0, 0.1)',
                borderWidth: 2,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'RM ' + value.toLocaleString();
                        }
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });

    // Enrollment Chart
    const enrollmentCtx = document.getElementById('enrollmentChart').getContext('2d');
    window.enrollmentChart = new Chart(enrollmentCtx, {
        type: 'bar',
        data: {
            labels: <?= json_encode($enrollmentData['labels']) ?>,
            datasets: [{
                label: 'New Students',
                data: <?= json_encode($enrollmentData['data']) ?>,
                backgroundColor: '#000000',
                borderColor: '#000000',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
});

function updateRevenueChart(period) {
    // In a real application, this would fetch new data
    console.log('Updating revenue chart for period:', period);
}

function updateEnrollmentChart(period) {
    // In a real application, this would fetch new data
    console.log('Updating enrollment chart for period:', period);
}

// Action functions
function viewCourseAnalytics(id) {
    window.location.href = `/instructor/analytics?course_id=${id}`;
}

function editCourse(id) {
    window.location.href = `/instructor/courses/${id}/edit`;
}

function previewCourse(id) {
    window.location.href = `/instructor/courses/${id}/preview`;
}

function refreshAnalytics() {
    const button = event.target;
    const originalText = button.innerHTML;
    button.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Refreshing...';
    button.disabled = true;
    
    setTimeout(() => {
        button.innerHTML = originalText;
        button.disabled = false;
        location.reload();
    }, 1500);
}

function exportAnalytics() {
    const button = event.target;
    const originalText = button.innerHTML;
    button.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Exporting...';
    button.disabled = true;
    
    setTimeout(() => {
        button.innerHTML = originalText;
        button.disabled = false;
        alert('Analytics data exported successfully!');
    }, 2000);
}
</script>

<?php
$content = ob_get_clean();
include '../app/Views/layouts/instructor.php';
?>