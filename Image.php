<?php

namespace VeronicaSlider;

class Image
{
    public string $image {
        get {
            return $this->image;
        }
    }
    public string $url {
        get {
            return $this->url;
        }
    }

    public function __construct(string $image, string $url = "") {
        $this->image = $image;
        $this->url = $url;
    }

}