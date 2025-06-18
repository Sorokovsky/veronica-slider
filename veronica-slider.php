<?php
/**
 * Plugin Name: Veronica Slider
 * Description: UI component for veronica slider
 * Author: Sorokovsky Andrey
 * Version: 1.0
 * Text Domain: veronica-slider
 */

if (!defined('ABSPATH')) {
    die( 'Not in wordpress' );
}

require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'functions.php';
add_action( 'elementor/widgets/register', 'add_component' );