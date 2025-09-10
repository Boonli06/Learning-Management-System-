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
                placeholder="Search sections..." 
                value="<?= htmlspecialchars($filters['search']) ?>"
                class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg text-sm placeholder-gray-500 focus:outline-none focus:ring-1 focus:ring-black focus:border-black"
            >
        </div>

        <!-- Clear Button -->
        <button type="button" class="bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black transition-colors duration-200" onclick="window.location.href='/instructor/sections'">
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

        <!-- Status Filter -->
        <select id="statusFilter" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-black focus:border-black">
            <option value="">All Status</option>
            <?php foreach ($statusOptions as $value => $label): ?>
                <option value="<?= $value ?>" <?= $filters['status'] === $value ? 'selected' : '' ?>>
                    <?= $label ?>
                </option>
            <?php endforeach; ?>
        </select>

        <!-- Sort -->
        <select id="sortFilter" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-black focus:border-black">
            <?php foreach ($sortOptions as $value => $label): ?>
                <option value="<?= $value ?>" <?= $filters['sort'] === $value ? 'selected' : '' ?>>
                    <?= $label ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="flex items-center space-x-3">
        <button type="button" class="bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black transition-colors duration-200" onclick="exportSections()">
            <i class="fas fa-download mr-2"></i>
            Export
        </button>
        <button type="button" class="bg-black text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black transition-colors duration-200" onclick="window.location.href='/instructor/sections/create'">
            <i class="fas fa-plus mr-2"></i>
            Create Section
        </button>
    </div>
</div>

<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 mb-6">
    <div class="bg-white rounded-lg border border-gray-200 p-4">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-list text-blue-600 text-sm"></i>
                </div>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-gray-500">Total Sections</p>
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
                <p class="text-sm font-medium text-gray-500">Active</p>
                <p class="text-lg font-semibold text-gray-900"><?= $stats['active'] ?></p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg border border-gray-200 p-4">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="w-8 h-8 bg-yellow-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-edit text-yellow-600 text-sm"></i>
                </div>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-gray-500">Draft</p>
                <p class="text-lg font-semibold text-gray-900"><?= $stats['draft'] ?></p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg border border-gray-200 p-4">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-play text-purple-600 text-sm"></i>
                </div>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-gray-500">Total Lectures</p>
                <p class="text-lg font-semibold text-gray-900"><?= $stats['total_lectures'] ?></p>
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
                <p class="text-sm font-medium text-gray-500">Total Duration</p>
                <p class="text-lg font-semibold text-gray-900"><?= floor($stats['total_duration'] / 60) ?>h <?= $stats['total_duration'] % 60 ?>m</p>
            </div>
        </div>
    </div>
</div>

