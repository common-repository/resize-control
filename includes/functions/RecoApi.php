<?php

namespace Reco;

class RecoApi
{
    /**
     * Add routes
     */
    public function addRoutes()
    {
        register_rest_route(
            'reco-api/v1',
            '/settings',
            [
                'methods' => 'POST',
                'callback' => [$this, 'updateSettings'],
                'args' => array(
                    'ignoredroles' => array(
                        'type' => 'string',
                        'required' => false,
                        'sanitize_callback' => 'sanitize_text_field'
                    ),
                    'enableresize' => array(
                        'type' => 'boolean',
                        'required' => true,
                        'sanitize_callback' => 'rest_sanitize_boolean'
                    ),
                    'imageoptions' => array(
                        'type' => 'array',
                        'required' => false,
                        'sanitize_callback' => 'rest_sanitize_array'
                    ),
                ),
                'permission_callback' => [$this, 'permissions']
            ]
        );

        register_rest_route(
            'reco-api/v1',
            '/settings',
            array(
                'methods' => 'GET',
                'callback' => [$this, 'getSettings'],
                'permission_callback' => [$this, 'permissions']
            )
        );
    }

    public function permissions()
    {
        return current_user_can('manage_options');
    }

    public function updateSettings(\WP_REST_Request $request)
    {
        $settings = [
            'ignoredroles' => $request->get_param('ignoredroles'),
            'enableresize' => $request->get_param('enableresize'),
            'imageoptions' => $request->get_param('imageoptions'),
        ];

        $save = RecoSettings::saveSettings($settings);
        return rest_ensure_response(RecoSettings::getSettings())->set_status(201);
    }

    public function updateLicense(\WP_REST_Request $request)
    {
        $settings = [
            'license' => $request->get_param('license'),
        ];

        $save = RecoSettings::saveLicense($settings);
        return rest_ensure_response(RecoSettings::getLicense())->set_status(201);
    }

    public function getSettings(\WP_REST_Request $request)
    {
        return rest_ensure_response(RecoSettings::getSettings());
    }
}