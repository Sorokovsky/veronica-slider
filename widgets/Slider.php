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

        $this->start_controls_section("main-content",
            [
                "label" => "Зміст посереденні",
                "tab" => Controls_Manager::TAB_CONTENT,
            ]);

        $this->add_control("title",
            [
               "label" => "Заголовок",
               "type" => Controls_Manager::TEXT,
               "default" => "Заголовок",
            ]);

        $this->add_control("text",
            [
                "label" => "Текст",
                "type" => Controls_Manager::TEXT,
                "default" => "Текст",
            ]);

        $this->add_control("slider_button_text",
        [
            "label" => "Текст кнопки",
            "type" => Controls_Manager::TEXT,
            "default" => "",
        ]);

        $this->add_control("slider_button_link",
        [
            "label" => "Посилання кнопки",
            "type" => Controls_Manager::URL,
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
        $this->add_control("background-color",
        [
           "label" => "Задній фон",
           "type" => Controls_Manager::COLOR,
        ]);
        $this->end_controls_section();
    }

    protected function render(): void
    {
        $settings = $this->get_settings_for_display();
        if($this->can_render($settings)) {
            $max_height = $settings['max-height'] ?? "300px";
            $title = $settings['title'] ?? "";
            $text = $settings['text'] ?? "";
            $button_text = $settings['slider_button_text'] ?? "";
            $button_link = $settings['slider_button_link']['url'] ?? "";
            $color = $settings['background-color'] ?? "#ffffff";
            $presenter = new SliderPresenter();
            $chooser = $this->setup_random_chooser($settings);
            $first_image = $chooser->choose_random_image();
            $second_image = $chooser->choose_random_image();
            echo $presenter->get_view($title, $text, $button_text, $button_link, $color, $first_image, $second_image, $max_height);
        }
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

    private function can_render($settings): bool
    {
        $can_render = true;
        $images = $settings["images"] ?? [];
        $text = $settings["text"] ?? "";
        $title = $settings["title"] ?? "";
        $button_text = $settings["slider_button_text"] ?? "";
        $button_link = $settings["slider_button_link"]['url'] ?? "";
        if(count($images) < 2) $can_render = false;
        if($text == "" || $title == "" || $button_text == "" || $button_link == "") $can_render = false;
        foreach ($images as $item) {
            $image_data = $item['image'];
            if (!isset($image_data) || $image_data == null || $image_data["url"] == "") $can_render = false;
        }
        return $can_render;
    }
}