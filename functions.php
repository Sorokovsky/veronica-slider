<?php
use Elementor\Plugin;
use VeronicaSlider\Slider;
use widgets\SliderPresenter;

function get_ui_file(string $file): string
{
    return dirname(__FILE__).DIRECTORY_SEPARATOR."ui".DIRECTORY_SEPARATOR.$file;
}

/**
 * @throws Exception
 */
function add_component(): void
{
    if (!did_action('elementor/loaded')) {
        add_action( 'admin_notices', function() {
            echo '<div class="notice notice-warning"><p>Elementor повинен бути активним для використання My Elementor Widget.</p></div>';
        });
        return;
    }
    require_once dirname(__FILE__).DIRECTORY_SEPARATOR."widgets".DIRECTORY_SEPARATOR."Slider.php";
    $slider = new Slider();
    Plugin::instance()->widgets_manager->register($slider);

}