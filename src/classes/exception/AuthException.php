<?php
namespace netvod\exception;
class AuthException extends \Exception {
    public function __construct(string $prop){
        parent::__construct($prop);
    }
}
?>