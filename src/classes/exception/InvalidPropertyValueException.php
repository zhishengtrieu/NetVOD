<?php
namespace netvod\exception;

//Exception levée lorsqu'on essaye de modifier une propriété avec une mauvaise valeur
class InvalidPropertyValueException extends \Exception {
    public function __construct(string $prop){
        parent::__construct("mauvaise valeur de $prop");
    }
}
?>