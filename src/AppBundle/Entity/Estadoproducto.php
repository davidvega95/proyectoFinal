<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Estadoproducto
 *
 * @ORM\Table(name="estadoproducto")
 * @ORM\Entity
 */
class Estadoproducto
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idEstadoProducto", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idestadoproducto;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=100, nullable=false)
     */
    private $nombre;



    /**
     * Get idestadoproducto
     *
     * @return integer
     */
    public function getIdestadoproducto()
    {
        return $this->idestadoproducto;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Estadoproducto
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
    public function __toString() {
        return $this->nombre;
    }
}
