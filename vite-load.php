<?php
/**
 * Path: app\public\wp-content\plugins\coursefactory-integration\vite-load.php
 * este archivo encola composer e /inc/enqueue.php
 *
 * @package Course Factory Integration */

namespace Kucrut\ViteForWPExample\React;

require_once __DIR__ . '/vite-for-wp.php';
require_once __DIR__ . '/inc/Enqueue.php';

Enqueue\frontend();
Enqueue\backend();
