<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonMain for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Main\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use Zend\Paginator\Paginator;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        $em =  $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        $session = $this->getServiceLocator()->get('Session');
        $usuario = $session->offsetGet('user');
        


        $em =  $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        $query = $em->createQuery("SELECT Post FROM \Admin\Entity\Post Post order by Post.id DESC");         

        $paginator = new Paginator(
            new DoctrinePaginator(new ORMPaginator($query))
        );

        $paginator
        ->setCurrentPageNumber($this->params()->fromRoute('page'))
        ->setItemCountPerPage(10);

      if (is_object($usuario)){
            $id2 = $usuario->getId();
            $em =  $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
            $query2 = $em->createQuery('SELECT Usuario FROM \Admin\Entity\Usuario Usuario WHERE Usuario.id = :id2');         
            $query2->setParameters(array('id2' => $id2));
            $paginator2 = new Paginator(
                new DoctrinePaginator(new ORMPaginator($query2))
            );

            $paginator2->setCurrentPageNumber($this->params()->fromRoute('page'))
            ->setItemCountPerPage(10);
        }
        
   

        if(isset($id2)){
            return new ViewModel(
                 array(
                'posts' => $paginator,
                'meusdados' => $paginator2,
                 )
            );
         }else{
            return new ViewModel(
                array(
                'posts' => $paginator,
                )
            );
        }
    
    }

    public function comentarAction()
    {

    }

    public function deleteAction()
    {
    	
    }
}
