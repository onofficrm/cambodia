<?php
if (!defined('_GNUBOARD_')) {
    exit;
}

if (!defined('ONOFF_BUILDER_LOADED') && defined('G5_PLUGIN_PATH')) {
    $bootstrap = G5_PLUGIN_PATH . '/onoff-builder-bridge/bootstrap.php';
    if (is_file($bootstrap)) {
        include_once $bootstrap;
    }
}

if (is_file(G5_PLUGIN_PATH . '/onoff-builder-bridge/lib/cambodia-chat.php')) {
    include_once G5_PLUGIN_PATH . '/onoff-builder-bridge/lib/cambodia-chat.php';
}

if (function_exists('cambodia_chat_print_assets')) {
    add_event('tail_sub', 'cambodia_chat_tail_assets', 20);
}

if (!function_exists('cambodia_chat_tail_assets')) {
    function cambodia_chat_tail_assets()
    {
        cambodia_chat_print_assets();
    }
}
