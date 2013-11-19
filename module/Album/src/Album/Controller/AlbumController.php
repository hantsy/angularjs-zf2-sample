<?php

namespace Album\Controller;

use Album\Model\Album;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

class AlbumController extends AbstractRestfulController {

    public function getList() {
        $em = $this
                ->getServiceLocator()
                ->get('Doctrine\ORM\EntityManager');

        $results= $em->createQuery('select a from Album\Model\Album as a')->getArrayResult();

       
        return new JsonModel(array(
            'data' => $results)
        );
    }

    public function get($id) {
        $em = $this
                ->getServiceLocator()
                ->get('Doctrine\ORM\EntityManager');

        $album = $em->find('Album\Model\Album', $id);
        
//        print_r($album->toArray());
//        
        return new JsonModel(array("data" => $album->toArray()));
    }

    public function create($data) {
        $em = $this
                ->getServiceLocator()
                ->get('Doctrine\ORM\EntityManager');

        $album = new Album();
        $album->setArtist($data['artist']);
        $album->setTitle($data['title']);

        $em->persist($album);
        $em->flush();

        return new JsonModel(array(
            'data' => $album->getId(),
        ));
    }

    public function update($id, $data) {
        $em = $this
                ->getServiceLocator()
                ->get('Doctrine\ORM\EntityManager');

        $album = $em->find('Album\Model\Album', $id);
        $album->setArtist($data['artist']);
        $album->setTitle($data['title']);

        $album = $em->merge($album);
        $em->flush();

        return new JsonModel(array(
            'data' => $album->getId(),
        ));
    }

    public function delete($id) {
        $em = $this
                ->getServiceLocator()
                ->get('Doctrine\ORM\EntityManager');

        $album = $em->find('Album\Model\Album', $id);
        $em->remove($album);
        $em->flush();

        return new JsonModel(array(
            'data' => 'deleted',
        ));
    }

}
