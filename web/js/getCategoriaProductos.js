
    $( document ).ready(function() {
        $( ".container_uno" ).hide();
        $( ".container_dos" ).show();
        $( ".formularioEdicionPro" ).hide();
        $( ".formularioNuevoProducto" ).hide();
        
        
       
        $( ".container_tres" ).hide();
        $( ".container_cuatro" ).hide();

        $("#nuevoProducto").click(function(){
            $( ".formularioNuevoProducto" ).show();
            $( ".container_dos" ).hide();

        });
        //al hacer click al boton editar de la tabla productos PUBLICADOS
        $( "button[id^=formEditarP]" ).click(function() {
       
            var oID = $(this).attr("id");
            var regex = /(\d+)/g;
            var idProducto=oID.match(regex);
            
            $.ajax({
                type: "GET",
                url: "http://localhost/proyectofinal/proyectoThinder/web/app_dev.php/pagina/idProducto",
                dataType: "json",
                data: {idProducto : idProducto}
            }).done  (function(response) 
                  {
                    
                    
                    $("#form_idproductos").val(response[0].idproductos);
                    $(".nombre").val(response[0].nombre);
                     $("#form_precio").val(response[0].precio);
                     $("#form_descripcion").val(response[0].descripcion);
                    
                    
                    $( ".formularioEdicionPro" ).show();
                    $( ".container_dos" ).hide();


                    
    
                  } )
    
                  .fail  (function(response) 
                  {
                    
                      
                    console.log(JSON.stringify(response));
                  }
    
                );
            

           // $( ".container_dos" ).hide();
          //  $( ".formularioEdicionPro" ).show();

            
          });
          $("input[id^=checkboxU]").change(function(){
              //cogemos id del producto
            
              var oID = $(this).attr("id");
              var regex = /(\d+)/g;
              var idUsuario=oID.match(regex);
             
            if($("#checkboxU"+idUsuario).attr('checked')){
                
                $("#checkboxU"+idUsuario).removeAttr("checked");

            }
            
            //si el checkbox está atrue
            if( $("#checkboxU"+idUsuario).is(':checked') ) {
                
                $.ajax({
                    type: "GET",
                    url: "http://localhost/proyectofinal/proyectoThinder/web/app_dev.php/usuarioR/check",
                    dataType: "json",
                    data: {idUsuario : idUsuario}
                }).done  (function(response) 
                      {
                        
                          $("#nombreC").append('<p>'+response[0].nombre+'</p>');
                         
        
                      } )
        
                      .fail  (function(response) 
                      {
                   
                          
                        console.log(JSON.stringify(response));
                      }
        
                    );
                }
                else {
                    $.ajax({
                        type: "GET",
                        url: "http://localhost/proyectofinal/proyectoThinder/web/app_dev.php/usuarioR/check",
                        dataType: "json",
                        data: {idUsuario : idUsuario}
                    }).done  (function(response) 
                          {
                             
                              $("p").remove(":contains("+response[0].nombre+")");
                             
            
                          } )
            
                          .fail  (function(response) 
                          {
                              
                              
                            console.log(JSON.stringify(response));
                          }
            
                        );

                }
                
            });


            $("input[id^=checkboxV]").change(function(){
                //cogemos id del producto
              
                var oID = $(this).attr("id");
                var regex = /(\d+)/g;
                var idProducto=oID.match(regex);
               
              if($("#checkboxV"+idProducto).attr('checked')){
                  
                  $("#checkboxV"+idProducto).removeAttr("checked");
  
              }
              
              //si el checkbox está atrue
              if( $("#checkboxV"+idProducto).is(':checked') ) {
                  
                  $.ajax({
                      type: "GET",
                      url: "http://localhost/proyectofinal/proyectoThinder/web/app_dev.php/producto/check",
                      dataType: "json",
                      data: {idProducto : idProducto}
                  }).done  (function(response) 
                        {
                          
                            $("#nombre").append('<p>'+response[0].nombre+'</p>');
                           
          
                        } )
          
                        .fail  (function(response) 
                        {
                     
                            
                          console.log(JSON.stringify(response));
                        }
          
                      );
                  }
                  else {
                      $.ajax({
                          type: "GET",
                          url: "http://localhost/proyectofinal/proyectoThinder/web/app_dev.php/producto/check",
                          dataType: "json",
                          data: {idProducto : idProducto}
                      }).done  (function(response) 
                            {
                               
                                $("p").remove(":contains("+response[0].nombre+")");
                               
              
                            } )
              
                            .fail  (function(response) 
                            {
                                
                                
                              console.log(JSON.stringify(response));
                            }
              
                          );
  
                  }
                  
              });
            
            $("input[id^=checkboxC]").change(function(){
                //cogemos id del producto
              
                var oID = $(this).attr("id");
                var regex = /(\d+)/g;
                var idProducto=oID.match(regex);
               
              if($("#checkboxC"+idProducto).attr('checked')){
                  
                  $("#checkboxC"+idProducto).removeAttr("checked");
  
              }
              
              //si el checkbox está atrue
              if( $("#checkboxC"+idProducto).is(':checked') ) {
                  $.ajax({
                      type: "GET",
                      url: "http://localhost/proyectofinal/proyectoThinder/web/app_dev.php/categoria1/check",
                      dataType: "json",
                      data: {idProducto : idProducto}
                  }).done  (function(response) 
                        {
                            
                            $("#nombreC").append('<p>'+response[0].nombre+'</p>');
                           
          
                        } )
          
                        .fail  (function(response) 
                        {
                          
                            
                          console.log(JSON.stringify(response));
                        }
          
                      );
                  }
                  else {
                      $.ajax({
                          type: "GET",
                          url: "http://localhost/proyectofinal/proyectoThinder/web/app_dev.php/categoria1/check",
                          dataType: "json",
                          data: {idProducto : idProducto}
                      }).done  (function(response) 
                            {
                                
                                $("p").remove(":contains("+response[0].nombre+")");
                               
              
                            } )
              
                            .fail  (function(response) 
                            {
                                
                                
                              console.log(JSON.stringify(response));
                            }
              
                          );
  
                  }
                  
              });


              $("input[id^=checkboxP]").change(function(){
                //cogemos id del producto
              
                var oID = $(this).attr("id");
                var regex = /(\d+)/g;
                var idProducto=oID.match(regex);
                
              if($("#checkboxP"+idProducto).attr('checked')){
                  
                  $("#checkboxP"+idProducto).removeAttr("checked");
  
              }
              
              //si el checkbox está atrue
              if( $("#checkboxP"+idProducto).is(':checked') ) {
                  $.ajax({
                      type: "GET",
                      url: "http://localhost/proyectofinal/proyectoThinder/web/app_dev.php/producto/check",
                      dataType: "json",
                      data: {idProducto : idProducto}
                  }).done  (function(response) 
                        {
                            
                            $("#nombre").append('<p>'+response[0].nombre+'</p>');
                           
          
                        } )
          
                        .fail  (function(response) 
                        {
                           
                            
                          console.log(JSON.stringify(response));
                        }
          
                      );
                  }
                  else {
                      $.ajax({
                          type: "GET",
                          url: "http://localhost/proyectofinal/proyectoThinder/web/app_dev.php/producto/check",
                          dataType: "json",
                          data: {idProducto : idProducto}
                      }).done  (function(response) 
                            {
                                
                                $("p").remove(":contains("+response[0].nombre+")");
                               
              
                            } )
              
                            .fail  (function(response) 
                            {
                               
                                
                              console.log(JSON.stringify(response));
                            }
              
                          );
  
                  }
                  
              });
          
            


          $( "button[id^=formBorrarP]" ).click(function() {
            
                 
                var oID = $(this).attr("id");
                var regex = /(\d+)/g;
                var idProducto=oID.match(regex);
                
                 //checkea al producto que le ha dado borrar
                 $("#checkboxP"+idProducto).attr('checked', true);  
                 //$("#checkbox"+idProducto).css({"display": "block"});
                 //abre todos los checkbox
                 $("input:checkbox").each(function() {
                    $(this).css({"display": "block"});
               });
               //desaparece boton editar 
               $( "button[id^=formEditarP]" ).each(function() {
                   $(this).css({"display": "none"});

               });
               //desaparece el boton borrar
               $( "button[id^=formBorrarP]" ).each(function() {
                $(this).css({"display": "none"});

            });
               //aparece un div
               $("#borrar").css({"display": "block"});

               //ajax para coger los nombre de los productos que esta en checkbox a true
               $.ajax({
                type: "GET",
                url: "http://localhost/proyectofinal/proyectoThinder/web/app_dev.php/producto/check",
                dataType: "json",
                data: {idProducto : idProducto}
            }).done  (function(response) 
                  {
                      
                      $("#nombre").append('<p>'+response[0].nombre+'</p>');
                     
    
                  } )
    
                  .fail  (function(response) 
                  {
                     
                      
                    console.log(JSON.stringify(response));
                  }
    
                );
            });


            $( "button[id^=formBorraV]" ).click(function() {
                
                     
                    var oID = $(this).attr("id");
                    var regex = /(\d+)/g;
                    var idProducto=oID.match(regex);
                   
                     //checkea al producto que le ha dado borrar
                     $("#checkboxV"+idProducto).attr('checked', true);  
                     //$("#checkbox"+idProducto).css({"display": "block"});
                     //abre todos los checkbox
                     $("input:checkbox").each(function() {
                        $(this).css({"display": "block"});
                   });
                  
                   //desaparece el boton borrar
                   $( "button[id^=formBorrar]" ).each(function() {
                    $(this).css({"display": "none"});
    
                });
                   //aparece un div
                   $("#borrar").css({"display": "block"});
    
                   //ajax para coger los nombre de los productos que esta en checkbox a true
                   $.ajax({
                    type: "GET",
                    url: "http://localhost/proyectofinal/proyectoThinder/web/app_dev.php/producto/check",
                    dataType: "json",
                    data: {idProducto : idProducto}
                }).done  (function(response) 
                      {
                          
                          $("#nombre").append('<p>'+response[0].nombre+'</p>');
                         
        
                      } )
        
                      .fail  (function(response) 
                      {
                          
                          
                        console.log(JSON.stringify(response));
                      }
        
                    );
                });

                $( "button[id^=formBorraU]" ).click(function() {
                    
                         
                        var oID = $(this).attr("id");
                        var regex = /(\d+)/g;
                        var idUsuario=oID.match(regex);
                       
                         //checkea al producto que le ha dado borrar
                         $("#checkboxU"+idUsuario).attr('checked', true);  
                         //$("#checkbox"+idProducto).css({"display": "block"});
                         //abre todos los checkbox
                         $("input:checkbox").each(function() {
                            $(this).css({"display": "block"});
                       });
                      
                       //desaparece el boton borrar
                       $( "button[id^=formBorrar]" ).each(function() {
                        $(this).css({"display": "none"});
        
                    });
                       //aparece un div
                       $("#borrar").css({"display": "block"});
        
                       //ajax para coger los nombre de los productos que esta en checkbox a true
                       $.ajax({
                        type: "GET",
                        url: "http://localhost/proyectofinal/proyectoThinder/web/app_dev.php/usuarioR/check",
                        dataType: "json",
                        data: {idUsuario : idUsuario}
                    }).done  (function(response) 
                          {
                              
                              $("#nombre").append('<p>'+response[0].nombre+'</p>');
                             
            
                          } )
            
                          .fail  (function(response) 
                          {
                              
                              
                            console.log(JSON.stringify(response));
                          }
            
                        );
                    });
           
            
            //al hacer click a borrar productos del div generado
            $( "#borrar_productos" ).click(function(){
                
                var array=[];
                var texto=$('#nombre p').text();
                $('span').children('p').each(function(){
                    array.push($(this).text());
                });
               
                
                
                var objeto={};
               for(i=0;i<array.length;i++){
                   var nombreProducto=array[i];
                   var producto={nombreProducto:array[i]}
                  
                objeto["nombreProducto"+i]=array[i];
                
                
                
               }
               objetoLongitud=Object.keys(objeto).length;;
               
               objeto["longitudObjeto"]=objetoLongitud;
               console.log(objeto);

               
                   //AJAX PARA BORRAR PRODUCTOS
                    //ajax para coger los nombre de los productos que esta en checkbox a true
               $.ajax({
                type: "GET",
                url: "http://localhost/proyectofinal/proyectoThinder/web/app_dev.php/producto/borrar",
                dataType: "json",
                data: objeto,
                contentType: "application/json; charset=utf-8",
            }).done  (function(response) 
                  {
                    $("#borrar").css({"display": "none"});
                    location.reload();
                       
                     
                     
                     
    
                  } )
    
                  .fail  (function(response) 
                  {
                    
                      location.reload();
                      
                    console.log(JSON.stringify(response));
                  }
    
                );
                   

                   
               
              

            });


    });
    function abrirDiv1(){
        $( ".container_uno" ).show();
        $( ".container_dos" ).hide();
        $( ".container_tres" ).hide();
        $( ".container_cuatro" ).hide();
        $( ".container_cinco" ).hide();
        $( ".container_seis" ).hide();
        $( ".formularioEdicionPro" ).hide();
    }
    function abrirDiv2(){
       
        $( ".container_uno" ).hide();
        $( ".container_cinco" ).hide();
        $( ".container_seis" ).hide();
        $( ".formularioEdicionPro" ).hide();
        $( ".container_dos" ).show();
        $( ".container_tres" ).hide();
        $( ".container_cuatro" ).hide();
        $(".formularioNuevoProducto").hide();
        

    }
    
    function abrirDiv4(){
        $( ".container_uno" ).hide();
        $( ".container_dos" ).hide();
        $( ".container_tres" ).hide();
        $( ".container_cuatro" ).show();
        $( ".container_cinco" ).hide();
        $( ".container_seis" ).hide();

    }
    //al hacer click al tab publicos
    function activarTabsPublicados(){
        //si hacmos click en el tab vendidos
        if(!$("#publicados").hasClass('active')){
            $("#publicados").addClass("active");
            $( ".publicadosPro" ).show();
            $("#vendidos").removeClass("active");
            $("#vendidosPro").hide();
        }
    }
    //al hacer click al tab de vendidos
    function activarTabsVendidos(){
        //si hacemos click en el publicados
        if(!$("#vendidos").hasClass('active')){
            $("#vendidosPro").show();
            $("#vendidos").addClass("active");
            $("#publicados").removeClass("active");
            $( ".publicadosPro" ).hide();
            
           

        }

    }

    
   //funcion parabuscar un producto en campo input a hacer click a search
    function buscarProducto() {
        
        //valor del input
        searchText = $("input#buscar").val();
        var nuevaCadena =  searchText.trim();
        
       
         

        $.ajax({
            type: "GET",
            url: "http://localhost/proyectofinal/proyectoThinder/web/app_dev.php/producto/buscarProducto",
            dataType: "json",
            data: {nuevaCadena : nuevaCadena}
        }).done  (function(response) 
              {
                
                //pone todos los div ocultos
                $('div[class ^= producto]').hide();
                //busca un div en concreto cogiendo el nombre de un clase
                for (i = 0; i < response.length; i++) { 
                    var buscar=$('div.producto'+response[i].idproductos).find('.nombre');
                    //console.log(buscar[0].innerHTML);
                    //cogemos el texto del span
                    var nombre=buscar[0].innerHTML
                    //lo mostramos
                    if(nombre==response[i].nombre) {
                        $('div.producto'+response[i].idproductos).show();
    
                    }
                    
                }
                
                //$( ".productos" ).hide();
                console.log(JSON.stringify(response));

              } )

              .fail  (function(response) 
              {
                 
                  
                console.log(JSON.stringify(response));
              }

            );
      
    }
    //funcion para que aparezca el form a clickear en iniciar sesion
    function formSesion(){
       // $(selector).attr(atributo, valor)
        //cambiar los valores del atributo style
        $('.form').attr('style','display:block');
       
        $('#sesion').attr('style','display:none');
        $('#registrarse').attr('style','display:none');
        $('#atras').attr('style','display:block');
        

    }

    function volverAtras(){
        $('#sesion').attr('style','display:block');
        $('#registrarse').attr('style','display:block');
        $('.form').attr('style','display:none');
        $('#atras').attr('style','display:none');
        $('.formRegistro').attr('style','display:none');


    }

    function formRegistro(){
        $('.formRegistro').attr('style','display:block');
        $('#registrarse').attr('style','display:none');
        $('#sesion').attr('style','display:none');
        $('#atras').attr('style','display:block');

        
    }

    $(document).ready(function(){
        $("select[name=categoria]").change(function(){
             
                var URLactual = window.location;
               
                if(URLactual=="http://localhost/proyectofinal/proyectoThinder/web/app_dev.php/catServ"){
            
                //$('input[name=valor1]').val($(this).val());
                //cogemose el texto de las opciones 
              
                //hacemos el ajax
                //cogemos la opcion que va a se rcomparado con id e categorias
                var categoriaSeleccionada=$('select[name=categoria]').val();

                $.ajax({
                    type: "GET",
                    url: "http://localhost/proyectofinal/proyectoThinder/web/app_dev.php/categoria/buscarProducto",
                    dataType: "json",
                    data: {categoriaSeleccionada : categoriaSeleccionada}
                }).done  (function(response) 
                      {
                         
                        //pone todos los div ocultos
                        
                        $('div[class ^= producto]').hide();
                        //busca un div en concreto cogiendo el nombre de un clase
                        for (i = 0; i < response.length; i++) { 
                             $('div.producto'+response[i].idproductos).show();
            
                            
                            
                        }
                        
                        //$( ".productos" ).hide();
                        console.log(JSON.stringify(response));
        
                      } )
        
                      .fail  (function(response) 
                      {
                        
                          
                        console.log(JSON.stringify(response));
                      }
        
                    );

                }
                else{
                    //si está en otra vista y quiere ver otra categoria redireccionamos a la página
                    var categoriaSeleccionada=$('select[name=categoria]').val();
                    window.location.href="http://localhost/proyectofinal/proyectoThinder/web/app_dev.php/catServ/"+categoriaSeleccionada;
                }

            });

            //para enviar mensaje por AJAX
            $("input[id^=enviarMensaje]").click(function(){
                 //valor del input
                 searchText = $("input#mensaje").val();
             
                //obtener los valores numéricos del string
                var oID = $(this).attr("id");
                var regex = /(\d+)/g;
                var idProducto=oID.match(regex);
                console.log(idProducto[0]);
                var objeto={};
               
               
               objeto["nombreTexto"]=searchText;
               objeto["idProducto"]=idProducto[0];
               console.log(objeto);
                

                $.ajax({
                    type: "GET",
                    url: "http://localhost/proyectofinal/proyectoThinder/web/app_dev.php/chatMensaje",
                    dataType: "json",
                    data: {objeto},
                    contentType: "application/json; charset=utf-8",
                }).done  (function(response) 
                      {
                 
                        console.log(response);
                        //eliminos todos los divs de datos-chat
                        $("#datos-chat").empty("div");
                        for (i = 0; i < response.length; i++) { 
                            $( "#datos-chat" ).append( "<div>"+
                            "<span style='color:#1c62c4'>"+response[i].nombre+"  </span>"+
                            "<span style='color:#848484'>"+response[i].mensaje+"  </span>"
                            +"</div>" );
           
                           
                           
                       }
                        	
                        
        
                      } )
        
                      .fail  (function(response) 
                      {
                          
                          
                        console.log(JSON.stringify(response));
                      }
        
                    );
               

            })   
            
            $("#nuevoUsuario").click(function(){
                $( ".container_cinco" ).hide();
                $( ".formularioNuevoUsuario" ).show();


            });

             $("#nuevaCategoria").click(function(){
                $( ".container_seis" ).hide();
                $( ".formularioNuevaCategoria" ).show();


            });

            //al hacer click al boton editar de la tabla uusarios 
     $( "button[id^=EditarU]" ).click(function() {
             
            var oID = $(this).attr("id");
            var regex = /(\d+)/g;
            var idUsuario=oID.match(regex);
           
            $.ajax({
                type: "GET",
                url: "http://localhost/proyectofinal/proyectoThinder/web/app_dev.php/crudUsuarios/idUsuario",
                dataType: "json",
                data: {idUsuario : idUsuario}
            }).done  (function(response) 
                  {
                   
                    $(".idusuarios").val(response[0].idusuarios);
                    $(".nombre").val(response[0].nombre);
                     $(".apellidos").val(response[0].apellidos);
                     $(".email").val(response[0].email);
                     $(".nick").val(response[0].nick);
                     $(".password").val(response[0].password);
                     $(".fechanc").val(response[0].fechanac);
                     $( ".formularioEdicionUsuario" ).show();
                     $( ".container_cinco" ).hide();
                   


                    
    
                  } )
    
                  .fail  (function(response) 
                  {
                   
                      
                    console.log(JSON.stringify(response));
                  }
    
                );
            

           // $( ".container_dos" ).hide();
          //  $( ".formularioEdicionPro" ).show();

            
          });


                 //al hacer click al boton editar de la tabla uusarios 
     $( "button[id^=EditarC]" ).click(function() {
            
            var oID = $(this).attr("id");
            var regex = /(\d+)/g;
            var idUsuario=oID.match(regex);
           
            $.ajax({
                type: "GET",
                url: "http://localhost/proyectofinal/proyectoThinder/web/app_dev.php/crudCategorias/idCategoria",
                dataType: "json",
                data: {idUsuario : idUsuario}
            }).done  (function(response) 
                  {
                   
                    $(".idcategoriaproductos").val(response[0].idcategoriaproductos);
                    $(".nombre").val(response[0].nombre);
                    $( ".formularioEdicionCategoria" ).show();
                    $( ".container_seis" ).hide();
                   


                    
    
                  } )
    
                  .fail  (function(response) 
                  {
                      
                      
                    console.log(JSON.stringify(response));
                  }
    
                );
            

           // $( ".container_dos" ).hide();
          //  $( ".formularioEdicionPro" ).show();

            
          });

          $( "button[id^=formBorrarU]" ).click(function() {
            
                var oID = $(this).attr("id");
                var regex = /(\d+)/g;
                var idUsuario=oID.match(regex);
                
                 //checkea al producto que le ha dado borrar
                 $("#checkboxU"+idUsuario).attr('checked', true);  
                 //$("#checkbox"+idProducto).css({"display": "block"});
                 //abre todos los checkbox
                 $("input:checkbox").each(function() {
                    $(this).css({"display": "block"});
               });
               //desaparece boton editar 
               $( "button[id^=formEditarU]" ).each(function() {
                   $(this).css({"display": "none"});

               });
               //desaparece el boton borrar
               $( "button[id^=formBorrarU]" ).each(function() {
                $(this).css({"display": "none"});

            });
               //aparece un div
               $("#borrar").css({"display": "block"});

               //ajax para coger los nombre de los productos que esta en checkbox a true
               $.ajax({
                type: "GET",
                url: "http://localhost/proyectofinal/proyectoThinder/web/app_dev.php/usuarioR/check",
                dataType: "json",
                data: {idUsuario : idUsuario}
            }).done  (function(response) 
                  {
                      
                     
                      $("#nombreC").append('<p>'+response[0].nombre+'</p>');
                     
    
                  } )
    
                  .fail  (function(response) 
                  {
                      
                      
                    console.log(JSON.stringify(response));
                  }
    
                );
            });


            $( "button[id^=formBorrarC]" ).click(function() {
                
                     
                    var oID = $(this).attr("id");
                    var regex = /(\d+)/g;
                    var idUsuario=oID.match(regex);
                    
                     //checkea al producto que le ha dado borrar
                     $("#checkboxC"+idUsuario).attr('checked', true);  
                     //$("#checkbox"+idProducto).css({"display": "block"});
                     //abre todos los checkbox
                     $("input:checkbox").each(function() {
                        $(this).css({"display": "block"});
                   });
                   //desaparece boton editar 
                   $( "button[id^=formEditarC]" ).each(function() {
                       $(this).css({"display": "none"});
    
                   });
                   //desaparece el boton borrar
                   $( "button[id^=formBorrarC]" ).each(function() {
                    $(this).css({"display": "none"});
    
                });
                   //aparece un div
                   $("#borrar").css({"display": "block"});
    
                   //ajax para coger los nombre de los productos que esta en checkbox a true
                   $.ajax({
                    type: "GET",
                    url: "http://localhost/proyectofinal/proyectoThinder/web/app_dev.php/categoriaR/check",
                    dataType: "json",
                    data: {idUsuario : idUsuario}
                }).done  (function(response) 
                      {
                        
                          $("#nombreC").append('<p>'+response[0].nombre+'</p>');
                         
        
                      } )
        
                      .fail  (function(response) 
                      {
                         
                          
                        console.log(JSON.stringify(response));
                      }
        
                    );
                });


            //al hacer click a borrar productos del div generado
            $( "#borrar_usuarios" ).click(function(){
                
                var array=[];
                var texto=$('#nombreC p').text();
                $('span').children('p').each(function(){
                    array.push($(this).text());
                });
                
                
                
                var objeto={};
               for(i=0;i<array.length;i++){
                   var nombreUsuario=array[i];
                   var producto={nombreProducto:array[i]}
                  
                objeto["nombreUsuario"+i]=array[i];
                
                
                
               }
               objetoLongitud=Object.keys(objeto).length;;
               
               objeto["longitudObjeto"]=objetoLongitud;
               console.log(objeto);

               
                   //AJAX PARA BORRAR PRODUCTOS
                    //ajax para coger los nombre de los productos que esta en checkbox a true
               $.ajax({
                type: "GET",
                url: "http://localhost/proyectofinal/proyectoThinder/web/app_dev.php/usuario1/borrar",
                dataType: "json",
                data: objeto,
                contentType: "application/json; charset=utf-8",
            }).done  (function(response) 
                  {
                    $("#borrar").css({"display": "none"});
                    location.reload();
                       
                     
                     
                     
    
                  } )
    
                  .fail  (function(response) 
                  {
                    location.reload();
                      
                      
                    console.log(JSON.stringify(response));
                  }
    
                );
                   

                   
               
              

            });

             //al hacer click a borrar productos del div generado
             $( "#borrar_categorias" ).click(function(){
                
                var array=[];
                var texto=$('#nombreC p').text();
                $('span').children('p').each(function(){
                    array.push($(this).text());
                });
                
                
                
                var objeto={};
               for(i=0;i<array.length;i++){
                   var nombreUsuario=array[i];
                   var producto={nombreProducto:array[i]}
                  
                objeto["nombreUsuario"+i]=array[i];
                
                
                
               }
               objetoLongitud=Object.keys(objeto).length;;
               
               objeto["longitudObjeto"]=objetoLongitud;
               console.log(objeto);

               
                   //AJAX PARA BORRAR PRODUCTOS
                    //ajax para coger los nombre de los productos que esta en checkbox a true
               $.ajax({
                type: "GET",
                url: "http://localhost/proyectofinal/proyectoThinder/web/app_dev.php/categoria1/borrar",
                dataType: "json",
                data: objeto,
                contentType: "application/json; charset=utf-8",
            }).done  (function(response) 
                  {
                    $("#borrar").css({"display": "none"});
                    location.reload();
                       
                     
                     
                     
    
                  } )
    
                  .fail  (function(response) 
                  {
                    location.reload();
                    
                      
                    console.log(JSON.stringify(response));
                  }
    
                );
                   

                   
               
              

            });

            $(".divPerfil").click(function(){
                $(".container_uno").show();
                $(".contenedorChat").hide();
                $("#contenedor").hide();
               
            })

    });
     

     
   
   
   
  
         
      


  