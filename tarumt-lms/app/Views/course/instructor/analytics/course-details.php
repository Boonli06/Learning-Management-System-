<?php
ob_start();
?>

<!-- Header Actions -->
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
    <div class="flex items-center space-x-4">
        <!-- Course Info -->
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 bg-gradient-to-br from-gray-900 to-gray-700 rounded-lg flex items-center justify-center">
                <span class="text-white text-sm font-bold"><?= strtoupper(substr($course['title'], 0, 2)) ?></span>
            </div>
            <div>
                <h1 class="text-lg font-semibold text-gray-900"><?= htmlspecialchars($course['title']) ?></h1>
                <p class="text-sm text-gray-500"><?= $course['sections_count'] ?> sections • <?= $course['lectures_count'] ?> lectures</p>
            </div>
        </div>

        <!-- Time Range Filter -->
        <select id="timeRangeFilter" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-black focus:border-black">
            <option value="7">Last 7 days</option>
            <option value="30" selected>Last 30 days</option>
            <option value="90">Last 90 days</option>
            <option value="365">All time</option>
        </select>
    </div>
    
    <div class="flex items-center space-x-3">
        <button type="button" class="bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black transition-colors duration-200" onclick="exportCourseData(<?= $course['id'] ?>)">
            <i class="fas fa-download mr-2"></i>
            Export Data
        </button>
        <button type="button" class="bg-black text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black transition-colors duration-200" onclick="window.location.href='/instructor/courses/<?= $course['id'] ?>/edit'">
            <i class="fas fa-edit mr-2"></i>
            Edit Course
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
                <p class="text-lg font-semibold text-gray-900">RM <?= number_format($courseAnalytics['total_revenue']) ?></p>
            </div>
        </div>
        <div class="mt-2">
            <p class="text-sm text-green-600">
                <i class="fas fa-arrow-up text-xs mr-1"></i>
                +RM <?= number_format($courseAnalytics['monthly_revenue']) ?> this month
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
                <p class="text-lg font-semibold text-gray-900"><?= number_format($courseAnalytics['total_students']) ?></p>
            </div>
        </div>
        <div class="mt-2">
            <p class="text-sm text-blue-600">
                <i class="fas fa-user-plus text-xs mr-1"></i>
                <?= $courseAnalytics['active_students'] ?> active students
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
                <p class="text-sm font-medium text-gray-500">Average Rating</p>
                <p class="text-lg font-semibold text-gray-900"><?= $courseAnalytics['avg_rating'] ?></p>
            </div>
        </div>
        <div class="mt-2">
            <p class="text-sm text-gray-600">
                Based on <?= $courseAnalytics['total_reviews'] ?> reviews
            </p>
        </div>
    </div>

    <div class="bg-white rounded-lg border border-gray-200 p-4">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-chart-pie text-purple-600 text-sm"></i>
                </div>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-gray-500">Completion Rate</p>
                <p class="text-lg font-semibold text-gray-900"><?= $courseAnalytics['completion_rate'] ?>%</p>
            </div>
        </div>
        <div class="mt-2">
            <div class="w-full bg-gray-200 rounded-full h-2">
                <div class="bg-purple-600 h-2 rounded-full" style="width: <?= $courseAnalytics['completion_rate'] ?>%"></div>
            </div>
        </div>
    </div>
</div>

<!-- Charts Section -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
    <!-- Revenue Timeline Chart -->
    <div class="bg-white rounded-lg border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-medium text-gray-900">Revenue Trend</h3>
            <div class="flex items-center space-x-2">
                <button class="text-xs px-3 py-1 bg-black text-white rounded-lg">Monthly</button>
                <button class="text-xs px-3 py-1 text-gray-600 hover:bg-gray-100 rounded-lg">Weekly</button>
            </div>
        </div>
        <div class="h-64">
            <canvas id="revenueChart"></canvas>
        </div>
    </div>

    <!-- Student Enrollment Chart -->
    <div class="bg-white rounded-lg border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-medium text-gray-900">Student Enrollments</h3>
            <div class="flex items-center space-x-2">
                <button class="text-xs px-3 py-1 bg-black text-white rounded-lg">Monthly</button>
                <button class="text-xs px-3 py-1 text-gray-600 hover:bg-gray-100 rounded-lg">Weekly</button>
            </div>
        </div>
        <div class="h-64">
            <canvas id="enrollmentChart"></canvas>
        </div>
    </div>
