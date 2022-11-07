<?php
namespace netvod\exception;
class NonEditablePropertyException extends \Exception {
    public function __construct(string $prop){
        parent::__construct("propriété $prop non modifiable");
    }
}
?>


