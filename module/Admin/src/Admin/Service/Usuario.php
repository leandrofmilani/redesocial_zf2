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
class Usuario extends Service
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
        if ( (int) $data['id'] > 0)
            $usuario = $this->getEm()->find($this->entity, $data['id']);
        
        $usuario->setNome($data['nome']);
        $usuario->setSobrenome($data['sobrenome']);
        $usuario->setEmail($data['email']);
        $usuario->setCelular($data['celular']);
        $usuario->setSenha($data['senha']);
        if($data['visibilidadePerfil'] != null )
        {
            $usuario->setVisibilidadePerfil($data['visibilidadePerfil']);
        }else
        {   
            $usuario->setVisibilidadePerfil('publico');
        }
        if($data['role'] != null) 
        {
            $usuario->setRole($data['role']);
        }else
        {   
            $usuario->setRole('USUARIO');
        }       
        $usuario->setDataNasc(new \DateTime($data['dataNasc']));
        $sexo = $this->getEm()->find('\Admin\Entity\Sexo', $data['sexo']);
        $usuario->setSexo($sexo);

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

