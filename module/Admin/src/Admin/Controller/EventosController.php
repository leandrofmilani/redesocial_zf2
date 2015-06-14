<?php

namespace Admin\Controller;

use Zend\View\Model\ViewModel;
use Zend\Mvc\Controller\AbstractActionController;
use \Admin\Form\Evento as EventoForm;
use \Admin\Entity\Evento as Evento;
use \Admin\Entity\Comentario as Comentario;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use Zend\Paginator\Paginator;


/**
 * Controlador que gerencia os posts
 *
 * @category Admin
 * @package Controller
 * @author  Cezar Junior de Souza <cezar08@unochapeco.edu.br>
 */
class EventosController extends AbstractActionController
{

    /**
     * Exibe os posts
     * @return void
     */
    public function indexAction()
    {
      
        $session = $this->getServiceLocator()->get('Session');

        if (!$session->offsetGet('user')) {
            $this->flashMessenger()
            ->addErrorMessage('Voce precisa logar'); 

            return $this->redirect()->toUrl('/admin/login');                       
        }
        
        //var para fazer consulta no DB
        $id = $session->offsetGet('id');
        $em =  $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');

        if ($role = $session->offsetGet('role') == 'ADMIN'){
            $query = $em->createQuery('SELECT Evento FROM \Admin\Entity\Evento Evento order by Evento.id DESC');
        }else {        
            $query = $em->createQuery('SELECT Evento FROM \Admin\Entity\Evento Evento WHERE Evento.usuario = :id order by Evento.id DESC');
            $query->setParameters(array('id' => $id));
        }
        

        $paginator = new Paginator(
            new DoctrinePaginator(new ORMPaginator($query))
        );


        $paginator
        ->setCurrentPageNumber($this->params()->fromRoute('page'))
        ->setItemCountPerPage(10);

        return new ViewModel(
            array(
                'eventos' => $paginator
            )
        );
    }

    /**
     * Cria ou edita um post
     * @return void
     */
    public function saveAction()
    {
        $em =  $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');

        /*
        Se chegar algo em $id entao é uma edição, ainda vai comprar se é usuario,
        entao, se vier algo em $id e for usuario teré um form para o usuario editar sem post sem poder ativar/desativar
        se nao obedecer ao if ou nao chegou post, entao 1- é um novo post, onde o usuario podera grava-lo como ativadou ou desativado
        ou 2- é somente o admin editado o post, onde o mesmo terá acesso a tudo inclusive ativar/desativar.
        */
        $id = $this->params()->fromRoute('id', 0);
        
        $form = new EventoForm($em);
        
        $request = $this->getRequest();

        //minha alteracao
        $this->getServiceLocator()->get('Admin\Service\Auth');
                $session = $this->getServiceLocator()->get('Session');
                //var_dump($session->offsetGet('id'));
        //var_dump($session);
       // die();

        if ($request->isPost()) {
            $evento = new Evento();
            $values = $request->getPost();
            //$form->setInputFilter($post->getInputFilter());
            $form->setData($values);
            
            if ($form->isValid()) {             
                $values = $form->getData();


                if ( (int) $values['id'] > 0)
                $evento = $em->find('\Admin\Entity\Evento', $values['id']);

                $evento->setTitulo($values['titulo']);
                $evento->setMinText($values['minText']);
                $evento->setEventoComp($values['eventoComp']);
               // $user = $session->offsetGet('user');

                /*
                se for uma edição nao irá mudar o id do autor,
                se for um novo post irá setar o id do autor
                */
                if ( (int) $values['id'] > 0){
                     // se for edição nao mudará autor..
                }else{
                  $autor = $em->find('\Admin\Entity\Usuario', $session->offsetGet('user'));
                  $evento->setUsuario($autor);
                }
              
                $evento->setDataEvento(new \DateTime('now'));
                $em->persist($evento);

                try {
                    $em->flush();
                    $this->flashMessenger()->addSuccessMessage('Evento armazenado com sucesso');
                } catch (\Exception $e) {
                    $this->flashMessenger()->addErrorMessage($e,'Erro ao armazenar evento');
                }

                return $this->redirect()->toUrl('/admin/eventos/index');
            }
            else{
                echo"<center><b>FORM INVALIDO</b></center>";
            }
        }

        $id = $this->params()->fromRoute('id', 0);

        if ((int) $id > 0) {
            $evento = $em->find('\Admin\Entity\Evento', $id);
            $form->bind($evento);
        }

        return new ViewModel(
            array('form' => $form)
        );
    }    

