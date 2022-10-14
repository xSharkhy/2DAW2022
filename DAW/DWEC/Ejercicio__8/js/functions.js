function ejercicio31(n = prompt("Introduce un número ( n > 0 ): ")) {
    n % 2 == 0 ? alert("El número es par") : alert("El número es impar");
}


function ejercicio32(string = prompt("Introduce una cadena de texto: ")) {
    string === String(string).toUpperCase() ? alert("La cadena está formada por mayúsculas")
    : string === String(string).toLowerCase() ? alert("La cadena está formada por minúsculas")
    : alert("La cadena está formada por mayúsculas y minúsculas");
}

function ejercicio33(string = prompt("Introduce una cadena de texto: ")) {
    string = string.toLowerCase();
    string = string.trim();
    let length = string.length;
    for (let i = 0; i < length / 2; i++)
        if (string[i] !== string[length - 1 - i])
            return alert("La cadena no es un palíndromo");
    alert("La cadena es un palíndromo");
}
