function checkConnection() {
    let check = document.getElementById("connection");
    
    if (navigator.onLine) {
        check.innerHTML = "Conectado";
        check.style.color = "green";
    } else {
        check.innerHTML = "Desconectado";
        check.style.color = "red";
    }
}

function getResolution() {
    let resolution = document.getElementById("resolution");

    if (screen.width >= 1920) resolution.innerHTML = "4K" + " (" + screen.width + "x" + screen.height + ")";
    else if (screen.width >= 1280) resolution.innerHTML = "Full HD" + " (" + screen.width + "x" + screen.height + ")";
    else if (screen.width >= 720) resolution.innerHTML = "HD" + " (" + screen.width + "x" + screen.height + ")";
    else resolution.innerHTML = "SD" + " (" + screen.width + "x" + screen.height + ")";
}

function openWindow() {
    window.open("https://www.google.com", "Google", "width=500,height=500");
}

function closeWindow() {
    window.close();
}

function holamundo() {
    document.getElementById("holamundo").innerHTML = "Hola Mundo";
}

function locationEjemplo() {
    document.getElementById("locationEjemplo").innerHTML = "La URL de la página es: " + location.href;    
}