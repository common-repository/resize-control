<?php

namespace Reco;

class EnqueueAdmin
{
    public function loadJS($hook)
    {
        $scriptLocation = RECO_PLUGINFILE;
        $names = [];
        $deps = [];
        if (defined('RECO_PREMIUM_PLUGINFILE')) {
            $scriptLocation = RECO_PREMIUM_PLUGINFILE;
            $deps = ['wp-color-picker', 'jquery'];
            $postTypes = get_post_types(array('public' => true), 'objects');

            //remove media from post types
            unset($postTypes['attachment']);

            foreach ($postTypes as $postType) {
                $names[] = $postType->name;
            }
        }

        //Wordpress media library page
        wp_enqueue_script('PngScript', plugin_dir_url(RECO_PLUGINFILE) . '/admin/js/browser-image-compression.js');

        if ('toplevel_page_tuning-wp' != $hook) {
            return;
        }
        wp_enqueue_script( 'wp-color-picker' );
        wp_enqueue_script('RecoImage', plugin_dir_url(RECO_PLUGINFILE) . '/admin/js/reco-image.js', array('jquery', 'plupload', 'wp-plupload'), null, true);
        wp_enqueue_script('RecoScript', plugin_dir_url($scriptLocation) . '/admin/js/reco-script.js', $deps, null, true);
        wp_localize_script('RecoScript', 'ajax_var', array(
        'adminurl' => get_admin_url(),
        'ajaxurl' => admin_url('admin-ajax.php'),
        'resturl' => rest_url('reco-api/v1/settings'),
        'restlicenseurl' => rest_url('reco-api/v1/license'),
        'nonce' => wp_create_nonce('wp_rest'),
        'posttypes' => $names,
        ));
    }

    public function loadCSS($hook)
    {
        if ('toplevel_page_tuning-wp' != $hook) {
            return;
        }
        wp_enqueue_style( 'wp-color-picker' );
        wp_enqueue_style( 'wpb-google-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap', false ); 
        wp_enqueue_style('RecoStyle', plugin_dir_url(RECO_PLUGINFILE) . '/admin/css/reco-style.min.css');
    }
}