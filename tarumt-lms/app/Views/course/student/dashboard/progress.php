<?php
ob_start();
?>

<!-- Progress Overview Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
    <!-- Total Courses -->
    <div class="bg-white rounded-lg border border-gray-200 p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-book text-blue-600"></i>
                </div>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-500">Total Courses</p>
                <p class="text-2xl font-bold text-gray-900"><?= $progressStats['total_courses'] ?></p>
            </div>
        </div>
    </div>

    <!-- Completed Courses -->
    <div class="bg-white rounded-lg border border-gray-200 p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-graduation-cap text-green-600"></i>
                </div>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-500">Completed</p>
                <p class="text-2xl font-bold text-gray-900"><?= $progressStats['completed_courses'] ?></p>
                <p class="text-xs text-gray-500"><?= round(($progressStats['completed_courses'] / $progressStats['total_courses']) * 100) ?>% completion rate</p>
            </div>
        </div>
    </div>

    <!-- Learning Hours -->
    <div class="bg-white rounded-lg border border-gray-200 p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-clock text-purple-600"></i>
                </div>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-500">Hours Spent</p>
                <p class="text-2xl font-bold text-gray-900"><?= $progressStats['total_hours_spent'] ?>h</p>
                <p class="text-xs text-gray-500">This week: <?= $progressStats['weekly_progress'] ?>h</p>
            </div>
        </div>
    </div>

    <!-- Current Streak -->
    <div class="bg-white rounded-lg border border-gray-200 p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-fire text-orange-600"></i>
                </div>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-500">Current Streak</p>
                <p class="text-2xl font-bold text-gray-900"><?= $progressStats['current_streak'] ?></p>
                <p class="text-xs text-gray-500">days</p>
            </div>
        </div>
    </div>
</div>

<!-- Progress Charts and Weekly Goal -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
    <!-- Overall Progress -->
    <div class="lg:col-span-2 bg-white rounded-lg border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg font-medium text-gray-900">Learning Progress</h2>
            <div class="text-sm text-gray-500">
                Average: <?= number_format($progressStats['average_progress'], 1) ?>%
            </div>
        </div>
        
        <!-- Progress Bar -->
        <div class="mb-6">
            <div class="flex justify-between text-sm text-gray-600 mb-2">
                <span>Overall Progress</span>
                <span><?= number_format($progressStats['average_progress'], 1) ?>%</span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-3">
                <div class="bg-gradient-to-r from-blue-500 to-green-500 h-3 rounded-full transition-all duration-300" style="width: <?= $progressStats['average_progress'] ?>%"></div>
            </div>
        </div>

        <!-- Certificates -->
        <div class="grid grid-cols-3 gap-4 text-center">
            <div>
                <div class="text-2xl font-bold text-blue-600"><?= $progressStats['in_progress_courses'] ?></div>
                <div class="text-sm text-gray-500">In Progress</div>
            </div>
            <div>
                <div class="text-2xl font-bold text-green-600"><?= $progressStats['completed_courses'] ?></div>
                <div class="text-sm text-gray-500">Completed</div>
            </div>
            <div>
                <div class="text-2xl font-bold text-yellow-600"><?= $progressStats['certificates_earned'] ?></div>
                <div class="text-sm text-gray-500">Certificates</div>
            </div>
        </div>
    </div>

    <!-- Weekly Goal -->
    <div class="bg-white rounded-lg border border-gray-200 p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Weekly Goal</h3>
        
        <div class="text-center mb-6">
            <div class="text-3xl font-bold text-gray-900"><?= $progressStats['weekly_progress'] ?>h</div>
            <div class="text-sm text-gray-500">of <?= $progressStats['weekly_goal'] ?>h goal</div>
        </div>
        
        <!-- Circular Progress -->
        <div class="relative w-32 h-32 mx-auto mb-6">
            <svg class="w-32 h-32 transform -rotate-90" viewBox="0 0 36 36">
                <path
                    d="M18 2.0845
                    a 15.9155 15.9155 0 0 1 0 31.831
                    a 15.9155 15.9155 0 0 1 0 -31.831"
                    fill="none"
                    stroke="#e5e7eb"
                    stroke-width="2"
                />
                <path
                    d="M18 2.0845
                    a 15.9155 15.9155 0 0 1 0 31.831
                    a 15.9155 15.9155 0 0 1 0 -31.831"
                    fill="none"
                    stroke="#3b82f6"
                    stroke-width="2"
                    stroke-dasharray="<?= min(($progressStats['weekly_progress'] / $progressStats['weekly_goal']) * 100, 100) ?>, 100"
                />
            </svg>
            <div class="absolute inset-0 flex items-center justify-center">
                <span class="text-xl font-bold text-gray-900"><?= round(($progressStats['weekly_progress'] / $progressStats['weekly_goal']) * 100) ?>%</span>
            </div>
        </div>
        
        <div class="text-center">
            <?php if ($progressStats['weekly_progress'] >= $progressStats['weekly_goal']): ?>
                <p class="text-sm text-green-600 font-medium">Goal achieved! 🎉</p>
            <?php else: ?>
                <p class="text-sm text-gray-600"><?= $progressStats['weekly_goal'] - $progressStats['weekly_progress'] ?>h to reach your goal</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Recent Activity -->
