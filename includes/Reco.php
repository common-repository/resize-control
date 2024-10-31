<?php

/**
 * Class for loading all the hooks, filters and other functionality for the whole plugin.
 */

 //TODO
 //Add checker and notice for elementor

namespace Reco;

class Reco
{
    protected $loader; //For loading all the hooks and filters

    public function __construct()
    {
        $this->loadPluginDependencies();
        $this->setLocale();
        $this->defineAdminHooks();
    }

    private function loadPluginDependencies()
    {
        require_once 'RecoI18n.php';
        require_once 'RecoLoader.php';
        require_once '_includes.php';
        $this->loader = new RecoLoader();
    }

    private function setLocale()
    {
        $RecoI18n = new RecoI18n();
        $this->loader->addAction('init', $RecoI18n, 'loadDomain');
    }

    //These are all the hooks registered for everyone
    private function defineAdminHooks()
    {
        $enqueueAdmin = new EnqueueAdmin();
        $this->loader->addAction('admin_enqueue_scripts', $enqueueAdmin, 'loadJS');
        $this->loader->addAction('admin_enqueue_scripts', $enqueueAdmin, 'loadCSS');

        $adminPage = new AdminPage();
        $this->loader->addAction('admin_menu', $adminPage, 'createPage');
        $this->loader->addAction('admin_head', $adminPage, 'addAdminPageIcon');

        $RecoApi = new RecoApi();
        $this->loader->addAction('rest_api_init', $RecoApi, 'addRoutes');

        $RecoReplaceScripts = new RecoReplaceScripts();
        $this->loader->addAction('admin_enqueue_scripts', $RecoReplaceScripts, 'modifyDefaultScripts', 998);
        $this->loader->addAction('wp_enqueue_scripts', $RecoReplaceScripts, 'modifyDefaultScripts', 998);
    }

    public function run()
    {
        $this->loader->run();
    }
}