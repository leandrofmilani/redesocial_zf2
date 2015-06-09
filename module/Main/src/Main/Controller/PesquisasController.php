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

        if ( (isset($q_user[0])) && (!isset($q_evento[0])) ) {
            $resultado = $query_user;
        }elseif ( (!isset($q_user[0])) && (isset($q_evento[0])) ) {
            $resultado = $query_evento;
        }else //( (!isset($q_user[0])) && (!isset($q_evento[0])) ) {
            {
            echo "<div class='alert alert-warning' align='center'><h1>@@@@@@@@@NADAAAAA '".$pesquisa."'.</h1></div>";
            echo "<meta HTTP-EQUIV='refresh' CONTENT='3;URL=/'>";
            $resultado = $query_evento;
        }

        /*// Logica para verificar se obteve resultado
        $q_user = $query_user->getResult();
        if (isset($q_user[0]) == NULL){
            echo "<div class='alert alert-warning' align='center'><h1>USER-Nenhum resultado encontrado para '".$pesquisa."'.</h1></div>";
            echo "<meta HTTP-EQUIV='refresh' CONTENT='3;URL=/'>";
        }

        // Logica para verificar se obteve resultado
        $q_evento = $query_evento->getResult();
        if (isset($q_evento[0]) == NULL){
            echo "<div class='alert alert-warning' align='center'><h1>EVENTO-Nenhum resultado encontrado para '".$pesquisa."'.</h1></div>";
            echo "<meta HTTP-EQUIV='refresh' CONTENT='3;URL=/'>";
        }*/

        $paginator = new Paginator(
            new DoctrinePaginator(new ORMPaginator($resultado))
        );

        $paginator
        ->setCurrentPageNumber($this->params()->fromRoute('page'))
        ->setItemCountPerPage(10);

        return new ViewModel(
            array(
                'pesquisas' => $paginator,
            )
        );
    
    }

}
