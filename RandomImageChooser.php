<?php
namespace VeronicaSlider;

class RandomImageChooser
{
    /**
     * @var Image[] $images
     */
    private array $images = array();

    public function __construct() {
    }

    public function choose_random_image(bool $canRepeat = false): Image {
        $index = $this->get_random_index();
        $image = $this->images[$index];
        if(!$canRepeat) {
            array_splice($this->images, $index, 1);
        }
        return $image;
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