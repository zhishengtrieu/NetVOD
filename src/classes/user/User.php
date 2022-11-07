<?php
declare(strict_types=1);
namespace netvod\user;
use netvod\audio\lists\Playlist;
use netvod\db\ConnectionFactory;
use netvod\exception\InvalidPropertyNameException;
class User{
    public static int $ADMIN_USER = 100; 
    private string $email;
    private string $password;
    private int $role;

    public function __construct(string $email, string $password, int $role){
        $this->email = $email;
        $this->password = $password;
        $this->role = $role;
    }

    public function __get($attribut){
        if (property_exists($this, $attribut)){
            return $this->$attribut;
        }else{
            throw new InvalidPropertyNameException($attribut);
        }
    }
    

}
?>
