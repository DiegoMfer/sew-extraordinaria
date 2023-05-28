class Index {

    constructor(){
        this.carrusel = ['caravia.jpg','caravia2.jpg','caravia3.jpg','caravia4.jpg','caravia5.jpg']
        this.carpeta = 'multimedia/images/'
        this.textoImagen = 'Imagen de Caravia'
        this.index = 0
        this.key = "c4ed265dd950cde9fc4d2b46bf0ee682";
    }

    anterior(){
        this.index -= 1;
        if(this.index == -1){
            this.index = 4;
        }
        $('img[name="carrusel"]').attr("src","multimedia/images/" + this.carrusel[this.index]);
    }

    siguiente(){
        this.index += 1;
        if(this.index >= 5){
            this.index = 0;
        }
        $('img[name="carrusel"]').attr("src","multimedia/images/" + this.carrusel[this.index]);
    }

    cargarNoticias(){
      
        var settings = {
            "url": "https://api.newscatcherapi.com/v2/search?q=Caravia",
            "method": "GET",
            "timeout": 0,
            "headers": {
              "x-api-key": "50Wka5hGVBCRFIwndVaLoCzV479JbJ2w77RDCiQ_2i4"
            },
          };
          
          $.ajax(settings).done(function (response) {
            console.log(response);
            var datos = "<p> Título: " + response["articles"][0]["title"] + "</p>"
            datos += "<p> Resumen: " + response["articles"][0]["summary"] + "</p>"
            datos += "<p> ------------------------------------------------ </p>"
            datos += "<p> Título: " + response["articles"][1]["title"] + "</p>"
            datos += "<p> Resumen: " + response["articles"][1]["summary"] + "</p>"

            $("main section:eq(2)").append(datos)
            $("main section:eq(2) button").attr("disabled","disabled");
          });
    }
    
    cargarDatosMeteorológicos() {

        var settings = {
          dataType:"json",
          url:
            "http://api.openweathermap.org/data/2.5/weather?q=" +
            "Caravia" +
            ",ES&units=metric&lang=es&APPID=" +
            this.key,
          method: "GET",
          timeout: 0,
        };
    
    
        $.ajax(settings).done(function (datos) {
            var meteo = ("<p>Datos de Caravia</p>")
             meteo +=("<p>País: " +  datos.sys.country + "</p>");
             meteo +=("<p>Latitud: " +  datos.coord.lat + " grados</p>");
             meteo +=("<p>Longitud: " +  datos.coord.lon + " grados</p>");
             meteo +=("<p>Temperatura: " +  datos.main.temp + " grados Celsius</p>");
             meteo +=("<p>Temperatura máxima: " +  datos.main.temp_max + " grados Celsius</p>");
             meteo +=("<p>Temperatura mínima: " +  datos.main.temp_min + " grados Celsius</p>");
             meteo +=("<p>Presión: " +  datos.main.pressure + " milímetros</p>");
             meteo +=("<p>Humedad: " +  datos.main.humidity + "%</p>"); 
             meteo +=("<p>Amanece a las: " + new Date( datos.sys.sunrise *1000).toLocaleTimeString() + "</p>"); 
             meteo +=("<p>Oscurece a las: " + new Date( datos.sys.sunset *1000).toLocaleTimeString() + "</p>"); 
             meteo +=("<p>Dirección del viento: " +  datos.wind.deg + "  grados</p>");
             meteo +=("<p>Velocidad del viento: " +  datos.wind.speed + " metros/segundo</p>");
             meteo +=("<p>Hora de la medida: " + new Date( datos.dt *1000).toLocaleTimeString() + "</p>");
             meteo +=("<p>Fecha de la medida: " + new Date( datos.dt *1000).toLocaleDateString() + "</p>");
             meteo +=("<p>Descripción: " +  datos.weather[0].description + "</p>");
             meteo +=("<p>Visibilidad: " +  datos.visibility + " metros</p>");
             meteo +=("<p>Nubosidad: " +  datos.clouds.all + " %</p>");
    
             $("main section:eq(1)").append(meteo)
             $("main section:eq(1) button").attr("disabled","disabled");
            
        });   
    }

    ultimaVezActualizado(){
      $("main section:eq(5)").append("<p>"+ document.lastModified+"</p>")
      console.log("aaa")
    }


}

class MapaDinamicoGoogle {
  initMap(){  
      var centro = {lat: 43.4676, lng: -5.19014};
      var mapaGeoposicionado = new google.maps.Map(document.getElementsByName('map')[0],{
          zoom: 14,
          center:centro,
          mapTypeId: google.maps.MapTypeId.ROADMAP
      });
      
      

      $("main section:eq(4)").append("<p>Esto es para hacer que el mapa sea más grande</p>")
      $("main section:eq(4)").append("<p>Esto es para hacer que el mapa sea más grande</p>")
      $("main section:eq(4)").append("<p>Esto es para hacer que el mapa sea más grande</p>")
      $("main section:eq(4)").append("<p>Esto es para hacer que el mapa sea más grande</p>")
      $("main section:eq(4)").append("<p>Esto es para hacer que el mapa sea más grande</p>")
  }

  handleLocationError(browserHasGeolocation, infoWindow, pos) {
      infoWindow.setPosition(pos);
      infoWindow.setContent(browserHasGeolocation ?
                            'Error: Ha fallado la geolocalización' :
                            'Error: Su navegador no soporta geolocalización');
      infoWindow.open(mapaGeoposicionado);
  }
}

var mapaDinamicoGoogle = new MapaDinamicoGoogle();
var index = new Index();