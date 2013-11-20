<?php

namespace Album\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Artist {

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /** @ORM\Column(type="string") */
    private $name;
    
    /**
     *
     * @ORM\ManyToMany(targetEntity="Album", mappedBy="artists")
     */
    private $albums;
    
    public function __construct() {
        $this->albums=new ArrayCollection();
    }

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setName($name) {
        $this->name = $name;
    }

}
