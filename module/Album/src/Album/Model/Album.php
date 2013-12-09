<?php

namespace Album\Model;

use Doctrine\Common\Collections\ArrayCollection;
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
    private $title;

    /**
     * @ORM\ManyToMany(targetEntity="Artist", inversedBy="albums")
     * @ORM\JoinTable(name="albums_artists",
     *      joinColumns={@ORM\JoinColumn(name="album_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="artist_id", referencedColumnName="id")}
     *      )
     */
    private $artists;

    /**
     * @ORM\OneToMany(targetEntity="Song", mappedBy="album", cascade="ALL", orphanRemoval=true, fetch="EXTRA_LAZY")
     */
    private $songs;

    /**
     * @ORM\ElementCollection(tableName="tags")
     */
    private $tags;

    public function __construct() {
        $this->songs = new ArrayCollection();
        $this->artists = new ArrayCollection();
        $this->tags = new ArrayCollection();
    }

    public function getId() {
        return $this->id;
    }

    public function getTitle() {
        return $this->title;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function getArtists() {
        return $this->artists;
    }

    public function setArtists($artists) {
        $this->artists = $artists;
    }

    public function getSongs() {
        return $this->songs;
    }

    public function setSongs($songs) {
        $this->songs = $songs;
    }

    public function getTags() {
        return $this->tags;
    }

    public function setTags($tags) {
        $this->tags = $tags;
    }
    
    public function addTag($tag){
        $this->tags[]=$tag;
    }
    
    public function removeTag($tag){
        $this->tags->removeElement($tag);
    }

    public function toArray() {
        return get_object_vars($this);
    }

}
