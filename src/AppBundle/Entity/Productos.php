<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * Productos
 *
 * @ORM\Table(name="productos", indexes={@ORM\Index(name="fk_productos_EstadoProducto1_idx", columns={"EstadoProducto_idEstadoProducto"}), @ORM\Index(name="fk_productos_CategoriaProductos1_idx", columns={"CategoriaProductos_idCategoriaProductos"}), @ORM\Index(name="fk_productos_usuarios1_idx", columns={"usuarios_idusuarios"})})
 * @ORM\Entity
 */
class Productos 
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idproductos", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idproductos;

    /**
     * @var float
     *
     * @ORM\Column(name="precio", type="float", precision=10, scale=0, nullable=false)
     */
    private $precio;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=100, nullable=false)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=300, nullable=true)
     */
    private $descripcion;

    /**
     * @var string
     *
     * @ORM\Column(name="foto", type="blob", nullable=false)
     */
    private $foto;

    /**
     * @var string
     *
     * @ORM\Column(name="Ubicacion", type="string", length=45, nullable=true)
     */
    private $ubicacion;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="FechaPublicacion", type="datetime", nullable=false)
     */
    private $fechapublicacion;

    /**
     * @var \Categoriaproductos
     *
     * @ORM\ManyToOne(targetEntity="Categoriaproductos")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="CategoriaProductos_idCategoriaProductos", referencedColumnName="idCategoriaProductos")
     * })
     */
    private $categoriaproductoscategoriaproductos;

    /**
     * @var \Estadoproducto
     *
     * @ORM\ManyToOne(targetEntity="Estadoproducto")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="EstadoProducto_idEstadoProducto", referencedColumnName="idEstadoProducto")
     * })
     */
    private $estadoproductoestadoproducto;

    /**
     * @var \Usuarios
     *
     * @ORM\ManyToOne(targetEntity="Usuarios")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="usuarios_idusuarios", referencedColumnName="idusuarios")
     * })
     */
    private $usuariosusuarios;



    /**
     * Get idproductos
     *
     * @return integer
     */
    public function getIdproductos()
    {
        return $this->idproductos;
    }

    public function setIdproductos($idproductos)
    {
        $this->idproductos = $idproductos;

        return $this;
    }

    /**
     * Set precio
     *
     * @param float $precio
     *
     * @return Productos
     */
    public function setPrecio($precio)
    {
        $this->precio = $precio;

        return $this;
    }

    /**
     * Get precio
     *
     * @return float
     */
    public function getPrecio()
    {
        return $this->precio;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Productos
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
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return Productos
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set foto
     *
     * @param string $foto
     *
     * @return Productos
     */
    public function setFoto($foto)
    {
        $this->foto = $foto;

        return $this;
    }

    /**
     * Get foto
     *
     * @return string
     */
    public function getFoto()
    {
        return $this->foto;
    }

    /**
     * Set ubicacion
     *
     * @param string $ubicacion
     *
     * @return Productos
     */
    public function setUbicacion($ubicacion)
    {
        $this->ubicacion = $ubicacion;

        return $this;
    }

    /**
     * Get ubicacion
     *
     * @return string
     */
    public function getUbicacion()
    {
        return $this->ubicacion;
    }

    /**
     * Set fechapublicacion
     *
     * @param \DateTime $fechapublicacion
     *
     * @return Productos
     */
    public function setFechapublicacion($fechapublicacion)
    {
        $this->fechapublicacion = $fechapublicacion;

        return $this;
    }

    /**
     * Get fechapublicacion
     *
     * @return \DateTime
     */
    public function getFechapublicacion()
    {
        return $this->fechapublicacion;
       
    }

    /**
     * Set categoriaproductoscategoriaproductos
     *
     * @param \AppBundle\Entity\Categoriaproductos $categoriaproductoscategoriaproductos
     *
     * @return Productos
     */
    public function setCategoriaproductoscategoriaproductos(\AppBundle\Entity\Categoriaproductos $categoriaproductoscategoriaproductos = null)
    {
        $this->categoriaproductoscategoriaproductos = $categoriaproductoscategoriaproductos;

        return $this;
    }

    /**
     * Get categoriaproductoscategoriaproductos
     *
     * @return \AppBundle\Entity\Categoriaproductos
     */
    public function getCategoriaproductoscategoriaproductos()
    {
        return $this->categoriaproductoscategoriaproductos;
    }

    /**
     * Set estadoproductoestadoproducto
     *
     * @param \AppBundle\Entity\Estadoproducto $estadoproductoestadoproducto
     *
     * @return Productos
     */
    public function setEstadoproductoestadoproducto(\AppBundle\Entity\Estadoproducto $estadoproductoestadoproducto = null)
    {
        $this->estadoproductoestadoproducto = $estadoproductoestadoproducto;

        return $this;
    }

    /**
     * Get estadoproductoestadoproducto
     *
     * @return \AppBundle\Entity\Estadoproducto
     */
    public function getEstadoproductoestadoproducto()
    {
        return $this->estadoproductoestadoproducto;
    }

    /**
     * Set usuariosusuarios
     *
     * @param \AppBundle\Entity\Usuarios $usuariosusuarios
     *
     * @return Productos
     */
    public function setUsuariosusuarios(\AppBundle\Entity\Usuarios $usuariosusuarios = null)
    {
        $this->usuariosusuarios = $usuariosusuarios;

        return $this;
    }

    /**
     * Get usuariosusuarios
     *
     * @return \AppBundle\Entity\Usuarios
     */
    public function getUsuariosusuarios()
    {
        return $this->usuariosusuarios;
    }
    public function __toString() {
        return $this->precio+$this->fechapublicacion;
    }

    
}
