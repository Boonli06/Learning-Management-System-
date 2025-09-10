<?php
ob_start();
?>

<!-- Course Learning Interface -->
<div class="min-h-screen bg-black">
    <!-- Top Navigation Bar -->
    <div class="bg-black border-b border-gray-800 px-4 py-3">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <!-- Back Button -->
                <button type="button" class="text-gray-300 hover:text-white" onclick="window.location.href='/student/course/<?= $course['id'] ?>'">
                    <i class="fas fa-arrow-left text-lg"></i>
                </button>
                
                <!-- Course Title -->
                <div>
                    <h1 class="text-white font-medium text-lg"><?= htmlspecialchars($course['title']) ?></h1>
                    <?php if ($currentLecture): ?>
                        <p class="text-gray-400 text-sm"><?= htmlspecialchars($currentLecture['title']) ?></p>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Progress & Actions -->
            <div class="flex items-center space-x-4">
                <!-- Progress -->
                <div class="flex items-center space-x-2">
                    <div class="w-32 bg-gray-700 rounded-full h-2">
                        <div class="bg-green-500 h-2 rounded-full" style="width: <?= $progress['progress_percentage'] ?>%"></div>
                    </div>
                    <span class="text-white text-sm"><?= $progress['progress_percentage'] ?>%</span>
                </div>
                
                <!-- Course Menu -->
                <button type="button" class="text-gray-300 hover:text-white" onclick="toggleSidebar()">
                    <i class="fas fa-list text-lg"></i>
                </button>
            </div>
        </div>
    </div>
    
    <div class="flex h-[calc(100vh-64px)]">
        <!-- Main Video Area -->
        <div class="flex-1 flex flex-col">
            <!-- Video Player -->
            <div class="flex-1 bg-black flex items-center justify-center">
                <?php if ($currentLecture): ?>
                    <div class="w-full h-full relative">
                        <!-- Video Element -->
                        <video 
                            id="videoPlayer" 
                            class="w-full h-full object-contain" 
                            controls 
                            poster="<?= htmlspecialchars($course['thumbnail']) ?>"
                        >
                            <source src="<?= htmlspecialchars($currentLecture['video_url']) ?>" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                        
                        <!-- Video Controls -->
                        <div class="absolute bottom-4 left-4 right-4">
                            <div class="bg-black bg-opacity-75 rounded-lg p-4">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-4">
                                        <button type="button" class="text-white hover:text-gray-300" onclick="previousLecture()">
                                            <i class="fas fa-step-backward"></i>
                                        </button>
                                        <button type="button" class="text-white hover:text-gray-300" onclick="togglePlayPause()">
                                            <i class="fas fa-play" id="playPauseIcon"></i>
                                        </button>
                                        <button type="button" class="text-white hover:text-gray-300" onclick="nextLecture()">
                                            <i class="fas fa-step-forward"></i>
                                        </button>
                                    </div>
                                    
                                    <div class="flex items-center space-x-4">
                                        <!-- Speed Control -->
                                        <select class="bg-gray-800 text-white text-sm rounded px-2 py-1" onchange="changePlaybackSpeed(this.value)">
                                            <option value="0.5">0.5x</option>
                                            <option value="0.75">0.75x</option>
                                            <option value="1" selected>1x</option>
                                            <option value="1.25">1.25x</option>
                                            <option value="1.5">1.5x</option>
                                            <option value="2">2x</option>
                                        </select>
                                        
                                        <!-- Fullscreen -->
                                        <button type="button" class="text-white hover:text-gray-300" onclick="toggleFullscreen()">
                                            <i class="fas fa-expand"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <!-- No Video Selected -->
                    <div class="text-center text-gray-400">
                        <i class="fas fa-play-circle text-6xl mb-4"></i>
                        <h3 class="text-xl font-medium mb-2">Select a lecture to start learning</h3>
                        <p>Choose from the course content on the right</p>
                    </div>
                <?php endif; ?>
            </div>
            
            <!-- Lecture Info & Tabs -->
            <?php if ($currentLecture): ?>
            <div class="bg-white border-t border-gray-200">
                <!-- Lecture Header -->
                <div class="px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-xl font-semibold text-gray-900"><?= htmlspecialchars($currentLecture['title']) ?></h2>
                            <p class="text-sm text-gray-600 mt-1">Lecture in <?= htmlspecialchars($course['title']) ?></p>
                        </div>
                        <div class="flex items-center space-x-3">
                            <!-- Mark Complete Button -->
                            <button type="button" class="bg-green-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-green-700" onclick="markLectureComplete()">
                                <i class="fas fa-check mr-2"></i>
                                Mark Complete
                            </button>
                            
                            <!-- Notes Button -->
                            <button type="button" class="bg-gray-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-700" onclick="showTab('notes')">
                                <i class="fas fa-sticky-note mr-2"></i>
                                Notes
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Tabs -->
                <div class="border-b border-gray-200">
                    <nav class="-mb-px flex">
                        <button type="button" class="py-3 px-6 border-b-2 border-black text-black font-medium text-sm" onclick="showTab('overview')" id="tab-overview">
                            Overview
                        </button>
                        <button type="button" class="py-3 px-6 border-b-2 border-transparent text-gray-500 hover:text-gray-700 font-medium text-sm" onclick="showTab('resources')" id="tab-resources">
                            Resources
                        </button>
                        <button type="button" class="py-3 px-6 border-b-2 border-transparent text-gray-500 hover:text-gray-700 font-medium text-sm" onclick="showTab('notes')" id="tab-notes">
                            My Notes
                        </button>
                    </nav>
                </div>
                
                <!-- Tab Content -->
                <div class="p-6 max-h-64 overflow-y-auto">
                    <!-- Overview Tab -->
                    <div id="content-overview">
                        <div class="grid grid-cols-3 gap-4 mb-6">
                            <div class="text-center">
                                <div class="text-2xl font-bold text-gray-900"><?= htmlspecialchars($currentLecture['duration']) ?></div>
                                <div class="text-sm text-gray-500">Duration</div>
                            </div>
                            <div class="text-center">
                                <div class="text-2xl font-bold text-gray-900">Video</div>
                                <div class="text-sm text-gray-500">Type</div>
                            </div>
                            <div class="text-center">
                                <div class="text-2xl font-bold text-green-600">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                                <div class="text-sm text-gray-500">Status</div>
                            </div>
                        </div>
                        <p class="text-gray-700">This lecture is part of the <?= htmlspecialchars($course['title']) ?> course.</p>
                    </div>
                    
                    <!-- Resources Tab -->
                    <div id="content-resources" class="hidden">
                        <?php if (!empty($currentLecture['resources'])): ?>
                            <div class="space-y-3">
                                <?php foreach ($currentLecture['resources'] as $resource): ?>
                                <div class="flex items-center justify-between p-3 border border-gray-200 rounded-lg">
                                    <div class="flex items-center">
                                        <i class="fas fa-file-alt text-gray-400 mr-3"></i>
                                        <div>
                                            <p class="font-medium text-gray-900"><?= htmlspecialchars($resource['title']) ?></p>
                                        </div>
                                    </div>
                                    <a href="<?= htmlspecialchars($resource['url']) ?>" target="_blank" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                        Download
                                    </a>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <p class="text-gray-500 text-center py-8">No resources available for this lecture.</p>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Notes Tab -->
                    <div id="content-notes" class="hidden">
                        <div class="space-y-4">
                            <textarea 
                                id="lectureNotes" 
                                class="w-full h-32 border border-gray-300 rounded-lg p-3 text-sm" 
                                placeholder="Add your notes for this lecture..."
                            ></textarea>
                            <button type="button" class="bg-black text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-800" onclick="saveNotes()">
                                Save Notes
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
        
        <!-- Course Sidebar -->
        <div id="courseSidebar" class="w-80 bg-white border-l border-gray-200 flex flex-col">
            <!-- Sidebar Header -->
            <div class="p-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h3 class="font-medium text-gray-900">Course Content</h3>
                    <button type="button" class="text-gray-400 hover:text-gray-600" onclick="toggleSidebar()">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                
                <!-- Progress Summary -->
                <div class="mt-3">
                    <div class="flex justify-between text-sm text-gray-600 mb-1">
                        <span><?= $progress['completed_lectures'] ?> of <?= $progress['total_lectures'] ?> completed</span>
                        <span><?= $progress['progress_percentage'] ?>%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-green-600 h-2 rounded-full" style="width: <?= $progress['progress_percentage'] ?>%"></div>
                    </div>
                </div>
            </div>
            
            <!-- Course Sections -->
            <div class="flex-1 overflow-y-auto">
                <?php foreach ($sections as $sectionIndex => $section): ?>
                <div class="border-b border-gray-200">
                    <button type="button" class="w-full px-4 py-3 text-left hover:bg-gray-50" onclick="toggleSection(<?= $sectionIndex ?>)">
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="font-medium text-gray-900"><?= htmlspecialchars($section['title']) ?></h4>
                                <p class="text-sm text-gray-500"><?= count($section['lectures']) ?> lectures</p>
                            </div>
                            <i class="fas fa-chevron-down text-gray-400 transform transition-transform duration-200" id="icon-<?= $sectionIndex ?>"></i>
                        </div>
                    </button>
                    
                    <div id="section-<?= $sectionIndex ?>" class="hidden">
                        <?php foreach ($section['lectures'] as $lecture): ?>
                        <div class="pl-4 pr-4 py-2 border-l-4 <?= $currentLecture && $currentLecture['id'] == $lecture['id'] ? 'border-black bg-gray-50' : 'border-transparent hover:bg-gray-50' ?>">
                            <button type="button" class="w-full text-left" onclick="loadLecture(<?= $lecture['id'] ?>)">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <i class="fas fa-play-circle text-gray-400 mr-3"></i>
                                        <div>
                                            <p class="text-sm font-medium text-gray-900"><?= htmlspecialchars($lecture['title']) ?></p>
                                            <p class="text-xs text-gray-500"><?= htmlspecialchars($lecture['duration']) ?></p>
                                        </div>
                                    </div>
                                    <div class="flex items-center">
                                        <i class="fas fa-check-circle text-green-500 text-sm"></i>
                                    </div>
                                </div>
                            </button>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<script>
