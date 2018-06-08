<?php

namespace AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Usuarios;
use AppBundle\Entity\Categoriaproductos ;
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

class crudCategoriaController extends Controller
{

     /**
     * @Route("/crudCategoria", name="gestionCategorias")
     */

     public function crudCategoriasAction(Request $request){

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

          //formulario para nuevo usuario
        $categoria = new Categoriaproductos();
        //me creo el form del nuevo producto
        $formNuevaCategoria = $this->createFormBuilder($categoria)
        ->add('idcategoriaproductos', HiddenType::class)
        ->add('nombre', TextType::class)
        ->add('actualizar', SubmitType::class, array('label' => 'Guardar'))
        ->getForm();
        $formNuevaCategoria->handleRequest($request);

        if($formNuevaCategoria->isSubmitted() && $formNuevaCategoria->isValid()){
         
            
            //obtenemos los datos del formulario en un objeto productos
            $categoria->setNombre($formNuevaCategoria->get('nombre')->getData());
            
            
            //var_dump($formNuevoProducto->get('usuariosusuarios')->getData());
            
            $em=$this->getDoctrine()->getManager();
            //lo guardamos en la base de datos
            $em->persist($categoria);
            $em->flush();
            return $this->redirect($this->generateUrl('gestionCategorias'));
            
            
        }

         //me creo el form de Editar 
         $formEditarCategoria = $this->createFormBuilder($categoria)
         ->add('idcategoriaproductos', TextType::class)
         ->add('nombre', TextType::class)
         ->add('actualizar1', SubmitType::class, array('label' => 'Guardar'))
         ->getForm();
         $formEditarCategoria->handleRequest($request);

          //al darle al boton actualizar
    if($formEditarCategoria->isSubmitted() && $formEditarCategoria->isValid()){
        //exit();
        $idCategorias = $formEditarCategoria->get('idcategoriaproductos')->getData();
        $nombreCategoria= $formEditarCategoria->get('nombre')->getData();
       

        $em = $this->getDoctrine()->getManager();
        $categoria = $em->getRepository('AppBundle:Categoriaproductos')->find($idCategorias);

        if (!$categoria) {
            throw $this->createNotFoundException(
                'No product found for id '.$idCategorias
            );
        }
        //actualizamos los datos 
        $categoria->setNombre($nombreCategoria);
       
        //lo persistimos
        $em->flush();

        return $this->redirect($this->generateUrl('gestionCategorias'));

    }
        


        return $this->render('crudCategorias/index.html.twig',["categorias"=>$categorias,
        "productos"=>$productos,"formNuevaCategoria"=>$formNuevaCategoria->createView(),"formEditarCategoria"=>$formEditarCategoria->createView()]
        ); 
     }


      /**
     * @Route("/crudCategorias/idCategoria", name="idCategoriasEditar")
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
        $query=$em->createQuery('SELECT c.nombre,c.idcategoriaproductos FROM AppBundle:Categoriaproductos c WHERE c.idcategoriaproductos  LIKE :string')
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
     * @Route("/categoriaR/check", name="categoria2Check")
     * @Method({"GET"})
     */
    public function productoCheckAction(Request $request){
        //variable que coge el texto del input
        $string=$request->get('idUsuario');

        //echo $string;
        //return users on json format
        $em = $this->getDoctrine()->getManager();
        //consulta por id
        //al poner la foto en la consulta da error
        $query=$em->createQuery('SELECT c.nombre FROM AppBundle:Categoriaproductos c WHERE c.idcategoriaproductos  LIKE :string')
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
     * @Route("/categoria1/borrar", name="categoriaBorrar")
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
            $query=$em->createQuery('DELETE  FROM AppBundle:Categoriaproductos c WHERE c.nombre  LIKE :string')
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

    /**
     * @Route("/categoria1/check", name="categoriaCheck")
     * @Method({"GET"})
     */
    public function categoriaCheckAction(Request $request){
        //variable que coge el texto del input
        $string=$request->get('idProducto');

        //echo $string;
        //return users on json format
        $em = $this->getDoctrine()->getManager();
        //consulta por id
        //al poner la foto en la consulta da error
        $query=$em->createQuery('SELECT c.nombre FROM AppBundle:Categoriaproductos c WHERE c.idcategoriaproductos  LIKE :string')
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
}
