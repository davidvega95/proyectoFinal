<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Productos;
use Symfony\Component\Validator\Constraints\DateTime;
class UsuarioController extends Controller
{

    /** funcion para mostrar los productos de ese usuario
     * @Route("/usuario/{id}", name="usuario")
     *
     * @return void
     */
    public function UsuarioAction($id){
        
        $categorias=$this->getDoctrine()
        ->getRepository("AppBundle\Entity\Categoriaproductos")
        ->findAll();
        //buscamos usuario por id
        $em=$this->getDoctrine()->getManager();
        $usuarios=$em->getRepository(
        "AppBundle\Entity\Usuarios");
        $usuario=$usuarios->find($id);
        //obtenemos la imagen del usuario
        $file1=$usuario->getFoto();
        $bits1=stream_get_contents($file1);
        $file1=$bits1;
        $imagen1=base64_encode($bits1);
        $imagenesCod1[$usuario->getIdusuarios()]=$imagen1;
        //obtenemos el numero de productos que ha subido un usuario
        $query1=$em->createQuery('SELECT COUNT(p) from AppBundle:Productos p where p.usuariosusuarios=:id')
        ->setParameter(':id',$id);
        //ejecutamos sentencias
        $numeroProductos=$query1->getResult();
        //obtememos los productos de ese usuario
        $query2=$em->createQuery('SELECT p from AppBundle:Productos p where p.usuariosusuarios=:id')
        ->setParameter(':id',$id);
        //ejecutamos sentencias
        $productos=$query2->getResult();

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
        
       
            
    
    
        

        return $this->render('usuario/usuario.html.twig',["usuario"=>$usuario,"categorias"=>$categorias,
        "imagenCod1"=>$imagenesCod1,"numProductosUsuario"=>$numeroProductos,
        "productos"=>$productos,"imagenCod"=>$imagenesCod]
    );

    }

    /**
     * funcion para ver el detalle del producto
     * @Route("/producto/{id_producto}/{id_usuario}", name="detalle_producto")
     *
     * @return void
     */

    public function ProductoAction($id_producto,$id_usuario){
        $categorias=$this->getDoctrine()
        ->getRepository("AppBundle\Entity\Categoriaproductos")
        ->findAll();
        $em=$this->getDoctrine()->getManager();
        $usuarios=$em->getRepository(
            "AppBundle\Entity\Usuarios");
            $usuario=$usuarios->find($id_usuario);
            //obtenemos la imagen del usuario
            $file1=$usuario->getFoto();
            $bits1=stream_get_contents($file1);
            $file1=$bits1;
            $imagen1=base64_encode($bits1);
            $imagenesCod1[$usuario->getIdusuarios()]=$imagen1;
         //obtenemos el numero de productos que ha subido un usuario
         $query1=$em->createQuery('SELECT COUNT(p) from AppBundle:Productos p where p.usuariosusuarios=:id')
         ->setParameter(':id',$id_usuario);
         //ejecutamos sentencias
         $numeroProductos=$query1->getResult();
         $productos=$em->getRepository(
            "AppBundle\Entity\Productos");
            $producto=$productos->find($id_producto);
        //obtenemos la imagen del usuario
        $file2=$producto->getFoto();
        $bits2=stream_get_contents($file2);
        $file2=$bits2;
        $imagen2=base64_encode($bits2);
        $imagenesCod2[$producto->getIdproductos()]=$imagen2;
        dump($producto);
        

         

        return $this->render('usuario/producto.html.twig',["usuario"=>$usuario,"categorias"=>$categorias,
        "imagenCod1"=>$imagenesCod1,"numProductosUsuario"=>$numeroProductos,
        "producto"=>$producto,"imagenCod2"=>$imagenesCod2]
    );


    }
}
