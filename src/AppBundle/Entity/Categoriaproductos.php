<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Categoriaproductos
 *
 * @ORM\Table(name="categoriaproductos")
 * @ORM\Entity
 */
class Categoriaproductos 
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idCategoriaProductos", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idcategoriaproductos;

    /**
     * @var string
     *
     * @ORM\Column(name="Nombre", type="string", length=100, nullable=false)
     */
    private $nombre;



    /**
     * Get idcategoriaproductos
     *
     * @return integer
     */
    public function getIdcategoriaproductos()
    {
        return $this->idcategoriaproductos;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Categoriaproductos
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
}
