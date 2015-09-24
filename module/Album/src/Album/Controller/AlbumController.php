<?php
namespace Album\Controller;

use Album\Model\Album;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

class AlbumController extends AbstractRestfulController
{
    public function getList()
    {
        $em = $this->getServiceLocator()
            ->get('Doctrine\ORM\EntityManager');

        $results= $em->createQuery('select a, u from Album\Model\Album a join a.artists u')->getArrayResult();

        return new JsonModel([
            'data' => $results
        ]);
    }

    public function get($id)
    {
        $em = $this->getServiceLocator()
            ->get('Doctrine\ORM\EntityManager');

        $album = $em->find('Album\Model\Album', $id);

        $results = $em->createQuery('select a, u, s from Album\Model\Album a join a.artists u join a.songs s where a.id=:id')
            ->setParameter("id", $id)
            ->getArrayResult();

        return new JsonModel($results[0]);
    }

    public function create($data)
    {
        $em = $this->getServiceLocator()
            ->get('Doctrine\ORM\EntityManager');

        $album = new Album();
        
        $album->setArtist($data['artist']);
        $album->setTitle($data['title']);

        $em->persist($album);
        $em->flush();

        return new JsonModel([
            'data' => $album->getId()
        ]);
    }

    public function update($id, $data)
    {
        $em = $this->getServiceLocator()
            ->get('Doctrine\ORM\EntityManager');

        $album = $em->find('Album\Model\Album', $id);
        
        $album->setArtist($data['artist']);
        $album->setTitle($data['title']);

        $album = $em->merge($album);
        $em->flush();

        return new JsonModel([
            'data' => $album->getId()
        ]);
    }

    public function delete($id)
    {
        $em = $this->getServiceLocator()
            ->get('Doctrine\ORM\EntityManager');

        $album = $em->find('Album\Model\Album', $id);
        
        $em->remove($album);
        
        $em->flush();

        return new JsonModel([
            'data' => 'deleted'
        ]);
    }
}
