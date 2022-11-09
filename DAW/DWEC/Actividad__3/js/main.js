//Función que se encarga de reiniciar el ejercico 1 
function reiniciar() {
    document.getElementById("n1ex1").value = "";
    document.getElementById("n2ex1").value = "";
    document.getElementById("res1").innerHTML = "";
}

//Función que se encarga de concatenar dos arrays del mismo tamaño
function concatenar1() {
    //Se obtienen los arrays
	let arrayA = document.getElementById("n1ex1").value.split(",");
	let arrayB = document.getElementById("n2ex1").value.split(",");
	let arrayC = [];
	document.getElementById("res1").innerHTML += "Array final: ";

    //Se concatenan
	for (let i = 0; i < arrayA.length; i++) {
		arrayC.push(arrayA[i]);
		arrayC.push(arrayB[i]);
	}

	document.getElementById("res1").innerHTML += arrayC.toString();
}

//Función que concatena dos arrays de diferentes tamaños
function concatenar2() {
    //Se obtienen los valores de los inputs
    let arrayA = document.getElementById("n1ex2").value.split(",");
    let arrayB = document.getElementById("n2ex2").value.split(",");
    let arrayC = [];

    //Se obtienen las supuestas longitudes de los arrays
    let longA = document.getElementById("numeric1").value;
    let longB = document.getElementById("numeric2").value;

    //Si las longitudes no coinciden con el tamaño de los arrays, se muestra un mensaje de error
    if (longA != arrayA.length || longB != arrayB.length) {
        document.getElementById("res2").innerHTML = "Los arrays no tienen la longitud especificada";
    } else {
        //En caso contrario, se concatenan los arrays

        //Se crea un array que almacena en la posición 0 la longitud del array más largo
        //y en la posición 1 un boolean que indica si el ArrayA es más largo que el ArrayB
        const constantes = [
            arrayA.length < arrayB.length ? arrayA.length : arrayB.length,
            arrayA.length > arrayB.length,
        ];
        
        //Finalmente se concatenan los arrays y se muestra el resultado
        document.getElementById("res2").innerHTML += "Array final: ";

        for (let i = 0; i < constantes[0]; i++) {
            arrayC.push(arrayA[i]);
            arrayC.push(arrayB[i]);
        }

        //Los elementos restantes del array más largo los concatena al final
        if (constantes[1])
            document.getElementById("res2").innerHTML +=
                arrayC.toString() + "," + arrayA.slice(constantes[0]).toString();
        else
            document.getElementById("res2").innerHTML +=
                arrayC.toString() + "," + arrayB.slice(constantes[0]).toString();
    }
}

//Función que añade un valor a una posición de un array introducido por el usuario
function insertar() {
    let array = document.getElementById("n1ex3").value.split(",");
    let valor = document.getElementById("value").value;
    let posicion = document.getElementById("position").value;

    //En caso de que no exista la posición dará un error
    if (posicion > array.length) {
        document.getElementById("res3").innerHTML = "La posición especificada no existe";
    } else {
        array.splice(posicion, 0, valor);
        document.getElementById("res3").innerHTML = "Array final: " + array.toString();
    }
}

//Función que realiza diferentes acciones con una cadena introducida por el usuario
function tratamientoCadena() {
    //Se obtiene la cadena introducida por el usuario y se trata
    let cadena = document.getElementById("n1ex4").value;
    let array = cadena.split(" ");

    let resultado = [
        'número de palabras: ' + array.length,
        'primera palabra: ' + array[0],
        'última palabra: ' + array.at(-1),
        'cadenas al revés: ' + array.reverse().toString(),
        'palabras ordenadas alfabéticamente: ' + array.sort().toString(),
        'palabras ordenadas a la inversa: ' + array.sort().reverse().toString(),
    ];

    //Se muestran los resultados en una nueva ventana
    let win = window.open("", "Tratamiento de cadenas", "width=400,height=400");

    win.document.write(resultado.join("<br>"));

}