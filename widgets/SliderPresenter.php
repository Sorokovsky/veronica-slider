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
        return "<a class='veronica__button' href='$link'>$text</a>";
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
                max-height: $max_height;
            }
            .veronica-slider .image {
                display: block;
                margin: 0;
                padding: 0;
                max-height: $max_height;
            }
            .veronica__title {
                line-height: 1;
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
                padding: 75px 0;
            }
            .veronica-slider > * {
                flex: 33.3% 1 1;
            }
            .veronica__button {
                display: block;
                text-decoration: none;
                font-weight: 500;
                background-color: transparent;
                position: relative;
                z-index: 1;
                margin-bottom: 6px;
            }
            .veronica__button::after {
                content: '';
                position: absolute;
                z-index: 1;
                bottom: -5px;
                left: 0;
                width: 100%;
                height: 1px;
                background-color: #111111;
                transform-origin: left;
                transform: scaleX(1);
                transition: transform .2s ease-in-out;
            }
            .veronica__button:hover::after {
                transform-origin: right;
                transform: scaleX(0);
            }
            @media screen and (max-width: 640px) {
                .veronica-slider {
                    flex-direction: column;
                }
                .veronica-slider > * {
                    flex: auto 1 1;
                }
                .veronica-slider .image {
                    max-height: 80vh;
                    overflow: hidden;
                }
                .veronica-slider .image img {
                    max-height: 80vh;
                }
            }
        </style>";
    }
}