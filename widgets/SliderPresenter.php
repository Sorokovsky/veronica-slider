<?php

namespace widgets;

use VeronicaSlider\Image;

class SliderPresenter
{

    public function get_view(string $title, string $text, string $color, Image $first, Image $second, string $max_height): string
    {
        $html = $this->get_styles($max_height, $color);
        $html .= '<div class="veronica-slider">';
        $html .= $this->get_image_block($first);
        $html .= $this->get_main_block($title, $text);
        $html .= $this->get_image_block($second);
        $html .= '</div>';
        return $html;
    }

    private function get_image_block(Image $image): string
    {
        if ($image->url != "") return $this->get_url_block($image);
        else return $this->get_normal_image_block($image);
    }

    private function get_url_block(Image $image): string
    {
        $html = "<a class='image' href='$image->url'>";
        $html .= $this->get_image_tag_block($image);
        $html .= "</a>";
        return $html;
    }

    private function get_normal_image_block(Image $image): string
    {
        $html = "<div class='image'>";
        $html .= $this->get_image_tag_block($image);
        $html .= "</div>";
        return $html;
    }

    private function get_image_tag_block(Image $image): string
    {
        $url = $image->image['url'];
        $alt = $image->image['alt'];
        return "<img alt='$alt' src='$url' />";
    }

    public function get_main_block(string $title, string $text): string
    {
        return "<div class='veronica__main'>
                    <h2 class='veronica__title'>$title</h2>
                    <p class='veronica__text'>$text</p>
                    <a>Button</a>
                </div>";
    }

    public function get_styles(string $max_height, string $color): string
    {
        return "<style>
            .veronica-slider {
            display: flex;
            align-items: stretch;
            justify-content: space-between;
            max-height: $max_height;
            }
            .veronica-slider img {
                object-fit: cover;
                width: 100%;
                height: 100%;
            }
            .veronica-slider .image {
                display: block;
                margin: 0;
                padding: 0;
                max-width: 600px;
            }
            .veronica__title {
                font-size: 36px;
                text-align: center;
                padding: 10px 5px;
                margin: 0;
            }
            p.veronica__text {
                font-size: 16px;
                padding: 10px 5px;
                margin: 0;
                text-align: center;
            }
            .veronica__main {
                width: 100%;
                background-color: $color;
            }
        </style>";
    }
}