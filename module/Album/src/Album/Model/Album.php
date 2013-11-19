<?php

namespace Album\Model;

use Exception;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Album {

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /** @ORM\Column(type="string") */
    private $artist;

    /** @ORM\Column(type="string") */
    private $title;


    public function getId() {
        return $this->id;
    }

    public function getArtist() {
        return $this->artist;
    }

    public function getTitle() {
        return $this->title;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setArtist($artist) {
        $this->artist = $artist;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function toArray(){
        return get_object_vars($this);
    }
}
