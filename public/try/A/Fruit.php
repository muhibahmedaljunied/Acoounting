<?php
namespace A;
class Fruit {
    private $color;

    public function eat(...$argments) {
        
        echo __CLASS__.'arquments'.$argments['name'];
    }

    public function setColor($c) {
        $this->color = $c;
    }
}
