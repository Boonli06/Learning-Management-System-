<?php
ob_start();
?>

<!-- Header Actions -->
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
    <div class="flex items-center space-x-3">
        <!-- Search -->
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="fas fa-search text-gray-400"></i>
            </div>
            <input 
                type="text" 
                id="searchInput" 
                placeholder="Search lectures..." 
                value="<?= htmlspecialchars($filters['search']) ?>"
                class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg text-sm placeholder-gray-500 focus:outline-none focus:ring-1 focus:ring-black focus:border-black"
            >
        </div>

        <!-- Clear Button -->
        <button type="button" class="bg-white border border-gray-300 text-gray-700 px-3 py-2 rounded-lg text-sm font-medium hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black transition-colors duration-200" onclick="window.location.href='/instructor/lectures'">
            <i class="fas fa-times mr-1"></i>
            Clear
        </button>

        <!-- Course Filter -->
        <select id="courseFilter" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-black focus:border-black">
            <option value="">All Courses</option>
            <?php foreach ($courses as $course): ?>
                <option value="<?= $course['id'] ?>" <?= $filters['course_id'] == $course['id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($course['title']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <!-- Status Filter -->
        <select id="statusFilter" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-black focus:border-black">
            <option value="">All Status</option>
            <?php foreach ($statusOptions as $value => $label): ?>
                <option value="<?= $value ?>" <?= $filters['status'] === $value ? 'selected' : '' ?>>
                    <?= $label ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="flex items-center space-x-3">
        <button type="button" class="bg-white border border-gray-300 text-gray-700 px-3 py-2 rounded-lg text-sm font-medium hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black transition-colors duration-200" onclick="exportLectures()">
            <i class="fas fa-download mr-1"></i>
            Export
        </button>
        <button type="button" class="bg-black text-white px-3 py-2 rounded-lg text-sm font-medium hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black transition-colors duration-200" onclick="window.location.href='/instructor/lectures/create'">
            <i class="fas fa-plus mr-1"></i>
            Create
        </button>
    </div>
</div>

<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-lg border border-gray-200 p-4">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-play text-blue-600 text-sm"></i>
                </div>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-gray-500">Total Lectures</p>
                <p class="text-lg font-semibold text-gray-900"><?= $stats['total'] ?></p>
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
                <p class="text-sm font-medium text-gray-500">Published</p>
                <p class="text-lg font-semibold text-gray-900"><?= $stats['published'] ?></p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg border border-gray-200 p-4">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-clock text-purple-600 text-sm"></i>
                </div>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-gray-500">Total Duration</p>
                <p class="text-lg font-semibold text-gray-900"><?= floor($stats['total_duration'] / 60) ?>h <?= $stats['total_duration'] % 60 ?>m</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg border border-gray-200 p-4">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-eye text-gray-600 text-sm"></i>
                </div>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-gray-500">Total Views</p>
                <p class="text-lg font-semibold text-gray-900"><?= number_format($stats['total_views']) ?></p>
            </div>
        </div>
    </div>
</div>

<!-- Lectures Table -->
<div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200">
        <h3 class="text-lg font-medium text-gray-900">Lectures</h3>
    </div>

    <?php if (empty($lectures)): ?>
    <div class="text-center py-12">
        <div class="w-24 h-24 mx-auto bg-gray-100 rounded-full flex items-center justify-center mb-4">
            <i class="fas fa-play text-gray-400 text-2xl"></i>
        </div>
        <h3 class="text-lg font-medium text-gray-900 mb-2">No lectures found</h3>
        <p class="text-gray-500 mb-6">Get started by creating your first lecture to engage your students.</p>
        <button type="button" class="bg-black text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-800" onclick="window.location.href='/instructor/lectures/create'">
            <i class="fas fa-plus mr-2"></i>
            Create Lecture
        </button>
    </div>
    <?php else: ?>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lecture</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Course</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Order</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Duration</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Views</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Updated</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php foreach ($lectures as $lecture): ?>
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-4">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 w-8 h-8">
                                <div class="w-8 h-8 bg-gradient-to-br from-gray-900 to-gray-700 rounded-lg flex items-center justify-center">
                                    <?php if ($lecture['is_preview']): ?>
                                        <i class="fas fa-eye text-white text-xs"></i>
                                    <?php else: ?>
                                        <i class="fas fa-play text-white text-xs"></i>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="ml-3 min-w-0 flex-1">
                                <div class="flex items-center">
                                    <div class="text-sm font-medium text-gray-900 truncate"><?= htmlspecialchars($lecture['title']) ?></div>
                                    <?php if ($lecture['is_preview']): ?>
                                        <span class="ml-2 inline-flex items-center px-1.5 py-0.5 rounded text-xs font-medium bg-orange-100 text-orange-800">
                                            Preview
                                        </span>
                                    <?php endif; ?>
                                </div>
                                <div class="text-xs text-gray-500 truncate"><?= htmlspecialchars($lecture['section_title']) ?></div>
                            </div>
                        </div>
                    </td>
                    <td class="px-3 py-4">
                        <div class="text-sm text-gray-900"><?= htmlspecialchars($lecture['course_title']) ?></div>
                    </td>
                    <td class="px-3 py-4 text-center">
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                            <?= $lecture['order'] ?>
                        </span>
                    </td>
                    <td class="px-3 py-4 text-center text-sm text-gray-900">
                        <div class="flex items-center justify-center">
                            <i class="fas fa-clock text-gray-400 text-xs mr-1"></i>
                            <?= $lecture['duration'] ?>m
                        </div>
                    </td>
                    <td class="px-3 py-4 text-center text-sm text-gray-900">
                        <div class="flex flex-col items-center">
                            <div class="flex items-center">
                                <i class="fas fa-eye text-gray-400 text-xs mr-1"></i>
                                <?= number_format($lecture['view_count']) ?>
                            </div>
                            <div class="text-xs text-gray-500"><?= number_format($lecture['completion_rate'], 1) ?>%</div>
                        </div>
                    </td>
                    <td class="px-3 py-4 text-center">
                        <?php if ($lecture['status'] === 'published'): ?>
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                <span class="w-1.5 h-1.5 bg-green-400 rounded-full mr-1"></span>
                                Published
                            </span>
                        <?php elseif ($lecture['status'] === 'draft'): ?>
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                <span class="w-1.5 h-1.5 bg-yellow-400 rounded-full mr-1"></span>
                                Draft
                            </span>
                        <?php else: ?>
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                <span class="w-1.5 h-1.5 bg-gray-400 rounded-full mr-1"></span>
                                Archived
                            </span>
                        <?php endif; ?>
                    </td>
                    <td class="px-3 py-4 text-center text-sm text-gray-500">
                        <?= date('M j', strtotime($lecture['updated_at'])) ?>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <div class="flex items-center justify-center space-x-3">
                            <button type="button" class="text-gray-600 hover:text-black transition-colors duration-200" onclick="previewLecture(<?= $lecture['id'] ?>)" title="Preview">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button type="button" class="text-gray-600 hover:text-black transition-colors duration-200" onclick="editLecture(<?= $lecture['id'] ?>)" title="Edit">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button type="button" class="text-gray-600 hover:text-black transition-colors duration-200" onclick="duplicateLecture(<?= $lecture['id'] ?>)" title="Duplicate">
                                <i class="fas fa-copy"></i>
                            </button>
                            <button type="button" class="text-red-600 hover:text-red-800 transition-colors duration-200" onclick="deleteLecture(<?= $lecture['id'] ?>)" title="Delete">
                                <i class="fas fa-trash"></i>
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
            Showing <span class="font-medium"><?= $pagination['start_item'] ?></span> to <span class="font-medium"><?= $pagination['end_item'] ?></span> of <span class="font-medium"><?= $pagination['total_items'] ?></span> lectures
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
document.getElementById('statusFilter').addEventListener('change', applyFilters);

function applyFilters() {
    const search = document.getElementById('searchInput').value;
    const course_id = document.getElementById('courseFilter').value;
    const status = document.getElementById('statusFilter').value;
    
    const params = new URLSearchParams();
    if (search) params.set('search', search);
    if (course_id) params.set('course_id', course_id);
    if (status) params.set('status', status);
    
    window.location.href = '/instructor/lectures?' + params.toString();
}

// Action functions
function previewLecture(id) {
    window.location.href = `/instructor/lectures/${id}`;
}

function editLecture(id) {
    window.location.href = `/instructor/lectures/${id}/edit`;
}

function duplicateLecture(id) {
    if (confirm('Do you want to create a copy of this lecture?')) {
        window.location.href = '/instructor/lectures/' + id + '/duplicate';
    }
}

function deleteLecture(id) {
    if (confirm('Are you sure you want to delete this lecture? This action cannot be undone.')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '/instructor/lectures/' + id;
        
        const methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'DELETE';
        form.appendChild(methodInput);
        
        document.body.appendChild(form);
        form.submit();
    }
}

function exportLectures() {
    alert('Export functionality would be implemented here');
}
</script>

<?php
$content = ob_get_clean();
include '../app/Views/layouts/instructor.php';
?>