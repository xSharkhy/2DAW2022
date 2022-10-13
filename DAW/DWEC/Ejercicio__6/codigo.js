let letra = ['T', 'R', 'W', 'A', 'G', 'M', 'Y', 'F', 'P', 'D', 'X', 'B', 'N', 'J', 'Z', 'S', 'Q', 'V', 'H', 'L', 'C', 'K', 'E'];

let dni = prompt('Introduce tu DNI');
let numero = dni.substring(0, dni.length - 1);

if (numero.length < 7 || numero.length > 8) {
    alert('El DNI introducido no es válido');
} else {
    let letraDNI = dni.substring(dni.length - 1, dni.length);
    let letraCalculada = letra[numero % 23];

    if (letraDNI.toUpperCase() == letraCalculada) {
        alert('DNI correcto');
    } else {
        alert('DNI incorrecto');
    }
}
