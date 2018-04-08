<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use AppBundle\Entity\Categoriaproductos;
use AppBundle\Entity\Productos;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\HttpFoundation\Response;

class LoginController extends Controller
{

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
    public function ListadoAction()
    {  
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
    $productos=$this->getDoctrine()->getRepository("AppBundle\Entity\Productos")->findAll();
    dump($productos);
    dump($categorias);
    //pasamos las fotos de los usuarios a base 64
    foreach($usuarios as $usuario){
        $file1=$usuario->getFoto();
        $bits1=stream_get_contents($file1);
        $file1=$bits1;
        $imagen1=base64_encode($bits1);
        $imagenesCod1[$usuario->getIdusuarios()]=$imagen1;


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
        //return users on json format
        $em = $this->getDoctrine()->getManager();
        //consulta por id
        //al poner la foto en la consulta da error
        $query=$em->createQuery('SELECT p.nombre,p.precio FROM AppBundle:Productos p WHERE p.nombre  LIKE :string')
        ->setParameter(':string',$string);
        $centro=$query->getResult();

        dump($centro);
        
        //Codificadores XML y JSON
        $encoders = array(new XmlEncoder(), new JsonEncoder());
       
        $normalizers = array(new ObjectNormalizer());
       
        $serializer = new Serializer($normalizers, $encoders);
        
        $jsonContent = $serializer->serialize($centro, 'json');
    
        var_dump($jsonContent);

        $response = new Response($jsonContent);
        return $response;
    }

  


}
