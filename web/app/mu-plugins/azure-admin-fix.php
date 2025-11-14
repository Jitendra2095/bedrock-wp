<?php
/**
 * Fix wrong admin URLs on Azure App Service for Bedrock
 * Uses getenv() because WP_SITEURL constant is not loaded yet in MU plugins.
 */

add_filter('admin_url', function ($url) {

    // Get site URL from environment variables
    $env_siteurl = getenv('WP_SITEURL');

    // Fallback if getenv fails (rare)
    if (! $env_siteurl) {
        $env_siteurl = rtrim(get_option('siteurl'), '/');
    }

    // If /wp-admin is missing, Azure removed it via SCRIPT_NAME bug
    if (strpos($url, '/wp-admin') === false) {
        $parsed = parse_url($url);
        $path   = isset($parsed['path']) ? basename($parsed['path']) : '';
        $qs     = isset($parsed['query']) ? '?' . $parsed['query'] : '';

        return rtrim($env_siteurl, '/') . '/wp-admin/' . $path . $qs;
    }

    return $url;
}, 9999);


add_filter('network_admin_url', function ($url) {

    $env_siteurl = getenv('WP_SITEURL');

    if (! $env_siteurl) {
        $env_siteurl = rtrim(get_option('siteurl'), '/');
    }

    if (strpos($url, '/wp-admin') === false) {
        $parsed = parse_url($url);
        $path   = isset($parsed['path']) ? basename($parsed['path']) : '';
        $qs     = isset($parsed['query']) ? '?' . $parsed['query'] : '';

        return rtrim($env_siteurl, '/') . '/wp-admin/' . $path . $qs;
    }

    return $url;
}, 9999);
