<?php

namespace Admin\Controller;

use Zend\View\Model\ViewModel;
use Zend\Mvc\Controller\AbstractActionController;
use \Admin\Entity\Sexo as Sexo;
use \Admin\Form\Sexo as SexoForm;

/**
 * Controlador que gerencia os sexos
 *
 * @category Admin
 * @package Controller
 * @author  Cezar Junior de Souza <cezar08@unochapeco.edu.br>
 */
class SexosController extends AbstractActionController
{
    /**
     * Exibe os sexos
     * @return void
     */
    public function indexAction()
    {
        $em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        $dados = $em->getRepository('\Admin\Entity\Sexo')->findAll();
        //var_dump($dados);
        //exit;
        return new ViewModel(
            array('sexos' => $dados)
        );
    }

    public function saveAction()
    {
        $form = new SexoForm();
        $request = $this->getRequest();
        $em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');

        if($request->isPost()){
            $values = $request->getPost();
            $sexo = new Sexo();
            $form->setInputFilter($sexo->getInputFilter());
            $form->setData($values);
            if($form->isValid()){
                $values = $form->getData();

                //Para editar
                if ((int)$values['id']>0)
                    $sexo = $em->find('\Admin\Entity\Sexo', $values['id']);
                
                $sexo->setDescricao($values['descricao']);
                $em->persist($sexo);

                try{
                    $em->flush();
                }catch(\Exception $e) {
                    echo $e; exit;
                }

                return $this->redirect()->toURL('/admin/sexos/index');
            }
        }

        $id = $this->params()->fromRoute('id', 0);

        if ($id > 0){
            $sexo = $em->find('\Admin\Entity\Sexo',$id);
            //exibe o valor no form
            $form->bind($sexo);
        }

        return new ViewModel(
            array('form' => $form)
        );
    }

    public function deleteAction()
    {
        $id = $this->params()->fromRoute('id',0);
        $em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');

        if ($id > 0) {
            $sexo = $em->find('\Admin\Entity\Sexo', $id);
            $em->remove($sexo);

            try {
                $em->flush();
            } catch (\Exception $e) {
                echo $e; exit;
            }

            return $this->redirect()->toURL('/admin/sexos');
        }
    }  


        /*$sexo = new Interesse();
        $values = array(
            'id' => 'asdasds',
            'desc_interesse' => 'teste'
        );
        $input_filter = $sexo->getInputFilter();
        $input_filter->setData($values);

        if ($input_filter->isValid() ){
            $values = $input_filter->getValues();
            var_dump($values);
        }else {
            var_dump($input_filter->getMessages());
            exit;
        }

        $sexo->setDescInteresse($values['desc_interesse']);
        $em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        $em->persist($sexo);
        $em->flush();
        //var_dump($sexo);
        exit;*/ 
    
}
