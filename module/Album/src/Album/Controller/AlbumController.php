<?php

namespace Album\Controller;

use Album\Form\AlbumForm;
use Album\Model\Album;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

class AlbumController extends AbstractRestfulController {

    public function getList() {
        $results = $this->getAlbumTable()->fetchAll();
        $data = array();
        foreach ($results as $result) {
            $data[] = $result;
        }

        return new JsonModel(array(
            'data' => $data)
        );
    }

    public function get($id) {
        $album = $this->getAlbumTable()->getAlbum($id);
        return new JsonModel(array("data" => $album));
    }

    public function create($data) {
        
        $data['id']=0;
        $form = new AlbumForm();
        $album = new Album();
        $form->setInputFilter($album->getInputFilter());
        $form->setData($data);

        $id=0;
        if ($form->isValid()) {
            $album->exchangeArray($form->getData());
            $id = $this->getAlbumTable()->saveAlbum($album);
        }else {           
          print_r(  $form->getMessages());
        }

        return new JsonModel(array(
            'data' => $id,
        ));
    }

    public function update($id, $data) {
        $data['id'] = $id;
        $album = $this->getAlbumTable()->getAlbum($id);
        $form = new AlbumForm();
        $form->bind($album);
        $form->setInputFilter($album->getInputFilter());
        $form->setData($data);
        
        if ($form->isValid()) {
            $id = $this->getAlbumTable()->saveAlbum($form->getData());
        }

        return new JsonModel(array(
            'data' => $id,
        ));
    }

    public function delete($id) {
        $this->getAlbumTable()->deleteAlbum($id);

        return new JsonModel(array(
            'data' => 'deleted',
        ));
    }

    protected $albumTable;

    public function getAlbumTable() {
        if (!$this->albumTable) {
            $sm = $this->getServiceLocator();
            $this->albumTable = $sm->get('Album\Model\AlbumTable');
        }
        return $this->albumTable;
    }

}
