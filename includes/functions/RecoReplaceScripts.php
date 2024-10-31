<?php

namespace Reco;

class RecoReplaceScripts
{
    public static $scriptsSupplemented = false;

    public function modifyDefaultScripts($scripts = null)
    {
        if (self::$scriptsSupplemented) {
            return;
        }

        if (wp_script_is('plupload', 'registered')) {
            self::$scriptsSupplemented = true;

            if ($scripts instanceof \WP_Scripts) {
                $scripts->remove('plupload');
            } else {
                wp_deregister_script('plupload');
            }

            $plupload_script = [
                'path' => plugin_dir_url(RECO_PLUGINFILE) . '/admin/js/vendor/plupload.min.js',
                'deps' => [ 'moxiejs' ],
                'ver'  => '2.1.9',
            ];

            if ($scripts instanceof \WP_Scripts) {
                $scripts->add('plupload', $plupload_script['path'], $plupload_script['deps'], $plupload_script['ver']);
            } else {
                wp_enqueue_script('plupload', $plupload_script['path'], $plupload_script['deps'], $plupload_script['ver']); // @codingStandardsIgnoreLine
            }

            if ($scripts instanceof \WP_Scripts) {
                $scripts->localize(
                    'plupload',
                    'recosettings',
                    [
                        'recosettings' => RecoSettings::getSettings(true),
                        'recouser' => wp_get_current_user(),
                    ]
                );
            } else {
                wp_localize_script(
                    'plupload',
                    'recosettings',
                    [
                        'recosettings' => RecoSettings::getSettings(true),
                        'recouser' => wp_get_current_user(),
                    ]
                );
            }
        }
    }
}
