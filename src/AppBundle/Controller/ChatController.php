<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Conversaciones;
use AppBundle\Entity\Usuarios;
use AppBundle\Entity\Productos;
use AppBundle\Entity\Mensajes;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\HttpFoundation\Response;

class ChatController extends Controller
{


     /**
     * @Route("/chat/{idProducto}/{idUsuario}", name="chat")
     */

    public function chatAction($idProducto,$idUsuario, Request $request){


         //para crear el header
         $categorias=$this->getDoctrine()
         ->getRepository("AppBundle\Entity\Categoriaproductos")
         ->findAll();
        //para crear una conversación
        $em = $this->getDoctrine()->getManager();
        $conversacion=new Conversaciones();
        $usuario = $this->getDoctrine()
        ->getRepository(Usuarios::class)
        ->find($idUsuario);
        $producto= $this->getDoctrine()
        ->getRepository(Productos::class)
        ->find($idProducto);
        $conversacion->setId_productos($producto);
        $conversacion->setId_usuarios($usuario);
        $em=$this->getDoctrine()->getManager();
        //lo guardamos en la base de datos
        //$em->persist($conversacion);
        //$em->flush();
        
        //mostrar conversaciones
        $query1=$em->createQuery('SELECT u.nombre,p.descripcion,p.foto,c.idconversaciones,p.idproductos,u.idusuarios from AppBundle:Conversaciones c,AppBundle:Usuarios u,
        AppBundle:Productos p 
        where c.id_usuarios=u.idusuarios and p.idproductos=c.id_productos and 
        c.id_usuarios=:idusu and c.id_productos=:producto')->setParameter(":idusu",$idUsuario)
        ->setParameter(":producto",$idProducto);
         //ejecutamos sentencias
         $conversaciones=$query1->getResult();
         dump($conversaciones);
         if($conversaciones!=null){
         //echo $conversaciones[0]["foto"];
         for($i=0;$i<count($conversaciones);$i++){
             // dump($producto->getFoto());
            //guardamos en una variable cada una de las fotos de la bd
            
            $file=$conversaciones[$i]["foto"];
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
             $imagenesCod[$conversaciones[$i]["idproductos"]]=$imagen;
             //$imagenesCod1[$producto->getIdproductos()]=$imagen1;
             

         }

         //mostrar chat
         $query2=$em->createQuery('SELECT m.mensaje,u.nombre,m.idmensajes from AppBundle:Conversaciones c, AppBundle:Mensajes m,
         AppBundle:Usuarios u
          WHERE  m.conversaciones=:idconversaciones and m.usuariosusuarios=u.idusuarios')
          ->setParameter(":idconversaciones",$conversaciones[0]["idconversaciones"]);
          //ejecutamos sentencias
          $mensajes=$query2->getResult();
          dump($mensajes);

          //mostrar el formulario para crear mensajes
           //creamos un formulario para el registro
        $mensaje = new Mensajes();
        $form = $this->createFormBuilder($mensaje)
                ->add('mensaje', TextType::class)
                ->add('Enviar', SubmitType::class)
                ->getForm();
    
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $conversacion = $this->getDoctrine()
            ->getRepository(Conversaciones::class)
            ->find($conversaciones[0]["idconversaciones"]);
           
            //$formNuevoProducto->get('categoriaproductoscategoriaproductos')->getData()
            $mensaje->setUsuariosusuarios1($usuario);
            $mensaje->setUsuariosusuarios($usuario);
            $mensaje->setConversaciones($conversacion);
            //para guardarlo en la  bd
            $em = $this->getDoctrine()->getManager();
            //$em->persist($mensaje);
            //$em->flush();

         
        return $this->render('chat/chat.html.twig',["categorias"=>$categorias,
        "conversaciones"=>$conversaciones,"imagenCod"=>$imagenesCod,"mensajes"=>$mensajes,
        'form'=>$form->createView()]
        ); 

            
        }

        return $this->render('chat/chat.html.twig',["categorias"=>$categorias,
        "conversaciones"=>$conversaciones,"imagenCod"=>$imagenesCod,"mensajes"=>$mensajes,
        'form'=>$form->createView()]
        ); 
    }
    else{
        return $this->render('chat/chat.html.twig',["categorias"=>$categorias]
        ); 


    }
       
        

        

         


       
        

     }

     /**
     * @Route("/chatPrincipal/{idUsuario}", name="chatPrincipal")
     */

     public function chatPrincipalAction($idUsuario, Request $request){

        //para crear el header
        $categorias=$this->getDoctrine()
        ->getRepository("AppBundle\Entity\Categoriaproductos")
        ->findAll();
        $em = $this->getDoctrine()->getManager();
         //mostrar todas las conversaciones
        $query1=$em->createQuery('SELECT u.nombre,p.descripcion,p.foto,c.idconversaciones,p.idproductos,u.idusuarios from AppBundle:Conversaciones c,AppBundle:Usuarios u,
        AppBundle:Productos p 
        where c.id_usuarios=u.idusuarios and p.idproductos=c.id_productos and 
        c.id_usuarios=:idusu')->setParameter(":idusu",$idUsuario);
         //ejecutamos sentencias
         $conversaciones=$query1->getResult();


         if($conversaciones!=null){
            //echo $conversaciones[0]["foto"];
            for($i=0;$i<count($conversaciones);$i++){
                // dump($producto->getFoto());
               //guardamos en una variable cada una de las fotos de la bd
               
               $file=$conversaciones[$i]["foto"];
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
                $imagenesCod[$conversaciones[$i]["idproductos"]]=$imagen;
                //$imagenesCod1[$producto->getIdproductos()]=$imagen1;
                
   
            }
   
            //mostrar chat
            $query2=$em->createQuery('SELECT m.mensaje,u.nombre,m.idmensajes from AppBundle:Conversaciones c, AppBundle:Mensajes m,
            AppBundle:Usuarios u
             WHERE  m.conversaciones=:idconversaciones and m.usuariosusuarios=u.idusuarios')
             ->setParameter(":idconversaciones",$conversaciones[0]["idconversaciones"]);
             //ejecutamos sentencias
             $mensajes=$query2->getResult();
             dump($mensajes);
   
             //mostrar el formulario para crear mensajes
              //creamos un formulario para el registro
           $mensaje = new Mensajes();
           $form = $this->createFormBuilder($mensaje)
                   ->add('mensaje', TextType::class)
                   ->add('Enviar', SubmitType::class)
                   ->getForm();
       
           $form->handleRequest($request);
   
           if ($form->isSubmitted() && $form->isValid()) {
               // $form->getData() holds the submitted values
               // but, the original `$task` variable has also been updated
               $conversacion = $this->getDoctrine()
               ->getRepository(Conversaciones::class)
               ->find($conversaciones[0]["idconversaciones"]);
              
               //$formNuevoProducto->get('categoriaproductoscategoriaproductos')->getData()
               $mensaje->setUsuariosusuarios1($usuario);
               $mensaje->setUsuariosusuarios($usuario);
               $mensaje->setConversaciones($conversacion);
               //para guardarlo en la  bd
               $em = $this->getDoctrine()->getManager();
               //$em->persist($mensaje);
               //$em->flush();
   
            
           return $this->render('chat/chat.html.twig',["categorias"=>$categorias,
           "conversaciones"=>$conversaciones,"imagenCod"=>$imagenesCod,"mensajes"=>$mensajes,
           'form'=>$form->createView()]
           ); 
   
               
           }
   
           return $this->render('chat/chat.html.twig',["categorias"=>$categorias,
           "conversaciones"=>$conversaciones,"imagenCod"=>$imagenesCod,"mensajes"=>$mensajes,
           'form'=>$form->createView()]
           ); 
       }
       else{
           return $this->render('chat/chat.html.twig',["categorias"=>$categorias]
           ); 
   
   
       }
         
         
     }


     /**
     * @Route("/chatMensaje", name="crearMensaje")
     * @Method({"GET"})
     */
     //AJAX
     
     public function chatMensajeAction(Request $request ){

        //cogemos el usuario para indicarselo en el mensaje de quien es
        $email=$this->getUser()->getUsername();
        //coger primero el id de usuario que sea del gmail
        $em = $this->getDoctrine()->getManager();
        //consulta por id
        //al poner la foto en la consulta da error
        $query=$em->createQuery('SELECT u.idusuarios FROM AppBundle:Usuarios u WHERE u.email  LIKE :string')
        ->setParameter(':string',$email);
        $usuario=$query->getResult();
        //coger el usuario logueado
        $usuario1 = $this->getDoctrine()
        ->getRepository(Usuarios::class)
        ->find($usuario[0]["idusuarios"]);

        //variable que coge el texto del input
        $idconversacion=$request->get('objeto');
   
        
        //echo $string;
        //return users on json format
        $em = $this->getDoctrine()->getManager();


         //cogemos la conversacion para indicarselo al mensaje
         $query2=$em->createQuery('SELECT c.idconversaciones from AppBundle:Conversaciones c,AppBundle:Usuarios u,
        AppBundle:Productos p 
        where c.id_usuarios=u.idusuarios and p.idproductos=c.id_productos and
         c.idconversaciones=:idconversaciones')
        ->setParameter(":idconversaciones",$idconversacion["idProducto"]);
        $conversaciones=$query2->getResult();
        
        $conversacion = $this->getDoctrine()
        ->getRepository(Conversaciones::class)
        ->find($conversaciones[0]["idconversaciones"]);
        
       //var_dump($conversacion);


        //creamos mensaje
        $mensaje = new Mensajes();

         //$formNuevoProducto->get('categoriaproductoscategoriaproductos')->getData()
         $mensaje->setMensaje($idconversacion["nombreTexto"]);
         $mensaje->setUsuariosusuarios1($usuario1);
         $mensaje->setUsuariosusuarios($usuario1);
         $mensaje->setConversaciones($conversacion);
         //para guardarlo en la  bd
         $em = $this->getDoctrine()->getManager();
         $em->persist($mensaje);
         $em->flush();
       
         //ahora cogemos  los mensajes nuevos de la conversacion 
        //mostrar chat
        $query3=$em->createQuery('SELECT m.mensaje,u.nombre,m.idmensajes from AppBundle:Conversaciones c, AppBundle:Mensajes m,
        AppBundle:Usuarios u
         WHERE  m.conversaciones=:idconversaciones and m.usuariosusuarios=u.idusuarios')
         ->setParameter(":idconversaciones",$conversaciones[0]["idconversaciones"]);
         //ejecutamos sentencias
         $mensajesActualizados=$query3->getResult();


       

        //dump($centro);
        
        //Codificadores XML y JSON
        $encoders = array(new XmlEncoder(), new JsonEncoder());
       
        $normalizers = array(new GetSetMethodNormalizer());
       
        $serializer = new Serializer($normalizers, $encoders);
        
        $jsonContent = $serializer->serialize($mensajesActualizados, 'json');
    
        //var_dump($jsonContent);
        
        $response = new Response($jsonContent);
        //var_dump($response);
        return $response;
    }
}
