<?php
ob_start();
?>

<div class="space-y-8">
    
    <!-- Introduction -->
    <div>
        <p class="text-gray-700 leading-relaxed">
            Welcome to TARUMT Learning Management System ("LMS", "we", "us", or "our"). These Terms of Service ("Terms") govern your use of our learning management platform and services provided by Tunku Abdul Rahman University of Management and Technology.
        </p>
        <p class="text-gray-700 leading-relaxed mt-4">
            By accessing or using our LMS, you agree to be bound by these Terms. If you disagree with any part of these terms, you may not access the service.
        </p>
    </div>

    <!-- Table of Contents -->
    <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Table of Contents</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-2 text-sm">
            <a href="#acceptance" class="text-gray-600 hover:text-black" onclick="toggleSection('acceptance')">1. Acceptance of Terms</a>
            <a href="#accounts" class="text-gray-600 hover:text-black" onclick="toggleSection('accounts')">2. User Accounts</a>
            <a href="#usage" class="text-gray-600 hover:text-black" onclick="toggleSection('usage')">3. Acceptable Use</a>
            <a href="#content" class="text-gray-600 hover:text-black" onclick="toggleSection('content')">4. Content and Intellectual Property</a>
            <a href="#privacy" class="text-gray-600 hover:text-black" onclick="toggleSection('privacy')">5. Privacy and Data Protection</a>
            <a href="#academic" class="text-gray-600 hover:text-black" onclick="toggleSection('academic')">6. Academic Integrity</a>
            <a href="#payments" class="text-gray-600 hover:text-black" onclick="toggleSection('payments')">7. Payments and Refunds</a>
            <a href="#termination" class="text-gray-600 hover:text-black" onclick="toggleSection('termination')">8. Termination</a>
            <a href="#disclaimers" class="text-gray-600 hover:text-black" onclick="toggleSection('disclaimers')">9. Disclaimers</a>
            <a href="#contact" class="text-gray-600 hover:text-black" onclick="toggleSection('contact')">10. Contact Information</a>
        </div>
    </div>

    <!-- 1. Acceptance of Terms -->
    <section id="acceptance" class="collapsible-section">
        <button onclick="toggleSection('acceptance')" class="w-full text-left bg-gray-50 hover:bg-gray-100 p-4 rounded-lg border border-gray-200 transition-colors duration-200">
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-bold text-gray-900">1. Acceptance of Terms</h2>
                <i class="fas fa-chevron-down text-gray-500 transform transition-transform duration-200" id="acceptance-icon"></i>
            </div>
        </button>
        <div id="acceptance-content" class="hidden mt-4 space-y-4 text-gray-700 pl-4">
            <p>By creating an account or using any part of the TARUMT LMS, you acknowledge that you have read, understood, and agree to be bound by these Terms of Service and our Privacy Policy.</p>
            <p>These Terms apply to all users of the LMS, including students, instructors, administrators, and visitors.</p>
            <p>We reserve the right to modify these Terms at any time. Changes will be effective immediately upon posting to the platform. Your continued use of the LMS after changes are posted constitutes acceptance of the revised Terms.</p>
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                <h4 class="font-medium text-blue-900 mb-2">Key Points:</h4>
                <ul class="text-sm text-blue-800 space-y-1">
                    <li>• Agreement is binding upon registration or use</li>
                    <li>• Terms may be updated without prior notice</li>
                    <li>• Continued use implies acceptance of new terms</li>
                </ul>
            </div>
        </div>
    </section>

    <!-- 2. User Accounts -->
    <section id="accounts" class="collapsible-section">
        <button onclick="toggleSection('accounts')" class="w-full text-left bg-gray-50 hover:bg-gray-100 p-4 rounded-lg border border-gray-200 transition-colors duration-200">
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-bold text-gray-900">2. User Accounts</h2>
                <i class="fas fa-chevron-down text-gray-500 transform transition-transform duration-200" id="accounts-icon"></i>
            </div>
        </button>
        <div id="accounts-content" class="hidden mt-4 space-y-4 text-gray-700 pl-4">
            <h3 class="text-lg font-semibold text-gray-900">Account Registration</h3>
            <ul class="list-disc list-inside space-y-2">
                <li>You must provide accurate, current, and complete information during registration</li>
                <li>You are responsible for maintaining the confidentiality of your account credentials</li>
                <li>You must be at least 13 years old to create an account</li>
                <li>One person may not maintain multiple accounts</li>
            </ul>
            
            <h3 class="text-lg font-semibold text-gray-900">Account Security</h3>
            <ul class="list-disc list-inside space-y-2">
                <li>You are responsible for all activities that occur under your account</li>
                <li>You must notify us immediately of any unauthorized use of your account</li>
                <li>We recommend using strong, unique passwords and enabling two-factor authentication when available</li>
            </ul>
            
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                <h4 class="font-medium text-yellow-900 mb-2">Security Best Practices:</h4>
                <ul class="text-sm text-yellow-800 space-y-1">
                    <li>• Use a unique password with at least 8 characters</li>
                    <li>• Include uppercase, lowercase, numbers, and symbols</li>
                    <li>• Enable two-factor authentication when available</li>
                    <li>• Never share your login credentials</li>
                </ul>
            </div>
        </div>
    </section>

    <!-- 3. Acceptable Use -->
    <section id="usage" class="collapsible-section">
        <button onclick="toggleSection('usage')" class="w-full text-left bg-gray-50 hover:bg-gray-100 p-4 rounded-lg border border-gray-200 transition-colors duration-200">
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-bold text-gray-900">3. Acceptable Use Policy</h2>
                <i class="fas fa-chevron-down text-gray-500 transform transition-transform duration-200" id="usage-icon"></i>
            </div>
        </button>
        <div id="usage-content" class="hidden mt-4 space-y-4 text-gray-700 pl-4">
            <p>You may use the LMS only for lawful educational purposes. The following activities are strictly prohibited:</p>
            
            <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                <h4 class="font-medium text-red-900 mb-3">Prohibited Activities:</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-sm text-red-800">
                    <div>
                        <h5 class="font-medium mb-2">Legal & Security:</h5>
                        <ul class="space-y-1">
                            <li>• Violating any applicable laws</li>
                            <li>• Uploading malicious software</li>
                            <li>• Unauthorized system access</li>
                            <li>• Distributing spam or malware</li>
                        </ul>
                    </div>
                    <div>
                        <h5 class="font-medium mb-2">Academic & Social:</h5>
                        <ul class="space-y-1">
                            <li>• Academic dishonesty or plagiarism</li>
                            <li>• Harassment or discrimination</li>
                            <li>• Sharing account credentials</li>
                            <li>• Copyright infringement</li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                <h4 class="font-medium text-green-900 mb-2">Encouraged Activities:</h4>
                <ul class="text-sm text-green-800 space-y-1">
                    <li>• Engaging in respectful academic discussions</li>
                    <li>• Collaborating appropriately with peers</li>
                    <li>• Providing constructive feedback</li>
                    <li>• Reporting security issues or violations</li>
                </ul>
            </div>
        </div>
    </section>

    <!-- Continue with other sections using similar pattern -->
    <!-- 4. Content and Intellectual Property -->
    <section id="content" class="collapsible-section">
        <button onclick="toggleSection('content')" class="w-full text-left bg-gray-50 hover:bg-gray-100 p-4 rounded-lg border border-gray-200 transition-colors duration-200">
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-bold text-gray-900">4. Content and Intellectual Property</h2>
                <i class="fas fa-chevron-down text-gray-500 transform transition-transform duration-200" id="content-icon"></i>
            </div>
        </button>
        <div id="content-content" class="hidden mt-4 space-y-4 text-gray-700 pl-4">
            <h3 class="text-lg font-semibold text-gray-900">University Content</h3>
            <p>All course materials, lectures, assignments, and educational content are intellectual property of TARUMT and our instructors.</p>
            
            <div class="bg-purple-50 border border-purple-200 rounded-lg p-4">
                <h4 class="font-medium text-purple-900 mb-2">Content Usage Rights:</h4>
                <div class="text-sm text-purple-800 space-y-2">
                    <div class="flex items-start">
                        <i class="fas fa-check text-green-600 mr-2 mt-1"></i>
                        <span>Personal educational use during enrollment</span>
                    </div>
                    <div class="flex items-start">
                        <i class="fas fa-times text-red-600 mr-2 mt-1"></i>
                        <span>Commercial distribution or resale</span>
                    </div>
                    <div class="flex items-start">
                        <i class="fas fa-times text-red-600 mr-2 mt-1"></i>
                        <span>Recording or screenshotting without permission</span>
                    </div>
                    <div class="flex items-start">
                        <i class="fas fa-times text-red-600 mr-2 mt-1"></i>
                        <span>Sharing with non-enrolled individuals</span>
                    </div>
                </div>
            </div>
            
            <h3 class="text-lg font-semibold text-gray-900">User-Generated Content</h3>
            <p>By submitting content (assignments, discussions, etc.), you grant TARUMT a license to use, store, and display such content for educational purposes while retaining your original ownership rights.</p>
        </div>
    </section>

    <!-- Add JavaScript for collapsible sections -->
    <script>
    function toggleSection(sectionId) {
        const content = document.getElementById(sectionId + '-content');
        const icon = document.getElementById(sectionId + '-icon');
        
        if (content.classList.contains('hidden')) {
            content.classList.remove('hidden');
            icon.classList.add('rotate-180');
        } else {
            content.classList.add('hidden');
            icon.classList.remove('rotate-180');
        }
    }
    
    // Auto-expand section if hash matches
    document.addEventListener('DOMContentLoaded', function() {
        const hash = window.location.hash.substring(1);
        if (hash) {
            toggleSection(hash);
        }
    });
    </script>>
        <div class="space-y-4 text-gray-700">
            <h3 class="text-lg font-semibold text-gray-900">Account Registration</h3>
            <ul class="list-disc list-inside space-y-2">
                <li>You must provide accurate, current, and complete information during registration</li>
                <li>You are responsible for maintaining the confidentiality of your account credentials</li>
                <li>You must be at least 13 years old to create an account</li>
                <li>One person may not maintain multiple accounts</li>
            </ul>
            
            <h3 class="text-lg font-semibold text-gray-900">Account Security</h3>
            <ul class="list-disc list-inside space-y-2">
                <li>You are responsible for all activities that occur under your account</li>
                <li>You must notify us immediately of any unauthorized use of your account</li>
                <li>We recommend using strong, unique passwords and enabling two-factor authentication when available</li>
            </ul>
        </div>
    </section>

    <!-- 3. Acceptable Use -->
    <section id="usage">
        <h2 class="text-2xl font-bold text-gray-900 mb-4">3. Acceptable Use</h2>
        <div class="space-y-4 text-gray-700">
            <p>You may use the LMS only for lawful educational purposes. Prohibited activities include, but are not limited to:</p>
            
            <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                <h4 class="font-medium text-red-900 mb-2">Prohibited Activities:</h4>
                <ul class="list-disc list-inside space-y-1 text-red-800 text-sm">
                    <li>Violating any applicable laws or regulations</li>
                    <li>Sharing account credentials with other users</li>
                    <li>Uploading malicious software or code</li>
                    <li>Harassment, bullying, or discriminatory behavior</li>
                    <li>Academic dishonesty or plagiarism</li>
                    <li>Attempting to gain unauthorized access to systems</li>
                    <li>Distributing spam or unsolicited communications</li>
                    <li>Infringing on intellectual property rights</li>
                </ul>
            </div>
        </div>
    </section>

    <!-- 4. Content and Intellectual Property -->
    <section id="content">
        <h2 class="text-2xl font-bold text-gray-900 mb-4">4. Content and Intellectual Property</h2>
        <div class="space-y-4 text-gray-700">
            <h3 class="text-lg font-semibold text-gray-900">University Content</h3>
            <p>All course materials, lectures, assignments, and educational content provided through the LMS are the intellectual property of TARUMT and our instructors. You may not:</p>
            <ul class="list-disc list-inside space-y-2">
                <li>Distribute, share, or republish course materials without permission</li>
                <li>Use content for commercial purposes</li>
                <li>Record or screenshot content without explicit authorization</li>
            </ul>
            
            <h3 class="text-lg font-semibold text-gray-900">User-Generated Content</h3>
            <p>By submitting content to the LMS (assignments, discussions, etc.), you grant TARUMT a license to use, store, and display such content for educational purposes.</p>
        </div>
    </section>

    <!-- 5. Privacy and Data Protection -->
    <section id="privacy">
        <h2 class="text-2xl font-bold text-gray-900 mb-4">5. Privacy and Data Protection</h2>
        <div class="space-y-4 text-gray-700">
            <p>Your privacy is important to us. Our collection and use of personal information is governed by our Privacy Policy, which is incorporated into these Terms by reference.</p>
            <p>We implement appropriate security measures to protect your personal information, but cannot guarantee absolute security of data transmitted over the internet.</p>
        </div>
    </section>

    <!-- 6. Academic Integrity -->
    <section id="academic">
        <h2 class="text-2xl font-bold text-gray-900 mb-4">6. Academic Integrity</h2>
        <div class="space-y-4 text-gray-700">
            <p>All users must maintain the highest standards of academic integrity. This includes:</p>
            <ul class="list-disc list-inside space-y-2">
                <li>Completing original work and properly citing sources</li>
                <li>Not engaging in plagiarism or cheating</li>
                <li>Not sharing answers or collaborating when prohibited</li>
                <li>Reporting suspected violations to appropriate authorities</li>
            </ul>
            <p class="text-sm bg-yellow-50 border border-yellow-200 rounded-lg p-3">
                <strong>Note:</strong> Violations of academic integrity may result in course failure, suspension, or other disciplinary actions as outlined in the university's academic policies.
            </p>
        </div>
    </section>

    <!-- 7. Payments and Refunds -->
    <section id="payments">
        <h2 class="text-2xl font-bold text-gray-900 mb-4">7. Payments and Refunds</h2>
        <div class="space-y-4 text-gray-700">
            <p>Course fees and payment terms are subject to the university's financial policies. Refund eligibility depends on the timing of withdrawal and is governed by academic calendar deadlines.</p>
            <p>All payment processing is handled securely through approved third-party processors. We do not store payment card information on our systems.</p>
        </div>
    </section>

    <!-- 8. Termination -->
    <section id="termination">
        <h2 class="text-2xl font-bold text-gray-900 mb-4">8. Termination</h2>
        <div class="space-y-4 text-gray-700">
            <p>We may suspend or terminate your access to the LMS at any time for violations of these Terms or for any other reason, with or without notice.</p>
            <p>Upon termination, your right to use the LMS ceases immediately. We may retain certain information as required by law or legitimate business purposes.</p>
        </div>
    </section>

    <!-- 9. Disclaimers -->
    <section id="disclaimers">
        <h2 class="text-2xl font-bold text-gray-900 mb-4">9. Disclaimers and Limitation of Liability</h2>
    <!-- 5. Privacy and Data Protection -->
    <section id="privacy" class="collapsible-section">
        <button onclick="toggleSection('privacy')" class="w-full text-left bg-gray-50 hover:bg-gray-100 p-4 rounded-lg border border-gray-200 transition-colors duration-200">
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-bold text-gray-900">5. Privacy and Data Protection</h2>
                <i class="fas fa-chevron-down text-gray-500 transform transition-transform duration-200" id="privacy-icon"></i>
            </div>
        </button>
        <div id="privacy-content" class="hidden mt-4 space-y-4 text-gray-700 pl-4">
            <p>Your privacy is important to us. Our collection and use of personal information is governed by our <a href="/privacy" class="text-black underline hover:text-gray-700">Privacy Policy</a>, which is incorporated into these Terms by reference.</p>
            <p>We implement appropriate security measures to protect your personal information, but cannot guarantee absolute security of data transmitted over the internet.</p>
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                <h4 class="font-medium text-blue-900 mb-2">Data We Collect:</h4>
                <ul class="text-sm text-blue-800 space-y-1">
                    <li>• Personal information (name, email, student ID)</li>
                    <li>• Academic progress and assignment submissions</li>
                    <li>• Usage analytics and platform interactions</li>
                    <li>• Technical information (IP address, browser type)</li>
                </ul>
            </div>
        </div>
    </section>

    <!-- 6. Academic Integrity -->
    <section id="academic" class="collapsible-section">
        <button onclick="toggleSection('academic')" class="w-full text-left bg-gray-50 hover:bg-gray-100 p-4 rounded-lg border border-gray-200 transition-colors duration-200">
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-bold text-gray-900">6. Academic Integrity</h2>
                <i class="fas fa-chevron-down text-gray-500 transform transition-transform duration-200" id="academic-icon"></i>
            </div>
        </button>
        <div id="academic-content" class="hidden mt-4 space-y-4 text-gray-700 pl-4">
            <p>All users must maintain the highest standards of academic integrity. This includes:</p>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                    <h4 class="font-medium text-green-900 mb-2">Required Practices:</h4>
                    <ul class="text-sm text-green-800 space-y-1">
                        <li>• Completing original work</li>
                        <li>• Properly citing all sources</li>
                        <li>• Following collaboration guidelines</li>
                        <li>• Reporting suspected violations</li>
                    </ul>
                </div>
                <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                    <h4 class="font-medium text-red-900 mb-2">Violations Include:</h4>
                    <ul class="text-sm text-red-800 space-y-1">
                        <li>• Plagiarism or copying</li>
                        <li>• Unauthorized collaboration</li>
                        <li>• Sharing answers or solutions</li>
                        <li>• Using unauthorized materials</li>
                    </ul>
                </div>
            </div>
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                <p class="text-sm text-yellow-800">
                    <strong>Warning:</strong> Violations may result in course failure, suspension, or other disciplinary actions as outlined in the university's academic policies.
                </p>
            </div>
        </div>
    </section>

    <!-- 7. Payments and Refunds -->
    <section id="payments" class="collapsible-section">
        <button onclick="toggleSection('payments')" class="w-full text-left bg-gray-50 hover:bg-gray-100 p-4 rounded-lg border border-gray-200 transition-colors duration-200">
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-bold text-gray-900">7. Payments and Refunds</h2>
                <i class="fas fa-chevron-down text-gray-500 transform transition-transform duration-200" id="payments-icon"></i>
            </div>
        </button>
        <div id="payments-content" class="hidden mt-4 space-y-4 text-gray-700 pl-4">
            <p>Course fees and payment terms are subject to the university's financial policies. Refund eligibility depends on timing and circumstances.</p>
            <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                <h4 class="font-medium text-gray-900 mb-3">Payment & Refund Policy:</h4>
                <div class="space-y-2 text-sm text-gray-700">
                    <div class="flex justify-between">
                        <span>Full refund period:</span>
                        <span class="font-medium">First 7 days</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Partial refund (50%):</span>
                        <span class="font-medium">Days 8-14</span>
                    </div>
                    <div class="flex justify-between">
                        <span>No refund:</span>
                        <span class="font-medium">After 14 days</span>
                    </div>
                </div>
            </div>
            <p class="text-sm">All payment processing is handled securely through approved third-party processors. We do not store payment card information.</p>
        </div>
    </section>

    <!-- 8. Termination -->
    <section id="termination" class="collapsible-section">
        <button onclick="toggleSection('termination')" class="w-full text-left bg-gray-50 hover:bg-gray-100 p-4 rounded-lg border border-gray-200 transition-colors duration-200">
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-bold text-gray-900">8. Account Termination</h2>
                <i class="fas fa-chevron-down text-gray-500 transform transition-transform duration-200" id="termination-icon"></i>
            </div>
        </button>
        <div id="termination-content" class="hidden mt-4 space-y-4 text-gray-700 pl-4">
            <p>We may suspend or terminate your access for violations of these Terms or other reasons, with or without notice.</p>
            <div class="bg-orange-50 border border-orange-200 rounded-lg p-4">
                <h4 class="font-medium text-orange-900 mb-2">Termination Reasons:</h4>
                <ul class="text-sm text-orange-800 space-y-1">
                    <li>• Violation of Terms of Service</li>
                    <li>• Academic misconduct</li>
                    <li>• Fraudulent activity</li>
                    <li>• Inactive account (after 2+ years)</li>
                    <li>• Legal requirements</li>
                </ul>
            </div>
            <p>Upon termination, your right to use the LMS ceases immediately. We may retain certain information as required by law or for legitimate business purposes.</p>
        </div>
    </section>

    <!-- 9. Disclaimers -->
    <section id="disclaimers" class="collapsible-section">
        <button onclick="toggleSection('disclaimers')" class="w-full text-left bg-gray-50 hover:bg-gray-100 p-4 rounded-lg border border-gray-200 transition-colors duration-200">
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-bold text-gray-900">9. Disclaimers and Limitation of Liability</h2>
                <i class="fas fa-chevron-down text-gray-500 transform transition-transform duration-200" id="disclaimers-icon"></i>
            </div>
        </button>
        <div id="disclaimers-content" class="hidden mt-4 space-y-4 text-gray-700 pl-4">
            <p>The LMS is provided "as is" without warranties of any kind. TARUMT disclaims all warranties, express or implied.</p>
            <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                <h4 class="font-medium text-red-900 mb-2">Limitation of Liability:</h4>
                <p class="text-sm text-red-800">
                    To the fullest extent permitted by law, TARUMT shall not be liable for any indirect, incidental, special, 
                    consequential, or punitive damages arising from your use of the LMS, including but not limited to loss of data, 
                    revenue, or educational opportunities.
                </p>
            </div>
        </div>
    </section>

    <!-- 10. Contact Information -->
    <section id="contact" class="collapsible-section">
        <button onclick="toggleSection('contact')" class="w-full text-left bg-gray-50 hover:bg-gray-100 p-4 rounded-lg border border-gray-200 transition-colors duration-200">
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-bold text-gray-900">10. Contact Information</h2>
                <i class="fas fa-chevron-down text-gray-500 transform transition-transform duration-200" id="contact-icon"></i>
            </div>
        </button>
        <div id="contact-content" class="hidden mt-4 space-y-4 text-gray-700 pl-4">
            <p>If you have questions about these Terms of Service, please contact us:</p>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                    <h4 class="font-medium text-gray-900 mb-3">Legal Department</h4>
                    <div class="space-y-2 text-sm">
                        <div class="flex items-center">
                            <i class="fas fa-envelope w-4 mr-3 text-gray-400"></i>
                            <a href="mailto:legal@tarumt.edu" class="text-black hover:underline">legal@tarumt.edu</a>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-phone w-4 mr-3 text-gray-400"></i>
                            <span>+603 1234 5678 ext. 201</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-clock w-4 mr-3 text-gray-400"></i>
                            <span>Mon-Fri 9AM-5PM MYT</span>
                        </div>
                    </div>
                </div>
                
                <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                    <h4 class="font-medium text-gray-900 mb-3">Student Support</h4>
                    <div class="space-y-2 text-sm">
                        <div class="flex items-center">
                            <i class="fas fa-envelope w-4 mr-3 text-gray-400"></i>
                            <a href="mailto:support@tarumt.edu" class="text-black hover:underline">support@tarumt.edu</a>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-phone w-4 mr-3 text-gray-400"></i>
                            <span>+603 1234 5678</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-clock w-4 mr-3 text-gray-400"></i>
                            <span>24/7 Online Support</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Effective Date -->
    <div class="mt-12 pt-8 border-t border-gray-200">
        <div class="bg-blue-50 rounded-lg p-6 border border-blue-200">
            <div class="flex items-start">
                <i class="fas fa-info-circle text-blue-500 mt-1 mr-3"></i>
                <div>
                    <h4 class="text-sm font-medium text-blue-900 mb-1">Effective Date</h4>
                    <p class="text-sm text-blue-800">
                        These Terms of Service are effective as of <?= date('F j, Y') ?> and supersede all previous versions. 
                        By continuing to use the TARUMT LMS after this date, you agree to these updated terms.
                    </p>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Enhanced JavaScript for collapsible sections -->
