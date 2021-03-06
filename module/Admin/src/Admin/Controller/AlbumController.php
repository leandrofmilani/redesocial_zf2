<?php

namespace Admin\Controller;

use Zend\View\Model\ViewModel;
use Zend\Mvc\Controller\AbstractActionController;
use \Admin\Form\Album as AlbumForm;
use \Admin\Entity\Album as Album;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use Zend\Paginator\Paginator;
use Zend\Validator\Exception\InvalidMagicMimeFileException;

/**
 * Controlador que gerencia os usuÃ¡rios
 *
 * @category Admin
 * @package Controller
 * @author  Leandro Fabris Milani <lfm@unochapeco.edu.br>
 */
class AlbumController extends AbstractActionController
{

    public function indexAction()
    {
        $em =  $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        /*$session = $this->getServiceLocator()->get('Session');
        $usuario = $session->offsetGet('user');*/

        $id = $this->params()->fromRoute('id', 0);
        $em =  $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        $query = $em->createQuery('SELECT Album FROM \Admin\Entity\Album Album WHERE Album.usuario = :id');         
        $query->setParameters(array('id' => $id));



        $paginator = new Paginator(
            new DoctrinePaginator(new ORMPaginator($query))
        );

        $paginator
        ->setCurrentPageNumber($this->params()->fromRoute('page'))
        ->setItemCountPerPage(10);

        return new ViewModel(
            array(
                'fotos' => $paginator,
                'id_album' => $id,
            )
        );
    
    }

    public function saveAction()
    {
        $em =  $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        $form = new AlbumForm($em);
        $request = $this->getRequest();
        $id = $this->getServiceLocator()->get('Session')->offsetGet('user')->getId();

        if ($request->isPost()) {
            $album = new Album();
            $values = $request->getPost();
            $file = $request->getFiles('photo');
            $photo = $this->getServiceUser()->uploadPhoto($file);
            $form->setInputFilter($album->getInputFilter());
            $form->setData($values);
            
            if ($form->isValid()) {             
                $values = $form->getData();
                $values['photo'] = $photo;
                $values['id'] = $id;

                try {
                    $this->getServiceUser()->save($values);
                    $this->flashMessenger()->addSuccessMessage('Álbum armazenado com sucesso');
                } catch (\Exception $e) {
                    $this->flashMessenger()->addErrorMessage($e->getMessage());
                }
                return $this->redirect()->toUrl('/admin/album/index/id/'.$id);
            }
        }

        if ((int) $id > 0) {
            $form->bind($this->getServiceUser()->get($id));
        }
        return new ViewModel(
            array('form' => $form)
        );
    }

    public function deleteAction()
    {
        $id = $this->params()->fromRoute('id', 0);
        if ($id > 0) {
            try {
                $this->getServiceUser()->delete($id);
                $this->flashMessenger()->addSuccessMessage('Imagem excluída com sucesso');
            } catch (\Exception $e) {
                $this->flashMessenger()->addErrorMessage($e->getMessage());
            }
        }
        $id_retorno = $this->getServiceLocator()->get('Session')->offsetGet('user')->getId();
        return $this->redirect()->toUrl('/admin/album/index/id/'.$id_retorno);
    }

    public function getPhotoAction()
    {
        header('Content-Type: image');
        $id = (int) $this->params()->fromRoute('id', 0);
        $photo = $this->getServiceUser()->getPhoto($id);
        $view = new ViewModel(array('photo' => $photo));
        $view->setTerminal(true);

        return $view;
    }

     /**
     * @return object
     */
    private function getServiceUser()
    {
        return $this->getServiceLocator()->get('Admin\Service\Album');
    }

}