<?php


namespace EasyChunYu\Kernel\Support;


class Message
{
    private $bag;

    public function __construct()
    {
        $this->bag = [];
    }

    public function addText($text) {
        $this->bag[] = [
            'type' => 'text',
            'text' => $text
        ];
        return $this;
    }
    public function addImage($imageUrl) {
        $this->bag[] = [
            'type' => 'image',
            'file' => $imageUrl
        ];
        return $this;
    }

    public function addAudio($audioUrl) {
        $this->bag[] = [
            'type' => 'audio',
            'file' => $audioUrl
        ];
        return $this;
    }

    public function addMeta($age, $gender) {
        $this->bag[] = [
            'type' => 'patient_meta',
            'age' => $age,
            'sex' => $gender
        ];
        return $this;
    }

    public function build() {
        return json_encode($this->bag, JSON_UNESCAPED_UNICODE);
    }

}
