class Juego {

    calcular(){
        var resultado = 0;
        var checkedInputs = $('input[type="radio"]:checked');
        checkedInputs.each(function() {
            if($(this).val() == 'true'){
                resultado = resultado +1;
            }
        });

        alert("El resultado del juego en nota en base 10 es: " + resultado)
       
    }
}

var juego = new Juego();