<script>
function toggleSection(sectionId) {
    const content = document.getElementById(sectionId + '-content');
    const icon = document.getElementById(sectionId + '-icon');
    
    if (content.classList.contains('hidden')) {
        content.classList.remove('hidden');
        icon.classList.add('rotate-180');
        
        // Smooth scroll to section
        document.getElementById(sectionId).scrollIntoView({ 
            behavior: 'smooth', 
            block: 'start' 
        });
    } else {
        content.classList.add('hidden');
        icon.classList.remove('rotate-180');
    }
}

// Auto-expand section if hash matches
document.addEventListener('DOMContentLoaded', function() {
    const hash = window.location.hash.substring(1);
    if (hash) {
        setTimeout(() => {
            toggleSection(hash);
        }, 100);
    }
});

// Expand All / Collapse All functionality
function toggleAllSections(expand = true) {
    const sections = ['acceptance', 'accounts', 'usage', 'content', 'privacy', 'academic', 'payments', 'termination', 'disclaimers', 'contact'];
    
    sections.forEach(sectionId => {
        const content = document.getElementById(sectionId + '-content');
        const icon = document.getElementById(sectionId + '-icon');
        
        if (expand && content.classList.contains('hidden')) {
            content.classList.remove('hidden');
            icon.classList.add('rotate-180');
        } else if (!expand && !content.classList.contains('hidden')) {
            content.classList.add('hidden');
            icon.classList.remove('rotate-180');
        }
    });
}

// Add expand/collapse all buttons to the page
document.addEventListener('DOMContentLoaded', function() {
    const tableOfContents = document.querySelector('.bg-gray-50.rounded-lg.p-6');
    if (tableOfContents) {
        const buttonContainer = document.createElement('div');
        buttonContainer.className = 'mt-4 flex gap-2';
        buttonContainer.innerHTML = `
            <button onclick="toggleAllSections(true)" class="px-3 py-1 text-xs bg-black text-white rounded hover:bg-gray-800 transition-colors">
                Expand All
            </button>
            <button onclick="toggleAllSections(false)" class="px-3 py-1 text-xs bg-gray-300 text-gray-700 rounded hover:bg-gray-400 transition-colors">
                Collapse All
            </button>
        `;
        tableOfContents.appendChild(buttonContainer);
    }
});
</script>

<?php
$content = ob_get_clean();
include '../app/Views/layouts/legal.php';
?>