<?php
namespace netvod\exception;
class InvalidPropertyValueException extends \Exception {
    public function __construct(string $prop){
        parent::__construct("mauvaise valeur de $prop");
    }
}
?>