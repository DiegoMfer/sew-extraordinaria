class Rutas {
    load(){

        

        this.getXML()

        $("main").prepend("<h1> Rutas </h1>")
        
    }


    getXML(){
        $.ajax({
            url: "xml/rutas.xml",
            dataType: "xml",
            success: function(data){
                $(data).find('rutas ruta').each(function(){
                    
                    //------------------- nombre_ruta ---------------------
                    let nombre_ruta = $(this).find('nombre_ruta').text();
                    $("main").append("<section><section>")
                    $("main section:last").append("<h2> Nombre ruta: " + nombre_ruta + "</h2>");
                    //------------------- tipo_ruta ----------------------------
                    let tipo_ruta = $(this).find('tipo_ruta').text();
                    $("main section:last").append("<p> Tipo ruta: " + tipo_ruta + "</p>");
                    //------------------- transporte ----------------------------
                    let transporte = $(this).find('transporte').text();
                    $("main section:last").append("<p> Transporte: " + transporte + "</p>");
                    //------------------- fecha_inicio ----------------------------
                    let fecha_inicio = $(this).find('fecha_inicio').text();
                    $("main section:last").append("<p> Fecha inicio: " + fecha_inicio + "</p>");
                    //------------------- hora_inicio ----------------------------
                    let hora_inicio = $(this).find('hora_inicio').text();
                    $("main section:last").append("<p> Hora inicio: " + hora_inicio + "</p>");
                    //------------------- duracion ----------------------------
                    let duracion = $(this).find('duracion').text();
                    $("main section:last").append("<p> Duracion: " + duracion + "</p>");
                    //------------------- agencia ----------------------------
                    let agencia = $(this).find('agencia').text();
                    $("main section:last").append("<p> Agencia: " + agencia + "</p>");
                    //------------------- descripcion ----------------------------
                    let descripcion = $(this).find('descripcion').text();
                    $("main section:last").append("<p> Agencia: " + descripcion + "</p>");
                    //-------------------- personas_adecuadas --------------------------
                    let personas_adecuadas = $(this).find('personas_adecuadas').text();
                    $("main section:last").append("<p> Personas adecuadas: " + personas_adecuadas + "</p>");
                    //------------------- lugar_inicio ---------------------------
                    let lugar_inicio = $(this).find('lugar_inicio').text();
                    $("main section:last").append("<p> Lugar inicio: " + lugar_inicio + "</p>");
                    //------------------- direccion_inicio ---------------------------
                    let direccion_inicio = $(this).find('direccion_inicio').text();
                    $("main section:last").append("<p> Dirección inicio: " + direccion_inicio + "</p>");
                    //-------------------- coordenadas ------------------------------
                    $("main section:last").append("<p> COORDENADAS </p>");
                    //-------------------- longitud --------------------------
                    let longitud = $(this).find('coordenadas').find('longitud');
                    $("main section:last").append("<p> Longitud: " + longitud + "</p>");
                    //--------------------- latitud -------------------------
                    let latitud = $(this).find('coordenadas').find('latitud');
                    $("main section:last").append("<p> Latitud: " + latitud + "</p>");
                    //---------------------- altitud ------------------------
                    let altitud = $(this).find('coordenadas').find('altitud'); 
                    $("main section:last").append("<p> Altitud: " + altitud + "</p>");
                    //---------------------- referencias-----------------------
                    $("main section:last").append("<p> REFERENCIAS </p>");
                    $(this).find('referencias referencia').each(function(){
                        let refernecia = $(this).text();
                        $("main section:last").append("<p> Refernecia: " + refernecia + "</p>");
                    });
                    //----------------------- recomendacion ----------------------
                    let recomendacion = $(this).find('recomendacion');
                    $("main section:last").append("<p> Recomendacion: " + recomendacion + "</p>");
                    //----------------------- HITOS ----------------------
                    $("main section:last").append("<p> HITOS </p>");
                    $(this).find('hitos hito').each(function(){
                        let nombre_hito = $(this).find('nombre_hito').text();
                        $("main section:last").append("<p> Nombre hito: " + nombre_hito + "</p>");
                        let descripcion_hito = $(this).find('descripcion_hito').text();
                        $("main section:last").append("<p> Descripcion hito: " + descripcion_hito + "</p>");

                        let longitud = $(this).find('coordenadas_hito').find('longitud');
                        $("main section:last").append("<p> Longitud hito: " + longitud + "</p>");
                        //--------------------- latitud -------------------------
                        let latitud = $(this).find('coordenadas_hito').find('latitud');
                        $("main section:last").append("<p> Latitud hito: " + latitud + "</p>");
                        //---------------------- altitud ------------------------
                        let altitud = $(this).find('coordenadas_hito').find('altitud'); 
                        $("main section:last").append("<p> Altitud hito: " + altitud + "</p>");
                        //---------------------- distancia hito ----------------------
                        let distancia_hito = $(this).find('distancia_hito').attr('distancia');
                        $("main section:last").append("<p> Distancia hito: " + distancia_hito + " </p>");

                        //---------------------- galeria fotos -------------------
                        $("main section:last").append("<p> Fotos hito </p>");
                        $(this).find('galeria_fotos foto').each(function(){
                            $("main section:last").append("<p> Foto: </p>");
                            $("main section:last").append("<img src=\"multimedia/images/" + $(this).text() +"\"  alt=\" imagen de la ruta \" />");
                        });

                        //---------------------- galeria videos -------------------
                        $("main section:last").append("<p> Videos hito </p>");
                        $(this).find('galeria_videos video').each(function(){
                            $("main section:last").append("<p> Video: </p>");
                            $("main section:last").append("<img src=\"multimedia/video/" + $(this).text() +"\"  alt=\" video de la ruta \" />");
                        });

                    });
                    
                    //----------------------------------------------
                    let planimetria = $(this).find('planimetria')
                    $("main section:last").append("<p> Planimetria: " + planimetria + "</p>");
                    //----------------------------------------------
                    let altimetria = $(this).find('altimetria')
                    $("main section:last").append("<p> Altimetria: " + altimetria + "</p>");
                    //----------------------------------------------
                    
                });
            },
            error: function(){
                $(".timeline").text("Failed to get feed");
                
            }
        })
    }

}
  
var rutas = new Rutas();
  