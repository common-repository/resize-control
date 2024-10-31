<?php

if (!function_exists('RecoViewloader')) {
    function RecoViewloader($template)
    {
        return RECO_PLUGINROOT . '/admin/views/' . $template . '.php';
    }
}

if (!function_exists('recoDd')) {
    function recoDd($var, $die = true)
    {
        echo '<pre>';
        echo esc_html(print_r($var, true));
        echo '</pre>';
        $die && die();
    }
}


if ( ! function_exists('recoWriteLog')) {
    function recoWriteLog ($log, $vardump = false)  {
        
            if ($vardump) {
                error_log(var_dump($log));
            }

        if ( is_array( $log ) || is_object( $log ) ) {
            error_log( print_r( $log, true ) );
        } else {
            error_log( $log );
        }
    }
}