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

class PesquisasController extends AbstractActionController
{
    public function indexAction()
    {

        $request = $this->getRequest();
        if ($request->isPost()) {
            $result = $request->getPost();
            $pesquisa = $result['pesquisa'];
        }

        $em =  $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        $query_user = $em->createQuery("SELECT Usuario FROM \Admin\Entity\Usuario Usuario WHERE Usuario.nome LIKE :pesquisa or Usuario.sobrenome LIKE :pesquisa");
        $query_user->setParameter('pesquisa', '%'.$pesquisa.'%');
        $query_evento = $em->createQuery("SELECT Evento FROM \Admin\Entity\Evento Evento WHERE Evento.titulo LIKE :pesquisa");
        $query_evento->setParameter('pesquisa', '%'.$pesquisa.'%');

        $q_user = $query_user->getResult();
        $q_evento = $query_evento->getResult();

        if (count($q_user) >= count($q_evento)){
            $paginas = $query_user;
        }else{
            $paginas = $query_evento;
        }

        $paginator = new Paginator(
            new DoctrinePaginator(new ORMPaginator($paginas))
        );

        $paginator
        ->setCurrentPageNumber($this->params()->fromRoute('page'))
        ->setItemCountPerPage(10);

        return new ViewModel(
            array(
                'paginas' => $paginator,
                'usuarios' => $q_user,
                'eventos' => $q_evento,
            )
        );
    
    }

}