    /**
     * Exclui um post
     * @return void
     */
    public function deleteAction()
    {
        $id = $this->params()->fromRoute('id', 0);
        $em =  $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');

        if ($id > 0) {
            $post = $em->find('\Admin\Entity\Evento', $id);

            $contComents=(count($post->getComentarios()));
            $comentarios=$post->getComentarios();

            //echo $contComents;

            $i=0;
            while($i<$contComents){
            $em->remove($comentarios[$i]);
            $i++;
            }

            $em->remove($post);

            try {
                $em->flush();
                $this->flashMessenger()->addSuccessMessage("Evento e seus ".$contComents." comentarios excluidos com sucesso");
            } catch (\Exception $e) {
                $this->flashMessenger()->addErrorMessage('Erro ao excluir evento');
            }
        }

        return $this->redirect()->toUrl('/admin/eventos/index');
    }

    /**
     * Exibe os usuÃ¡rios
     * @return void
     */
    public function confirmarpresencaAction()
    {
        $em =  $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        $request = $this->getRequest();
        $session = $this->getServiceLocator()->get('Session');
        $usuario = $session->offsetGet('user');
        $usuario = $em->find('\Admin\Entity\Usuario', $usuario->getId());    
        $values = $request->getPost();
    
            
            if($values['opcao']=="confirmar"){

                    $evento = $em->find('\Admin\Entity\Evento', $values['id_evento']);
                    //IF CONSTEIN SE JA TIVER ACEITADO..
                    $evento->getParticipantes()->add($usuario);
                     $em->persist($evento);

                try {
                    $em->flush();
                    $this->flashMessenger()->addSuccessMessage('Presenca confirmada com sucesso');
                } catch (\Exception $e) {
                    
                    $this->flashMessenger()->addErrorMessage('Erro ao armazenar presenca');
                }
                
                return $this->redirect()->toUrl('/admin/exibirevento/index/id/'.$values['id_evento']);

            }
             if($values['opcao']=="remover"){

                 $evento = $em->find('\Admin\Entity\Evento', $values['id_evento']);
                    //IF CONSTEIN SE JA TIVER ACEITADO..
                    $evento->getParticipantes()->removeElement($usuario);
                //} PEDIR COMO FAZER O REMOVE PARA REMOVER PRESENCA
                     $em->persist($evento);

                try {
                    $em->flush();
                    $this->flashMessenger()->addSuccessMessage('Presenca removida com sucesso');
                } catch (\Exception $e) {
                    
                    $this->flashMessenger()->addErrorMessage('Erro ao remover presenca');
                }
                
                return $this->redirect()->toUrl('/admin/exibirevento/index/id/'.$values['id_evento']);

            }     

    }

    /**
     * Exibe os posts
     * @return void
     */
    public function mostrartodosAction()
    {
      
        $session = $this->getServiceLocator()->get('Session');

        if (!$session->offsetGet('user')) {
            $this->flashMessenger()
            ->addErrorMessage('Voce precisa logar'); 

            return $this->redirect()->toUrl('/admin/login');                       
        }
        
        //var para fazer consulta no DB
        $id = $session->offsetGet('id');
        $em =  $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');

       
        $query = $em->createQuery('SELECT Evento FROM \Admin\Entity\Evento Evento order by Evento.id DESC');
    
        

        $paginator = new Paginator(
            new DoctrinePaginator(new ORMPaginator($query))
        );


        $paginator
        ->setCurrentPageNumber($this->params()->fromRoute('page'))
        ->setItemCountPerPage(10);

        return new ViewModel(
            array(
                'eventos' => $paginator
            )
        );
    }

}
