class Rutas {
    load(){

        $("main").append("<h1> Rutas </h1>")
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
                    let nombre_ruta = $(this).find('nombre_ruta').text();
                    $("main li:last").append("<p> Nombre ruta: " + nombre_ruta + "</p>");
                    //------------------- tipo_ruta ----------------------------
                    let tipo_ruta = $(this).find('tipo_ruta').text();
                    $("main li:last").append("<p> Tipo ruta: " + tipo_ruta + "</p>");
                    //------------------- transporte ----------------------------
                    let transporte = $(this).find('transporte').text();
                    $("main li:last").append("<p> Transporte: " + transporte + "</p>");
                    //------------------- fecha_inicio ----------------------------
                    let fecha_inicio = $(this).find('fecha_inicio').text();
                    $("main li:last").append("<p> Fecha inicio: " + fecha_inicio + "</p>");
                    //------------------- hora_inicio ----------------------------
                    let hora_inicio = $(this).find('hora_inicio').text();
                    $("main li:last").append("<p> Hora inicio: " + hora_inicio + "</p>");
                    //------------------- duracion ----------------------------
                    let duracion = $(this).find('duracion').text();
                    $("main li:last").append("<p> Duracion: " + duracion + "</p>");
                    //------------------- agencia ----------------------------
                    let agencia = $(this).find('agencia').text();
                    $("main li:last").append("<p> Agencia: " + agencia + "</p>");
                    //------------------- descripcion ----------------------------
                    let descripcion = $(this).find('descripcion').text();
                    $("main li:last").append("<p> Agencia: " + descripcion + "</p>");
                    //-------------------- personas_adecuadas --------------------------
                    let personas_adecuadas = $(this).find('personas_adecuadas').text();
                    $("main li:last").append("<p> Personas adecuadas: " + personas_adecuadas + "</p>");
                    //------------------- lugar_inicio ---------------------------
                    let lugar_inicio = $(this).find('lugar_inicio').text();
                    $("main li:last").append("<p> Lugar inicio: " + lugar_inicio + "</p>");
                    //------------------- direccion_inicio ---------------------------
                    let direccion_inicio = $(this).find('direccion_inicio').text();
                    //-------------------- longitud --------------------------
                    let longitud = $(this).find('coordenadas').find('longitud');
                    //--------------------- latitud -------------------------
                    let latitud = $(this).find('coordenadas').find('latitud');
                    //---------------------- altitud ------------------------
                    let altitud = $(this).find('coordenadas').find('altitud'); 
                    //---------------------- referencias-----------------------
                    let referencias = $(this).find('referencias referencia').each(function(){

                    });
                    //----------------------------------------------
                    let recomendacion = $(this).find('recomendacion');
                    //----------------------------------------------
                    let hitos = $(this).find('hitos');
                    //----------------------------------------------
                    let planimetria = $(this).find('planimetria');
                    //----------------------------------------------
                    let altimetria = $(this).find('altimetria');
                    //----------------------------------------------



                    

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
  