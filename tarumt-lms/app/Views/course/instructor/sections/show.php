<?php
ob_start();
?>

<!-- Section Header -->
<div class="bg-white rounded-lg border border-gray-200 p-6 mb-6">
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-4">
            <div class="w-12 h-12 bg-gradient-to-br from-gray-900 to-gray-700 rounded-lg flex items-center justify-center">
                <?php if ($section['is_preview']): ?>
                    <i class="fas fa-eye text-white text-lg"></i>
                <?php else: ?>
                    <i class="fas fa-list text-white text-lg"></i>
                <?php endif; ?>
            </div>
            <div>
                <div class="flex items-center space-x-3">
                    <h1 class="text-2xl font-bold text-gray-900"><?= htmlspecialchars($section['title']) ?></h1>
                    <?php if ($section['is_preview']): ?>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                            <i class="fas fa-eye mr-1"></i>
                            Preview Section
                        </span>
                    <?php endif; ?>
                    <?php if ($section['status'] === 'draft'): ?>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                            <i class="fas fa-edit mr-1"></i>
                            Draft
                        </span>
                    <?php elseif ($section['status'] === 'active'): ?>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            <i class="fas fa-check-circle mr-1"></i>
                            Active
                        </span>
                    <?php endif; ?>
                </div>
                <div class="flex items-center text-sm text-gray-500 mt-1 space-x-4">
                    <span><i class="fas fa-book mr-1"></i><?= htmlspecialchars($section['course_title']) ?></span>
                    <span><i class="fas fa-sort-numeric-up mr-1"></i>Section <?= $section['order'] ?></span>
                    <span><i class="fas fa-clock mr-1"></i>Updated <?= date('M j, Y', strtotime($section['updated_at'])) ?></span>
                </div>
            </div>
        </div>
        
        <div class="flex items-center space-x-3">
            <button type="button" 
                    onclick="window.location.href='/instructor/sections/<?= $section['id'] ?>/edit'"
                    class="bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black transition-colors duration-200">
                <i class="fas fa-edit mr-2"></i>
                Edit Section
            </button>
            <button type="button" 
                    onclick="addLecture()"
                    class="bg-black text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black transition-colors duration-200">
                <i class="fas fa-plus mr-2"></i>
                Add Lecture
            </button>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
    <div class="bg-white rounded-lg border border-gray-200 p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-play text-blue-600"></i>
                </div>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-500">Total Lectures</p>
                <p class="text-2xl font-bold text-gray-900"><?= $stats['total_lectures'] ?></p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg border border-gray-200 p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-clock text-green-600"></i>
                </div>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-500">Total Duration</p>
                <p class="text-2xl font-bold text-gray-900"><?= floor($stats['total_duration'] / 60) ?>h <?= $stats['total_duration'] % 60 ?>m</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg border border-gray-200 p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-check text-purple-600"></i>
                </div>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-500">Published</p>
                <p class="text-2xl font-bold text-gray-900"><?= $stats['completed_lectures'] ?></p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg border border-gray-200 p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-stopwatch text-gray-600"></i>
                </div>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-500">Avg Duration</p>
                <p class="text-2xl font-bold text-gray-900"><?= $stats['avg_duration'] ?>m</p>
            </div>
        </div>
    </div>
</div>

<!-- Section Description -->
<div class="bg-white rounded-lg border border-gray-200 p-6 mb-6">
    <h2 class="text-lg font-medium text-gray-900 mb-3">Section Description</h2>
    <p class="text-gray-700 leading-relaxed"><?= nl2br(htmlspecialchars($section['description'])) ?></p>
</div>

