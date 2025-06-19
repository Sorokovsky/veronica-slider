<?php

namespace widgets;

use VeronicaSlider\Image;

class SliderPresenter
{

    public function get_view(Image $first, Image $second, string $max_height): string
    {
        $html = $this->get_styles($max_height);
        $html .= '<div class="veronica-slider">';
        $html .= $this->get_image_block($first);
        $html .= $this->get_main_block();
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

    public function get_main_block(): string
    {
        return "<div class='main'>
                <h2>Title</h2></div>";
    }

    public function get_styles(string $max_height): string
    {
        return "<style>
            .veronica-slider {
            display: flex;
            align-items: stretch;
            justify-content: center;
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
            }
        </style>";
    }
}