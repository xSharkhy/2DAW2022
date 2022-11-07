function concatenar1() {
    let arrayA = document.getElementById("n1ex1").value.split(",");
    let arrayB = document.getElementById("n2ex1").value.split(",");
    let arrayC = [];
    document.getElementById("res1").innerHTML += "Array final: ";

    for (let i = 0; i < arrayA.length; i++) {
        arrayC.push(arrayA[i]);
        arrayC.push(arrayB[i]);
	}
    
    document.getElementById("res1").innerHTML += arrayC.toString();
}

function reiniciar() {
    document.getElementById("n1ex1").value = "";
    document.getElementById("n2ex1").value = "";
    document.getElementById("res1").innerHTML = "";
}

function concatenar2() {
    let arrayA = document.getElementById("n1ex2").value.split(",");
    let arrayB = document.getElementById("n2ex2").value.split(",");
    let arrayC = [];
    let longA = document.getElementById("numeric1").value;
    let longB = document.getElementById("numeric2").value;
    const constantes = [
		arrayA.length < arrayB.length ? arrayA.length : arrayB.length,
        arrayA.length > arrayB.length,
	];

    if (longA != arrayA.length || longB != arrayB.length) {
        document.getElementById("res2").innerHTML = "Los arrays no tienen la longitud especificada";
    }

    document.getElementById("res2").innerHTML += "Array final: ";

    for (let i = 0; i < constantes[0]; i++) {
        arrayC.push(arrayA[i]);
        arrayC.push(arrayB[i]);
    }

    if (constantes[1])
        document.getElementById("res2").innerHTML += arrayC.toString() + "," + arrayA.slice(constantes[0]).toString();
    else
        document.getElementById("res2").innerHTML += arrayC.toString() + "," + arrayB.slice(constantes[0]).toString();
}

function insertar() {
    let array = document.getElementById("n1ex3").value.split(",");
    let valor = document.getElementById("value").value;
    let posicion = document.getElementById("position").value;

    if (posicion > array.length) {
        document.getElementById("res3").innerHTML = "La posición especificada no existe";
    } else {
        array.splice(posicion, 0, valor);
        document.getElementById("res3").innerHTML = "Array final: " + array.toString();
    }
}

function tratamientoCadena() {
    let cadena = document.getElementById("n1ex4").value;
    let array = cadena.split(" ");
    let resultado = [
        'número de palabras: ' + array.length,
        'primera palabra: ' + array[0],
        'última palabra: ' + array[array.length - 1],
        'cadenas al revés: ' + array.reverse().toString(),
        'palabras ordenadas alfabéticamente: ' + array.sort().toString(),
        'palabras ordenadas a la inversa: ' + array.sort().reverse().toString(),
    ]

    document.getElementById("res4").innerHTML = resultado.join("<br>");

}