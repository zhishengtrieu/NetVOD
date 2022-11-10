<?php
declare(strict_types=1);
namespace netvod\exception;

/**
 * Exception levée lorsqu'on a pas les droits pour accéder à une propriété
 */
class AccessControlException extends \Exception {
    public function __construct(string $prop){
        parent::__construct($prop);
    }
}
?>