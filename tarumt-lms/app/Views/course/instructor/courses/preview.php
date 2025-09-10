<?php
// 数据现在由Controller传递，直接开始页面内容
$courseId = $course['id'];

// Page actions for header
ob_start();
?>
<div class="flex gap-3">
    <button type="button" class="bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black transition-colors duration-200" onclick="window.location.href='/instructor/courses/<?= $courseId ?>/edit'">
        <i class="fas fa-edit mr-2"></i>
        Edit Course
    </button>
    <button type="button" class="bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black transition-colors duration-200" onclick="window.open('/courses/<?= $courseId ?>', '_blank')">
        <i class="fas fa-external-link-alt mr-2"></i>
        View as Student
    </button>
    <button type="button" class="bg-black text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black transition-colors duration-200" onclick="window.location.href='/instructor/courses/<?= $courseId ?>/settings'">
        <i class="fas fa-cog mr-2"></i>
        Settings
    </button>
</div>
<?php
$pageActions = ob_get_clean();

ob_start();
?>

<!-- Preview Mode Banner -->
<div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
    <div class="flex items-center justify-between">
        <div class="flex items-center">
            <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                <i class="fas fa-eye text-blue-600"></i>
            </div>
            <div>
                <h3 class="text-sm font-medium text-blue-900">Preview Mode</h3>
                <p class="text-xs text-blue-700">This is how your course appears to students. Some features may be limited in preview mode.</p>
            </div>
        </div>
        <div class="flex items-center gap-2">
            <span class="text-xs text-blue-700">Status: <?= ucfirst($course['status']) ?></span>
            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                <div class="w-1.5 h-1.5 bg-blue-400 rounded-full mr-1"></div>
                Preview
            </span>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    
    <!-- Main Content -->
    <div class="lg:col-span-2 space-y-6">
        
        <!-- Course Header -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            <!-- Video/Thumbnail Section -->
            <div class="aspect-video bg-gradient-to-br from-gray-900 to-gray-700 flex items-center justify-center relative">
                <span class="text-white text-4xl font-bold"><?= substr($course['title'], 0, 8) ?></span>
                <!-- Play Button Overlay -->
                <div class="absolute inset-0 flex items-center justify-center">
                    <button class="w-16 h-16 bg-white bg-opacity-20 rounded-full flex items-center justify-center hover:bg-opacity-30 transition-colors duration-200" onclick="playPreviewVideo()">
                        <i class="fas fa-play text-white text-xl ml-1"></i>
                    </button>
                </div>
                <!-- Preview Badge -->
                <div class="absolute top-4 left-4">
                    <span class="bg-black bg-opacity-50 text-white px-2 py-1 rounded text-xs font-medium">
                        Preview Available
                    </span>
                </div>
            </div>
            
            <!-- Course Info -->
            <div class="p-6">
                <div class="flex items-start justify-between mb-4">
                    <div class="flex-1">
                        <div class="flex items-center gap-2 mb-2">
                            <span class="text-xs bg-gray-100 text-gray-600 px-2 py-1 rounded"><?= $course['category'] ?></span>
                            <span class="text-xs bg-gray-100 text-gray-600 px-2 py-1 rounded"><?= $course['subcategory'] ?></span>
                        </div>
                        <h1 class="text-2xl font-bold text-gray-900 mb-2"><?= htmlspecialchars($course['title']) ?></h1>
                        <p class="text-gray-600 leading-relaxed"><?= htmlspecialchars($course['short_description']) ?></p>
                    </div>
                </div>

                <!-- Course Stats -->
                <div class="flex flex-wrap items-center gap-6 pt-4 border-t border-gray-200">
                    <div class="flex items-center">
                        <i class="fas fa-star text-yellow-400 mr-1"></i>
                        <span class="font-medium text-gray-900"><?= $course['rating'] ?></span>
                        <span class="text-gray-500 ml-1">(<?= $course['reviews_count'] ?> reviews)</span>
                    </div>
                    <div class="flex items-center text-gray-600">
                        <i class="fas fa-users mr-2"></i>
                        <span><?= $course['students_count'] ?> students</span>
                    </div>
                    <div class="flex items-center text-gray-600">
                        <i class="fas fa-clock mr-2"></i>
                        <span><?= $course['estimated_duration'] ?> hours</span>
                    </div>
                    <div class="flex items-center text-gray-600">
                        <i class="fas fa-signal mr-2"></i>
                        <span><?= $course['difficulty_level'] ?></span>
                    </div>
                    <div class="flex items-center text-gray-600">
                        <i class="fas fa-globe mr-2"></i>
                        <span><?= $course['language'] ?></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- What You'll Learn -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">What you'll learn</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                <?php foreach ($goals as $goal): ?>
                <div class="flex items-start">
                    <i class="fas fa-check text-green-500 mt-1 mr-3 flex-shrink-0"></i>
                    <span class="text-gray-700"><?= htmlspecialchars($goal) ?></span>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Course Content -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Course content</h3>
                <span class="text-sm text-gray-500"><?= count($sections) ?> sections • <?= $course['total_lectures'] ?> lectures • <?= $course['estimated_duration'] ?>h total length</span>
            </div>

            <div class="space-y-2">
                <?php foreach ($sections as $index => $section): ?>
                <div class="border border-gray-200 rounded-lg">
                    <button 
                        class="w-full flex items-center justify-between p-4 text-left hover:bg-gray-50 focus:outline-none focus:bg-gray-50 transition-colors duration-200"
                        onclick="toggleSection(<?= $section['id'] ?>)"
                    >
                        <div class="flex items-center">
                            <i class="fas fa-chevron-right text-gray-400 mr-3 transform transition-transform duration-200" id="chevron-<?= $section['id'] ?>"></i>
                            <div>
                                <h4 class="font-medium text-gray-900"><?= htmlspecialchars($section['title']) ?></h4>
                                <p class="text-sm text-gray-500"><?= $section['lectures_count'] ?> lectures • <?= $section['duration'] ?></p>
                            </div>
                        </div>
                    </button>
                    
                    <div id="section-<?= $section['id'] ?>" class="hidden border-t border-gray-200">
                        <?php foreach ($section['lectures'] as $lecture): ?>
                        <div class="flex items-center justify-between p-4 pl-12 hover:bg-gray-50">
                            <div class="flex items-center">
                                <i class="fas fa-play-circle text-gray-400 mr-3"></i>
                                <div>
                                    <span class="text-gray-900"><?= htmlspecialchars($lecture['title']) ?></span>
                                    <?php if ($lecture['is_preview']): ?>
                                    <span class="ml-2 text-xs bg-green-100 text-green-800 px-2 py-1 rounded">Preview</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <span class="text-sm text-gray-500"><?= $lecture['duration'] ?></span>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Description -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Description</h3>
            <div class="prose prose-gray max-w-none">
                <p class="text-gray-700 leading-relaxed"><?= nl2br(htmlspecialchars($course['description'])) ?></p>
            </div>
        </div>

        <!-- Prerequisites -->
        <?php if ($course['prerequisites']): ?>
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Requirements</h3>
            <div class="text-gray-700">
                <?= nl2br(htmlspecialchars($course['prerequisites'])) ?>
            </div>
        </div>
        <?php endif; ?>

        <!-- Instructor -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Instructor</h3>
            <div class="flex items-start">
                <div class="w-16 h-16 bg-gray-300 rounded-full flex items-center justify-center mr-4">
                    <i class="fas fa-user text-gray-600 text-xl"></i>
                </div>
                <div>
                    <h4 class="font-medium text-gray-900"><?= htmlspecialchars($course['instructor_name']) ?></h4>
                    <p class="text-sm text-gray-500 mb-2">Full-Stack Developer & Instructor</p>
                    <div class="flex items-center gap-4 text-sm text-gray-600">
                        <span><i class="fas fa-star mr-1"></i> 4.8 instructor rating</span>
                        <span><i class="fas fa-users mr-1"></i> 1,234 students</span>
                        <span><i class="fas fa-play-circle mr-1"></i> 8 courses</span>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Sidebar -->
    <div class="lg:col-span-1">
        <div class="sticky top-6 space-y-6">
            
            <!-- Purchase Card -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="text-center mb-6">
                    <div class="flex items-center justify-center mb-2">
                        <span class="text-3xl font-bold text-gray-900">RM <?= $course['price'] ?></span>
                        <?php if ($course['original_price'] > $course['price']): ?>
                        <span class="text-lg text-gray-500 line-through ml-2">RM <?= $course['original_price'] ?></span>
                        <?php endif; ?>
                    </div>
                    <?php if ($course['original_price'] > $course['price']): ?>
                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                        <?= round((($course['original_price'] - $course['price']) / $course['original_price']) * 100) ?>% OFF
                    </span>
                    <?php endif; ?>
                </div>

                <!-- Preview Notice -->
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3 mb-4">
                    <div class="flex items-center">
                        <i class="fas fa-info-circle text-yellow-600 mr-2"></i>
                        <span class="text-xs text-yellow-800">This is a preview - purchase buttons are disabled</span>
                    </div>
                </div>

                <div class="space-y-3 mb-6">
                    <button 
                        type="button" 
                        class="w-full bg-gray-300 text-gray-500 px-6 py-3 rounded-lg font-medium cursor-not-allowed"
                        disabled
                    >
                        Add to Cart (Preview)
                    </button>
                    <button 
                        type="button" 
                        class="w-full border border-gray-300 text-gray-500 px-6 py-3 rounded-lg font-medium cursor-not-allowed"
                        disabled
                    >
                        Buy Now (Preview)
                    </button>
                </div>

                <!-- Course Includes -->
                <div class="space-y-3 text-sm">
                    <div class="flex items-center">
                        <i class="fas fa-infinity text-gray-400 mr-3"></i>
                        <span class="text-gray-700">Full lifetime access</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-mobile-alt text-gray-400 mr-3"></i>
                        <span class="text-gray-700">Access on mobile and TV</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-certificate text-gray-400 mr-3"></i>
                        <span class="text-gray-700">Certificate of completion</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-undo text-gray-400 mr-3"></i>
                        <span class="text-gray-700">30-day money-back guarantee</span>
                    </div>
                </div>
            </div>

            <!-- Course Stats -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h4 class="font-medium text-gray-900 mb-4">Course Stats</h4>
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Students enrolled:</span>
                        <span class="font-medium text-gray-900"><?= $course['students_count'] ?></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Total lectures:</span>
                        <span class="font-medium text-gray-900"><?= $course['total_lectures'] ?></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Total duration:</span>
                        <span class="font-medium text-gray-900"><?= $course['estimated_duration'] ?>h</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Last updated:</span>
                        <span class="font-medium text-gray-900"><?= date('M Y', strtotime($course['last_updated'])) ?></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Language:</span>
                        <span class="font-medium text-gray-900"><?= $course['language'] ?></span>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>

<script>
function toggleSection(sectionId) {
    const content = document.getElementById(`section-${sectionId}`);
    const chevron = document.getElementById(`chevron-${sectionId}`);
    
    if (content.classList.contains('hidden')) {
        content.classList.remove('hidden');
        chevron.classList.add('rotate-90');
    } else {
        content.classList.add('hidden');
        chevron.classList.remove('rotate-90');
    }
}

function playPreviewVideo() {
    alert('Preview video would play here. In the actual course, this would open the promotional video.');
}

// Auto-expand first section for demo
document.addEventListener('DOMContentLoaded', function() {
    toggleSection(1);
});
</script>

<?php
$content = ob_get_clean();
include '../app/Views/layouts/instructor.php';
?>