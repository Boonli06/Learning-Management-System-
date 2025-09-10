<?php
// 数据现在由Controller传递，直接开始页面内容
ob_start();
?>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    
    <!-- Main Pricing Form -->
    <div class="lg:col-span-2 space-y-8">
        
        <!-- Current Pricing Overview -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Current Pricing</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="text-center p-4 bg-gray-50 rounded-lg">
                    <div class="text-2xl font-bold text-gray-900"><?= $course['currency'] ?> <?= $course['price'] ?></div>
                    <div class="text-sm text-gray-500">Current Price</div>
                    <?php if ($course['compare_price'] > $course['price']): ?>
                    <div class="text-xs text-red-600 mt-1">
                        <?= round((($course['compare_price'] - $course['price']) / $course['compare_price']) * 100) ?>% OFF
                    </div>
                    <?php endif; ?>
                </div>
                <div class="text-center p-4 bg-gray-50 rounded-lg">
                    <div class="text-2xl font-bold text-green-600"><?= $course['currency'] ?> <?= number_format(8950) ?></div>
                    <div class="text-sm text-gray-500">Total Revenue</div>
                    <div class="text-xs text-gray-600 mt-1">45 sales</div>
                </div>
                <div class="text-center p-4 bg-gray-50 rounded-lg">
                    <div class="text-2xl font-bold text-blue-600"><?= $course['currency'] ?> <?= round(8950 / 45) ?></div>
                    <div class="text-sm text-gray-500">Avg per Sale</div>
                    <div class="text-xs text-gray-600 mt-1">Based on 45 orders</div>
                </div>
            </div>
        </div>

        <!-- Pricing Form -->
        <form id="pricingForm" method="POST" action="/instructor/courses/<?= $course['id'] ?>/pricing" class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-6">Update Pricing</h3>
            
            <!-- Pricing Type -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-3">Pricing Type</label>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <label class="relative flex items-center p-4 border border-gray-300 rounded-lg hover:bg-gray-50 cursor-pointer">
                        <input type="radio" name="pricing_type" value="paid" <?= $course['pricing_type'] === 'paid' ? 'checked' : '' ?> class="text-black focus:ring-black" onchange="togglePricingInputs()">
                        <div class="ml-3">
                            <div class="text-sm font-medium text-gray-900">Paid Course</div>
                            <div class="text-xs text-gray-500">Students pay to access the course</div>
                        </div>
                    </label>
                    <label class="relative flex items-center p-4 border border-gray-300 rounded-lg hover:bg-gray-50 cursor-pointer">
                        <input type="radio" name="pricing_type" value="free" <?= $course['pricing_type'] === 'free' ? 'checked' : '' ?> class="text-black focus:ring-black" onchange="togglePricingInputs()">
                        <div class="ml-3">
                            <div class="text-sm font-medium text-gray-900">Free Course</div>
                            <div class="text-xs text-gray-500">Free access to build audience</div>
                        </div>
                    </label>
                </div>
            </div>

            <!-- Price Settings -->
            <div id="priceSettings" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Current Price -->
                    <div>
                        <label for="current_price" class="block text-sm font-medium text-gray-700 mb-2">
                            Course Price (<?= $course['currency'] ?>)
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500"><?= $course['currency'] ?></span>
                            </div>
                            <input 
                                type="number" 
                                id="current_price" 
                                name="current_price" 
                                value="<?= $course['price'] ?>"
                                class="block w-full pl-12 border border-gray-300 rounded-lg px-3 py-2 focus:ring-black focus:border-black" 
                                min="0"
                                step="0.01"
                                oninput="updatePricePreview()"
                            >
                        </div>
                        <p class="mt-1 text-xs text-gray-500">Recommended: <?= $course['currency'] ?> 149 - <?= $course['currency'] ?> 249</p>
                    </div>

                    <!-- Original Price (for discount display) -->
                    <div>
                        <label for="original_price" class="block text-sm font-medium text-gray-700 mb-2">
                            Original Price (Optional)
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500"><?= $course['currency'] ?></span>
                            </div>
                            <input 
                                type="number" 
                                id="original_price" 
                                name="original_price" 
                                value="<?= $course['compare_price'] ?>"
                                class="block w-full pl-12 border border-gray-300 rounded-lg px-3 py-2 focus:ring-black focus:border-black" 
                                min="0"
                                step="0.01"
                                oninput="updatePricePreview()"
                            >
                        </div>
                        <p class="mt-1 text-xs text-gray-500">Shows discount percentage if higher than current price</p>
                    </div>
                </div>

                <!-- Price Tier -->
                <div>
                    <label for="tier" class="block text-sm font-medium text-gray-700 mb-2">Price Tier</label>
                    <select 
                        id="tier" 
                        name="tier" 
                        class="block w-full max-w-md border border-gray-300 rounded-lg px-3 py-2 focus:ring-black focus:border-black"
                    >
                        <option value="basic">Basic (<?= $course['currency'] ?> 49 - <?= $course['currency'] ?> 99)</option>
                        <option value="standard">Standard (<?= $course['currency'] ?> 100 - <?= $course['currency'] ?> 199)</option>
                        <option value="premium" selected>Premium (<?= $course['currency'] ?> 200 - <?= $course['currency'] ?> 399)</option>
                        <option value="enterprise">Enterprise (<?= $course['currency'] ?> 400+)</option>
                    </select>
                </div>

                <!-- Promotional Options -->
                <div>
                    <h4 class="text-sm font-medium text-gray-900 mb-3">Promotional Options</h4>
                    <div class="space-y-3">
                        <label class="flex items-center">
                            <input type="checkbox" name="enable_coupons" value="1" class="text-black focus:ring-black">
                            <span class="ml-2 text-sm text-gray-700">Allow coupon codes</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="enable_bulk_discount" value="1" class="text-black focus:ring-black">
                            <span class="ml-2 text-sm text-gray-700">Bulk purchase discounts</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="early_bird_pricing" value="1" class="text-black focus:ring-black">
                            <span class="ml-2 text-sm text-gray-700">Early bird pricing for new releases</span>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Preview -->
            <div class="mt-8 p-4 bg-gray-50 rounded-lg">
                <h4 class="text-sm font-medium text-gray-900 mb-3">Price Display Preview</h4>
                <div class="flex items-center gap-4">
                    <div class="text-2xl font-bold text-gray-900" id="previewCurrentPrice"><?= $course['currency'] ?> <?= $course['price'] ?></div>
                    <div class="text-lg text-gray-500 line-through" id="previewOriginalPrice" style="<?= $course['compare_price'] <= $course['price'] ? 'display: none;' : '' ?>"><?= $course['currency'] ?> <?= $course['compare_price'] ?></div>
                    <div class="text-sm bg-red-100 text-red-800 px-2 py-1 rounded" id="previewDiscount" style="<?= $course['compare_price'] <= $course['price'] ? 'display: none;' : '' ?>">
                        <?= $course['compare_price'] > $course['price'] ? round((($course['compare_price'] - $course['price']) / $course['compare_price']) * 100) : 0 ?>% OFF
                    </div>
                </div>
            </div>

        </form>

        <!-- Pricing History -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Pricing History</h3>
            <div class="space-y-4">
                <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg">
                    <div>
                        <div class="font-medium text-gray-900"><?= $course['currency'] ?> 299</div>
                        <div class="text-sm text-gray-500">Jan 10, 2024</div>
                        <div class="text-xs text-blue-600">New Year Sale</div>
                    </div>
                    <div class="text-right">
                        <div class="text-sm font-medium text-gray-900">40 sales</div>
                        <div class="text-xs text-gray-500">Revenue: <?= $course['currency'] ?> <?= number_format(299 * 40) ?></div>
                    </div>
                </div>
                <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg">
                    <div>
                        <div class="font-medium text-gray-900"><?= $course['currency'] ?> 199</div>
                        <div class="text-sm text-gray-500">Jan 15, 2024</div>
                    </div>
                    <div class="text-right">
                        <div class="text-sm font-medium text-gray-900">5 sales</div>
                        <div class="text-xs text-gray-500">Revenue: <?= $course['currency'] ?> <?= number_format(199 * 5) ?></div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Sidebar -->
    <div class="space-y-6">
        
        <!-- Price Recommendations -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Pricing Recommendations</h3>
            <div class="space-y-4">
                <div class="flex justify-between items-center p-3 bg-green-50 rounded-lg border border-green-200">
                    <span class="text-sm font-medium text-green-900">Optimal Price</span>
                    <span class="text-sm font-bold text-green-900"><?= $course['currency'] ?> 199</span>
                </div>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Market Average:</span>
                        <span class="font-medium"><?= $course['currency'] ?> 195</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Suggested Range:</span>
                        <span class="font-medium"><?= $course['currency'] ?> 149 - <?= $course['currency'] ?> 249</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Market Comparison -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Market Comparison</h3>
            <div class="space-y-4">
                <div class="border-b border-gray-200 pb-3 last:border-b-0">
                    <div class="text-sm font-medium text-gray-900 mb-1">Similar Laravel Course A</div>
                    <div class="flex justify-between items-center">
                        <span class="text-lg font-bold text-gray-900"><?= $course['currency'] ?> 179</span>
                        <div class="text-right text-xs text-gray-500">
                            <div><i class="fas fa-star text-yellow-400"></i> 4.5</div>
                            <div>1,200 students</div>
                        </div>
                    </div>
                </div>
                <div class="border-b border-gray-200 pb-3 last:border-b-0">
                    <div class="text-sm font-medium text-gray-900 mb-1">Advanced Laravel Development</div>
                    <div class="flex justify-between items-center">
                        <span class="text-lg font-bold text-gray-900"><?= $course['currency'] ?> 249</span>
                        <div class="text-right text-xs text-gray-500">
                            <div><i class="fas fa-star text-yellow-400"></i> 4.7</div>
                            <div>890 students</div>
                        </div>
                    </div>
                </div>
                <div class="border-b border-gray-200 pb-3 last:border-b-0">
                    <div class="text-sm font-medium text-gray-900 mb-1">Laravel Complete Guide</div>
                    <div class="flex justify-between items-center">
                        <span class="text-lg font-bold text-gray-900"><?= $course['currency'] ?> 159</span>
                        <div class="text-right text-xs text-gray-500">
                            <div><i class="fas fa-star text-yellow-400"></i> 4.3</div>
                            <div>2,100 students</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Revenue Projections -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Revenue Projections</h3>
            <div class="space-y-3">
                <div class="flex justify-between p-2 bg-gray-50 rounded">
                    <span class="text-sm text-gray-600">At <?= $course['currency'] ?> 149:</span>
                    <span class="text-sm font-medium">~<?= $course['currency'] ?> <?= number_format(149 * 60) ?>/month</span>
                </div>
                <div class="flex justify-between p-2 bg-green-50 rounded border border-green-200">
                    <span class="text-sm text-green-700">At <?= $course['currency'] ?> 199:</span>
                    <span class="text-sm font-medium text-green-700">~<?= $course['currency'] ?> <?= number_format(199 * 50) ?>/month</span>
                </div>
                <div class="flex justify-between p-2 bg-gray-50 rounded">
                    <span class="text-sm text-gray-600">At <?= $course['currency'] ?> 249:</span>
                    <span class="text-sm font-medium">~<?= $course['currency'] ?> <?= number_format(249 * 35) ?>/month</span>
                </div>
            </div>
            <p class="text-xs text-gray-500 mt-3">*Based on similar courses and market data</p>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>
            <div class="space-y-3">
                <button type="button" class="w-full bg-gray-100 text-gray-700 px-4 py-2 rounded-lg text-sm hover:bg-gray-200 transition-colors duration-200" onclick="setOptimalPrice()">
                    Set Optimal Price
                </button>
                <button type="button" class="w-full bg-gray-100 text-gray-700 px-4 py-2 rounded-lg text-sm hover:bg-gray-200 transition-colors duration-200" onclick="window.open('/instructor/courses/<?= $course['id'] ?>/coupons', '_blank')">
                    Create Coupon
                </button>
                <button type="button" class="w-full bg-gray-100 text-gray-700 px-4 py-2 rounded-lg text-sm hover:bg-gray-200 transition-colors duration-200" onclick="exportPricingData()">
                    Export Pricing Data
                </button>
            </div>
        </div>

    </div>

