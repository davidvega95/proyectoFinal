<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Mensajes
 *
 * @ORM\Table(name="mensajes", indexes={@ORM\Index(name="fk_mensajes_usuarios2_idx", columns={"usuarios_idusuarios"}), @ORM\Index(name="fk_mensajes_usuarios1_idx", columns={"usuarios_idusuarios1"})})
 * @ORM\Entity
 */
class Mensajes
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idmensajes", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idmensajes;

    /**
     * @var string
     *
     * @ORM\Column(name="mensaje", type="string", length=200, nullable=false)
     */
    private $mensaje;

    /**
     * @var boolean
     *
     * @ORM\Column(name="leido", type="boolean", nullable=false)
     */
    private $leido;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="creado", type="datetime", nullable=false)
     */
    private $creado;

    /**
     * @var \Usuarios
     *
     * @ORM\ManyToOne(targetEntity="Usuarios")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="usuarios_idusuarios1", referencedColumnName="idusuarios")
     * })
     */
    private $usuariosusuarios1;

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
     * @var \Conversaciones
     *
     * @ORM\ManyToOne(targetEntity="Conversaciones")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fk_id_conversaciones", referencedColumnName="id_conversaciones")
     * })
     */
    private $conversaciones;



    /**
     * Get idmensajes
     *
     * @return integer
     */
    public function getIdmensajes()
    {
        return $this->idmensajes;
    }

    /**
     * Set mensaje
     *
     * @param string $mensaje
     *
     * @return Mensajes
     */
    public function setMensaje($mensaje)
    {
        $this->mensaje = $mensaje;

        return $this;
    }

    /**
     * Get mensaje
     *
     * @return string
     */
    public function getMensaje()
    {
        return $this->mensaje;
    }

    /**
     * Set leido
     *
     * @param boolean $leido
     *
     * @return Mensajes
     */
    public function setLeido($leido)
    {
        $this->leido = $leido;

        return $this;
    }

    /**
     * Get leido
     *
     * @return boolean
     */
    public function getLeido()
    {
        return $this->leido;
    }

    /**
     * Set creado
     *
     * @param \DateTime $creado
     *
     * @return Mensajes
     */
    public function setCreado($creado)
    {
        $this->creado = $creado;

        return $this;
    }

    /**
     * Get creado
     *
     * @return \DateTime
     */
    public function getCreado()
    {
        return $this->creado;
    }

    /**
     * Set usuariosusuarios1
     *
     * @param \AppBundle\Entity\Usuarios $usuariosusuarios1
     *
     * @return Mensajes
     */
    public function setUsuariosusuarios1(\AppBundle\Entity\Usuarios $usuariosusuarios1 = null)
    {
        $this->usuariosusuarios1 = $usuariosusuarios1;

        return $this;
    }

    /**
     * Get usuariosusuarios1
     *
     * @return \AppBundle\Entity\Usuarios
     */
    public function getUsuariosusuarios1()
    {
        return $this->usuariosusuarios1;
    }

    /**
     * Set usuariosusuarios
     *
     * @param \AppBundle\Entity\Usuarios $usuariosusuarios
     *
     * @return Mensajes
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


     /**
     * Set conversaciones1
     *
     * @param \AppBundle\Entity\Conversaciones $conversaciones
     *
     * @return Mensajes
     */
    public function setConversaciones(\AppBundle\Entity\Conversaciones $conversaciones = null)
    {
        $this->conversaciones = $conversaciones;

        return $this;
    }

    /**
     * Get conversaciones
     *
     * @return \AppBundle\Entity\Conversaciones
     */
    public function getConversaciones()
    {
        return $this->conversaciones;
    }
}