<!-- Lectures Management -->
<div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-lg font-medium text-gray-900">Lectures</h3>
                <p class="text-sm text-gray-500 mt-1">Manage and organize lectures within this section</p>
            </div>
            <div class="flex items-center space-x-3">
                <button type="button" 
                        onclick="reorderLectures()"
                        class="bg-white border border-gray-300 text-gray-700 px-3 py-2 rounded-lg text-sm font-medium hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black transition-colors duration-200">
                    <i class="fas fa-sort mr-2"></i>
                    Reorder
                </button>
                <button type="button" 
                        onclick="addLecture()"
                        class="bg-black text-white px-3 py-2 rounded-lg text-sm font-medium hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black transition-colors duration-200">
                    <i class="fas fa-plus mr-2"></i>
                    Add Lecture
                </button>
            </div>
        </div>
    </div>

    <?php if (empty($lectures)): ?>
    <div class="text-center py-12">
        <div class="w-16 h-16 mx-auto bg-gray-100 rounded-full flex items-center justify-center mb-4">
            <i class="fas fa-play text-gray-400 text-xl"></i>
        </div>
        <h3 class="text-lg font-medium text-gray-900 mb-2">No lectures yet</h3>
        <p class="text-gray-500 mb-6">Start building your section by adding your first lecture.</p>
        <button type="button" 
                onclick="addLecture()"
                class="bg-black text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-800">
            <i class="fas fa-plus mr-2"></i>
            Add First Lecture
        </button>
    </div>
    <?php else: ?>
    <div class="divide-y divide-gray-200" id="lecturesContainer">
        <?php foreach ($lectures as $index => $lecture): ?>
        <div class="p-6 hover:bg-gray-50 transition-colors duration-200" data-lecture-id="<?= $lecture['id'] ?>">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <!-- Drag Handle -->
                    <div class="flex-shrink-0 cursor-grab active:cursor-grabbing">
                        <i class="fas fa-grip-vertical text-gray-400"></i>
                    </div>
                    
                    <!-- Lecture Info -->
                    <div class="flex items-center space-x-4">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-gray-900 rounded-lg flex items-center justify-center">
                                <span class="text-white text-xs font-medium"><?= $lecture['order'] ?></span>
                            </div>
                        </div>
                        <div>
                            <div class="flex items-center space-x-2">
                                <h4 class="text-sm font-medium text-gray-900"><?= htmlspecialchars($lecture['title']) ?></h4>
                                <?php if ($lecture['is_preview']): ?>
                                    <span class="inline-flex items-center px-1.5 py-0.5 rounded text-xs font-medium bg-orange-100 text-orange-800">
                                        Preview
                                    </span>
                                <?php endif; ?>
                                <?php if ($lecture['status'] === 'published'): ?>
                                    <span class="inline-flex items-center px-1.5 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                                        Published
                                    </span>
                                <?php else: ?>
                                    <span class="inline-flex items-center px-1.5 py-0.5 rounded text-xs font-medium bg-yellow-100 text-yellow-800">
                                        Draft
                                    </span>
                                <?php endif; ?>
                            </div>
                            <div class="flex items-center text-xs text-gray-500 mt-1">
                                <i class="fas fa-clock mr-1"></i>
                                <?= $lecture['duration'] ?> minutes
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Actions -->
                <div class="flex items-center space-x-2">
                    <button type="button" 
                            onclick="previewLecture(<?= $lecture['id'] ?>)"
                            class="text-gray-400 hover:text-gray-600 p-2 rounded-lg hover:bg-gray-100"
                            title="Preview">
                        <i class="fas fa-eye text-sm"></i>
                    </button>
                    <button type="button" 
                            onclick="editLecture(<?= $lecture['id'] ?>)"
                            class="text-gray-400 hover:text-gray-600 p-2 rounded-lg hover:bg-gray-100"
                            title="Edit">
                        <i class="fas fa-edit text-sm"></i>
                    </button>
                    <button type="button" 
                            onclick="duplicateLecture(<?= $lecture['id'] ?>)"
                            class="text-gray-400 hover:text-blue-600 p-2 rounded-lg hover:bg-gray-100"
                            title="Duplicate">
                        <i class="fas fa-copy text-sm"></i>
                    </button>
                    <button type="button" 
                            onclick="deleteLecture(<?= $lecture['id'] ?>)"
                            class="text-gray-400 hover:text-red-600 p-2 rounded-lg hover:bg-gray-100"
                            title="Delete">
                        <i class="fas fa-trash text-sm"></i>
                    </button>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</div>

