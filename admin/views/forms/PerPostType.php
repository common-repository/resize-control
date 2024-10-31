<?php
    if (!defined('ABSPATH')) exit; // Exit if accessed directly      
?>
        <div class="pt-6 ml-6" id="imageSettingsGeneral">
                <div class="flex items-start justify-between">
                    <div>
                    <h2 class="text-2xl font-semibold font-inter"><?php _e('Resize settings for all media', 'resize-control'); ?></h2>
                    <p class="text-sm text-tuning-text font-inter"><?php _e('Select your resize settings for all post types', 'resize-control'); ?></p>
                    </div>
                    <a id="saveSettings" href="#" class="mr-6 reco-button"><?php _e('Save', 'resize-control'); ?></a>
                </div>
                <div class="rounded-md border-[1px] border-tuning-stroke max-w-[600px] mt-6">
                    <div class="py-3 px-5 border-b-[1px] border-tuning-stroke">
                        <p class="text-base font-medium"><?php _e('Resize', 'resize-control'); ?></p>
                    </div>
                        <div class="p-5">
                        <label for="width" class="block text-base font-medium"><?php _e('Image dimensions', 'resize-control'); ?></label>
                        <div class="flex w-full gap-5">
                            <div class="w-1/2">
                                <div class="flex mt-2 rounded-md shadow-sm">
                                    <div class="relative flex items-stretch flex-grow focus-within:z-10">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                                        <svg width="23" height="9" viewBox="0 0 23 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M21.9252 4.66726L18.7432 7.84924M21.9252 4.66726L18.7432 1.48528M21.9252 4.66726L14.5006 4.66726M1.00066 4.66719L4.18264 7.84917M1.00066 4.66719L4.18264 1.48521M1.00066 4.66719H8.42528" stroke="#828F9A" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>

                                    </div>
                                    <input type="number" name="width" value='<?php echo esc_attr($width) ?>' id="widthGeneral" class="block w-full pl-12 border-gray-300 rounded-none focus:ring-tuning-blue focus:border-tuning-blue rounded-l-md sm:text-sm" placeholder="700">
                                    </div>
                                    <button type="button" class="relative inline-flex items-center px-4 py-2 -ml-px space-x-2 text-sm font-medium text-gray-400 border border-gray-300 rounded-r-md bg-gray-50 hover:bg-gray-100 focus:outline-none focus:ring-1 focus:ring-tuning-blue focus:border-tuning-blue">
                                    <span>Px</span>
                                    </button>
                                </div>
                            </div>
                            <div class="w-1/2">
                                <div class="flex mt-2 rounded-md shadow-sm">
                                    <div class="relative flex items-stretch flex-grow focus-within:z-10">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg width="9" height="23" viewBox="0 0 9 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M4.4623 1.20493L7.64428 4.38692M4.4623 1.20493L1.28032 4.38692M4.4623 1.20493L4.4623 8.62956M4.46223 22.1295L7.64421 18.9475M4.46223 22.1295L1.28025 18.9475M4.46223 22.1295V14.7048" stroke="#828F9A" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>

                                    </div>
                                    <input type="number" value='<?php echo esc_attr($height) ?>' name="height" id="heightGeneral" class="block w-full pl-10 border-gray-300 rounded-none focus:ring-tuning-blue focus:border-tuning-blue rounded-l-md sm:text-sm" placeholder="700">
                                    </div>
                                    <button type="button" class="relative inline-flex items-center px-4 py-2 -ml-px space-x-2 text-sm font-medium text-gray-400 border border-gray-300 rounded-r-md bg-gray-50 hover:bg-gray-100 focus:outline-none focus:ring-1 focus:ring-tuning-blue focus:border-tuning-blue">
                                    <span>Px</span>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="mt-5">
                            <?php
                            $resize = isset($general['enableResizeDimensions']) ? $general['enableResizeDimensions'] : '';
                            if ($resize == 'true') {
                                $resize = 'checked';
                            } else {
                                $resize = '';
                            }
                            ?>
                            <p class="mb-2 text-base font-medium"><?php _e('Resize dimensions', 'resize-control'); ?></p>
                            <label class="switch">
                                <input name="resizeDimensions" class="resizeDimensions" type="checkbox" <?php echo esc_attr($resize) ?>>
                                <span class="slider round"></span>
                            </label>
                        </div>

                        <div class="relative">
                            <a href="https://tuningwp.com/resize-control/#get" target="_blank" class="absolute z-10 px-3 py-1 text-base font-medium text-black bg-white rounded-full shadow -right-3 top-3 proLock font-inter">
                                Pro
                                <img class="inline" src="<?php echo esc_attr(plugins_url('assets/lock.svg', dirname(__FILE__, 2))) ?>" />
                            </a>
                            <section class="cursor-not-allowed pointer-events-none opacity-40">
                                <div class="mt-5">
                                    <label for="method" class="block text-base font-medium"><?php _e('Resize method', 'resize-control'); ?></label>
                                    <select id="method" name="method" class="block w-full !max-w-full py-2 pl-3 pr-10 mt-1 text-base border-gray-300 rounded-md focus:outline-none focus:ring-tuning-blue sm:text-sm">
                                        <option>Scale</option>
                                    </select>
                                </div>
                            </section>
                        </div>

                        <div class="relative">
                            <a href="https://tuningwp.com/resize-control/#get" target="_blank" class="absolute z-10 px-3 py-1 text-base font-medium text-black bg-white rounded-full shadow -right-3 top-3 proLock font-inter">
                                Pro
                                <img class="inline" src="<?php echo esc_attr(plugins_url('assets/lock.svg', dirname(__FILE__, 2))) ?>" />
                            </a>
                            <section class="cursor-not-allowed pointer-events-none opacity-40">
                            <div class="mt-5">
                                <label for="bgcolor" class="block text-base font-medium"><?php _e('Background color', 'resize-control'); ?></label>
                                <div class="flex gap-5 mt-1">
                                    <input type="text" name="bgcolor" id="bgcolor" class="block w-full py-2 pl-3 border-gray-300 rounded-md shadow-sm focus:ring-tuning-blue focus:border-tuning-blue sm:text-sm" placeholder="#FFFFFF">
                                    <div class="flex-shrink-0 w-10 h-10 border border-gray-300 rounded"></div>
                                </div>
                            </div>
                            </section>
                        </div>
                    </div>
                </div>
                <div class="rounded-md border-[1px] border-tuning-stroke max-w-[600px] mt-6">
                    <div class="py-3 px-5 border-b-[1px] border-tuning-stroke">
                        <p class="text-base font-medium"><?php _e('Convert/compress', 'resize-control'); ?></p>
                    </div>
                    <div class="p-5 -mt-5">
                        <div class="relative">
                            <a href="https://tuningwp.com/resize-control/#get" target="_blank" class="absolute z-10 px-3 py-1 text-base font-medium text-black bg-white rounded-full shadow -right-3 top-3 proLock font-inter">
                                Pro
                                <img class="inline" src="<?php echo esc_attr(plugins_url('assets/lock.svg', dirname(__FILE__, 2))) ?>" />
                            </a>
                            <section class="cursor-not-allowed pointer-events-none opacity-40">
                                <div class="mt-5">
                                    <label for="method" class="block text-base font-medium"><?php _e('Convert all to file format', 'resize-control'); ?></label>
                                    <select id="method" name="method" class="block w-full !max-w-full py-2 pl-3 pr-10 mt-1 text-base border-gray-300 rounded-md focus:outline-none focus:ring-tuning-blue sm:text-sm">
                                        <option>JPG</option>
                                    </select>
                                </div>
                            </section>
                        </div>
                        <div class="mt-5">
                            <?php
                            $convert = isset($general['convert']) ? $general['convert'] : '';
                            if ($convert == 'true') {
                                $convert = 'checked';
                            } else {
                                $convert = '';
                            }
                            ?>
                            <p class="mb-2 text-base font-medium"><?php _e('Convert PNG to JPG', 'resize-control'); ?></p>
                            <label class="switch">
                                <input name="convertPngToJpg" type="checkbox" <?php echo esc_attr($convert) ?>>
                                <span class="slider round"></span>
                            </label>
                        </div>
                        <div class="pb-5 mt-5">
                            <p class="mb-2 text-base font-medium"><?php _e('Compression level', 'resize-control'); ?>
                                <span tooltip="<?php _e('The higher the number, the smaller the file', 'resize-control'); ?>" class="inline-block cursor-help ml-1 w-6 h-6 leading-[1.4rem] text-center align-middle border border-gray-300 border-solid rounded-full">
                                    i
                                </span>
                            </p>
                            <?php
                            $compression = isset($general['compression']) ? $general['compression'] : 0;
                            $progress = ($compression / 100) * 100;
                            ?>
                            <div class="range">
                                <input style="<?php echo esc_attr("background: linear-gradient(to right, #4272F9 {$progress}0%, #ccc {$progress}%)") ?>" type="range" min="0" max="10" value="<?php echo esc_attr($compression) ?>" id="range2" class="range-input" /> 
                                <div class="inline float-left text-sm font-medium text-gray-500 value2"><?php echo esc_attr($compression) ?></div>
                                <div class="inline float-right text-sm font-medium text-gray-500">10</div>
                            </div>
                        </div>
                    </div>
                </div>
                <a id="saveSettings" href="#" class="my-6 mr-6 reco-button"><?php _e('Save', 'resize-control'); ?></a>
        </div>