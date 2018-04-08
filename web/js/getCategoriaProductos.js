
   //funcion parabuscar un producto
    function buscarProducto() {
        
        //valor del input
        searchText = $("input#buscar").val();
        var nuevaCadena =  searchText.trim();
       
        //alert(nuevaCadena); 

        $.ajax({
            type: "GET",
            url: "http://localhost/proyectofinal/proyectoThinder/web/app_dev.php/producto/buscarProducto",
            dataType: "json",
            data: {nuevaCadena : nuevaCadena},
            success : function(response) 
              {
                  alert("entra");
                console.log(JSON.stringify(response));
              }
     
      });
    }
    //alert(nombreEmpresa); 
   /**
    * Archivo donde cogiendo el id del select vamos añadir las categorias de productos
    
    $.ajax({ 
        type: 'GET', 
        url: 'http://localhost/proyectofinal/proyectoThinder/web/app_dev.php/categoriaProductos',
        dataType: "json",
        success: function (response) { 
           
            var x = document.getElementById("categorias");
            for(var i=0;i<response.length;i++){
            var option = document.createElement("option");
            option.text = response[i].nombre;
            x.add(option);
            }

        }
        */
   
   
  
         
      


  