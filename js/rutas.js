class Rutas {
    load(){

        $("main").append("<h1> Rutas <h1>")
        $("main").append("<ul>") //Comienzo de la lista

        this.getXML()

        $("main").append("</ul>") //Final de la lista
        
    }


    getXML(){
        $.ajax({
            url: "xml/rutas.xml",
            dataType: "xml",
            success: function(data){
                $(data).find('rutas ruta').each(function(){

                    $("main").append("<li>") //principio de la ruta

                    //------------------- nombre_ruta ---------------------
                    $("main").append("<p>")
                    let nombre_ruta = $(this).find('nombre_ruta').text();
                    $("main").append("Nombre ruta: " + nombre_ruta);
                    $("main").append("</p>")
                    //------------------- tipo_ruta ----------------------------
                    let tipo_ruta = $(this).find('tipo_ruta').text();
                    //------------------- transporte ----------------------------
                    let transporte = $(this).find('transporte').text();
                    //------------------- fecha_inicio ----------------------------
                    let fecha_inicio = $(this).find('fecha_inicio').text();
                    //------------------- hora_inicio ----------------------------
                    let hora_inicio = $(this).find('hora_inicio').text();
                    //------------------- duracion ----------------------------
                    let duracion = $(this).find('duracion').text();
                    //------------------- agencia ----------------------------
                    let agencia = $(this).find('agencia').text();
                    //------------------- descripcion ----------------------------
                    let descripcion = $(this).find('descripcion').text();
                    //----------------------------------------------
                    let personas_adecuadas = $(this).find('personas_adecuadas').text();
                    //----------------------------------------------
                    let lugar_inicio = $(this).find('lugar_inicio').text();
                    //----------------------------------------------
                    let direccion_inicio = $(this).find('direccion_inicio').text();
                    //----------------------------------------------
                    let longitud = $(this).find('coordenadas').find('longitud');
                    //----------------------------------------------
                    let latitud = $(this).find('coordenadas').find('latitud');
                    //----------------------------------------------
                    let altitud = $(this).find('coordenadas').find('altitud'); 
                    //----------------------------------------------
                    let referencias = $(this).find('referencias referencia').each(function(){

                    });



                    

                    $("main").append("</li>") //final de la ruta
                });
            },
            error: function(){
                $(".timeline").text("Failed to get feed");
            }
        })
    }

}
  
var rutas = new Rutas();
  