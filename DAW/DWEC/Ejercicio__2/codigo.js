var nombre = prompt("Introduce tu nombre");
var apellido = prompt("Introduce tu apellido");
var fullName = nombre + " " + apellido;
var edad = parseInt(prompt("Introduce tu edad"));
var year = 2022 - edad;

document.write(" - Nombre completo: " + fullName + "<br>");
document.write(" - Año de nacimiento: " + year);
