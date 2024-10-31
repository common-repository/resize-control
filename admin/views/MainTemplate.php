<?php

$settings = Reco\RecoSettings::getSettings(true);
if (defined('RECO_PREMIUM_PLUGINFILE')) {
    $license = new Reco\Premium\RecoLicense();
    $licenseData = $license->getLicenseData();
    $valid = $license->isValidRegistration($licenseData) ? true : false;
    $licenseKey = isset($licenseData['key']) ? $licenseData['key'] : '';
    $validUntil = isset($licenseData['validuntil']) ? $licenseData['validuntil'] : '';
}
?>
<main class="h-full mt-6 mr-6 bg-white rounded-md shadow-md">
    <header class="p-4 border-b-[1px] border-tuning-stroke">
        <img class="inline-block" src="<?php echo esc_attr(plugins_url('assets/logo.svg', dirname(__FILE__))) ?>" />
        <div class="inline-block ml-2 align-middle">
            <h1 class="p-0 m-0 text-lg font-semibold font-inter">Resize Control</h1>
            <p class="text-sm text-tuning-text font-inter"><?php _e('Control all future uploads', 'resize-control'); ?></p>
        </div>
        <div class="inline-block float-right ml-2 align-right">
            <?php
                $name = __('Mr. Unknown', 'resize-control');
                $plan = __('Free plan', 'resize-control');
                if (defined('RECO_PREMIUM_PLUGINFILE') && $valid) {
                    $name = $license->getName() ?? __('Mr. Unknown', 'resize-control');
                    $plan = __('Pro plan', 'resize-control');
                }
            ?>
            <h4 class="p-0 m-0 text-base font-medium text-right font-inter"><?php echo esc_html($name) ?></h4>
            <p class="text-sm text-right text-tuning-text font-inter"><?php echo esc_html($plan) ?></p>
        </div>
    </header>
    <div class="flex">
        <aside class="w-1/6 pt-6">
            <button id="openDefault" class="py-2 tablinks" onclick="openTab(event, 'general')">
                <img class="inline pl-10 pr-1" src="<?php echo esc_attr(plugins_url('assets/settings.svg', dirname(__FILE__))) ?>" />
                <p class="inline text-base font-medium align-middle font-inter"><?php _e('General', 'resize-control'); ?></p>
            </button>
            <button id="perPostType" class="pt-2 tablinks" onclick="openTab(event, 'perposttype', 'perPostType')">
                <img class="inline pl-10 pr-1" src="<?php echo esc_attr(plugins_url('assets/grid.svg', dirname(__FILE__))) ?>" />
                <p class="inline text-base font-medium align-middle text-tuning-text font-inter"><?php _e('Resize options', 'resize-control'); ?></p>
                <div class="pl-16 mt-2 bg-white">
                    <?php 
                        if (defined('RECO_PREMIUM_PLUGINFILE') && $valid) {
                            ?>
                            <ul class="relative pb-2 post-sublist">
                                <?php
                                    $postTypes = get_post_types(array('public' => true), 'objects');

                                    //Remove media from the list
                                    unset($postTypes['attachment']);

                                    //Add general to the top of the list
                                    $postTypes = array_merge(['general' => (object) ['labels' => (object) ['name' => __('All media', 'resize-control')], 'name' => 'perposttypeform']], $postTypes);
                                    

                                    foreach ($postTypes as $postType) {
                                        $name = $postType->labels->name;
                                        $slug = $postType->name;
                                        ?>

                                        <li id="menu-item-<?php echo esc_attr($slug) ?>" onclick="openTab(event, '<?php echo esc_attr($slug) ?>', 'perPostType')" class="relative pt-2 text-base font-normal text-left font-inter text-tuning-text">
                                            <?php echo esc_html($name) ?>
                                        </li>
                                    <?php
                                    }
                                ?>
                            </ul>
                        <?php 
                        }
                    ?>
                </div>
            </button>
        </aside>
        <section class="w-5/6  border-l-[1px] border-tuning-stroke">
            <div id="general" class="pt-6 ml-6 tabcontent">
                <div class="flex items-start justify-between">
                    <div>
                    <h2 class="text-2xl font-semibold font-inter"><?php _e('General', 'resize-control'); ?></h2>
                    <p class="text-sm text-tuning-text font-inter"><?php _e('Set your global preferences', 'resize-control'); ?></p>
                    </div>
                    <a id="saveSettings" href="#" class="mr-6 reco-button"><?php _e('Save', 'resize-control'); ?></a>
                </div>
                <div class="rounded-md border-[1px] border-tuning-stroke max-w-[600px] mt-6">
                    <div class="py-3 px-5 border-b-[1px] border-tuning-stroke">
                        <p class="text-base font-medium"><?php _e('Settings', 'resize-control'); ?></p>
                    </div>
                    <div class="p-5">
                        <div class="mb-8">
                            <p class="mb-2 text-base font-medium"><?php _e('Ignore roles', 'resize-control'); ?></p>

                            <?php
                            //Get all available roles
                            $roles = get_editable_roles();
                            ob_start();
                            foreach ($roles as $key => $role) {
                                $name = $role['name'];
                                $slug = $key;

                                //$settings['ignoredroles'] is a comma seperated string of ignored roles we need to convert to an array
                                if (isset($settings['ignoredroles'])) {
                                    $ignoredroles = explode(',', $settings['ignoredroles']);
                                } else {
                                    $ignoredroles = [];
                                }

                                //if $settings['ignoredroles'] contains $slug, add checked to the checkbox
                                if (in_array($slug, $ignoredroles)) {
                                    $checked = 'checked';
                                } else {
                                    $checked = '';
                                }
                                ?>
                                <label class="check-button-small role-to-ignore">
                                    <input data-name="<?php echo esc_attr($slug) ?>" type="checkbox" <?php echo esc_attr($checked)?>>
                                    <span class="my-[3px]">
                                        <?php echo esc_html($name) ?>
                                    </span>
                                </label>
                                <?php
                            }
                            echo wp_kses(ob_get_clean(), [
                                'input' => [
                                    'data-name' => [],
                                    'type' => [],
                                    'checked' => [],
                                ],
                                'label' => [
                                    'class' => [],
                                ],
                                'span' => [
                                    'class' => [],
                                ],
                            ]);
                            ?>
                        </div>
                        <div>
                            <?php
                            //enable resize
                            $checked = 'checked';
                            if (isset($settings['enableresize'])) {
                                if ($settings['enableresize'] == 1) {
                                    $checked = 'checked';
                                }
                            }
                            ?>
                            <style>
                                input:checked + .slider:before {
                                    background-image: url("<?php echo esc_attr(plugins_url('assets/check.svg', dirname(__FILE__))) ?>");
                                }
                            </style>
                            <p class="mb-2 text-base font-medium"><?php _e('Enable resize', 'resize-control'); ?></p>
                            <label class="switch enableresize">
                                <input type="checkbox" <?php echo esc_attr($checked) ?>>
                                <span class="slider round"></span>
                            </label>
                        </div>
                    </div>
                </div>
                <?php
                    if (defined('RECO_PREMIUM_PLUGINFILE')) { 
                ?>
                <div class="mb-6 rounded-md border-[1px] border-tuning-stroke max-w-[600px] mt-6">
                    <div class="py-3 px-5 border-b-[1px] border-tuning-stroke">
                        <p class="text-base font-medium"><?php _e('License', 'resize-control'); ?></p>
                    </div>

                    <div class="p-5">
                        <div>
                            <p class="mb-2 text-base font-medium"><?php _e('License key', 'resize-control'); ?></p>
                                <div class="flex mt-2">
                                    <form action="<?php echo admin_url('admin-post.php')?>" method="post" class="w-full">
                                        <div class="relative flex items-stretch flex-grow focus-within:z-10">                                        
                                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#828f9a" class="w-[20px] h-[20px]">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25a3 3 0 0 1 3 3m3 0a6 6 0 0 1-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1 1 21.75 8.25Z" />
                                            </svg>
                                            </div>
                                        <input type="text" value='<?php echo esc_attr($licenseKey) ?>' name="license" id="licenseGeneral" class="block w-full px-4 py-2 pl-10 border-gray-300 rounded-md focus:ring-tuning-blue focus:border-tuning-blue sm:text-sm" placeholder="" required <?php echo esc_attr($valid ? 'readonly' : '') ?> >
                                        </div>
                                        <?php wp_nonce_field('recoConnect'); ?>
                                        <?php if ($valid) { ?>
                                            <div class="inline-flex p-6 mt-6 mr-6 rounded-md shadow">
                                                    <div class="roundedp-[14px]">
                                                        <img class="inline" src="<?php echo esc_attr(plugins_url('assets/greencheck.svg', dirname(__FILE__))) ?>" />
                                                    </div>
                                                    <div class="pl-[14px]">
                                                        <p class="inline text-base font-medium text-black font-inter"><b><?php _e('Active', 'resize-control'); ?></b></p>
                                                        <p class="text-sm text-tuning-text font-inter"><?php _e('Your code is valid until ', 'resize-control'); echo esc_html($validUntil) ?></p>
                                                    </div>
                                                </div>
                                                <input type ="hidden" name="action" value="recoDisconnect">
                                                <input type="submit" class="block pt-3 text-sm underline cursor-pointer text-tuning-blue" value="Deactivate license">
                                        <?php } else { ?>
                                            <input type ="hidden" name="action" value="recoConnect">
                                            <input type="submit" class="mt-3 reco-button-sm" value="Update license">
                                        <?php } ?>
                                    </form>
                                </div>
                    </div>
                </div>
            </div>
            <?php } else { ?>
                <div class="mb-6 mt-12 max-w-[600px] flex">
                    <div class="w-1/2">
                    <h3 class="text-2xl font-semibold font-inter"><?php _e('Upgrade to pro', 'resize-control'); ?></h3>
                    <ul class="mt-5">
                        <li class="flex py-1 text-sm text-tuning-text font-inter"><svg class="flex-shrink-0 mr-3" width="20" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="11" cy="11" r="11" fill="#4272F9"/><path d="M7.25 11.375L10.25 14.375L14.75 7.625" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg><?php _e('Convert any image automaticly to JPG or WEBP', 'resize-control'); ?></li>
                        <li class="flex py-1 text-sm text-tuning-text font-inter"><svg class="flex-shrink-0 mr-3" width="20" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="11" cy="11" r="11" fill="#4272F9"/><path d="M7.25 11.375L10.25 14.375L14.75 7.625" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg><?php _e('Cover, contain, fill and scale down resize method', 'resize-control'); ?></li>
                        <li class="flex py-1 text-sm text-tuning-text font-inter"><svg class="flex-shrink-0 mr-3" width="20" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="11" cy="11" r="11" fill="#4272F9"/><path d="M7.25 11.375L10.25 14.375L14.75 7.625" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg><?php _e('Set default background colors for resizing', 'resize-control'); ?></li>
                        <li class="flex py-1 text-sm text-tuning-text font-inter"><svg class="flex-shrink-0 mr-3" width="20" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="11" cy="11" r="11" fill="#4272F9"/><path d="M7.25 11.375L10.25 14.375L14.75 7.625" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg><?php _e('Resize contol per post type', 'resize-control'); ?></li>
                    </ul>
                    <a href="https://tuningwp.com/resize-control/#get" target="_blank" class="mt-5 reco-button"><?php _e('Upgrade', 'resize-control'); ?></a>
                </div>
                <div class="w-2/3">
                <object class="float-right" width="280" height="266" type="image/svg+xml" data="<?php echo esc_attr(plugins_url('assets/wizard.svg', dirname(__FILE__))) ?>">
                    <img src="<?php echo esc_attr(plugins_url('assets/wizard.svg', dirname(__FILE__))) ?>" />
                </object>
                </div>
            </div>
            <?php } ?>
        </div>
        <div id="perposttype" class="pt-6 ml-6 tabcontent">
                <div class="flex items-start justify-between">
                    <div>
                    <h2 class="text-2xl font-semibold font-inter"><?php _e('Resize options', 'resize-control'); ?></h2>
                    <p class="text-sm text-tuning-text font-inter"><?php _e('Select your resize settings per post type', 'resize-control'); ?></p>
                    </div>
                </div>
                <div class="flex flex-wrap <?php echo (defined('RECO_PREMIUM_PLUGINFILE') && !$valid) ? 'not-activated' : ''; ?>">
                    <?php
                    //general needs to be posttype
                    $general = isset($settings['imageoptions'][0]['general']) ? $settings['imageoptions'][0]['general'] : [];
                    $width = isset($general['width']) ? $general['width'] : '700';
                    $height = isset($general['height']) ? $general['height'] : '700';

                    $enableResize = isset($general['enableResizeDimensions']) ? $general['enableResizeDimensions'] : 0;

                    ?>

                    <div class="flex justify-between w-auto mt-6 mr-6 rounded-md shadow tablinks shrink-0">
                        <a onclick="openTab(event, 'perposttypeform', 'perPostType')" href="#" class="inline-flex p-6">
                            <div class="rounded bg-tuning-gray p-[14px]">
                                <img class="inline" src="<?php echo esc_attr(plugins_url('assets/gridactive.svg', dirname(__FILE__))) ?>" />
                            </div>
                            <div class="pl-[14px]">
                                <p class="inline text-base font-medium text-black font-inter"><?php _e('All media', 'resize-control'); ?></p>
                                <p class="text-sm text-tuning-text font-inter"><?php
                                    if ($enableResize == 0) {
                                        echo wp_kses(
                                            "<p style='color:#00000036;' class='text-sm line-through opacity-50 font-inter'><span class='text-tuning-text'>" . esc_html($width) . " x " . esc_html($height) . "</span></p>", 
                                            [
                                                'p' => [
                                                    'style' => [],
                                                    'class' => [],
                                                ],
                                                'span' => [
                                                    'class' => [],
                                                ],
                                            ]
                                        );
                                    } else {
                                        echo wp_kses(
                                            "<p class='text-sm text-tuning-text font-inter whitespace-nowrap'>" . esc_html($width) . " x " . esc_html($height) . "</p>",
                                            [
                                                'p' => [
                                                    'style' => [],
                                                    'class' => [],
                                                ],
                                            ]
                                        );
                                    }
                                ?></p>
                            </div>
                        </a>
                    </div>
                    <?php
                    if (defined('RECO_PREMIUM_PLUGINFILE')) {
                        //Get all post types
                        $postTypes = get_post_types(array('public' => true), 'objects');

                        //Remove media from the list
                        unset($postTypes['attachment']);

                        foreach ($postTypes as $postType) {
                            $name = $postType->labels->name;
                            $slug = $postType->name;
                            $general = isset($settings['imageoptions'][0][$slug]) ? $settings['imageoptions'][0][$slug] : [];

                            $width = isset($general['width']) ? $general['width'] : '700';
                            $height = isset($general['height']) ? $general['height'] : '700';

                        
                            $enabled = '';
                            if (isset($general['enabled'])) {
                                $enabled = $general['enabled'] ? 'checked' : '';
                            }

                            ?>
                            <div class="flex justify-between w-56 mt-6 mr-6 rounded-md shadow tablinks shrink-0">
                                <a onclick="openTab(event, '<?php echo esc_attr($slug) ?>', 'perPostType')" href="#" class="inline-flex p-6">
                                    <div class="rounded bg-tuning-gray p-[14px]">
                                        <img class="inline" src="<?php echo esc_attr(plugins_url('assets/grid.svg', dirname(__FILE__))) ?>" />
                                    </div>
                                    <div class="pl-[14px]">
                                        <p class="inline text-base font-medium text-black font-inter"><?php echo esc_html($name) ?></p>
                                        <p class="text-sm text-tuning-text font-inter"><?php
                                            if ($enableResize == 0) {
                                                echo wp_kses(
                                                    "<p style='color:#00000036;' class='text-sm line-through opacity-50 font-inter'><span class='text-tuning-text'>" . esc_html($width) . " x " . esc_html($height) . "</span></p>",
                                                    [
                                                        'p' => [
                                                            'style' => [],
                                                            'class' => [],
                                                        ],
                                                        'span' => [
                                                            'class' => [],
                                                        ],
                                                    ]
                                                );
                                            } else {
                                                echo wp_kses(
                                                    "<p class='text-sm text-tuning-text font-inter whitespace-nowrap'>" . esc_html($width) . " x " . esc_html($height) . "</p>",
                                                    [
                                                        'p' => [
                                                            'style' => [],
                                                            'class' => [],
                                                        ],
                                                    ]
                                                );
                                            }
                                        ?></p>
                                    </div>
                                </a>
                                <div class="check-shadow bg-gray-50 rounded-r-md">
                                    <div class="flex items-center h-full px-2" tooltip="<?php _e('Enable different resizing for this posttype', 'resize-control'); ?>">
                                        <input id="<?php echo esc_attr('imageSettings-' . $slug) ?>" name="enablePostType" class="p-0 m-0 shadow-sm focus:ring-0 tuning-checkbox" type="checkbox" <?php echo esc_attr($enabled) ?>>
                                    </div>
                                </div>
                            </div>
                            <?php
                            }
                            if (!$valid) {
                                echo wp_kses(
                                    '<p class="self-end w-full mt-3 text-red-800">' . __('Please, connect your license to change other posttypes.', 'resize-control') . '</p>',
                                    [
                                        'p' => [
                                            'style' => [],
                                            'class' => [],
                                        ],
                                        'br' => [],
                                    ]
                                );
                            }
                    } else {
                    ?>
                    <div class="relative">
                        <a href="https://tuningwp.com/resize-control/#get" target="_blank" class="absolute px-3 py-1 text-base font-medium text-black bg-white rounded-full shadow top-1.5 proLock -right-4 font-inter">
                            Pro
                            <img class="inline" src="<?php echo esc_attr(plugins_url('assets/lock.svg', dirname(__FILE__))) ?>" />
                        </a>
                        <div class="inline-flex p-6 mt-6 rounded-md shadow opacity-50 cursor-not-allowed">

                            <div class="rounded bg-tuning-gray p-[14px]">
                                <div class="dashicons-before dashicons-admin-post perPostIcon"><br></div>
                            </div>
                            <div class="pl-[14px]">
                                <p class="inline text-base font-medium text-black font-inter"><?php _e('Posts', 'resize-control'); ?></p>
                                <p class="text-sm text-tuning-text font-inter">500 x 500</p>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
                <?php if (!defined('RECO_PREMIUM_PLUGINFILE')) { ?>
                <div class="mt-12 mb-6 max-w-[600px] flex">
                    <div class="w-1/2">
                    <h3 class="text-2xl font-semibold font-inter">Upgrade to pro</h3>
                    <ul class="mt-5">
                        <li class="flex py-1 text-sm text-tuning-text font-inter"><svg class="flex-shrink-0 mr-3" width="20" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="11" cy="11" r="11" fill="#4272F9"/><path d="M7.25 11.375L10.25 14.375L14.75 7.625" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg><?php _e('Convert any image automaticly to JPG or WEBP', 'resize-control'); ?></li>
                        <li class="flex py-1 text-sm text-tuning-text font-inter"><svg class="flex-shrink-0 mr-3" width="20" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="11" cy="11" r="11" fill="#4272F9"/><path d="M7.25 11.375L10.25 14.375L14.75 7.625" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg><?php _e('Cover, contain, fill and scale down resize method', 'resize-control'); ?></li>
                        <li class="flex py-1 text-sm text-tuning-text font-inter"><svg class="flex-shrink-0 mr-3" width="20" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="11" cy="11" r="11" fill="#4272F9"/><path d="M7.25 11.375L10.25 14.375L14.75 7.625" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg><?php _e('Set default background colors for resizing', 'resize-control'); ?></li>
                        <li class="flex py-1 text-sm text-tuning-text font-inter"><svg class="flex-shrink-0 mr-3" width="20" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="11" cy="11" r="11" fill="#4272F9"/><path d="M7.25 11.375L10.25 14.375L14.75 7.625" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg><?php _e('Resize contol per post type', 'resize-control'); ?></li>
                    </ul>
                    <a href="https://tuningwp.com/resize-control/#get" target="_blank" class="mt-5 reco-button"><?php _e('Upgrade', 'resize-control'); ?></a>
                </div>
                <div class="w-2/3">
                    <object class="float-right" width="280" height="266" type="image/svg+xml" data="<?php echo esc_attr(plugins_url('assets/wizard.svg', dirname(__FILE__))) ?>">
                        <img src="<?php echo esc_attr(plugins_url('assets/wizard.svg', dirname(__FILE__))) ?>" />
                    </object>
                </div>
            </div>
            <?php } ?>
            <?php if (defined('RECO_PREMIUM_PLUGINFILE')) { ?>
                <a id="saveSettings" href="#" class="my-6 mr-6 text-right reco-button"><?php _e('Save', 'resize-control'); ?></a>
            <?php } ?>
        </div>
        <?php
        if (!defined('RECO_PREMIUM_PLUGINFILE')) { ?>
            <div class="tabcontent" id="perposttypeform">
                <?php include_once('forms/PerPostType.php'); ?>
            </div>
        <?php } else {
                if ($license->isValidRegistration($licenseData)) {
                    $postTypes = get_post_types(array('public' => true), 'objects');

                    //Remove media from the list
                    unset($postTypes['attachment']);

                    foreach ($postTypes as $postType) {
                        $name = $postType->labels->name;
                        $slug = $postType->name;

                        //Used in template
                        $general = $settings['imageoptions'][0][$slug];
                        $width = $general['width'] ? $general['width'] : '700';
                        $height = $general['height'] ? $general['height'] : '700';
                        ?>
                        <div class="tabcontent" id="<?php echo esc_attr($slug) ?>">
                            <?php include(RECO_PREMIUM_PLUGINROOT . '/admin/views/forms/PerPostTypePremium.php'); ?>
                        </div>
                        <?php
                    }
                    $slug = 'general';
                    //Used in template
                    $general = $settings['imageoptions'][0][$slug];
                    $width = $general['width'] ? $general['width'] : '700';
                    $height = $general['height'] ? $general['height'] : '700';
                    ?>
                        <!--- General settings --->
                        <div class="tabcontent" id="perposttypeform">
                            <?php include(RECO_PREMIUM_PLUGINROOT . '/admin/views/forms/PerPostTypePremium.php'); ?>
                        </div>
                    <?php
                }
            }
        ?>
</div>
    </section>
</main>