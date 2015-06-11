<?php
namespace Admin\Service;

use Core\Service\Service;
use Doctrine\ORM\NoResultException;

/**
 * 
 *
 * @category Admin
 * @package Service
 * @author 
 */
class Perfil extends Service
{

    /**
     * @var string
     */
    protected $entity = '\Admin\Entity\Usuario';

    /**
     * @param $id
     * @return null|object
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\TransactionRequiredException
     * @throws \NoResultException
     */
    public function get($id)
    {
        $obj = $this->getEm()->find($this->entity, (int) $id);

        if (!$obj)
            throw new \NoResultException('Usuário não encontrado');

        return $obj;
    }

    /**
     * @param $data
     * @return null|object
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\TransactionRequiredException
     */
    public function save($data)
    {
        $usuario = new $this->entity();
        $filters = $usuario->getInputFilter();
        $filters->setData($data);

        if (!$filters->isValid())
            throw new \InvalidArgumentException('Dados inválidos');

        $data = $filters->getValues();
       /* var_dump($data);
        die();*/   
        if ( (int) $data['id'] > 0)
            $usuario = $this->getEm()->find($this->entity, $data['id']);
        
        $usuario->setNome($data['nome']);
        $usuario->setSobrenome($data['sobrenome']);
        $usuario->setEmail($data['email']);
        $usuario->setCelular($data['celular']);
        $usuario->setSenha($data['senha']);
        $usuario->setEndereco($data['endereco']);
        $usuario->setProfissao($data['profissao']);
        $usuario->setLocaltrabalho($data['localtrabalho']);
        $usuario->setFormacao($data['formacao']);
        $usuario->setRole($data['role']);
        $usuario->setDataNasc(new \DateTime($data['dataNasc']));
        $sexo = $this->getEm()->find('\Admin\Entity\Sexo', $data['sexo']);
        $relacionamento = $this->getEm()->find('\Admin\Entity\Relacionamento', $data['relacionamento']);
        $usuario->setSexo($sexo);
        $usuario->setRelacionamento($relacionamento);

        $this->getEm()->persist($usuario);
        $this->getEm()->flush();

        return $usuario;
    }

    /**
     * @param $id
     * @return null|object
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\TransactionRequiredException
     * @throws \NoResultException
     */
    public function delete($id)
    {
        $obj = $this->getEm()->find($this->entity, (int) $id);

        if (!$obj)
            throw new \NoResultException('Usuário não encontrado');

        $this->getEm()->remove($obj);
        $this->getEm()->flush();
    }

}

