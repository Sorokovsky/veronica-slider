<?php

namespace VeronicaSlider;

class Image
{
    public mixed $image {
        get {
            return $this->image;
        }
    }
    public string $url {
        get {
            return $this->url;
        }
    }

    public function __construct(mixed $image, string $url = "") {
        $this->image = $image;
        $this->url = $url;
    }

}