<?php
ob_start();

// Handle any messages from session
$successMessage = $_SESSION['success'] ?? '';
$errorMessage = $_SESSION['error'] ?? '';
unset($_SESSION['success'], $_SESSION['error']);
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
                placeholder="Search goals..." 
                value="<?= htmlspecialchars($filters['search']) ?>"
                class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg text-sm placeholder-gray-500 focus:outline-none focus:ring-1 focus:ring-black focus:border-black"
            >
        </div>

        <!-- Clear Button -->
        <button type="button" class="bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black transition-colors duration-200" onclick="window.location.href='/instructor/goals'">
            <i class="fas fa-times mr-2"></i>
            Clear
        </button>

        <!-- Course Filter -->
        <select id="courseFilter" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-black focus:border-black">
            <?php foreach ($courses as $course): ?>
                <option value="<?= $course['id'] ?>" <?= $filters['course_id'] == $course['id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($course['title']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <!-- Sort -->
        <select id="sortFilter" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-black focus:border-black">
            <?php foreach ($sortOptions as $value => $label): ?>
                <option value="<?= $value ?>" <?= $filters['sort'] === $value ? 'selected' : '' ?>>
                    <?= htmlspecialchars($label) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="flex items-center space-x-3">
        <button type="button" class="bg-black text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black transition-colors duration-200" onclick="window.location.href='/instructor/goals/create'">
            <i class="fas fa-plus mr-2"></i>
            Add Goal
        </button>
    </div>
</div>

<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-lg border border-gray-200 p-4">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-bullseye text-blue-600 text-sm"></i>
                </div>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-gray-500">Total Goals</p>
                <p class="text-lg font-semibold text-gray-900"><?= $stats['total'] ?></p>
            </div>
        </div>
    </div>

    <?php $courseCount = 0; ?>
    <?php foreach (array_slice($stats['by_course'], 0, 3) as $courseTitle => $goalCount): ?>
        <div class="bg-white rounded-lg border border-gray-200 p-4">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-graduation-cap text-gray-600 text-sm"></i>
                    </div>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-500"><?= htmlspecialchars($courseTitle) ?></p>
                    <p class="text-lg font-semibold text-gray-900"><?= $goalCount ?> goals</p>
                </div>
            </div>
        </div>
        <?php $courseCount++; ?>
    <?php endforeach; ?>
</div>

<!-- Messages -->
<?php if ($successMessage): ?>
    <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
        <div class="flex">
            <i class="fas fa-check-circle text-green-400 mt-0.5 mr-3"></i>
            <p class="text-green-800"><?= htmlspecialchars($successMessage) ?></p>
        </div>
    </div>
<?php endif; ?>

<?php if ($errorMessage): ?>
    <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
        <div class="flex">
            <i class="fas fa-exclamation-circle text-red-400 mt-0.5 mr-3"></i>
            <p class="text-red-800"><?= htmlspecialchars($errorMessage) ?></p>
        </div>
    </div>
<?php endif; ?>

<!-- Goals Table -->
<div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200">
        <div class="flex items-center justify-between">
            <h3 class="text-lg font-medium text-gray-900">Learning Goals</h3>
        </div>
    </div>

    <?php if (empty($goals)): ?>
    <div class="text-center py-12">
        <div class="w-24 h-24 mx-auto bg-gray-100 rounded-full flex items-center justify-center mb-4">
            <i class="fas fa-bullseye text-gray-400 text-2xl"></i>
        </div>
        <h3 class="text-lg font-medium text-gray-900 mb-2">No learning goals found</h3>
        <p class="text-gray-500 mb-6">Get started by creating your first learning goal to define course objectives.</p>
        <button type="button" class="bg-black text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-800" onclick="window.location.href='/instructor/goals/create'">
            <i class="fas fa-plus mr-2"></i>
            Add Goal
        </button>
    </div>
    <?php else: ?>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Learning Goal</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Course</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Order</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Created</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php foreach ($goals as $goal): ?>
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-4">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 w-8 h-8">
                                <div class="w-8 h-8 bg-gradient-to-br from-gray-900 to-gray-700 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-bullseye text-white text-xs"></i>
                                </div>
                            </div>
                            <div class="ml-3 min-w-0 flex-1">
                                <div class="text-sm font-medium text-gray-900 truncate"><?= htmlspecialchars($goal['goal']) ?></div>
                                <div class="text-xs text-gray-500 truncate">Goal #<?= $goal['order'] ?> in <?= htmlspecialchars($goal['course_title']) ?></div>
                            </div>
                        </div>
                    </td>
                    <td class="px-3 py-4">
                        <div class="text-sm text-gray-900"><?= htmlspecialchars($goal['course_title']) ?></div>
                    </td>
                    <td class="px-3 py-4 text-center">
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                            <?= $goal['order'] ?>
                        </span>
                    </td>
                    <td class="px-3 py-4 text-center text-sm text-gray-500">
                        <?= date('M j', strtotime($goal['created_at'])) ?>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <div class="flex items-center justify-center space-x-3">
                            <button type="button" class="text-gray-600 hover:text-black transition-colors duration-200" onclick="viewGoal(<?= $goal['id'] ?>)" title="View">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button type="button" class="text-gray-600 hover:text-black transition-colors duration-200" onclick="editGoal(<?= $goal['id'] ?>)" title="Edit">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button type="button" class="text-gray-600 hover:text-black transition-colors duration-200" onclick="duplicateGoal(<?= $goal['id'] ?>)" title="Duplicate">
                                <i class="fas fa-copy"></i>
                            </button>
                            <button type="button" class="text-red-600 hover:text-red-800 transition-colors duration-200" onclick="deleteGoal(<?= $goal['id'] ?>)" title="Delete">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <?php if ($pagination['total_items'] > 0): ?>
    <div class="bg-white rounded-lg border border-gray-200 p-6 mt-6">
        <div class="flex items-center justify-between">
            <div class="text-sm text-gray-700">
                Showing <span class="font-medium"><?= $pagination['start_item'] ?></span> to <span class="font-medium"><?= $pagination['end_item'] ?></span> of <span class="font-medium"><?= $pagination['total_items'] ?></span> goals
            </div>
            <div class="flex items-center space-x-2">
                <button class="relative inline-flex items-center px-3 py-2 border border-gray-300 text-sm font-medium text-gray-500 bg-white rounded-lg hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed transition-colors duration-200" <?= $pagination['current_page'] <= 1 ? 'disabled' : '' ?> onclick="<?= $pagination['current_page'] > 1 ? 'window.location.href=\'?page=' . ($pagination['current_page'] - 1) . '&' . http_build_query(array_filter($filters)) . '\'' : '' ?>">
                    <i class="fas fa-chevron-left mr-1"></i>
                    Previous
                </button>
                
                <?php for ($i = 1; $i <= $pagination['total_pages']; $i++): ?>
                    <button class="relative inline-flex items-center px-3 py-2 border text-sm font-medium rounded-lg transition-colors duration-200 <?= $i == $pagination['current_page'] ? 'border-black bg-black text-white' : 'border-gray-300 text-gray-700 bg-white hover:bg-gray-50' ?>" onclick="<?= $i != $pagination['current_page'] ? 'window.location.href=\'?page=' . $i . '&' . http_build_query(array_filter($filters)) . '\'' : '' ?>">
                        <?= $i ?>
                    </button>
                <?php endfor; ?>
                
                <button class="relative inline-flex items-center px-3 py-2 border border-gray-300 text-sm font-medium text-gray-700 bg-white rounded-lg hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed transition-colors duration-200" <?= $pagination['current_page'] >= $pagination['total_pages'] ? 'disabled' : '' ?> onclick="<?= $pagination['current_page'] < $pagination['total_pages'] ? 'window.location.href=\'?page=' . ($pagination['current_page'] + 1) . '&' . http_build_query(array_filter($filters)) . '\'' : '' ?>">
                    Next
                    <i class="fas fa-chevron-right ml-1"></i>
                </button>
            </div>
        </div>
    </div>
    <?php endif; ?>
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
document.getElementById('courseFilter').addEventListener('change', applyFilters);
document.getElementById('sortFilter').addEventListener('change', applyFilters);

function applyFilters() {
    const search = document.getElementById('searchInput').value;
    const course_id = document.getElementById('courseFilter').value;
    const sort = document.getElementById('sortFilter').value;
    
    const params = new URLSearchParams();
    if (search) params.set('search', search);
    if (course_id) params.set('course_id', course_id);
    if (sort) params.set('sort', sort);
    
    window.location.href = '/instructor/goals?' + params.toString();
}

// Action functions
function viewGoal(id) {
    window.location.href = `/instructor/goals/${id}`;
}

function editGoal(id) {
    window.location.href = `/instructor/goals/${id}/edit`;
}

function duplicateGoal(id) {
    if (confirm('Do you want to create a copy of this learning goal?')) {
        window.location.href = `/instructor/goals/${id}/duplicate`;
    }
}

function deleteGoal(id) {
    if (confirm('Are you sure you want to delete this learning goal? This action cannot be undone.')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/instructor/goals/${id}`;
        
        const methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'DELETE';
        form.appendChild(methodInput);
        
        document.body.appendChild(form);
        form.submit();
    }
}
</script>

<?php
$content = ob_get_clean();
include '../app/Views/layouts/instructor.php';
?>