<!-- Section Actions -->
<div class="mt-6 flex items-center justify-between">
    <div class="flex items-center space-x-4">
        <button type="button" 
                onclick="window.location.href='/instructor/sections'"
                class="bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black transition-colors duration-200">
            <i class="fas fa-arrow-left mr-2"></i>
            Back to Sections
        </button>
        <button type="button" 
                onclick="duplicateSection(<?= $section['id'] ?>)"
                class="bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black transition-colors duration-200">
            <i class="fas fa-copy mr-2"></i>
            Duplicate Section
        </button>
    </div>
    
    <div class="flex items-center space-x-3">
        <button type="button" 
                onclick="previewSection(<?= $section['id'] ?>)"
                class="bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black transition-colors duration-200">
            <i class="fas fa-eye mr-2"></i>
            Preview Section
        </button>
        <button type="button" 
                onclick="deleteSection(<?= $section['id'] ?>)"
                class="bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-600 transition-colors duration-200">
            <i class="fas fa-trash mr-2"></i>
            Delete Section
        </button>
    </div>
</div>

<script>
// Lecture management functions
function addLecture() {
    // In a real application, this would open a modal or navigate to add lecture page
    window.location.href = `/instructor/sections/<?= $section['id'] ?>/lectures/create`;
}

function editLecture(lectureId) {
    window.location.href = `/instructor/lectures/${lectureId}/edit`;
}

function previewLecture(lectureId) {
    // Open lecture preview in new tab
    window.open(`/instructor/lectures/${lectureId}/preview`, '_blank');
}

function duplicateLecture(lectureId) {
    if (confirm('Do you want to create a copy of this lecture?')) {
        // In a real application, this would send an AJAX request
        console.log('Duplicating lecture:', lectureId);
        alert('Duplicate functionality would be implemented here');
    }
}

function deleteLecture(lectureId) {
    if (confirm('Are you sure you want to delete this lecture? This action cannot be undone.')) {
        // In a real application, this would send a DELETE request
        console.log('Deleting lecture:', lectureId);
        
        // Remove from DOM for demo purposes
        const lectureElement = document.querySelector(`[data-lecture-id="${lectureId}"]`);
        if (lectureElement) {
            lectureElement.style.transition = 'opacity 0.3s ease';
            lectureElement.style.opacity = '0';
            setTimeout(() => {
                lectureElement.remove();
                updateLectureNumbers();
            }, 300);
        }
    }
}

// Section management functions
function previewSection(sectionId) {
    // Open section preview in new tab
    window.open(`/sections/${sectionId}/preview`, '_blank');
}

function duplicateSection(sectionId) {
    if (confirm('Do you want to create a copy of this section? All lectures will be duplicated as well.')) {
        // In a real application, this would send an AJAX request
        console.log('Duplicating section:', sectionId);
        alert('Section duplication functionality would be implemented here');
    }
}