<div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200">
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-medium text-gray-900">Recent Learning Activity</h2>
            <a href="/student/dashboard/mycourses" class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                View All Courses <i class="fas fa-arrow-right ml-1"></i>
            </a>
        </div>
    </div>

    <div class="divide-y divide-gray-200">
        <?php if (!empty($recentProgress)): ?>
            <?php foreach ($recentProgress as $activity): ?>
            <div class="p-6 hover:bg-gray-50 transition-colors duration-200">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-check text-green-600"></i>
                            </div>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-sm font-medium text-gray-900"><?= htmlspecialchars($activity['lecture_title']) ?></h3>
                            <p class="text-sm text-gray-600"><?= htmlspecialchars($activity['course_title']) ?></p>
                            <p class="text-xs text-gray-500 mt-1">
                                Completed on <?= date('M d, Y \a\t g:i A', strtotime($activity['completed_at'])) ?>
                            </p>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            <?= $activity['duration'] ?> min
                        </span>
                        <button type="button" class="ml-3 text-gray-400 hover:text-gray-600" onclick="continueCourse(<?= $activity['course_id'] ?>)">
                            <i class="fas fa-play"></i>
                        </button>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="p-6 text-center">
                <i class="fas fa-chart-line text-gray-400 text-3xl mb-3"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No recent activity</h3>
                <p class="text-gray-500 mb-4">Start learning to see your progress here</p>
                <button type="button" class="bg-black text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-800" onclick="window.location.href='/student/dashboard/mycourses'">
                    View My Courses
                </button>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Learning Tips -->
<div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg p-6 mt-6">
    <div class="flex items-start">
        <div class="flex-shrink-0">
            <i class="fas fa-lightbulb text-blue-600 text-xl"></i>
        </div>
        <div class="ml-4">
            <h3 class="text-lg font-medium text-gray-900 mb-2">Learning Tips</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="flex items-start">
                    <i class="fas fa-target text-blue-500 mt-1 mr-3 flex-shrink-0"></i>
                    <div>
                        <h4 class="font-medium text-gray-900">Set Daily Goals</h4>
                        <p class="text-sm text-gray-600">Aim for 30-60 minutes of learning per day to maintain momentum.</p>
                    </div>
                </div>
                <div class="flex items-start">
                    <i class="fas fa-sticky-note text-blue-500 mt-1 mr-3 flex-shrink-0"></i>
                    <div>
                        <h4 class="font-medium text-gray-900">Take Notes</h4>
                        <p class="text-sm text-gray-600">Active note-taking helps improve retention and understanding.</p>
                    </div>
                </div>
                <div class="flex items-start">
                    <i class="fas fa-redo text-blue-500 mt-1 mr-3 flex-shrink-0"></i>
                    <div>
                        <h4 class="font-medium text-gray-900">Practice Regularly</h4>
                        <p class="text-sm text-gray-600">Apply what you learn through hands-on practice and projects.</p>
                    </div>
                </div>
                <div class="flex items-start">
                    <i class="fas fa-users text-blue-500 mt-1 mr-3 flex-shrink-0"></i>
                    <div>
                        <h4 class="font-medium text-gray-900">Join Discussions</h4>
                        <p class="text-sm text-gray-600">Engage with other learners to deepen your understanding.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function continueCourse(courseId) {
    window.location.href = `/student/course/${courseId}/learn`;
}

// Add interactive charts or animations here if needed
document.addEventListener('DOMContentLoaded', function() {
    // Animate progress bars on page load
    const progressBars = document.querySelectorAll('[style*="width:"]');
    progressBars.forEach(bar => {
        const width = bar.style.width;
        bar.style.width = '0%';
        setTimeout(() => {
            bar.style.width = width;
        }, 200);
    });
});
</script>

<?php
$content = ob_get_clean();
include '../app/Views/layouts/student.php';