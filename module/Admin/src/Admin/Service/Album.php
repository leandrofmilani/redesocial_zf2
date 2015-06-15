<?php
namespace Admin\Service;

use Core\Service\Service;
use Doctrine\ORM\NoResultException;
use Zend\Validator\Exception\InvalidMagicMimeFileException;

/**
 * 
 *
 * @category Admin
 * @package Service
 * @author Leandro Fabris Milani <lfm@unochapeco.edu.br>
 */
class Album extends Service
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
        $entity_album = '\Admin\Entity\Album';
        $album = new $entity_album();
        $filters = $album->getInputFilter();
        $filters->setData($data);

        if (!$filters->isValid())
            throw new \InvalidArgumentException('Dados inválidos');

        $data = $filters->getValues();
        
        $album->setTitulo($data['titulo']);
        $album->setDataAlbum(new \DateTime("now"));
        $album->setPhoto($data['photo']);
        $album->setVisibilidade($data['visibilidade']);
        $album->setUsuario($data['id']);

        $this->getEm()->persist($album);
        $this->getEm()->flush();

        return $album;
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
        $album = $this->getEm()->find('\Admin\Entity\Album', (int) $id);

        if (!$album)
            throw new \NoResultException('Imagem não encontrada');

        $this->getEm()->remove($album);
        $this->getEm()->flush();
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
        if ((int) $id <= 0)
            throw new \InvalidArgumentException('Parâmetros inválidos');
        $album = $this->getEm()->find('\Admin\Entity\Album', (int) $id);

        $base = null;
        if ($album->getPhoto() != null) {
            $stream = stream_get_contents($album->getPhoto());
            $base = base64_decode($stream);
        }

        return $base;
    }

    private function thumb($origem)
    {
        $size =  getimagesize($origem);
        $image_p = imagecreatetruecolor(160, 120);
        $image = imagecreatefromjpeg($origem);
        imagecopyresampled($image_p, $image, 0, 0, 0, 0, 160, 120, $size[0], $size[1]);
        imagejpeg($image_p, $origem, 50);
    }

}

