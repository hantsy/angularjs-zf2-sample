<?php

namespace Album\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Artist extends Person{
  
    /**
     *
     * @ORM\ManyToMany(targetEntity="Album", mappedBy="artists")
     */
    private $albums;
    
    public function __construct() {
        $this->albums=new ArrayCollection();
    }
}
