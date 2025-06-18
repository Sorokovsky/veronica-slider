<?php
namespace VeronicaSlider;
use Elementor\Repeater;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

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
        $repeater->add_control("image",
        [
            "label" => "Зображення",
            "type" => Controls_Manager::MEDIA,
        ]);
        $repeater->add_control("url",
            [
                "label" => "Посилання",
                "type" => Controls_Manager::URL,
            ]);
        $this->add_control("images",
        [
            "label" => "Списк фотографій",
            "type" => Controls_Manager::REPEATER,
            'fields' => $repeater->get_controls(),
            'default' => []
        ]);
        $this->end_controls_section();
        $this->start_controls_section("main", [
            "label" => "Зміст посережені",
            "tab" => Controls_Manager::TAB_CONTENT,
        ]);
    }

    protected function render(): void
    {
        echo "<style>
            .veronica-slider {
            display: flex;
            align-items: stretch;
            justify-content: center;
            }
            .veronica-slider img {
                object-fit: contain;
                width: 100%;
                height: 100%;
            }
            .veronica-slider .image {
                display: block;
                margin: 0;
                padding: 0;
            }
        </style>";
        echo "<div class='veronica-slider'>'";
        $image_chooser = $this->setup_random_chooser();
        echo $this->get_image_block($image_chooser->choose_random_image());
        echo $this->get_main_block();
        echo $this->get_image_block($image_chooser->choose_random_image());
        echo "</div>";
    }

    private function get_image_block(Image $image): string
    {
        if(isset($image->url) && $image->url != "") return $this->get_url_block($image);
        else return $this->get_normal_block($image);
    }

    private function get_url_block(Image $image): string
    {
        $html = "<a class='image' href='.$image->url.'>";
        $html.= "<img src='".$image->image."' />";
        $html.="</a>";
        return $html;
    }

    private function get_normal_block(Image $image): string
    {
        $html = "<div class='image'>";
        $html.= "<img src='".$image->image."' />";
        $html.="</div>";
        return $html;
    }

    private function get_main_block(): string
    {
        return "<div class='main'>
                <h2>Title</h2></div>";
    }

    private function setup_random_chooser(): RandomImageChooser
    {
        require_once dirname(__FILE__).DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."RandomImageChooser.php";
        $settings = $this->get_settings_for_display();
        $images = $settings["images"];
        $chooser = new RandomImageChooser();
        foreach ($images as $item) {
          $image_url = $item['image']["url"];
          $url = $item['url']["url"] ?? "";
          require_once dirname(__FILE__).DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."Image.php";
          $image = new Image($image_url, $url);
          $chooser->add_image($image);
        }
       return $chooser;
    }
}