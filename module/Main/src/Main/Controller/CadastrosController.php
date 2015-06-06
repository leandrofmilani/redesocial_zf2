<?php

namespace Main\Controller;

use Zend\View\Model\ViewModel;
use Zend\Mvc\Controller\AbstractActionController;
use \Main\Form\Cadastro as CadastroForm;
use \Admin\Entity\Usuario as Usuario;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use Zend\Paginator\Paginator;

/**
 * Controlador que gerencia os cadastros dos usuarios
 *
 * @category Main
 * @package Controller
 * @author  Leandro Fabris Milani <lfm@unochapeco.edu.br>
 */
class CadastrosController extends AbstractActionController
{

    /**
     * Cria novo usuario
     * @return void
     */
    public function novoAction()
    {
        $em =  $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        $form = new CadastroForm($em);
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
                    echo "<div class='alert alert-danger' align='center'><h1>Você é menor de 16 anos. Impossível se cadastrar! :(</h1></div>";
                    echo "<meta HTTP-EQUIV='refresh' CONTENT='5;URL=/'>";
                    return new ViewModel(
                        array('form' => $form)
                    );
                }

                $usuario->setNome($values['nome']);
                $usuario->setSobrenome($values['sobrenome']);
                $usuario->setEmail($values['email']);
                $usuario->setCelular($values['celular']);
                $usuario->setSenha($values['senha']);
                $usuario->setRole($values['role']);
                $usuario->setDataNasc($datanascimento);
                $sexo = $em->find('\Admin\Entity\Sexo', $values['sexo']);
                $usuario->setSexo($sexo);
                $em->persist($usuario);

                try {
                    $em->flush();
                    $this->flashMessenger()->addSuccessMessage('Cadastro realizado com sucesso!');
                } catch (\Exception $e) {
                    $this->flashMessenger()->addErrorMessage('Erro ao armazenar usuário');
                }

                return $this->redirect()->toUrl('/');
            }
            else{
                echo"<center><b>FORM INVÁLIDO</b></center>";
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

}
