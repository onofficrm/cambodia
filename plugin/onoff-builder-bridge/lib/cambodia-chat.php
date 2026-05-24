<?php
if (!defined('_GNUBOARD_')) {
    exit;
}

if (!function_exists('cambodia_chat_site_key')) {
    function cambodia_chat_site_key()
    {
        if (function_exists('g5site_cfg')) {
            $key = trim((string) g5site_cfg('chat_icrm_site_key', ''));
            if ($key !== '') {
                return $key;
            }
        }

        return '422dae9b225bc7fe05811fc6e4076083f4813353aba82a69';
    }
}

if (!function_exists('cambodia_chat_widget_script_url')) {
    function cambodia_chat_widget_script_url()
    {
        if (function_exists('g5site_cfg')) {
            $url = trim((string) g5site_cfg('chat_icrm_widget_url', ''));
            if ($url !== '') {
                return $url;
            }
        }

        return 'https://chat.icrm.co.kr/widget.js';
    }
}

if (!function_exists('cambodia_chat_iframe_dom_id')) {
    function cambodia_chat_iframe_dom_id()
    {
        return 'chat-icrm-widget-' . preg_replace('/[^a-zA-Z0-9_-]/', '', cambodia_chat_site_key());
    }
}

if (!function_exists('cambodia_chat_print_assets')) {
    /**
     * 온오프 iCRM 챗봇 — 본문 하단(</body> 직전)에 출력
     */
    function cambodia_chat_print_assets()
    {
        static $printed = false;

        if ($printed) {
            return;
        }
        $printed = true;

        if (!defined('ONOFF_BUILDER_ASSETS_URL')) {
            return;
        }

        $site_key = cambodia_chat_site_key();
        if ($site_key === '') {
            return;
        }

        $widget_url = cambodia_chat_widget_script_url();
        $css_url = ONOFF_BUILDER_ASSETS_URL . '/css/cambodia-chat.css';
        $js_url = ONOFF_BUILDER_ASSETS_URL . '/js/cambodia-chat.js';
        $ver = defined('G5_CSS_VER') ? G5_CSS_VER : '1';

        $config = array(
            'siteKey'   => $site_key,
            'iframeId'  => cambodia_chat_iframe_dom_id(),
            'origin'    => 'https://chat.icrm.co.kr',
        );
        $config_json = json_encode($config, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        if ($config_json === false) {
            $config_json = '{}';
        }

        echo '<link rel="stylesheet" href="' . htmlspecialchars($css_url . '?ver=' . $ver, ENT_QUOTES, 'UTF-8') . '">' . PHP_EOL;
        echo '<script>window.__CAMBODIA_CHAT__=' . $config_json . ';</script>' . PHP_EOL;
        echo '<script src="' . htmlspecialchars($widget_url, ENT_QUOTES, 'UTF-8') . '" data-site-key="';
        echo htmlspecialchars($site_key, ENT_QUOTES, 'UTF-8');
        echo '" async></script>' . PHP_EOL;
        echo '<script src="' . htmlspecialchars($js_url . '?ver=' . $ver, ENT_QUOTES, 'UTF-8') . '" defer></script>' . PHP_EOL;
    }
}
