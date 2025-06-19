<?php

namespace widgets;

use VeronicaSlider\Image;

class SliderPresenter
{

    public function get_view(
        string $title,
        string $text,
        string $button_text,
        string $button_link,
        string $color,
        Image $first,
        Image $second,
        string $max_height
    ): string
    {
        $html = $this->get_styles($max_height, $color);
        $html .= '<div class="veronica-slider">';
        $html .= $this->get_image_block($first);
        $html .= $this->get_main_block($title, $text, $button_text, $button_link);
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

    private function get_main_block(string $title, string $text, string $button_text, string $button_link): string
    {
        $button = $this->get_button($button_text, $button_link);
        $title_block = $this->get_title($title);
        $text_block = $this->get_text($text);
        return "<div class='veronica__main'>
                    $title_block
                    $text_block
                    $button
                </div>";
    }

    private function get_title(string $title): string
    {
        return "<h2 class='veronica__title'>$title</h2>";
    }

    private function get_text(string $text): string
    {
        return "<p class='veronica__text'>$text</p>";
    }

    private function get_button(string $text, string $link): string
    {
        return "<a class='button' href='$link'>$text</a>";
    }

    private function get_styles(string $max_height, string $color): string
    {
        return "<style>
            .veronica-slider {
            display: flex;
            align-items: stretch;
            justify-content: space-between;
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
                max-height: $max_height;
            }
            .veronica__title {
                font-size: 36px;
                text-align: center;
                padding: 0;
                margin: 0 0 25px;
            }
            p.veronica__text {
                font-size: 18px;
                padding: 0;
                text-align: center;
                margin-bottom: 39px;
            }
            .veronica__main {
                width: 100%;
                background-color: $color;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
            }
            .veronica-slider > * {
                flex: 33.3% 1 1;
            }
        </style>";
    }
}