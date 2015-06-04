<?php

namespace Admin\Controller;

use Zend\View\Model\ViewModel;
use Zend\Mvc\Controller\AbstractActionController;
use \Admin\Entity\Relacionamento as Relacionamento;
use \Admin\Form\Relacionamento as RelacionamentoForm;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use Zend\Paginator\Paginator;

/**
 * Controlador que gerencia os interesses
 *
 * @category Admin
 * @package Controller
 * @author  Josemar Fuzinatto <josemarfuzinatto@unochapeco.edu.br>
 */
class RelacionamentosController extends AbstractActionController
{
    /**
     * Exibe os interesses
     * @return void
     */
    public function indexAction()
    {
        
        $em =  $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        $query = $em->createQuery('SELECT Relacionamento FROM \Admin\Entity\Relacionamento Relacionamento');
        

        $paginator = new Paginator(
            new DoctrinePaginator(new ORMPaginator($query))
        );


        $paginator
        ->setCurrentPageNumber($this->params()->fromRoute('page'))
        ->setItemCountPerPage(10);

        return new ViewModel(
            array(
                'relacionamentos' => $paginator
            )
        );
    }

    public function saveAction()
    {
        $form = new RelacionamentoForm();
        $request = $this->getRequest();
        $em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');

        if($request->isPost()){
            $values = $request->getPost();
            $relacionamento = new Relacionamento();
           // $form->setInputFilter($relacionamento->getInputFilter());
            $form->setData($values);
            if($form->isValid()){
                $values = $form->getData();

                //Para editar
                if ((int)$values['id']>0)
                    $relacionamento = $em->find('\Admin\Entity\Relacionamento', $values['id']);
                
                $relacionamento->setDescRelacionamento($values['desc_relacionamento']);
                $em->persist($relacionamento);

                try{
                    $em->flush();
                }catch(\Exception $e) {
                    echo $e; exit;
                }

                return $this->redirect()->toURL('/admin/relacionamentos/index');
            }
        }

        $id = $this->params()->fromRoute('id', 0);

        if ($id > 0){
            $relacionamento = $em->find('\Admin\Entity\Relacionamento',$id);
            //exibe o valor no form
            $form->bind($relacionamento);
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
            $relacionamento = $em->find('\Admin\Entity\Relacionamento', $id);
            $em->remove($relacionamento);

            try {
                $em->flush();
            } catch (\Exception $e) {
                echo $e; exit;
            }

            return $this->redirect()->toURL('/admin/relacionamentos');
        }
    }   


        /*$interesse = new Interesse();
        $values = array(
            'id' => 'asdasds',
            'desc_interesse' => 'teste'
        );
        $input_filter = $interesse->getInputFilter();
        $input_filter->setData($values);

        if ($input_filter->isValid() ){
            $values = $input_filter->getValues();
            var_dump($values);
        }else {
            var_dump($input_filter->getMessages());
            exit;
        }

        $interesse->setDescInteresse($values['desc_interesse']);
        $em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        $em->persist($interesse);
        $em->flush();
        //var_dump($interesse);
        exit;*/ 
    
}
