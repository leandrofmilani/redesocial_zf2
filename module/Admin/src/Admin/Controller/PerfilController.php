<?php

namespace Admin\Controller;

use Zend\View\Model\ViewModel;
use Zend\Mvc\Controller\AbstractActionController;
use \Admin\Form\Perfil as PerfilForm;
use \Admin\Entity\Usuario as Usuario;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use Zend\Paginator\Paginator;

/**
 * Controlador que gerencia os usuÃ¡rios
 *
 * @category Admin
 * @package Controller
 * @author  Cezar Junior de Souza <cezar08@unochapeco.edu.br>
 */
class PerfilController extends AbstractActionController
{

    /**
     * Exibe os usuÃ¡rios
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

        $em =  $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        $query = $em
        ->createQuery('SELECT Usuario FROM \Admin\Entity\Usuario Usuario');
        

        $paginator = new Paginator(
            new DoctrinePaginator(new ORMPaginator($query))
        );


        $paginator
        ->setCurrentPageNumber($this->params()->fromRoute('page'))
        ->setItemCountPerPage(10); //usuarios por pagina

        return new ViewModel(
            array(
                'usuarios' => $paginator
            )
        );
    }

    /**
     * Cria ou edita um usuÃ¡rio
     * @return void
     */
    public function saveAction()
    {
        $em =  $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        $form = new PerfilForm($em);
        $request = $this->getRequest();

        if ($request->isPost()) {
            $usuario = new Usuario();
            $values = $request->getPost();
            $form->setInputFilter($usuario->getInputFilter());
            $form->setData($values);
            $idade = NULL;
            
            if ($form->isValid()) {             
                $values = $form->getData();

                try {
                    $this->getServiceUser()->save($values);
                    $this->flashMessenger()->addSuccessMessage('Usuário armazenado com sucesso');
                } catch (\Exception $e) {
                    $this->flashMessenger()->addErrorMessage($e->getMessage());
                }
                return $this->redirect()->toUrl('/admin/usuarios');
            }
        }
        $id = $this->params()->fromRoute('id', 0);
        if ((int) $id > 0) {
            $form->bind($this->getServiceUser()->get($id));
        }
        return new ViewModel(
            array('form' => $form)
        );
    }  

    /**
     * Exclui um usuÃ¡rio
     * @return void
     */
    public function deleteAction()
    {
    
        $id = $this->params()->fromRoute('id', 0);
        $em =  $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');

        if ($id > 0) {
            $usuario = $em->find('\Admin\Entity\Usuario', $id);

            $contPosts=(count($usuario->getPosts()));
            $posts=$usuario->getPosts();
            
            /*
            Abaixo excluir usuario e seus posts, pra cada post percore um while excluindo os comentarios daquele post.
            */
            $i=0;
            while($i<$contPosts){
            $contComentarios=count($posts[$i]->getComentarios());
            $comentarios=$posts[$i]->getComentarios();
                $j=0;
                while($j<$contComentarios){
                $em->remove($comentarios[$j]);
                $j++;
                }
            $somaComentarios = $somaComentarios + $contComentarios;
            $em->remove($posts[$i]);
            $i++;
            }
            
            $em->remove($usuario);

            try {
                $em->flush();
                $this->flashMessenger()->addSuccessMessage("Usuário removido! <br>Posts removidos do usuário: ".$contPosts."<br>Comentários dos posts removidos: ".(int)$somaComentarios);
            } catch (\Exception $e) {
                $this->flashMessenger()->addErrorMessage('Erro ao excluir usuário');
            }
        }

        return $this->redirect()->toUrl('/admin/usuarios');
    }

     /**
     * @return object
     */
    private function getServiceUser()
    {
        return $this->getServiceLocator()->get('Admin\Service\Perfil');
    }

}
