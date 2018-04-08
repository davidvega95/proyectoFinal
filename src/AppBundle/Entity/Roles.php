<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Roles
 *
 * @ORM\Table(name="roles")
 * @ORM\Entity
 */
class Roles
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idroles", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idroles;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=45, nullable=false)
     */
    private $nombre;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Usuarios", mappedBy="rolesroles")
     */
    private $usuariosusuarios;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->usuariosusuarios = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * Get idroles
     *
     * @return integer
     */
    public function getIdroles()
    {
        return $this->idroles;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Roles
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Add usuariosusuario
     *
     * @param \AppBundle\Entity\Usuarios $usuariosusuario
     *
     * @return Roles
     */
    public function addUsuariosusuario(\AppBundle\Entity\Usuarios $usuariosusuario)
    {
        $this->usuariosusuarios[] = $usuariosusuario;

        return $this;
    }

    /**
     * Remove usuariosusuario
     *
     * @param \AppBundle\Entity\Usuarios $usuariosusuario
     */
    public function removeUsuariosusuario(\AppBundle\Entity\Usuarios $usuariosusuario)
    {
        $this->usuariosusuarios->removeElement($usuariosusuario);
    }

    /**
     * Get usuariosusuarios
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUsuariosusuarios()
    {
        return $this->usuariosusuarios;
    }
}
