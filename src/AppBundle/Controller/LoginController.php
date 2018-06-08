<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use AppBundle\Entity\Categoriaproductos;
use AppBundle\Entity\Productos;
use AppBundle\Entity\Usuarios;
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
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

class LoginController extends Controller
{

    private $session;
    
        public function __construct()
        {
    
            $this->session = new Session();
    
        }

      /**
     * @Route("/categoriaProductos", name="categoriaProductos")
     * @Method({"GET"})
     */
     //AJAX
     //quiero que busque el centro de esa empresa solo (ahora mismo busca el tutor laboral de todas las empresas)
     public function catproductosAction(Request $request ){
        //variable que coge el texto del input
        //$string=$request->get('nuevaCadena');
        //return users on json format
        $em = $this->getDoctrine()->getManager();
        //consulta por id
        $query=$em->createQuery('SELECT c FROM AppBundle:Categoriaproductos c');
        $categoriaProductos=$query->getResult();
        //Codificadores XML y JSON
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new GetSetMethodNormalizer());
        $serializer = new Serializer($normalizers, $encoders);

        $jsonContent = $serializer->serialize($categoriaProductos, 'json');
        //var_dump($jsonContent);

        $response = new Response($jsonContent);
        return $response;
    }

    /**
     * @Route("/catServ", name="catServicio")
     *
     * @return void
     */
    public function ListadoAction(Request $request)
    {  
        //mostrar las categorias en el menú
        //inicializamos la entidad categorias
        if (is_object($this->getUser())) {
            return $this->redirectToRoute('paginaPrincipal');
        }
        $categorias=$this->getDoctrine()
    ->getRepository("AppBundle\Entity\Categoriaproductos")
    ->findAll();
    //inicializamos la entidad estado para que no salga nulo 
    $estado=$this->getDoctrine()
    ->getRepository("AppBundle\Entity\Estadoproducto")
    ->findAll();
    //inicializamos la entidad usuario para que no salga nulo
    $usuarios=$this->getDoctrine()
    ->getRepository("AppBundle\Entity\Usuarios")
    ->findAll();
    //mostrar productos en el body
    $productos=$this->getDoctrine()->getRepository("AppBundle\Entity\Productos")->findAll();
    //dump($productos);
    //dump($categorias);
    //pasamos las fotos de los usuarios a base 64
    foreach($usuarios as $usuario){
        $file1=$usuario->getFoto();
        if($file1!=null){
        $bits1=stream_get_contents($file1);
        $file1=$bits1;
        $imagen1=base64_encode($bits1);
        $imagenesCod1[$usuario->getIdusuarios()]=$imagen1;
        }

    }
    foreach ($productos as $producto){
       // dump($producto->getFoto());
       //guardamos en una variable cada una de las fotos de la bd
        $file=$producto->getFoto();
        //cogemos el archivo de usuario
        //$usuario=$producto->getUsuariosusuarios();
        //obtenemos la foto del usuario
        //$file1=$usuario->getFoto();
    
        //lo pasamos a bits
        $bits=stream_get_contents($file);
        //$bits1=stream_get_contents($file1);
        //echo $bits;
        $file=$bits;
        //$file1=$bits1;
        //lo codificamos a base 64 para proyectarlo
        $imagen=base64_encode($bits);
        //$imagen1=base64_encode($bits1);
       
        //creamos un array donde vamos a meter una array de imagenes codificados en base 64
        $imagenesCod[$producto->getIdproductos()]=$imagen;
        //$imagenesCod1[$producto->getIdproductos()]=$imagen1;

    }
    //creamos un formulario para el registro
    $usuario = new Usuarios();
    
    $form = $this->createFormBuilder($usuario)
            ->add('Nombre', TextType::class)
            ->add('Apellidos', TextType::class)
            ->add('password', TextType::class)
            ->add('email', TextType::class)
            ->add('nick', TextType::class)
            ->add('FechaNac',  DateType::class)
            ->add('guardar', SubmitType::class, array('label' => 'Enviar'))
            ->getForm();

    $form->handleRequest($request);
            
    if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $usuario = $form->getData();
            //para guardarlo en la  bd
            $em = $this->getDoctrine()->getManager();
             $em->persist($usuario);
             $em->flush();
    
            return $this->redirectToRoute('catServicio');
        }
    
    
    //ahora hay  que pasar las fotos en bits y despues en base 64


    //dump($categorias);
        // replace this example code with whatever you need
        return $this->render('base.html.twig',["estado"=>$estado,"categorias"=>$categorias,"productos"=>$productos,
        "imagenCod"=>$imagenesCod,"imagenCod1"=>$imagenesCod1,'formRegistro' => $form->createView()]
        );
    }

     /**
     * @Route("/imagen/{id}", name="imagen")
     *
     * @return void
     */
    public function ImagenAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        
            /* @var $entity Document */
            $entity = $em->getRepository('AppBundle\Entity\Productos')->find($id);
        
            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Document entity.');
            }
        
            $file = $entity->getFoto();  
            dump($file);
            $bits=stream_get_contents($file);
            echo $bits;
            $imagen=base64_encode($bits);
            return $this->render('login/probarImagen.html.twig',["imagen"=>$imagen]
        );

                 /*       
            $response = new \Symfony\Component\HttpFoundation\Response(base64_decode($bits), 200, array(
                    'Content-Type' => 'application/octet-stream',
                    'Content-Length' => sizeof($file),
                    'Content-Disposition' => 'attachment; filename="'.$entity->getNombre().'"',
            ));
        */
            
    }

      /**
     * @Route("/producto/buscarProducto", name="buscarProducto1")
     * @Method({"GET"})
     */
     //AJAX
     
     public function buscarProductoAction(Request $request ){
        //variable que coge el texto del input
        $string=$request->get('nuevaCadena');
        //echo $string;
        //return users on json format
        $em = $this->getDoctrine()->getManager();
        //consulta por id
        //al poner la foto en la consulta da error
        $query=$em->createQuery('SELECT p.nombre,p.precio,p.idproductos FROM AppBundle:Productos p WHERE p.nombre  LIKE :string')
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
     * @Route("/categoria/buscarProducto", name="buscarProducto2")
     * @Method({"GET"})
     */
     //AJAX
     
     public function ProductoPorCategoriaAction(Request $request ){
        //variable que coge el texto del input
        $string=$request->get('categoriaSeleccionada');
        //echo $string;
        //return users on json format
        $em = $this->getDoctrine()->getManager();
        //consulta por id
        //al poner la foto en la consulta da error
        $query=$em->createQuery('SELECT p.nombre,p.precio,p.idproductos FROM AppBundle:Productos p WHERE IDENTITY(p.categoriaproductoscategoriaproductos)  LIKE :string')
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

     /** método para ver productos de otra categoria cuando estás en otra vista distinta
     * @Route("/catServ/{idCategoria}", name="catServicio1")
     *
     * @return void
     */
    public function BuscarCatAction($idCategoria)
    {  
        $em = $this->getDoctrine()->getManager();
        //mostrar las categorias en el menú
        //inicializamos la entidad categorias
        $categorias=$this->getDoctrine()
    ->getRepository("AppBundle\Entity\Categoriaproductos")
    ->findAll();
    //inicializamos la entidad estado para que no salga nulo 
    $estado=$this->getDoctrine()
    ->getRepository("AppBundle\Entity\Estadoproducto")
    ->findAll();
    //inicializamos la entidad usuario para que no salga nulo
    $usuarios=$this->getDoctrine()
    ->getRepository("AppBundle\Entity\Usuarios")
    ->findAll();
    //mostrar productos en el body
    $query=$em->createQuery('SELECT p FROM AppBundle:Productos p WHERE IDENTITY(p.categoriaproductoscategoriaproductos)  LIKE :string')
    ->setParameter(':string',$idCategoria);
    $productos=$query->getResult();
    dump($productos);
    dump($categorias);
    //pasamos las fotos de los usuarios a base 64
    foreach($usuarios as $usuario){
        $file1=$usuario->getFoto();
        if($file1!=null){
        $bits1=stream_get_contents($file1);
        $file1=$bits1;
        $imagen1=base64_encode($bits1);
        $imagenesCod1[$usuario->getIdusuarios()]=$imagen1;
        }

    }
    $imagenesCod=null;
    foreach ($productos as $producto){
      
       // dump($producto->getFoto());
       //guardamos en una variable cada una de las fotos de la bd
        $file=$producto->getFoto();
        //cogemos el archivo de usuario
        //$usuario=$producto->getUsuariosusuarios();
        //obtenemos la foto del usuario
        //$file1=$usuario->getFoto();
    
        //lo pasamos a bits
        $bits=stream_get_contents($file);
        //$bits1=stream_get_contents($file1);
        //echo $bits;
        $file=$bits;
        //$file1=$bits1;
        //lo codificamos a base 64 para proyectarlo
        $imagen=base64_encode($bits);
        //$imagen1=base64_encode($bits1);
       
        //creamos un array donde vamos a meter una array de imagenes codificados en base 64
        $imagenesCod[$producto->getIdproductos()]=$imagen;
        //$imagenesCod1[$producto->getIdproductos()]=$imagen1;
        }
        
    
    
    /*
    foreach ($imagenesCod1 as $clave => $valor) {
        // $array[3] se actualizará con cada valor de $array...
        echo "{$clave} => {$valor} ";
        //print_r($imagenesCod);
    }
    */
    //ahora hay  que pasar las fotos en bits y despues en base 64


    //dump($categorias);
        // replace this example code with whatever you need
        
        return $this->render('base.html.twig',["estado"=>$estado,"categorias"=>$categorias,"productos"=>$productos,
        "imagenCod"=>$imagenesCod,"imagenCod1"=>$imagenesCod1]
        );
    }

    /**
     * @Route("/login", name="login")
     * 
     */
    public function loginAction(Request $request, AuthenticationUtils $aut){
        /**$errors= $aut->getLastAuthenticationError();
        $lastUsername=$aut->getLastUsername();
        return $this->render('base.html.twig',array('errors'=>$errors,'username')
        );
*/
        if (is_object($this->getUser())) {
            return $this->redirectToRoute('paginaPrincipal');
        }

        $autentificacionUtil = $this->get('security.authentication_utils');


        //Si falla el login
        $error = $autentificacionUtil->getLastAuthenticationError();
        $lastUsername = $autentificacionUtil->getLastUsername();
        
        return $this->redirectToRoute('catServicio',array( 'last_username' => $lastUsername,
        'error' => $error));
        
        
       


    }
    /**
     * @Route("/email", name="emailTest")
     * @Method({"POST"})
     */
    

    public function emailTestAction(Request $request)
    {
        $email = $request->get("email");

        $em = $this->getDoctrine()->getManager();
        $user_repo = $em->getRepository("AppBundle:Usuario");
        //para ver si existe
        $user_isset = $user_repo->findOneBy(array("email" => $email));

        $result = "usado";

        if (count($user_isset) >= 1 && is_object($user_isset)) {
            $result = "usado";
        } else {
            $result = "no usado";
        }
        return new Response($result);
    }
}
