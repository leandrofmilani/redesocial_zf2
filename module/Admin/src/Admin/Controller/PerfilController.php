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
            
            if ($form->isValid()) {             
                $values = $form->getData();

                if ( (int) $values['id'] > 0)
                    $usuario = $em->find('\Admin\Entity\Usuario', $values['id']);

                //Logica para pegar idade (fazer function)
                $data_atual = (new \DateTime("now"));
                $datanascimento = (new \DateTime($values['dataNasc']));
                $intervalo = date_diff($data_atual, $datanascimento);
                $idade = $intervalo->y;

                if ($idade < 16) {
                    echo "<meta HTTP-EQUIV='refresh' CONTENT='0;URL=/admin/usuarios/save'>";
                    $this->flashMessenger()->addErrorMessage('Não é possivel cadastrar menores de 16 anos de idade!');
                    
                    return new ViewModel(
                        array('form' => $form)
                    );
                }

                $usuario->setNome($values['nome']);
                $usuario->setSobrenome($values['sobrenome']);
                $usuario->setEmail($values['email']);
                $usuario->setCelular($values['celular']);
                $usuario->setSenha($values['senha']);
                $usuario->setEndereco($values['endereco']);
                $usuario->setProfissao($values['profissao']);
                $usuario->setLocaltrabalho($values['localtrabalho']);
                $usuario->setFormacao($values['formacao']);
                $usuario->setRole($values['role']);
                $usuario->setDataNasc(new \DateTime($values['dataNasc']));
                $sexo = $em->find('\Admin\Entity\Sexo', $values['sexo']);
                $relacionamento = $em->find('\Admin\Entity\Relacionamento', $values['relacionamento']);
                $usuario->setSexo($sexo);
                $usuario->setRelacionamento($relacionamento);
                $em->persist($usuario);

                try {
                    $em->flush();
                    $this->flashMessenger()->addSuccessMessage('Usuário armazenado com sucesso');
                } catch (\Exception $e) {
                    $this->flashMessenger()->addErrorMessage('Erro ao armazenar usuário');
                }

                return $this->redirect()->toUrl('/admin/usuario/index');
            }
            else{
                echo"<center><b>FORM INVALIDO</b></center>";
            }
        }

        $id = $this->params()->fromRoute('id', 0);

        if ((int) $id > 0) {
            $usuario = $em->find('\Admin\Entity\Usuario', $id);
            $form->bind($usuario);
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

}
