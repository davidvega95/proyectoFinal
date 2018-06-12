<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Categoriaproductos
 *
 * @ORM\Table(name="usuarios_has_roles")
 * @ORM\Entity
 */
class UsuariosHasRoles
{

    /**
     * @var integer
     *
     * @ORM\Column(name="idRoles", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idhasroles;
     /**
     * @var integer
     *
     * @ORM\Column(name="usuarios_idusuarios", type="integer", nullable=false)
     */
    private $idusuarios;

     /**
     * @var integer
     *
     * @ORM\Column(name="roles_idroles", type="integer", nullable=false)
     */
    private $idroles;



    /**
     * Get idcategoriaproductos
     *
     * @return integer
     */
    public function getidusuarios()
    {
        return $this->idusuarios;
    }

    public function setidusuarios($idusuarios)
    {
        $this->idusuarios = $idusuarios;
        
        return $this;
    }

    
    public function setidroles($idroles)
    {
        $this->idroles = $idroles;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string
     */
    public function getidroles()
    {
        return $this->idroles;
    }
   
}
