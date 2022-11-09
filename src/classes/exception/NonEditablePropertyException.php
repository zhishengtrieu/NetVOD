<?php
namespace netvod\exception;

//Exception levée lorsqu'on essaye de modifier une propriété non modifiable
class NonEditablePropertyException extends \Exception {
    public function __construct(string $prop){
        parent::__construct("propriété $prop non modifiable");
    }
}
?>


