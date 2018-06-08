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


class PaginaPrincipalController extends Controller
{

     /**
     * @Route("/pagina", name="paginaPrincipal")
     */

     public function paginaPrincipalAction(Request $request){

        $imagenesCod=null;
        $imagenesCodV=null;

    $session = $this->get('session');
    
    
    $session->set('filter', array(
    'accounts' => 'value',
));

  
    if (is_object($this->getUser())) {
    
        $email=$this->getUser()->getUsername();

        
        //coger primero el id de usuario que sea del gmail
        $em = $this->getDoctrine()->getManager();
    
        //consulta por id
        //al poner la foto en la consulta da error
        $query=$em->createQuery('SELECT u.idusuarios FROM AppBundle:Usuarios u WHERE u.email  LIKE :string')
        ->setParameter(':string',$email);
        
        $usuario=$query->getResult();
        dump($usuario);
        
        //coger el usuario logueado
        $usuario1 = $this->getDoctrine()
        ->getRepository(Usuarios::class)
        ->find($usuario[0]["idusuarios"]);
        dump($usuario1);
        
        
        $producto = new Productos();
        //me creo el form del nuevo producto
        $formNuevoProducto = $this->createFormBuilder($producto)
        ->add('idproductos', HiddenType::class)
        ->add('nombre', TextType::class)
        ->add('precio', TextType::class)
        ->add('descripcion', TextType::class)
        ->add('categoriaproductoscategoriaproductos')
        ->add('estadoproductoestadoproducto')
        ->add('foto', FileType::class,array(
            "label" => "Imagen:",
            "attr" =>array("class" => "form-control")
        ))
        ->add('actualizar', SubmitType::class, array('label' => 'Guardar'))
        ->getForm();
        $formNuevoProducto->handleRequest($request);
    
        if($formNuevoProducto->isSubmitted() && $formNuevoProducto->isValid()){
            $foto = $formNuevoProducto->get('foto')->getData();
            if(file_exists ($foto)){
            //pasamos el archivo a binario
            $foto1=file_get_contents($foto);
            //echo $foto1;
            //obtenemos los datos del formulario en un objeto productos
            $producto->setPrecio($formNuevoProducto->get('precio')->getData());
            $producto->setNombre($formNuevoProducto->get('nombre')->getData());
            $producto->setDescripcion($formNuevoProducto->get('descripcion')->getData());
            $producto->setFoto($foto1);
            $producto->setPrecio($formNuevoProducto->get('precio')->getData());
            $producto->setCategoriaproductoscategoriaproductos($formNuevoProducto->get('categoriaproductoscategoriaproductos')->getData());
            $producto->setEstadoproductoestadoproducto($formNuevoProducto->get('estadoproductoestadoproducto')->getData());
            $producto->setCategoriaproductoscategoriaproductos($formNuevoProducto->get('categoriaproductoscategoriaproductos')->getData());
            $producto->setUsuariosusuarios($usuario1);
            //var_dump($formNuevoProducto->get('usuariosusuarios')->getData());
            
            $em=$this->getDoctrine()->getManager();
            //lo guardamos en la base de datos
            $em->persist($producto);
            $em->flush();
            return $this->redirect($this->generateUrl('paginaPrincipal'));
            }
            
        }
    
        //me creo el form de Editar 
        $formEditarPro = $this->createFormBuilder($producto)
        ->add('idproductos', HiddenType::class)
        ->add('nombre', TextType::class)
        ->add('precio', TextType::class)
        ->add('descripcion', TextType::class)
        ->add('actualizar', SubmitType::class, array('label' => 'Actualizar'))
        ->getForm();
        $formEditarPro->handleRequest($request);
        //al darle al boton actualizar
        if($formEditarPro->isSubmitted() && $formEditarPro->isValid()){
            //cogemos los datos del formulario
            $idProductos = $formEditarPro->get('idproductos')->getData();
            $nombreProductos= $formEditarPro->get('nombre')->getData();
            $descripcionProducto= $formEditarPro->get('descripcion')->getData();
            $precioProducto= $formEditarPro->get('precio')->getData();
            $foto=$formEditarPro->get('foto')->getData();

            $em = $this->getDoctrine()->getManager();
            $product = $em->getRepository('AppBundle:Productos')->find($idProductos);

            if (!$product) {
                throw $this->createNotFoundException(
                    'No product found for id '.$id
                );
            }
            //actualizamos los datos 
            $product->setNombre($nombreProductos);
            $product-> setDescripcion($descripcionProducto);
            $product-> setPrecio($precioProducto);
            //lo persistimos
            $em->flush();

            return $this->redirect($this->generateUrl('paginaPrincipal'));

        }



        
        $query1=$em->createQuery('SELECT COUNT(p) from AppBundle:Productos p where p.usuariosusuarios=:id')
        ->setParameter(':id',$usuario[0]["idusuarios"]);
        //ejecutamos sentencias
        $numeroProductos=$query1->getResult();
        dump($numeroProductos);

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
        //mostrar productos que tiene cada usuario
        $query2=$em->createQuery('SELECT p from AppBundle:Productos p where p.usuariosusuarios=:id and  p.estadoproductoestadoproducto=2')
        ->setParameter(':id',$usuario[0]["idusuarios"]);
        $productos=$query2->getResult();

        $query3=$em->createQuery('SELECT p from AppBundle:Productos p where p.usuariosusuarios=:id and p.estadoproductoestadoproducto=1')
        ->setParameter(':id',$usuario[0]["idusuarios"]);
        $productosV=$query3->getResult();

        dump($productos);
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
        // echo $file.   "       ";
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

        foreach ($productosV as $producto){
            // dump($producto->getFoto());
            //guardamos en una variable cada una de las fotos de la bd
                $file=$producto->getFoto();
            // echo $file.   "       ";
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
                $imagenesCodV[$producto->getIdproductos()]=$imagen;
                //$imagenesCod1[$producto->getIdproductos()]=$imagen1;
                
            }
            
            //editar usuario formulario
        
            $formEditarUsu = $this->createFormBuilder($usuario1)
            ->add('idusuarios', HiddenType::class)
            ->add('nombre', TextType::class)
            ->add('apellidos', TextType::class)
            ->add('fechaNac', DateType::class)
            ->add('email', TextType::class)
            ->add('password', TextType::class)
            ->add('actualizar', SubmitType::class, array('label' => 'Actualizar'))
            ->getForm();

            $formEditarUsu->handleRequest($request);
            if($formEditarUsu->isSubmitted() && $formEditarUsu->isValid())
            {
                //cogemos los datos del formulario
                
                $idUsuario =$formEditarUsu->get('idusuarios')->getData();
                $nombreUsuario= $formEditarUsu->get('nombre')->getData();
                $apellidosUsuario= $formEditarUsu->get('apellidos')->getData();
                $fechaUsuario= $formEditarUsu->get('fechaNac')->getData();
                $emailUsuario= $formEditarUsu->get('email')->getData();
                $passwordUsuario= $formEditarUsu->get('password')->getData();

                $em = $this->getDoctrine()->getManager();
                $usuario = $em->getRepository('AppBundle:Usuarios')->find($idUsuario);
                
                if (!$usuario) {
                    throw $this->createNotFoundException(
                        'No usuario found for id '.$idUsuario
                    );
                }
                
                
                //actualizamos los datos 
                
                $usuario->setIdusuarios($idUsuario);
                $usuario->setNombre($nombreUsuario);
                $usuario->setApellidos($apellidosUsuario);
                $usuario->setEmail($emailUsuario);
                $usuario->setFechanac($fechaUsuario);
                $usuario->setPassword($passwordUsuario);
                //lo persistimos
                $em->flush();
            
                return $this->redirect($this->generateUrl('paginaPrincipal'));
                
                
            
            }

            
    
    
            


            

        
            
                return $this->render('paginaPrincipal/pagina.html.twig',["categorias"=>$categorias,
                'numeroProductos'=>$numeroProductos,'productos'=>$productos,"imagenCod"=>$imagenesCod,
                'formEditarPro'=>$formEditarPro->createView(),"imagenCod1"=>$imagenesCod1,
                'formNuevoProducto'=>$formNuevoProducto->createView(),"imagenCodV"=>$imagenesCodV,
                "productosV"=>$productosV,"usuario"=>$usuario1,"fomEditarUsu"=>$formEditarUsu->createView()]
                ); 
            }
            else{
                return $this->redirect($this->generateUrl('catServicio'));

            }
        }
      
 

