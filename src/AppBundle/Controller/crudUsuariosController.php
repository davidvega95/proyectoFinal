<?php

namespace AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Usuarios;
use AppBundle\Entity\Productos;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class crudUsuariosController extends Controller
{

     /**
     * @Route("/crudUsuarios", name="gestionUsuarios")
     */

     public function crudUsuariosAction(Request $request){

         //para crear el header
         $categorias=$this->getDoctrine()
         ->getRepository("AppBundle\Entity\Categoriaproductos")
         ->findAll();
        $usuarios=$this->getDoctrine()
        ->getRepository("AppBundle\Entity\Usuarios")
        ->findAll();

        $email=$this->getUser()->getUsername();
        //coger primero el id de usuario que sea del gmail
        $em = $this->getDoctrine()->getManager();
        //consulta por id
        //al poner la foto en la consulta da error
        $query=$em->createQuery('SELECT u.idusuarios FROM AppBundle:Usuarios u WHERE u.email  LIKE :string')
        ->setParameter(':string',$email);
        $usuario=$query->getResult();

        
        $query2=$em->createQuery('SELECT p from AppBundle:Productos p where p.usuariosusuarios=:id and  p.estadoproductoestadoproducto=2')
        ->setParameter(':id',$usuario[0]["idusuarios"]);
        $productos=$query2->getResult();

        foreach($usuarios as $usuario){
            $file1=$usuario->getFoto();
            if($file1!=null){
            $bits1=stream_get_contents($file1);
            $file1=$bits1;
            $imagen1=base64_encode($bits1);
            $imagenesCod1[$usuario->getIdusuarios()]=$imagen1;
            }
    
        }

        //formulario para nuevo usuario
        $usuario = new Usuarios();
        //me creo el form del nuevo producto
        $formNuevoUsuario = $this->createFormBuilder($usuario)
        ->add('idusuarios', HiddenType::class)
        ->add('nombre', TextType::class)
        ->add('apellidos', TextType::class)
        ->add('email', TextType::class)
        
        ->add('password', TextType::class)
        ->add('nick', TextType::class)
        ->add('fechanac', DateType::class, array(
            // renders it as a single text box
            'widget' => 'single_text',
        ))
        ->add('foto', FileType::class,array(
            "label" => "Imagen:",
            "attr" =>array("class" => "form-control")
        ))
        ->add('actualizar', SubmitType::class, array('label' => 'Guardar'))
        ->getForm();
        $formNuevoUsuario->handleRequest($request);

        if($formNuevoUsuario->isSubmitted() && $formNuevoUsuario->isValid()){
            $foto = $formNuevoUsuario->get('foto')->getData();
            if(file_exists ($foto)){
            //pasamos el archivo a binario
            $foto1=file_get_contents($foto);
            //echo $foto1;
            //obtenemos los datos del formulario en un objeto productos
            $usuario->setApellidos($formNuevoUsuario->get('apellidos')->getData());
            $usuario->setNombre($formNuevoUsuario->get('nombre')->getData());
            $usuario->setEmail($formNuevoUsuario->get('email')->getData());
            $usuario->setFoto($foto1);
            $usuario->setPassword($formNuevoUsuario->get('password')->getData());
            $usuario->setNick($formNuevoUsuario->get('nick')->getData());
            $usuario->setFechanac($formNuevoUsuario->get('fechanac')->getData());
            
            //var_dump($formNuevoProducto->get('usuariosusuarios')->getData());
            
            $em=$this->getDoctrine()->getManager();
            //lo guardamos en la base de datos
            $em->persist($usuario);
            $em->flush();
            return $this->redirect($this->generateUrl('gestionUsuarios'));
            }
            
        }

         //me creo el form de Editar 
         $formEditarUsu = $this->createFormBuilder($usuario)
         ->add('idusuarios', TextType::class)
         ->add('nombre', TextType::class)
         ->add('apellidos', TextType::class)
         ->add('email', TextType::class)
         
         ->add('password', TextType::class)
         ->add('nick', TextType::class)
         ->add('fechanac', DateType::class)
         
         ->add('actualizar', SubmitType::class, array('label' => 'Guardar'))
         ->getForm();
         $formEditarUsu->handleRequest($request);
    //al darle al boton actualizar
    if($formEditarUsu->isSubmitted() && $formEditarUsu->isValid()){
        $idUsuarios = $formEditarUsu->get('idusuarios')->getData();
        $nombreUsuario= $formEditarUsu->get('nombre')->getData();
        $apellidos= $formEditarUsu->get('apellidos')->getData();
        $nick= $formEditarUsu->get('nick')->getData();
        $email= $formEditarUsu->get('email')->getData();
        $password= $formEditarUsu->get('password')->getData();
        $nac= $formEditarUsu->get('fechanac')->getData();

        $em = $this->getDoctrine()->getManager();
        $usuario = $em->getRepository('AppBundle:Usuarios')->find($idUsuarios);

        if (!$usuario) {
            throw $this->createNotFoundException(
                'No product found for id '.$idUsuarios
            );
        }
        //actualizamos los datos 
        $usuario->setNombre($nombreUsuario);
        $usuario-> setApellidos($apellidos);
        $usuario-> setNick($nick);
        $usuario-> setEmail($email);
        $usuario-> setNick($nick);
        $usuario-> setPassword($password);
        $usuario-> setFechanac($nac);
        //lo persistimos
        $em->flush();

        return $this->redirect($this->generateUrl('gestionUsuarios'));

    }


        return $this->render('crudUsuarios/index.html.twig',["categorias"=>$categorias,
        "usuarios"=>$usuarios,"imagenCod1"=>$imagenesCod1,"productos"=>$productos,
        "formNuevoUsuario"=>$formNuevoUsuario->createView(),"formEditarUsu"=>$formEditarUsu->createView()]
        ); 
     }


      /**
     * @Route("/crudUsuarios/idUsuario", name="idUsuariosEditar")
     * @Method({"GET"})
     */
    public function formIdEditarUAction(Request $request){
        //variable que coge el texto del input
        $string=$request->get('idUsuario');
        //echo $string;
        //return users on json format
        $em = $this->getDoctrine()->getManager();
        //consulta por id
        //al poner la foto en la consulta da error
        $query=$em->createQuery('SELECT u.nombre,u.apellidos,u.idusuarios,u.email,u.nick,u.password,u.fechanac FROM AppBundle:Usuarios u WHERE u.idusuarios  LIKE :string')
        ->setParameter(':string',$string);
        $centro=$query->getResult();

        //dump($centro);
        
        //Codificadores XML y JSON
        $encoders = array(new XmlEncoder(), new JsonEncoder());
       
        $normalizers = array(new GetSetMethodNormalizer());
       
        $serializer = new Serializer($normalizers, $encoders);
        
        $jsonContent = $serializer->serialize($centro, 'json');
    
        //var_dump($jsonContent);
        
        $response = new Response($jsonContent);
        //var_dump($response);
        return $response;

    }

     /**
     * @Route("/usuarioR/check", name="usuarioCheck")
     * @Method({"GET"})
     */
    public function usuarioCheckAction(Request $request){
        //variable que coge el texto del input
        $string=$request->get('idUsuario');
        
        //echo $string;
        //return users on json format
        $em = $this->getDoctrine()->getManager();
        //consulta por id
        //al poner la foto en la consulta da error
        $query=$em->createQuery('SELECT u.nombre FROM AppBundle:Usuarios u WHERE u.idusuarios  LIKE :string')
        ->setParameter(':string',$string);
        $centro=$query->getResult();

        dump($centro);
        
        //Codificadores XML y JSON
        $encoders = array(new XmlEncoder(), new JsonEncoder());
       
        $normalizers = array(new GetSetMethodNormalizer());
       
        $serializer = new Serializer($normalizers, $encoders);
        
        $jsonContent = $serializer->serialize($centro, 'json');
    
        //var_dump($jsonContent);
        
        $response = new Response($jsonContent);
        //var_dump($response);
        return $response;

    }

     /**
     * @Route("/usuario1/borrar", name="usuarioBorrar")
     * @Method({"GET"})
     */
    public function productoBorrarAction(Request $request){
        //variable que coge el texto del input
        $longitud=$request->get('longitudObjeto');
        //echo $string;
        //return users on json format
        $em = $this->getDoctrine()->getManager();
        //consulta por id
        //al poner la foto en la consulta da error

        for ($i = 0; $i <= $longitud; $i++) {
            echo "--".$i;
            $usuario=$request->get('nombreUsuario'.$i);
            //DELETE FROM table_name
            echo "pro".$usuario;
            $query=$em->createQuery('DELETE  FROM AppBundle:Usuarios u WHERE u.nombre  LIKE :string')
            ->setParameter(':string',$usuario);
            $centro=$query->getResult();

            dump($centro);
            
            //Codificadores XML y JSON
            $encoders = array(new XmlEncoder(), new JsonEncoder());
           
            $normalizers = array(new GetSetMethodNormalizer());
           
            $serializer = new Serializer($normalizers, $encoders);
            
            $jsonContent = $serializer->serialize($centro, 'json');
        
            //var_dump($jsonContent);
            
            $response = new Response($jsonContent);
            //var_dump($response);
            return $response;


        }


    }
}
