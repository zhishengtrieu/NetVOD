<?php
namespace netvod\exception;
class AccessControlException extends \Exception {
    public function __construct(string $prop){
        parent::__construct($prop);
    }
}
?>