function deleteSection(sectionId) {
    const lectureCount = <?= count($lectures) ?>;
    let confirmMessage = 'Are you sure you want to delete this section?';
    
    if (lectureCount > 0) {
        confirmMessage = `This section contains ${lectureCount} lecture(s). Are you sure you want to delete this section and all its lectures? This action cannot be undone.`;
    }
    
    if (confirm(confirmMessage)) {
        // Create form for DELETE request
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/instructor/sections/${sectionId}`;
        
        const methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'DELETE';
        form.appendChild(methodInput);
        
        document.body.appendChild(form);
        form.submit();
    }
}

// Lecture reordering functionality
let isReorderMode = false;

function reorderLectures() {
    const container = document.getElementById('lecturesContainer');
    if (!container) return;
    
    isReorderMode = !isReorderMode;
    const reorderBtn = document.querySelector('button[onclick="reorderLectures()"]');
    
    if (isReorderMode) {
        // Enable reorder mode
        reorderBtn.innerHTML = '<i class="fas fa-check mr-2"></i>Save Order';
        reorderBtn.classList.remove('bg-white', 'border-gray-300', 'text-gray-700');
        reorderBtn.classList.add('bg-green-600', 'text-white');
        
        // Make lectures draggable
        enableDragAndDrop();
        
        // Show reorder instructions
        showReorderInstructions();
    } else {
        // Save and exit reorder mode
        reorderBtn.innerHTML = '<i class="fas fa-sort mr-2"></i>Reorder';
        reorderBtn.classList.add('bg-white', 'border-gray-300', 'text-gray-700');
        reorderBtn.classList.remove('bg-green-600', 'text-white');
        
        // Disable dragging
        disableDragAndDrop();
        
        // Hide instructions
        hideReorderInstructions();
        
        // Save new order
        saveNewOrder();
    }
}

function enableDragAndDrop() {
    const lectures = document.querySelectorAll('[data-lecture-id]');
    lectures.forEach(lecture => {
        lecture.draggable = true;
        lecture.classList.add('cursor-move', 'select-none');
        
        lecture.addEventListener('dragstart', handleDragStart);
        lecture.addEventListener('dragover', handleDragOver);
        lecture.addEventListener('drop', handleDrop);
        lecture.addEventListener('dragend', handleDragEnd);
    });
}

function disableDragAndDrop() {
    const lectures = document.querySelectorAll('[data-lecture-id]');
    lectures.forEach(lecture => {
        lecture.draggable = false;
        lecture.classList.remove('cursor-move', 'select-none');
        
        lecture.removeEventListener('dragstart', handleDragStart);
        lecture.removeEventListener('dragover', handleDragOver);
        lecture.removeEventListener('drop', handleDrop);
        lecture.removeEventListener('dragend', handleDragEnd);
    });
}

let draggedElement = null;

function handleDragStart(e) {
    draggedElement = this;
    this.style.opacity = '0.5';
}

function handleDragOver(e) {
    e.preventDefault();
    return false;
}

function handleDrop(e) {
    e.preventDefault();
    
    if (draggedElement !== this) {
        const container = document.getElementById('lecturesContainer');
        const draggedIndex = Array.from(container.children).indexOf(draggedElement);
        const targetIndex = Array.from(container.children).indexOf(this);
        
        if (draggedIndex < targetIndex) {
            this.parentNode.insertBefore(draggedElement, this.nextSibling);
        } else {
            this.parentNode.insertBefore(draggedElement, this);
        }
    }
    
    return false;
}

function handleDragEnd(e) {
    this.style.opacity = '';
    updateLectureNumbers();
}

function updateLectureNumbers() {
    const lectures = document.querySelectorAll('[data-lecture-id]');
    lectures.forEach((lecture, index) => {
        const numberElement = lecture.querySelector('.w-8.h-8 span');
        if (numberElement) {
            numberElement.textContent = index + 1;
        }
    });
}

function showReorderInstructions() {
    const instructions = document.createElement('div');
    instructions.id = 'reorderInstructions';
    instructions.className = 'bg-blue-50 border border-blue-200 rounded-lg p-4 mb-4';
    instructions.innerHTML = `
        <div class="flex items-center">
            <i class="fas fa-info-circle text-blue-600 mr-2"></i>
            <span class="text-sm text-blue-800">Drag and drop lectures to reorder them. Click "Save Order" when finished.</span>
        </div>
    `;
    
    const container = document.getElementById('lecturesContainer');
    container.parentNode.insertBefore(instructions, container);
}

function hideReorderInstructions() {
    const instructions = document.getElementById('reorderInstructions');
    if (instructions) {
        instructions.remove();
    }
}

function saveNewOrder() {
    const lectures = document.querySelectorAll('[data-lecture-id]');
    const newOrder = Array.from(lectures).map((lecture, index) => ({
        id: lecture.dataset.lectureId,
        order: index + 1
    }));
    
    // In a real application, this would send the new order to the server
    console.log('New lecture order:', newOrder);
    
    // Show success message
    const successMsg = document.createElement('div');
    successMsg.className = 'fixed top-4 right-4 bg-green-600 text-white px-4 py-2 rounded-lg shadow-lg z-50';
    successMsg.innerHTML = '<i class="fas fa-check mr-2"></i>Lecture order saved successfully!';
    document.body.appendChild(successMsg);
    
    setTimeout(() => {
        successMsg.remove();
    }, 3000);
}
</script>

<?php
$content = ob_get_clean();
include '../app/Views/layouts/instructor.php';
?>