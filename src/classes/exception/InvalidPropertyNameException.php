<?php
namespace netvod\exception;

//Exception levée lorsqu'on nomme une propriété invalide
class InvalidPropertyNameException extends \Exception {
    public function __construct(string $prop){
        parent::__construct("invalid property : $prop");
    }
}
?>