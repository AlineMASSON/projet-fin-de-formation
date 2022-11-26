<?php

namespace App\Service;

class PictureUser
{
    private $link;
    public function __construct(){
        $this->link = 'src/assets/avatar/';
    }
    public function getpictureman(): string
    {
        $linksman = ['nageur.svg', 'joggeur.svg', 'biker.svg'];
        $this->link .= $linksman[mt_rand(0,2)];
        return $this->link;
    }
    public function getpicturewoman(): string
    {
        $linkswoman = ['nageuse.svg', 'joggeuse.svg', 'bikeuse.svg'];
        $this->link .=$linkswoman[mt_rand(0,2)];
        return $this->link;
    }
}