     /**
     * @Route("/admin", name="admin")
     */

    public function indexAction(){
        return new Response("Welcome to the admin area"); 
     }

     /**
     * @Route("/login1", name="login1")
     */

    public function loginAction(){

        if (is_object($this->getUser())) {
            return $this->redirectToRoute('paginaprincipal');
        }
        $autentificacionUtil = $this->get('security.authentication_utils');
        
        //Si falla el login
        $error = $autentificacionUtil->getLastAuthenticationError();
        return $this->render('security/login.html.twig',array('error'=>$error));
     }

      /**
     * @Route("/login_check", name="login_check")
     */

    public function loginCheckAction(){
        return new Response("Welcome to the admin area"); 
     }

     /**
     * @Route("/pagina/idProducto", name="idProductoEditar")
     * @Method({"GET"})
     */
    public function formIdEditarAction(Request $request){
        //variable que coge el texto del input
        $string=$request->get('idProducto');
        //echo $string;
        //return users on json format
        $em = $this->getDoctrine()->getManager();
        //consulta por id
        //al poner la foto en la consulta da error
        $query=$em->createQuery('SELECT p.nombre,p.precio,p.idproductos,p.descripcion FROM AppBundle:Productos p WHERE p.idproductos  LIKE :string')
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
     * @Route("/producto/check", name="productoCheck")
     * @Method({"GET"})
     */
    public function productoCheckAction(Request $request){
        //variable que coge el texto del input
        $string=$request->get('idProducto');
        
        //echo $string;
        //return users on json format
        $em = $this->getDoctrine()->getManager();
        //consulta por id
        //al poner la foto en la consulta da error
        $query=$em->createQuery('SELECT p.nombre FROM AppBundle:Productos p WHERE p.idproductos  LIKE :string')
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
     * @Route("/producto/borrar", name="productoBorrar")
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
            $producto=$request->get('nombreProducto'.$i);
            //DELETE FROM table_name
            echo "pro".$producto;
            $query=$em->createQuery('DELETE  FROM AppBundle:Productos p WHERE p.nombre  LIKE :string')
            ->setParameter(':string',$producto);
            $centro=$query->getResult();


        }
        

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
    * @Route("/logout", name="logout")
    */
    public function logoutAction(Request $request)
    {
    // UNREACHABLE CODE
    }
}
