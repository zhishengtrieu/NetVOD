<?php
namespace netvod\exception;
class InvalidPropertyNameException extends \Exception {
    public function __construct(string $prop){
        parent::__construct("invalid property : $prop");
    }
}
?>