<?php

/**
 *  Define internationlization for plugin so it's ready
 */

namespace Reco;

class RecoI18n
{
    public function loadDomain()
    {
		$locale = get_user_locale();
		$locale = apply_filters('plugin_locale', $locale, 'resize-control'); // phpcs:ignore

		unload_textdomain('resize-control');
		if (false === load_textdomain('resize-control', WP_LANG_DIR . '/plugins/resize-control-' . $locale . '.mo')) {
			load_textdomain('resize-control', WP_LANG_DIR . '/resize-control/resize-control-' . $locale . '.mo');
		}
		load_plugin_textdomain('resize-control', false, plugin_dir_path(RECO_PLUGINFILE) . '/' .  'languages/');
    }

}