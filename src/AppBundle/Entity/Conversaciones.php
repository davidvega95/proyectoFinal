<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Conversaciones
 *
 * @ORM\Table(name="conversaciones")
 * @ORM\Entity
 */
class Conversaciones
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_conversaciones", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idconversaciones;

    /**
     * @var \Productos
     *
     * @ORM\ManyToOne(targetEntity="Productos")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_productos", referencedColumnName="idproductos")
     * })
     */
    private $id_productos;

    /**
     * @var \Usuarios
     *
     * @ORM\ManyToOne(targetEntity="Usuarios")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_usuarios", referencedColumnName="idusuarios")
     * })
     */
    private $id_usuarios;

    public function getIdconversaciones()
    {
        return $this->idconversaciones;
    }

    public function setIdconversaciones($idconversaciones)
    {
        $this->idconversaciones = $idconversaciones;

        return $this;
    }


    /**
     * Set id_productos
     *
     * @param \AppBundle\Entity\Productos $id_productos
     *
     * @return Productos
     */
    public function setId_productos(\AppBundle\Entity\Productos $id_productos = null)
    {
        $this->id_productos = $id_productos;

        return $this;
    }

    /**
     * Get id_productos
     *
     * @return \AppBundle\Entity\Productos
     */
    public function getId_productos()
    {
        return $this->id_productos;
    }


    /**
     * Set id_usuarios
     *
     * @param \AppBundle\Entity\Usuarios $id_usuarios
     *
     * @return Productos
     */
    public function setId_usuarios(\AppBundle\Entity\Usuarios $id_usuarios = null)
    {
        $this->id_usuarios = $id_usuarios;

        return $this;
    }

    /**
     * Get id_usuarios
     *
     * @return \AppBundle\Entity\Usuarios
     */
    public function getId_usuarios()
    {
        return $this->id_usuarios;
    }



    
}