<!-- Sections Table -->
<div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200">
        <h3 class="text-lg font-medium text-gray-900">Course Sections</h3>
    </div>

    <?php if (empty($sections)): ?>
    <div class="text-center py-12">
        <div class="w-24 h-24 mx-auto bg-gray-100 rounded-full flex items-center justify-center mb-4">
            <i class="fas fa-list text-gray-400 text-2xl"></i>
        </div>
        <h3 class="text-lg font-medium text-gray-900 mb-2">No sections found</h3>
        <p class="text-gray-500 mb-6">Get started by creating your first section to organize your course content.</p>
        <button type="button" class="bg-black text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-800" onclick="window.location.href='/instructor/sections/create'">
            <i class="fas fa-plus mr-2"></i>
            Create Section
        </button>
    </div>
    <?php else: ?>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Section</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Course</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Order</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Lectures</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Duration</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Updated</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php foreach ($sections as $section): ?>
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-4">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 w-8 h-8">
                                <div class="w-8 h-8 bg-gradient-to-br from-gray-900 to-gray-700 rounded-lg flex items-center justify-center">
                                    <?php if ($section['is_preview']): ?>
                                        <i class="fas fa-eye text-white text-xs"></i>
                                    <?php else: ?>
                                        <i class="fas fa-list text-white text-xs"></i>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="ml-3 min-w-0 flex-1">
                                <div class="flex items-center">
                                    <div class="text-sm font-medium text-gray-900 truncate"><?= htmlspecialchars($section['title']) ?></div>
                                    <?php if ($section['is_preview']): ?>
                                        <span class="ml-2 inline-flex items-center px-1.5 py-0.5 rounded text-xs font-medium bg-orange-100 text-orange-800">
                                            Preview
                                        </span>
                                    <?php endif; ?>
                                </div>
                                <div class="text-xs text-gray-500 truncate"><?= htmlspecialchars($section['description']) ?></div>
                            </div>
                        </div>
                    </td>
                    <td class="px-3 py-4">
                        <div class="text-sm text-gray-900"><?= htmlspecialchars($section['course_title']) ?></div>
                    </td>
                    <td class="px-3 py-4 text-center">
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                            <?= $section['order'] ?>
                        </span>
                    </td>
                    <td class="px-3 py-4 text-center text-sm text-gray-900">
                        <div class="flex items-center justify-center">
                            <i class="fas fa-play text-gray-400 text-xs mr-1"></i>
                            <?= $section['lecture_count'] ?>
                        </div>
                    </td>
                    <td class="px-3 py-4 text-center text-sm text-gray-900">
                        <div class="flex items-center justify-center">
                            <i class="fas fa-clock text-gray-400 text-xs mr-1"></i>
                            <?= floor($section['total_duration'] / 60) ?>h <?= $section['total_duration'] % 60 ?>m
                        </div>
                    </td>
                    <td class="px-3 py-4 text-center">
                        <?php if ($section['status'] === 'active'): ?>
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                <span class="w-1.5 h-1.5 bg-green-400 rounded-full mr-1"></span>
                                Active
                            </span>
                        <?php elseif ($section['status'] === 'draft'): ?>
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
                        <?= date('M j', strtotime($section['updated_at'])) ?>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <div class="flex items-center justify-center space-x-3">
                            <button type="button" class="text-gray-600 hover:text-black transition-colors duration-200" onclick="viewSection(<?= $section['id'] ?>)" title="View">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button type="button" class="text-gray-600 hover:text-black transition-colors duration-200" onclick="editSection(<?= $section['id'] ?>)" title="Edit">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button type="button" class="text-gray-600 hover:text-black transition-colors duration-200" onclick="manageLectures(<?= $section['id'] ?>)" title="Manage Lectures">
                                <i class="fas fa-play"></i>
                            </button>
                            <button type="button" class="text-red-600 hover:text-red-800 transition-colors duration-200" onclick="deleteSection(<?= $section['id'] ?>)" title="Delete">
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
            Showing <span class="font-medium"><?= $pagination['start_item'] ?></span> to <span class="font-medium"><?= $pagination['end_item'] ?></span> of <span class="font-medium"><?= $pagination['total_items'] ?></span> sections
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
document.getElementById('sortFilter').addEventListener('change', applyFilters);

function applyFilters() {
    const search = document.getElementById('searchInput').value;
    const course_id = document.getElementById('courseFilter').value;
    const status = document.getElementById('statusFilter').value;
    const sort = document.getElementById('sortFilter').value;
    
    const params = new URLSearchParams();
    if (search) params.set('search', search);
    if (course_id) params.set('course_id', course_id);
    if (status) params.set('status', status);
    if (sort) params.set('sort', sort);
    
    window.location.href = '/instructor/sections?' + params.toString();
}

// Action functions
function viewSection(id) {
    window.location.href = `/instructor/sections/${id}`;
}

function editSection(id) {
    window.location.href = `/instructor/sections/${id}/edit`;
}

function manageLectures(id) {
    // In a real application, this would go to the lectures management page for this section
    window.location.href = `/instructor/sections/${id}/lectures`;
}

function deleteSection(id) {
    if (confirm('Are you sure you want to delete this section? This action cannot be undone.')) {
        // 创建一个表单来发送DELETE请求
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/instructor/sections/${id}`;
        
        // 添加_method字段来模拟DELETE请求
        const methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'DELETE';
        form.appendChild(methodInput);
        
        document.body.appendChild(form);
        form.submit();
    }
}

function exportSections() {
    // In a real application, this would trigger a download
    alert('Export functionality would be implemented here');
}

// Bulk actions (for future implementation)
function selectAllSections() {
    const checkboxes = document.querySelectorAll('input[name="section_ids[]"]');
    checkboxes.forEach(cb => cb.checked = true);
}

function bulkAction(action) {
    const selectedIds = Array.from(document.querySelectorAll('input[name="section_ids[]"]:checked')).map(cb => cb.value);
    
    if (selectedIds.length === 0) {
        alert('Please select at least one section.');
        return;
    }
    
    switch (action) {
        case 'delete':
            if (confirm(`Are you sure you want to delete ${selectedIds.length} sections?`)) {
                console.log('Bulk deleting:', selectedIds);
            }
            break;
        case 'activate':
            console.log('Bulk activating:', selectedIds);
            break;
        case 'deactivate':
            console.log('Bulk deactivating:', selectedIds);
            break;
    }
}

// Quick section reordering (drag and drop would be implemented here)
function reorderSection(sectionId, newOrder) {
    // In a real application, this would send an AJAX request to update the order
    console.log(`Reordering section ${sectionId} to position ${newOrder}`);
}
</script>

<?php
$content = ob_get_clean();
include '../app/Views/layouts/instructor.php';