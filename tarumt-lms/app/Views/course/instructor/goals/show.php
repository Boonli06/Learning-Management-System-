<?php
ob_start();

// Handle any messages from session
$successMessage = $_SESSION['success'] ?? '';
$errorMessage = $_SESSION['error'] ?? '';
unset($_SESSION['success'], $_SESSION['error']);
?>

<!-- Main Content -->
<div class="space-y-6">
    
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900"><?= htmlspecialchars($pageTitle) ?></h1>
            <p class="text-gray-600 mt-1"><?= htmlspecialchars($pageSubtitle) ?></p>
        </div>
        <div class="flex gap-3">
            <a href="/instructor/goals/<?= $goal['id'] ?>/edit" 
               class="bg-black text-white px-4 py-2 rounded-lg hover:bg-gray-800 transition-colors duration-200">
                <i class="fas fa-edit mr-2"></i>Edit Goal
            </a>
            <button onclick="duplicateGoal(<?= $goal['id'] ?>)" 
                    class="border border-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                <i class="fas fa-copy mr-2"></i>Duplicate
            </button>
        </div>
    </div>

    <!-- Messages -->
    <?php if ($successMessage): ?>
        <div class="bg-green-50 border border-green-200 rounded-lg p-4">
            <div class="flex">
                <i class="fas fa-check-circle text-green-400 mt-0.5 mr-3"></i>
                <p class="text-green-800"><?= htmlspecialchars($successMessage) ?></p>
            </div>
        </div>
    <?php endif; ?>

    <?php if ($errorMessage): ?>
        <div class="bg-red-50 border border-red-200 rounded-lg p-4">
            <div class="flex">
                <i class="fas fa-exclamation-circle text-red-400 mt-0.5 mr-3"></i>
                <p class="text-red-800"><?= htmlspecialchars($errorMessage) ?></p>
            </div>
        </div>
    <?php endif; ?>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Main Goal Details -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- Goal Content Card -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center mb-6">
                    <div class="w-10 h-10 bg-black rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-bullseye text-white"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-900">Learning Goal #<?= $goal['order'] ?></h2>
                        <p class="text-gray-600">Course: <?= htmlspecialchars($goal['course_title']) ?></p>
                    </div>
                </div>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Goal Description</label>
                        <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                            <p class="text-gray-900 leading-relaxed"><?= htmlspecialchars($goal['goal']) ?></p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Course</label>
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-graduation-cap text-gray-600 text-sm"></i>
                                </div>
                                <span class="text-gray-900 font-medium"><?= htmlspecialchars($goal['course_title']) ?></span>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Goal Order</label>
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-black rounded-lg flex items-center justify-center mr-3">
                                    <span class="text-white text-sm font-bold"><?= $goal['order'] ?></span>
                                </div>
                                <span class="text-gray-900">Goal #<?= $goal['order'] ?> in course</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Goal Analysis Card -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center mb-6">
                    <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-chart-line text-white"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Goal Analysis</h3>
                        <p class="text-gray-600">Assessment of this learning objective</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="text-center p-4 bg-gray-50 rounded-lg">
                        <div class="text-2xl font-bold text-gray-900"><?= strlen($goal['goal']) ?></div>
                        <div class="text-sm text-gray-600">Characters</div>
                    </div>
                    <div class="text-center p-4 bg-gray-50 rounded-lg">
                        <div class="text-2xl font-bold text-gray-900"><?= str_word_count($goal['goal']) ?></div>
                        <div class="text-sm text-gray-600">Words</div>
                    </div>
                    <div class="text-center p-4 bg-gray-50 rounded-lg">
                        <?php 
                        $actionVerbs = ['master', 'create', 'build', 'understand', 'apply', 'develop', 'implement', 'design', 'analyze', 'solve'];
                        $hasActionVerb = false;
                        foreach ($actionVerbs as $verb) {
                            if (stripos($goal['goal'], $verb) !== false) {
                                $hasActionVerb = true;
                                break;
                            }
                        }
                        ?>
                        <div class="text-2xl font-bold <?= $hasActionVerb ? 'text-green-600' : 'text-yellow-600' ?>">
                            <?= $hasActionVerb ? 'Yes' : 'Maybe' ?>
                        </div>
                        <div class="text-sm text-gray-600">Action Verb</div>
                    </div>
                </div>

                <div class="mt-6 p-4 bg-blue-50 rounded-lg border border-blue-200">
                    <h4 class="font-medium text-blue-900 mb-2">Writing Quality Assessment</h4>
                    <div class="space-y-2 text-sm">
                        <?php if (strlen($goal['goal']) >= 20): ?>
                            <div class="flex items-center text-green-700">
                                <i class="fas fa-check mr-2"></i>
                                Good length (<?= strlen($goal['goal']) ?> characters)
                            </div>
                        <?php else: ?>
                            <div class="flex items-center text-yellow-700">
                                <i class="fas fa-exclamation-triangle mr-2"></i>
                                Consider adding more detail
                            </div>
                        <?php endif; ?>

                        <?php if ($hasActionVerb): ?>
                            <div class="flex items-center text-green-700">
                                <i class="fas fa-check mr-2"></i>
                                Contains action verb
                            </div>
                        <?php else: ?>
                            <div class="flex items-center text-yellow-700">
                                <i class="fas fa-exclamation-triangle mr-2"></i>
                                Consider starting with an action verb
                            </div>
                        <?php endif; ?>

                        <?php if (str_word_count($goal['goal']) >= 5): ?>
                            <div class="flex items-center text-green-700">
                                <i class="fas fa-check mr-2"></i>
                                Descriptive (<?= str_word_count($goal['goal']) ?> words)
                            </div>
                        <?php else: ?>
                            <div class="flex items-center text-yellow-700">
                                <i class="fas fa-exclamation-triangle mr-2"></i>
                                Could be more descriptive
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            
            <!-- Quick Actions Card -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>
                <div class="space-y-3">
                    <a href="/instructor/goals/<?= $goal['id'] ?>/edit" 
                       class="flex items-center w-full px-4 py-3 text-left bg-black text-white rounded-lg hover:bg-gray-800 transition-colors duration-200">
                        <i class="fas fa-edit mr-3"></i>
                        <div>
                            <div class="font-medium">Edit Goal</div>
                            <div class="text-xs opacity-75">Modify this learning objective</div>
                        </div>
                    </a>
                    <button onclick="duplicateGoal(<?= $goal['id'] ?>)" 
                            class="flex items-center w-full px-4 py-3 text-left border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                        <i class="fas fa-copy mr-3"></i>
                        <div>
                            <div class="font-medium">Duplicate Goal</div>
                            <div class="text-xs text-gray-500">Create a copy of this goal</div>
                        </div>
                    </button>
                    <a href="/instructor/courses/<?= $goal['course_id'] ?>/goals" 
                       class="flex items-center w-full px-4 py-3 text-left border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                        <i class="fas fa-list mr-3"></i>
                        <div>
                            <div class="font-medium">Course Goals</div>
                            <div class="text-xs text-gray-500">View all goals for this course</div>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Goal Information Card -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Goal Information</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Goal ID</label>
                        <p class="text-gray-900 font-mono text-sm">#<?= $goal['id'] ?></p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Created</label>
                        <p class="text-gray-900"><?= date('M j, Y \a\t g:i A', strtotime($goal['created_at'])) ?></p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Last Updated</label>
                        <p class="text-gray-900"><?= date('M j, Y \a\t g:i A', strtotime($goal['updated_at'])) ?></p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Course Position</label>
                        <p class="text-gray-900">Goal #<?= $goal['order'] ?> of course</p>
                    </div>
                </div>
            </div>

            <!-- Danger Zone Card -->
            <div class="bg-white rounded-lg shadow-sm border border-red-200 p-6">
                <h3 class="text-lg font-semibold text-red-900 mb-4">Danger Zone</h3>
                <p class="text-sm text-red-700 mb-4">
                    Once you delete this learning goal, there is no going back. Please be certain.
                </p>
                <button onclick="deleteGoal(<?= $goal['id'] ?>)" 
                        class="w-full px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors duration-200">
                    <i class="fas fa-trash mr-2"></i>Delete Goal
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function duplicateGoal(id) {
    if (confirm('Do you want to create a copy of this learning goal?')) {
        window.location.href = '/instructor/goals/' + id + '/duplicate';
    }
}

function deleteGoal(id) {
    if (confirm('Are you sure you want to delete this learning goal? This action cannot be undone.')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '/instructor/goals/' + id;
        
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