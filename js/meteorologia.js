class Meteorologia{
    constructor(){
       
    }

    cargarTiempo(){
        var settings = {
            "url": "https://api.weatherapi.com/v1/forecast.json?key=da5b7116f0c74a14a2c150310232805&q=Caravia&days=7&aqi=no&alerts=no",
            "method": "GET",
            "timeout": 0,
          };
          
          $.ajax(settings).done(function (response) {
            for (let i = 0; i < 7; i++) {
                $("main section").append("<h3>" + response["forecast"]["forecastday"][i]["date"] + "</h3>" )
                $("main section").append("<p> Predicción: " + response["forecast"]["forecastday"][i]["day"]["condition"]["text"] + "</p>" )
            }
            $("main section button").attr("disabled","disabled");
          });
    }
}

var meteo = new Meteorologia();