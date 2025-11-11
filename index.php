<?php
/**
 * Azure Web App root redirect for Bedrock
 *
 * This file lets Azure (Nginx + PHP-FPM) serve Bedrock correctly
 * without changing folder structure or Nginx configuration.
 */

require __DIR__ . '/web/index.php';
