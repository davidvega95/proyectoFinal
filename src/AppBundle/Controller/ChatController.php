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
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
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

        if(is_object($this->getUser())){

            $email=$this->getUser()->getUsername();
            
                    
            //coger primero el id de usuario que sea del gmail
            $em = $this->getDoctrine()->getManager();
        
            //consulta por id
            //al poner la foto en la consulta da error
            $query=$em->createQuery('SELECT u.idusuarios FROM AppBundle:Usuarios u WHERE u.email  LIKE :string')
            ->setParameter(':string',$email);
            
            $usuarioE=$query->getResult();
            //$usuario[0]["idusuarios"]


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
            //cogemos el del usuario
            $usuario1 = $this->getDoctrine()
            ->getRepository(Usuarios::class)
            ->find($usuarioE[0]["idusuarios"]);
            $producto= $this->getDoctrine()
            ->getRepository(Productos::class)
            ->find($idProducto);
            $conversacion->setId_productos($producto);
            $conversacion->setId_usuarios($usuario);
            $conversacion->setId_usuarios1($usuario1);
            $em=$this->getDoctrine()->getManager();
            
            $idproConverN=$conversacion->getId_productos()->getIdproductos();
            $idusuConverN=$conversacion->getId_usuarios()->getIdusuarios();
            $idusuConverM1=$conversacion->getId_usuarios1()->getIdusuarios();
            dump($conversacion);
            $conversacionesBD = $this->getDoctrine()
            ->getRepository(Conversaciones::class)
            ->findAll();
            foreach ($conversacionesBD as $conversacion1){
                $idproConver=$conversacion1->getId_productos()->getIdproductos();
                $idusuConver=$conversacion1->getId_usuarios()->getIdusuarios();
                $idusuConver1=$conversacion1->getId_usuarios1()->getIdusuarios();
                 //lo guardamos en la base de datos
                if($idproConver==$idproConverN && $idusuConver==$idusuConverN && $idusuConver1==$idusuConverM1){
                    $encontrado=true;
                    break;
            }
            else{
                //no se ha encontrado en la bd por lo que se añada
                $encontrado=false;
            }
        }
        dump($encontrado);
       
        if($encontrado==false){
           
            $em->persist($conversacion);
            $em->flush();

        }
           
   
            
            
            //mostrar conversaciones
            $query1=$em->createQuery('SELECT u.nombre,p.descripcion,p.foto,c.idconversaciones,p.idproductos
            ,u.idusuarios from AppBundle:Conversaciones c,AppBundle:Usuarios u,
             AppBundle:Productos p  where c.id_usuarios=u.idusuarios  and p.idproductos=c.id_productos and  
            c.id_usuarios1=:idusu')->setParameter(":idusu",$usuarioE[0]["idusuarios"]);
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
            WHERE  m.conversaciones=:idconversaciones and m.usuariosusuarios=u.idusuarios and m.conversaciones=c.idconversaciones')
            ->setParameter(":idconversaciones",$conversaciones[0]["idconversaciones"]);
            //ejecutamos sentencias
            $mensajes=$query2->getResult();
            dump($conversaciones[0]["idconversaciones"]);
            dump($mensajes);
            
            //mostrar el formulario para crear mensajes
            //creamos un formulario para el registro
           


            return $this->render('chat/chat.html.twig',["categorias"=>$categorias,
            "conversaciones"=>$conversaciones,"imagenCod"=>$imagenesCod,"mensajes"=>$mensajes]
            ); 
    }
        else{
                return $this->render('chat/chat.html.twig',["categorias"=>$categorias]
            ); 

        }
    }
    else{
        return $this->redirect($this->generateUrl('catServicio'));
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
        where c.id_usuarios=u.idusuarios  and p.idproductos=c.id_productos and 
        c.id_usuarios1=:idusu ')->setParameter(":idusu",$idUsuario);
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
     * @Route("/converChat/{idUsuario}/{idconversacion}", name="chatPrivado")
     */

    public function converChatAction($idUsuario,$idconversacion, Request $request){

                $email=$this->getUser()->getUsername();
                
                        
                //coger primero el id de usuario que sea del gmail
                $em = $this->getDoctrine()->getManager();
            
                //consulta por id
                //al poner la foto en la consulta da error
                $query=$em->createQuery('SELECT u.idusuarios FROM AppBundle:Usuarios u WHERE u.email  LIKE :string')
                ->setParameter(':string',$email);
                
                $usuarioE=$query->getResult();
        
                //para crear el header
                $categorias=$this->getDoctrine()
                ->getRepository("AppBundle\Entity\Categoriaproductos")
                ->findAll();
                $em = $this->getDoctrine()->getManager();
                 //mostrar todas las conversaciones del usuario
                $query1=$em->createQuery('SELECT u.nombre,p.descripcion,p.foto,c.idconversaciones,p.idproductos
                ,u.idusuarios 
                from AppBundle:Conversaciones c,AppBundle:Usuarios u,
                AppBundle:Productos p 
                where c.id_usuarios=u.idusuarios  and p.idproductos=c.id_productos and  
                c.id_usuarios1=:idusu')->setParameter(":idusu",$usuarioE[0]["idusuarios"]);
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

                    $query5=$em->createQuery('SELECT c.idconversaciones,p.idproductos from AppBundle:Conversaciones c, AppBundle:Productos p
                    where c.idconversaciones=:id and p.idproductos=c.id_productos')->setParameter(":id",$idconversacion);
                     //ejecutamos sentencias
                     $conversation=$query5->getResult();
                     dump($conversation);
                     
           
                    //mostrar chat
                    $query2=$em->createQuery('SELECT m.mensaje,u.nombre,m.idmensajes from AppBundle:Conversaciones c, AppBundle:Mensajes m,
                    AppBundle:Usuarios u
                     WHERE  m.conversaciones=:idconversaciones and m.usuariosusuarios=u.idusuarios and m.conversaciones=c.idconversaciones')
                     ->setParameter(":idconversaciones",$idconversacion);
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
                       ->find($idconversacion);
                      
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
                   'form'=>$form->createView(),"conversation"=>$conversation]
                   ); 
           
                       
                   }
           
                   return $this->render('chat/chat.html.twig',["categorias"=>$categorias,
                   "conversaciones"=>$conversaciones,"imagenCod"=>$imagenesCod,"mensajes"=>$mensajes,
                   'form'=>$form->createView(),"conversation"=>$conversation]
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
        
       dump($conversacion);
       


        //creamos mensaje
        $mensaje = new Mensajes();

         //$formNuevoProducto->get('categoriaproductoscategoriaproductos')->getData()
         $mensaje->setMensaje($idconversacion["nombreTexto"]);
         $mensaje->setUsuariosusuarios1($usuario1);
         $mensaje->setUsuariosusuarios($usuario1);
         $mensaje->setConversaciones($conversacion);
         dump($mensaje);
         //para guardarlo en la  bd
         $em = $this->getDoctrine()->getManager();
         $em->persist($mensaje);
         $em->flush();
       
         //ahora cogemos  los mensajes nuevos de la conversacion 
        //mostrar chat
        $query3=$em->createQuery('SELECT m.mensaje,u.nombre,m.idmensajes from AppBundle:Conversaciones c, AppBundle:Mensajes m,
        AppBundle:Usuarios u
         WHERE  m.conversaciones=:idconversaciones and m.usuariosusuarios=u.idusuarios and m.conversaciones=c.idconversaciones')
         ->setParameter(":idconversaciones",$conversaciones[0]["idconversaciones"]);
         //ejecutamos sentencias
         $mensajesActualizados=$query3->getResult();


       

        dump($mensajesActualizados);
        
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


     /**
     * @Route("/perfil", name="perfil")
     */

    public function perfilAction(Request $request){


            if (is_object($this->getUser())) {
                $imagenesCodV=null;
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
                        echo "hola";
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
        
                    
            
            
                    
        
        
                
        
                
                    
                        return $this->render('perfil/index.html.twig',["categorias"=>$categorias,
                        'numeroProductos'=>$numeroProductos,'productos'=>$productos,"imagenCod"=>$imagenesCod,"imagenCod1"=>$imagenesCod1,
                        "imagenCodV"=>$imagenesCodV,"productosV"=>$productosV,"usuario"=>$usuario1,"fomEditarUsu"=>$formEditarUsu->createView()]
                        ); 
                    }
                    else{
                        return $this->redirect($this->generateUrl('catServicio'));
        
                    }
                }
}
