<?php
namespace VeronicaSlider;

use http\Exception\RuntimeException;

class RandomImageChooser
{
    /**
     * @var Image[] $images
     */
    private array $images = array();

    public function __construct() {
    }

    public function choose_random_image(bool $canRepeat = false): Image {
        if($this->is_empty()) {
            throw new RuntimeException("Images is empty");
        }
        $index = $this->get_random_index();
        $image = $this->images[$index];
        if(!$canRepeat) {
            array_splice($this->images, $index, 1);
        }
        return $image;
    }

    public function is_empty(): bool
    {
        return count($this->images) == 0;
    }

    public function add_image(Image $image): void
    {
        $this->images[] = $image;
    }

    private function get_random_index(): int
    {
        return rand(0, count($this->images) - 1);
    }

}