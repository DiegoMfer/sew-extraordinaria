class Rutas {
  load() {
    this.getXML();
    $("main").prepend("<h1> Rutas </h1>");
  }

  getXML() {
    $.ajax({
      url: "xml/rutas.xml",
      dataType: "xml",
      success: function (data) {
        $(data)
          .find("rutas ruta")
          .each(function () {
            //------------------- nombre_ruta ---------------------
            let nombre_ruta = $(this).find("nombre_ruta").text();
            $("main").append("<section>");
            $("main section:last").append(
              "<h2> Nombre ruta: " + nombre_ruta + "</h2>"
            );
            //------------------- tipo_ruta ----------------------------
            let tipo_ruta = $(this).find("tipo_ruta").text();
            $("main section:last").append(
              "<p> Tipo ruta: " + tipo_ruta + "</p>"
            );
            //------------------- transporte ----------------------------
            let transporte = $(this).find("transporte").text();
            $("main section:last").append(
              "<p> Transporte: " + transporte + "</p>"
            );
            //------------------- fecha_inicio ----------------------------
            let fecha_inicio = $(this).find("fecha_inicio").text();
            $("main section:last").append(
              "<p> Fecha inicio: " + fecha_inicio + "</p>"
            );
            //------------------- hora_inicio ----------------------------
            let hora_inicio = $(this).find("hora_inicio").text();
            $("main section:last").append(
              "<p> Hora inicio: " + hora_inicio + "</p>"
            );
            //------------------- duracion ----------------------------
            let duracion = $(this).find("duracion").text();
            $("main section:last").append("<p> Duracion: " + duracion + "</p>");
            //------------------- agencia ----------------------------
            let agencia = $(this).find("agencia").text();
            $("main section:last").append("<p> Agencia: " + agencia + "</p>");
            //------------------- descripcion ----------------------------
            let descripcion = $(this).find("descripcion").text();
            $("main section:last").append(
              "<p> Agencia: " + descripcion + "</p>"
            );
            //-------------------- personas_adecuadas --------------------------
            let personas_adecuadas = $(this).find("personas_adecuadas").text();
            $("main section:last").append(
              "<p> Personas adecuadas: " + personas_adecuadas + "</p>"
            );
            //------------------- lugar_inicio ---------------------------
            let lugar_inicio = $(this).find("lugar_inicio").text();
            $("main section:last").append(
              "<p> Lugar inicio: " + lugar_inicio + "</p>"
            );
            //------------------- direccion_inicio ---------------------------
            let direccion_inicio = $(this).find("direccion_inicio").text();
            $("main section:last").append(
              "<p> Dirección inicio: " + direccion_inicio + "</p>"
            );
            //-------------------- coordenadas ------------------------------
            $("main section:last").append("<p> COORDENADAS </p>");
            //-------------------- longitud --------------------------
            let longitud = $(this).find("coordenadas").find("longitud");
            $("main section:last").append("<p> Longitud: " + longitud + "</p>");
            //--------------------- latitud -------------------------
            let latitud = $(this).find("coordenadas").find("latitud");
            $("main section:last").append("<p> Latitud: " + latitud + "</p>");
            //---------------------- altitud ------------------------
            let altitud = $(this).find("coordenadas").find("altitud");
            $("main section:last").append("<p> Altitud: " + altitud + "</p>");
            //---------------------- referencias-----------------------
            $("main section:last").append("<p> REFERENCIAS </p>");
            $(this)
              .find("referencias referencia")
              .each(function () {
                let refernecia = $(this).text();
                $("main section:last").append(
                  "<p> Refernecia: " + refernecia + "</p>"
                );
              });
            //----------------------- recomendacion ----------------------
            let recomendacion = $(this).find("recomendacion");
            $("main section:last").append(
              "<p> Recomendacion: " + recomendacion + "</p>"
            );
            //----------------------- HITOS ----------------------
            $("main section:last").append("<p> HITOS </p>");
            $(this)
              .find("hitos hito")
              .each(function () {
                let nombre_hito = $(this).find("nombre_hito").text();
                $("main section:last").append(
                  "<p> Nombre hito: " + nombre_hito + "</p>"
                );
                let descripcion_hito = $(this).find("descripcion_hito").text();
                $("main section:last").append(
                  "<p> Descripcion hito: " + descripcion_hito + "</p>"
                );

                let longitud = $(this)
                  .find("coordenadas_hito")
                  .find("longitud");
                $("main section:last").append(
                  "<p> Longitud hito: " + longitud + "</p>"
                );
                //--------------------- latitud -------------------------
                let latitud = $(this).find("coordenadas_hito").find("latitud");
                $("main section:last").append(
                  "<p> Latitud hito: " + latitud + "</p>"
                );
                //---------------------- altitud ------------------------
                let altitud = $(this).find("coordenadas_hito").find("altitud");
                $("main section:last").append(
                  "<p> Altitud hito: " + altitud + "</p>"
                );
                //---------------------- distancia hito ----------------------
                let distancia_hito = $(this)
                  .find("distancia_hito")
                  .attr("distancia");
                $("main section:last").append(
                  "<p> Distancia hito: " + distancia_hito + " </p>"
                );

                //---------------------- galeria fotos -------------------
                $("main section:last").append("<p> Fotos hito </p>");
                $(this)
                  .find("galeria_fotos foto")
                  .each(function () {
                    $("main section:last").append("<p> Foto: </p>");
                    $("main section:last").append(
                      '<img src="multimedia/images/' +
                        $(this).text() +
                        '"  alt=" imagen de la ruta " />'
                    );
                  });

                //---------------------- galeria videos -------------------
                $("main section:last").append("<p> Videos hito </p>");
                $(this)
                  .find("galeria_videos video")
                  .each(function () {
                    $("main section:last").append("<p> Video: </p>");
                    $("main section:last").append(
                      '<img src="multimedia/video/' +
                        $(this).text() +
                        '"  alt=" video de la ruta " />'
                    );
                  });
              });

            //----------------------------------------------
            let planimetria = $(this).find("planimetria");
            $("main section:last").append(
              "<p> Planimetria: " + planimetria + "</p>"
            );
            //----------------------------------------------
            let altimetria = $(this).find("altimetria");
            $("main section:last").append(
              "<p> Altimetria: " + altimetria + "</p>"
            );
            //----------------------------------------------
          });
      },
      error: function () {
        $(".timeline").text("Failed to get feed");
      },
    });
  }

  generateKML() {
    // Cargar el XML
    $.ajax({
      url: "xml/rutas.xml",
      dataType: "xml",
      success: function (xml) {
        // Crear el documento KML
        var kmlDoc = document.implementation.createDocument("", "kml", null);
        var kmlElement = kmlDoc.documentElement;

        // Agregar la declaración XML al principio del KML
        var declaration = kmlDoc.createProcessingInstruction(
          "xml",
          'version="1.0" encoding="UTF-8"'
        );
        kmlDoc.insertBefore(declaration, kmlElement);

        // Recorrer las rutas
        $(xml)
          .find("ruta")
          .each(function () {
            // Crear el elemento Placemark
            var placemarkElement = kmlDoc.createElement("Placemark");

            // Obtener el nombre de la ruta y crear el elemento name
            var nombreRuta = $(this).find("nombre_ruta").text();
            var nameElement = kmlDoc.createElement("name");
            nameElement.appendChild(kmlDoc.createTextNode(nombreRuta));
            placemarkElement.appendChild(nameElement);

            // Crear el elemento LineString
            var lineStringElement = kmlDoc.createElement("LineString");

            // Crear los elementos extrude y tessellate
            var extrudeElement = kmlDoc.createElement("extrude");
            extrudeElement.appendChild(kmlDoc.createTextNode("1"));
            lineStringElement.appendChild(extrudeElement);

            var tessellateElement = kmlDoc.createElement("tessellate");
            tessellateElement.appendChild(kmlDoc.createTextNode("1"));
            lineStringElement.appendChild(tessellateElement);

            // Crear el elemento coordinates
            var coordinatesElement = kmlDoc.createElement("coordinates");

            // Obtener las coordenadas de los hitos de la ruta
            var hitos = $(this).find("hito");
            hitos.each(function () {
              var longitud = $(this).find("longitud").text();
              var latitud = $(this).find("latitud").text();
              var altitud = $(this).find("altitud").text();

              // Agregar las coordenadas al elemento coordinates
              var coordinateText =
                longitud + "," + latitud + "," + altitud + "\n";
              coordinatesElement.appendChild(
                kmlDoc.createTextNode(coordinateText)
              );
            });

            lineStringElement.appendChild(coordinatesElement);
            placemarkElement.appendChild(lineStringElement);
            kmlElement.appendChild(placemarkElement);
          });

        // Generar el contenido KML
        var serializer = new XMLSerializer();
        var kmlString = serializer.serializeToString(kmlDoc);

        // Descargar el archivo KML
        var link = document.createElement("a");
        link.setAttribute(
          "href",
          "data:text/xml;charset=utf-8," + encodeURIComponent(kmlString)
        );
        link.setAttribute("download", "rutas.kml");
        link.style.display = "none";
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
      },
    });
  }

  generateSVG() {
    $(document).ready(function () {
      parseXMLToSVG("xml/rutas.xml", "#svg-container");
    });

    $(document).ready(function () {
      parseXMLToSVG("xml/rutas.xml", "#svg-container", "tree.svg");
    });
  }

  parseXMLToSVG(xmlFile, svgContainer, downloadFileName) {
    $.ajax({
      type: "GET",
      url: xmlFile,
      dataType: "xml",
      success: function (xml) {
        var $svg = $(svgContainer);
        $svg.empty();

        function createNode(element, x, y, level) {
          var $g = $("<g>");
          var $text = $("<text>")
            .attr("x", x)
            .attr("y", y)
            .text(element.tagName);

          $g.append($text);

          var children = $(element).children();
          if (children.length > 0) {
            var startX = x - 100;
            var startY = y + 50;

            for (var i = 0; i < children.length; i++) {
              var child = children[i];
              var childX = startX + i * 200;
              var childY = startY + level * 100;

              var $line = $("<line>")
                .attr("x1", x)
                .attr("y1", y)
                .attr("x2", childX)
                .attr("y2", childY);

              $g.append($line);
              $g.append(createNode(child, childX, childY, level + 1));
            }
          }

          return $g;
        }

        var root = $(xml).children().first();
        $svg.append(createNode(root[0], 400, 50, 1));

        var svgString = $svg.prop("outerHTML");
        var link = document.createElement("a");
        link.setAttribute(
          "href",
          "data:image/svg+xml;charset=utf-8," + encodeURIComponent(svgString)
        );
        link.setAttribute("download", downloadFileName);
        link.style.display = "none";
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
      },
      error: function () {
        console.log("Failed to load XML file.");
      },
    });
  }
}

var rutas = new Rutas();