</div>

<script>
// Toggle pricing inputs based on type
function togglePricingInputs() {
    const pricingType = document.querySelector('input[name="pricing_type"]:checked').value;
    const priceSettings = document.getElementById('priceSettings');
    
    if (pricingType === 'free') {
        priceSettings.style.opacity = '0.5';
        priceSettings.style.pointerEvents = 'none';
        document.getElementById('current_price').value = 0;
        updatePricePreview();
    } else {
        priceSettings.style.opacity = '1';
        priceSettings.style.pointerEvents = 'auto';
    }
}

// Update price preview
function updatePricePreview() {
    const currentPrice = parseFloat(document.getElementById('current_price').value) || 0;
    const originalPrice = parseFloat(document.getElementById('original_price').value) || 0;
    
    document.getElementById('previewCurrentPrice').textContent = `<?= $course['currency'] ?> ${currentPrice}`;
    
    if (originalPrice > currentPrice && currentPrice > 0) {
        document.getElementById('previewOriginalPrice').textContent = `<?= $course['currency'] ?> ${originalPrice}`;
        document.getElementById('previewOriginalPrice').style.display = 'block';
        
        const discountPercent = Math.round(((originalPrice - currentPrice) / originalPrice) * 100);
        document.getElementById('previewDiscount').textContent = `${discountPercent}% OFF`;
        document.getElementById('previewDiscount').style.display = 'block';
    } else {
        document.getElementById('previewOriginalPrice').style.display = 'none';
        document.getElementById('previewDiscount').style.display = 'none';
    }
}

// Set optimal price
function setOptimalPrice() {
    document.getElementById('current_price').value = 199;
    updatePricePreview();
}

// Export pricing data
function exportPricingData() {
    alert('Pricing data export started. You will receive a download link shortly.');
}

// Form submission
document.getElementById('pricingForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const currentPrice = document.getElementById('current_price').value;
    const pricingType = document.querySelector('input[name="pricing_type"]:checked').value;
    
    if (pricingType === 'paid' && (!currentPrice || currentPrice <= 0)) {
        alert('Please enter a valid price for paid courses.');
        return;
    }
    
    alert('Pricing updated successfully!');
});

// Initialize
document.addEventListener('DOMContentLoaded', function() {
    togglePricingInputs();
});
</script>

<?php
$content = ob_get_clean();
include '../app/Views/layouts/instructor.php';
?>