let currentVideoTime = 0;
let lectureCompleted = false;

// Video player controls
function togglePlayPause() {
    const video = document.getElementById('videoPlayer');
    const icon = document.getElementById('playPauseIcon');
    
    if (video.paused) {
        video.play();
        icon.className = 'fas fa-pause';
    } else {
        video.pause();
        icon.className = 'fas fa-play';
    }
}

function changePlaybackSpeed(speed) {
    const video = document.getElementById('videoPlayer');
    video.playbackRate = parseFloat(speed);
}

function toggleFullscreen() {
    const video = document.getElementById('videoPlayer');
    if (video.requestFullscreen) {
        video.requestFullscreen();
    }
}

// Lecture navigation
function loadLecture(lectureId) {
    window.location.href = `/student/course/<?= $course['id'] ?>/learn?lecture=${lectureId}`;
}

function previousLecture() {
    console.log('Navigate to previous lecture');
}

function nextLecture() {
    console.log('Navigate to next lecture');
}

// Progress tracking
function markLectureComplete() {
    const courseId = <?= $course['id'] ?>;
    const lectureId = <?= $currentLecture['id'] ?? 0 ?>;
    
    if (lectureCompleted) return;
    
    fetch(`/student/course/${courseId}/lecture/${lectureId}/complete`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ 
            time_spent: Math.floor(currentVideoTime / 60)
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            lectureCompleted = true;
            showNotification('Lecture marked as complete!', 'success');
        }
    });
}

// Sidebar controls
function toggleSidebar() {
    const sidebar = document.getElementById('courseSidebar');
    sidebar.classList.toggle('hidden');
}

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

// Notes functionality
function saveNotes() {
    const notes = document.getElementById('lectureNotes').value;
    const lectureId = <?= $currentLecture['id'] ?? 0 ?>;
    
    // Save notes to backend
    fetch('/student/lecture/' + lectureId + '/notes', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ notes: notes })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification('Notes saved successfully!', 'success');
        }
    });
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

// Initialize
document.addEventListener('DOMContentLoaded', function() {
    // Auto-expand current section if lecture is selected
    <?php if ($currentLecture): ?>
        // Expand the first section by default
        toggleSection(0);
    <?php endif; ?>
});
</script>

<?php
$content = ob_get_clean();
include '../app/Views/layouts/student.php';
?>