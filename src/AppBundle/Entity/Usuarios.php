<?php

namespace AppBundle\Entity;
use Serializable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;


/**
 * Usuarios
 *
 * @ORM\Table(name="usuarios", uniqueConstraints={@ORM\UniqueConstraint(name="idusuarios_UNIQUE", columns={"idusuarios"})})
 * @ORM\Entity
 */
class Usuarios implements UserInterface, Serializable
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idusuarios", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idusuarios;

    /**
     * @var string
     *
     * @ORM\Column(name="Nombre", type="string", length=100, nullable=false)
     */
    private $nombre;


    /**
     * @var string
     *
     * @ORM\Column(name="Apellidos", type="string", length=100, nullable=false)
     */
    private $apellidos;

    //Con que nos vamos a registrar
    public function getUsername()
    {
        return $this->email;
    }

    //Roles
    public function getRoles()
    {
        return array('ROLE_USER', 'ROLE_ADMIN');
    }

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=100, nullable=false)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=100, nullable=false)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="nick", type="string", length=100, nullable=false)
     */
    private $nick;

    /**
     * @var string
     *
     * @ORM\Column(name="foto", type="blob", nullable=true)
     */
    private $foto;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaNac", type="date", nullable=false)
     */
    private $fechanac;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Roles", inversedBy="usuariosusuarios")
     * @ORM\JoinTable(name="usuarios_has_roles",
     *   joinColumns={
     *     @ORM\JoinColumn(name="usuarios_idusuarios", referencedColumnName="idusuarios")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="roles_idroles", referencedColumnName="idroles")
     *   }
     * )
     */
    private $rolesroles;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->rolesroles = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * Get idusuarios
     *
     * @return integer
     */
    public function getIdusuarios()
    {
        return $this->idusuarios;
    }

    public function setIdusuarios($idusuario)
    {
        $this->idusuario = $idusuario;

        return $this;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Usuarios
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
     * Set apellidos
     *
     * @param string $apellidos
     *
     * @return Usuarios
     */
    public function setApellidos($apellidos)
    {
        $this->apellidos = $apellidos;

        return $this;
    }

    /**
     * Get apellidos
     *
     * @return string
     */
    public function getApellidos()
    {
        return $this->apellidos;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return Usuarios
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Usuarios
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set nick
     *
     * @param string $nick
     *
     * @return Usuarios
     */
    public function setNick($nick)
    {
        $this->nick = $nick;

        return $this;
    }

    /**
     * Get nick
     *
     * @return string
     */
    public function getNick()
    {
        return $this->nick;
    }

    /**
     * Set foto
     *
     * @param string $foto
     *
     * @return Usuarios
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
     * Set fechanac
     *
     * @param \DateTime $fechanac
     *
     * @return Usuarios
     */
    public function setFechanac($fechanac)
    {
        $this->fechanac = $fechanac;

        return $this;
    }

    /**
     * Get fechanac
     *
     * @return \DateTime
     */
    public function getFechanac()
    {
        return $this->fechanac;
    }

    /**
     * Add rolesrole
     *
     * @param \AppBundle\Entity\Roles $rolesrole
     *
     * @return Usuarios
     */
    public function addRolesrole(\AppBundle\Entity\Roles $rolesrole)
    {
        $this->rolesroles[] = $rolesrole;

        return $this;
    }

    /**
     * Remove rolesrole
     *
     * @param \AppBundle\Entity\Roles $rolesrole
     */
    public function removeRolesrole(\AppBundle\Entity\Roles $rolesrole)
    {
        $this->rolesroles->removeElement($rolesrole);
    }

    /**
     * Get rolesroles
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRolesroles()
    {
        return $this->rolesroles;
    }

    public function __toString() {
        return $this->nombre;
    }
    public function getSalt()
    {
        return null;
    }

    public function eraseCredentials()
    {

    }
    public function serialize(){
        return serialize(array($this->idusuarios,$this->email,$this->password));
    }

    public function unserialize($serialized){
        list($this->idusuarios,$this->email,$this->password)=unserialize($serialized);
    }

    

    

   
    
    
   
}
