<?php

namespace Admin\Controller;

use Zend\View\Model\ViewModel;
use Zend\Mvc\Controller\AbstractActionController;
use \Admin\Form\Post as PostForm;
use \Admin\Form\PostUsuario as PostUsuarioForm;
use \Admin\Entity\Post as Post;
use \Admin\Entity\Comentario as Comentario;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use Zend\Paginator\Paginator;
use Zend\Validator\Exception\InvalidMagicMimeFileException;
use Doctrine\ORM\NoResultException;


/**
 * Controlador que gerencia os posts
 *
 * @category Admin
 * @package Controller
 * @author  Cezar Junior de Souza <cezar08@unochapeco.edu.br>
 */
class PostsController extends AbstractActionController
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
            $query = $em->createQuery('SELECT Post FROM \Admin\Entity\Post Post order by Post.id DESC');
        }else {        
            $query = $em->createQuery('SELECT Post FROM \Admin\Entity\Post Post WHERE Post.usuario = :id order by Post.id DESC');
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
                'posts' => $paginator
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
        entao, se vier algo em $id e for usuario tera um form para o usuario editar sem post sem poder ativar/desativar
        se nao obedecer ao if ou nao chegou post, entao 1- é um novo post, onde o usuario podera grava-lo como ativadou ou desativado
        ou 2- é somente o admin editado o post, onde o mesmo terá acesso a tudo inclusive ativar/desativar.
        */
        $id = $this->params()->fromRoute('id', 0);
        
        $form = new PostForm($em);
        
        $request = $this->getRequest();

        //minha alteracao
        $this->getServiceLocator()->get('Admin\Service\Auth');
                $session = $this->getServiceLocator()->get('Session');
                //var_dump($session->offsetGet('id'));
        //var_dump($session);
       // die();

        if ($request->isPost()) {
            $post = new Post();
            $values = $request->getPost();
            //$form->setInputFilter($post->getInputFilter());
            $file = $request->getFiles('photo');
            if (!$file['name'] == NULL){
                $photo = $this->uploadPhoto($file);
            }else{
                $photo == NULL;
            }
            
            $form->setData($values);
            
            if ($form->isValid()) {             
                $values = $form->getData();
                $values['photo'] = $photo;

                if ( (int) $values['id'] > 0)
                $post = $em->find('\Admin\Entity\Post', $values['id']);

                $post->setTitulo($values['titulo']);
                $post->setMinText($values['minText']);
                $post->setPostComp($values['postComp']);
                $post->setVisibilidade($values['visibilidade']);
                $post->setPhoto($values['photo']);
                if ( (int) $values['id'] > 0){
                     // se for edição nao mudará autor..
                }else{
                  $autor = $em->find('\Admin\Entity\Usuario', $session->offsetGet('user'));
                  $post->setUsuario($autor);
                }
              
                $post->setDataPost(new \DateTime('now'));
                $em->persist($post);
                
                try {
                    $em->flush();
                    $this->flashMessenger()->addSuccessMessage('Post armazenado com sucesso');
                } catch (\Exception $e) {
                    $this->flashMessenger()->addErrorMessage($e,'Erro ao armazenar post');
                }

                return $this->redirect()->toUrl('/admin/posts/index');
            }
            else{
                echo"<center><b>FORM INVALIDO</b></center>";
            }
        }

        $id = $this->params()->fromRoute('id', 0);

        if ((int) $id > 0) {
            $post = $em->find('\Admin\Entity\Post', $id);
            $form->bind($post);
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
            $post = $em->find('\Admin\Entity\Post', $id);

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
                $this->flashMessenger()->addSuccessMessage("Post e seus ".$contComents." comentarios excluidos com sucesso");
            } catch (\Exception $e) {
                $this->flashMessenger()->addErrorMessage('Erro ao excluir Post');
            }
        }

        return $this->redirect()->toUrl('/admin/posts/index');
    }

    /**
     * Exibe os usuÃ¡rios
     * @return void
     */
    public function curtidasAction()
    {
        $em =  $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        $request = $this->getRequest();
        $session = $this->getServiceLocator()->get('Session');
        $usuario = $session->offsetGet('user');
        $usuario = $em->find('\Admin\Entity\Usuario', $usuario->getId());    
        $values = $request->getPost();
    
            
            if($values['opcao']=="curtir"){

                    $post = $em->find('\Admin\Entity\Post', $values['id_post']);
                    //IF CONSTEIN SE JA TIVER ACEITADO..
                    $post->getCurtiram()->add($usuario);
                     $em->persist($post);

                try {
                    $em->flush();
                    $this->flashMessenger()->addSuccessMessage('Curtida armazenada com sucesso');
                } catch (\Exception $e) {
                    
                    $this->flashMessenger()->addErrorMessage('Erro ao armazenar curtida');
                }
                
                return $this->redirect()->toUrl('/admin/exibirpost/index/id/'.$values['id_post']);

            }
             if($values['opcao']=="naocurtir"){

                 $post = $em->find('\Admin\Entity\Post', $values['id_post']);
                    //IF CONSTEIN SE JA TIVER ACEITADO..
                    $post->getNaocurtiram()->add($usuario);
                //} PEDIR COMO FAZER O REMOVE PARA REMOVER PRESENCA
                     $em->persist($post);

                try {
                    $em->flush();
                    $this->flashMessenger()->addSuccessMessage('Nao-curti armazenada com sucesso');
                } catch (\Exception $e) {
                    
                    $this->flashMessenger()->addErrorMessage('Erro ao armazenar nao curti');
                }
                
                return $this->redirect()->toUrl('/admin/exibirpost/index/id/'.$values['id_post']);

            }
            if($values['opcao']=="removercurtida"){

                    $post = $em->find('\Admin\Entity\Post', $values['id_post']);
                    //IF CONSTEIN SE JA TIVER ACEITADO..
                    $post->getCurtiram()->removeElement($usuario);
                     $em->persist($post);

                try {
                    $em->flush();
                    $this->flashMessenger()->addSuccessMessage('Curtida removida com sucesso');
                } catch (\Exception $e) {
                    
                    $this->flashMessenger()->addErrorMessage('Erro ao remover curtida');
                }
                
                return $this->redirect()->toUrl('/admin/exibirpost/index/id/'.$values['id_post']);

            }
            if($values['opcao']=="removernaocurtida"){

                    $post = $em->find('\Admin\Entity\Post', $values['id_post']);
                    //IF CONSTEIN SE JA TIVER ACEITADO..
                    $post->getNaocurtiram()->removeElement($usuario);
                     $em->persist($post);

                try {
                    $em->flush();
                    $this->flashMessenger()->addSuccessMessage('Nao-Curtida removida com sucesso');
                } catch (\Exception $e) {
                    
                    $this->flashMessenger()->addErrorMessage('Erro ao remover nao-curtida');
                }
                
                return $this->redirect()->toUrl('/admin/exibirpost/index/id/'.$values['id_post']);

            }     

    }

    public function getPhotoAction()
    {
        header('Content-Type: image');
        $id = (int) $this->params()->fromRoute('id', 0);
        $photo = $this->getPhoto($id);
        $view = new ViewModel(array('photo' => $photo));
        $view->setTerminal(true);

        return $view;
    }

    public function uploadPhoto($file) {
        $target_path = getcwd() . '/public/temp/';
        $target_path = $target_path . basename($file['name']);
        $validator_img = new \Zend\Validator\File\IsImage(array('image/jpg', 'image/png', 'image/jpeg'));
        move_uploaded_file($file['tmp_name'], $target_path);
        if (!$validator_img->isValid($target_path))
            throw new InvalidMagicMimeFileException('O arquivo enviado não é uma imagem válida');

        $rand = uniqid();
        $origem = $target_path;
        $this->thumb($origem);
        $novo = getcwd() . '/public/temp/' . $rand;
        copy($origem, $novo);
        $image = file_get_contents($novo);
        $data = base64_encode($image);
        unlink($origem);
        unlink($novo);

        return $data;
    }

    public function getPhoto($id)
    {
        $em =  $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        $autor = $em->find('\Admin\Entity\Post', (int) $id);
        if ((int) $id <= 0)
            throw new \InvalidArgumentException('Parâmetros inválidos');

        $base = null;

       if ($autor->getPhoto() != null) {
            $stream = stream_get_contents($autor->getPhoto());
            $base = base64_decode($stream);
        }

        return $base;
    }

    private function thumb($origem)
    {
        $size =  getimagesize($origem);
        $image_p = imagecreatetruecolor(300, 260);
        $image = imagecreatefromjpeg($origem);
        imagecopyresampled($image_p, $image, 0, 0, 0, 0, 300, 260, $size[0], $size[1]);
        imagejpeg($image_p, $origem, 50);
    }

}
