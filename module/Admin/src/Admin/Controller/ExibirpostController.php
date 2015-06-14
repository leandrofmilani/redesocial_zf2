<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonMain for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use Zend\Paginator\Paginator;

class ExibirpostController extends AbstractActionController
{
    public function indexAction()
    {
        $em =  $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        $session = $this->getServiceLocator()->get('Session');
        $usuario = $session->offsetGet('user');

        $postRequerido = NULL;

        $id = $this->params()->fromRoute('id', 0);
        $query = $em->createQuery('SELECT Post FROM \Admin\Entity\Post Post WHERE Post.id = :id order by Post.id DESC');         
        $query->setParameters(array('id' => $id));
        $postRequerido = $query->getResult();

          $meusdados = NULL;
        
        if (is_object($usuario)){
            $id2 = $usuario->getId();
            $em =  $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
            $query2 = $em->createQuery('SELECT Usuario FROM \Admin\Entity\Usuario Usuario WHERE Usuario.id = :id2');         
            $query2->setParameters(array('id2' => $id2));
            $meusdados = $query2->getResult();
        }


        return new ViewModel(
            array(
                'posts' => $postRequerido,
                'meusdados' => $meusdados,
            )
        );
    
    }

    public function comentarAction()
    {

    }

    public function deleteAction()
    {
    	
    }
}
