<?php

namespace Reco;

class RecoSettings
{
    /**
     * Option key to save settings
     *
     * @var string
     */
    protected static $option_key = '_reco_settings';
    protected static $license_key = '_reco_license';
    /**
     * Default settings
     *
     * @var array
     */
    protected static $defaults = array(
        'ignoredroles' => '',
        'enableresize' => true
    );
    /**
     * Get saved settings
     *
     * @return array
     */
    public static function getSettings($plain = false)
    {
        $saved = get_option(self::$option_key, array());
        // if (!is_array($saved) || !empty($saved)) {
        //     return self::$defaults;
        // }

        if ($plain) {
            return $saved;
        }

        return wp_send_json(wp_parse_args($saved, self::$defaults));
    }
    public static function saveSettings($settings)
    {
        update_option(self::$option_key, $settings);
    }

}