</div>

<!-- Detailed Analytics -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
    <!-- Student Engagement -->
    <div class="lg:col-span-2 bg-white rounded-lg border border-gray-200 p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Student Engagement</h3>
        
        <!-- Engagement Metrics -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div class="text-center p-4 bg-gray-50 rounded-lg">
                <p class="text-2xl font-bold text-gray-900"><?= round($courseAnalytics['watch_time_hours'] / $courseAnalytics['total_students']) ?>h</p>
                <p class="text-sm text-gray-600">Avg Watch Time</p>
            </div>
            <div class="text-center p-4 bg-gray-50 rounded-lg">
                <p class="text-2xl font-bold text-gray-900"><?= $courseAnalytics['avg_progress'] ?>%</p>
                <p class="text-sm text-gray-600">Average Progress</p>
            </div>
            <div class="text-center p-4 bg-gray-50 rounded-lg">
                <p class="text-2xl font-bold text-gray-900"><?= round($courseAnalytics['active_students'] / $courseAnalytics['total_students'] * 100) ?>%</p>
                <p class="text-sm text-gray-600">Active Students</p>
            </div>
        </div>

        <!-- Section Completion Rates -->
        <div>
            <h4 class="font-medium text-gray-900 mb-3">Section Completion Rates</h4>
            <div class="space-y-3">
                <?php foreach ($engagementAnalytics['section_completion'] as $section): ?>
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-700"><?= htmlspecialchars($section['section_title']) ?></span>
                    <div class="flex items-center space-x-2">
                        <div class="w-32 bg-gray-200 rounded-full h-2">
                            <div class="bg-blue-600 h-2 rounded-full" style="width: <?= $section['completion_rate'] ?>%"></div>
                        </div>
                        <span class="text-sm font-medium text-gray-900 w-10"><?= $section['completion_rate'] ?>%</span>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- Course Performance -->
    <div class="bg-white rounded-lg border border-gray-200 p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Performance Metrics</h3>
        
        <div class="space-y-4">
            <!-- Completion Funnel -->
            <div>
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm font-medium text-gray-700">Completion Funnel</span>
                </div>
                <div class="space-y-2">
                    <?php foreach ($completionAnalytics['completion_funnel'] as $stage => $percentage): ?>
                    <div class="flex items-center justify-between text-xs">
                        <span class="text-gray-600"><?= $stage ?></span>
                        <span class="font-medium"><?= $percentage ?>%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-1">
                        <div class="bg-green-500 h-1 rounded-full" style="width: <?= $percentage ?>%"></div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Average Completion Time -->
            <div class="border-t pt-4">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm font-medium text-gray-700">Avg. Completion Time</span>
                </div>
                <p class="text-2xl font-bold text-gray-900"><?= $completionAnalytics['average_time_to_complete'] ?> days</p>
            </div>

            <!-- Drop-off Points -->
            <div class="border-t pt-4">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm font-medium text-gray-700">High Drop-off Points</span>
                </div>
                <div class="space-y-2">
                    <?php foreach (array_slice($completionAnalytics['drop_off_points'], 0, 3) as $dropOff): ?>
                    <div class="text-xs">
                        <div class="flex items-center justify-between">
                            <span class="text-gray-700 truncate"><?= htmlspecialchars($dropOff['lecture_title']) ?></span>
                            <span class="text-red-600 font-medium"><?= $dropOff['drop_off_rate'] ?>%</span>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Student Demographics & Revenue -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
    <!-- Student Demographics -->
    <div class="bg-white rounded-lg border border-gray-200 p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Student Demographics</h3>
        
        <div class="mb-6">
            <h4 class="font-medium text-gray-900 mb-3">Age Distribution</h4>
            <div class="space-y-3">
                <?php foreach ($studentAnalytics['demographics']['age_groups'] as $ageGroup => $percentage): ?>
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-700"><?= $ageGroup ?></span>
                    <div class="flex items-center space-x-2">
                        <div class="w-20 bg-gray-200 rounded-full h-2">
                            <div class="bg-blue-600 h-2 rounded-full" style="width: <?= $percentage * 2 ?>%"></div>
                        </div>
                        <span class="text-sm font-medium text-gray-900 w-8"><?= $percentage ?>%</span>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div>
            <h4 class="font-medium text-gray-900 mb-3">Top Countries</h4>
            <div class="space-y-3">
                <?php foreach ($studentAnalytics['demographics']['countries'] as $country => $percentage): ?>
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-700"><?= $country ?></span>
                    <div class="flex items-center space-x-2">
                        <div class="w-20 bg-gray-200 rounded-full h-2">
                            <div class="bg-green-600 h-2 rounded-full" style="width: <?= $percentage * 2 ?>%"></div>
                        </div>
                        <span class="text-sm font-medium text-gray-900 w-8"><?= $percentage ?>%</span>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- Revenue Analytics -->
    <div class="bg-white rounded-lg border border-gray-200 p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Revenue Breakdown</h3>
        
        <div class="mb-6">
            <h4 class="font-medium text-gray-900 mb-3">Monthly Revenue Trend</h4>
            <div class="h-32">
                <canvas id="monthlyRevenueChart"></canvas>
            </div>
        </div>

        <div class="border-t pt-4">
            <h4 class="font-medium text-gray-900 mb-3">Payment Methods</h4>
            <div class="space-y-3">
                <?php foreach ($revenueAnalytics['payment_methods'] as $method => $percentage): ?>
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-700"><?= $method ?></span>
                    <div class="flex items-center space-x-2">
                        <div class="w-16 bg-gray-200 rounded-full h-2">
                            <div class="bg-purple-600 h-2 rounded-full" style="width: <?= $percentage ?>%"></div>
                        </div>
                        <span class="text-sm font-medium text-gray-900 w-8"><?= $percentage ?>%</span>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="border-t pt-4 mt-4">
            <div class="grid grid-cols-2 gap-4 text-center">
                <div>
                    <p class="text-lg font-bold text-gray-900">RM <?= number_format($courseAnalytics['total_revenue'] / $courseAnalytics['total_students']) ?></p>
                    <p class="text-xs text-gray-600">Avg Revenue per Student</p>
                </div>
                <div>
                    <p class="text-lg font-bold text-gray-900">RM <?= number_format($courseAnalytics['monthly_revenue']) ?></p>
                    <p class="text-xs text-gray-600">This Month</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Watch Time Analytics -->
