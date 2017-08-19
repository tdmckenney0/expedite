<?php

App::uses('CakePlugin', 'Core');

class CakePluginPolling extends CakePlugin {
    public static function getLoadedPlugins() {
        return array_keys(CakePlugin::$_plugins); 
    }
}