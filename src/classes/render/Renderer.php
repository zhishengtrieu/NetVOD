<?php 
declare(strict_types=1);
namespace netvod\render;
interface Renderer{
    const COMPACT = 1;
    const LONG = 2;

    function render(int $selector):string;

}

?>