<div class="bg-white rounded-lg border border-gray-200 p-6">
    <h3 class="text-lg font-medium text-gray-900 mb-4">Watch Time Analytics</h3>
    
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="text-center p-4 bg-gray-50 rounded-lg">
            <p class="text-2xl font-bold text-gray-900"><?= number_format($courseAnalytics['watch_time_hours']) ?></p>
            <p class="text-sm text-gray-600">Total Hours Watched</p>
        </div>
        <div class="text-center p-4 bg-gray-50 rounded-lg">
            <p class="text-2xl font-bold text-gray-900"><?= round($courseAnalytics['watch_time_hours'] / $courseAnalytics['total_students'], 1) ?></p>
            <p class="text-sm text-gray-600">Avg Hours per Student</p>
        </div>
        <div class="text-center p-4 bg-gray-50 rounded-lg">
            <p class="text-2xl font-bold text-gray-900"><?= round($courseAnalytics['watch_time_hours'] / ($course['total_duration'] / 60) * 100) ?>%</p>
            <p class="text-sm text-gray-600">Content Watched</p>
        </div>
        <div class="text-center p-4 bg-gray-50 rounded-lg">
            <p class="text-2xl font-bold text-gray-900"><?= round($courseAnalytics['watch_time_hours'] / 30, 1) ?></p>
            <p class="text-sm text-gray-600">Daily Avg (Hours)</p>
        </div>
    </div>

    <div class="h-64">
        <canvas id="watchTimeChart"></canvas>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Chart configuration
    const chartDefaults = {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            }
        }
    };

    // Revenue Chart
    const revenueCtx = document.getElementById('revenueChart').getContext('2d');
    new Chart(revenueCtx, {
        type: 'line',
        data: {
            labels: <?= json_encode($revenueAnalytics['monthly_trend']['labels']) ?>,
            datasets: [{
                data: <?= json_encode($revenueAnalytics['monthly_trend']['data']) ?>,
                borderColor: '#059669',
                backgroundColor: 'rgba(5, 150, 105, 0.1)',
                borderWidth: 2,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            ...chartDefaults,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'RM ' + value.toLocaleString();
                        }
                    }
                }
            }
        }
    });

    // Enrollment Chart
    const enrollmentCtx = document.getElementById('enrollmentChart').getContext('2d');
    new Chart(enrollmentCtx, {
        type: 'bar',
        data: {
            labels: <?= json_encode($studentAnalytics['enrollment_trend']['labels']) ?>,
            datasets: [{
                data: <?= json_encode($studentAnalytics['enrollment_trend']['data']) ?>,
                backgroundColor: '#3b82f6',
                borderRadius: 4
            }]
        },
        options: {
            ...chartDefaults,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return value + ' students';
                        }
                    }
                }
            }
        }
    });

    // Monthly Revenue Chart
    const monthlyRevenueCtx = document.getElementById('monthlyRevenueChart').getContext('2d');
    new Chart(monthlyRevenueCtx, {
        type: 'line',
        data: {
            labels: <?= json_encode($revenueAnalytics['monthly_trend']['labels']) ?>,
            datasets: [{
                data: <?= json_encode($revenueAnalytics['monthly_trend']['data']) ?>,
                borderColor: '#8b5cf6',
                backgroundColor: 'rgba(139, 92, 246, 0.1)',
                borderWidth: 2,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            ...chartDefaults,
            scales: {
                x: {
                    display: false
                },
                y: {
                    beginAtZero: true,
                    ticks: {
                        display: false
                    }
                }
            }
        }
    });

    // Watch Time Chart
    const watchTimeCtx = document.getElementById('watchTimeChart').getContext('2d');
    new Chart(watchTimeCtx, {
        type: 'bar',
        data: {
            labels: <?= json_encode($engagementAnalytics['watch_time_trend']['labels']) ?>,
            datasets: [{
                data: <?= json_encode($engagementAnalytics['watch_time_trend']['data']) ?>,
                backgroundColor: '#f59e0b',
                borderRadius: 4
            }]
        },
        options: {
            ...chartDefaults,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return value + 'h';
                        }
                    }
                }
            }
        }
    });
});

// Time range filter
document.getElementById('timeRangeFilter').addEventListener('change', function() {
    console.log('Time range changed to:', this.value);
    // In a real application, this would trigger data refresh
});

// Export function
function exportCourseData(courseId) {
    const button = event.target;
    const originalText = button.innerHTML;
    button.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Exporting...';
    button.disabled = true;
    
    setTimeout(() => {
        button.innerHTML = originalText;
        button.disabled = false;
        alert('Course analytics data exported successfully!');
    }, 2000);
}
</script>

<?php
$content = ob_get_clean();
include '../app/Views/layouts/instructor.php';
?>