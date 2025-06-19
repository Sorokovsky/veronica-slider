<?php

namespace VeronicaSlider;
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "RandomImageChooser.php";
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "Image.php";
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . "SliderPresenter.php";


use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Widget_Base;
use widgets\SliderPresenter;

class Slider extends Widget_Base {

    public function get_name(): string
    {
        return "veronica-slider";
    }

    public function get_title(): string {
        return "Слайдер для вероніки";
    }

    public function get_icon(): string
    {
        return "eicon-code";
    }

    public function get_categories(): array {
        return ["general"];
    }

    protected function register_controls(): void {
        $this->start_controls_section(
            "content_section",
            [
                "label" => "Фотографії",
                "tab" => Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new Repeater();
        $repeater->add_control("image", [
            "label" => "Зображення",
            "type" => Controls_Manager::MEDIA,
        ]);
        $repeater->add_control("url", [
            "label" => "Посилання",
            "type" => Controls_Manager::URL,
        ]);

        $this->add_control("images", [
            "label" => "Список фотографій",
            "type" => Controls_Manager::REPEATER,
            "fields" => $repeater->get_controls() ?: [],
            "default" => [],
        ]);

        $this->end_controls_section();

        $this->start_controls_section("styles", [
            "label" => "Налаштування стилів",
            "tab" => Controls_Manager::TAB_CONTENT,
        ]);
        $this->add_control("max-height",
        [
           "label" => "Максимальна висота",
           "type" => Controls_Manager::TEXT,
           "default" => "500px",
        ]);
        $this->end_controls_section();
    }

    protected function render(): void
    {
        $settings = $this->get_settings_for_display();
        $max_height = $settings['max-height'] ?? "300px";
        $presenter = new SliderPresenter();
        $chooser = $this->setup_random_chooser($settings);
        echo $presenter->get_view($chooser->choose_random_image(), $chooser->choose_random_image(), $max_height);
    }

    private function setup_random_chooser(mixed $settings): RandomImageChooser
    {
        $images = $settings["images"] ?? [];
        $chooser = new RandomImageChooser();
        foreach ($images as $item) {
          $image_data = $item['image'];
          $url = $item['url']["url"] ?? "";
          $image = new Image($image_data, $url);
          $chooser->add_image($image);
        }
       return $chooser;
    }
}