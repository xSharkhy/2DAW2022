function objetoNavigator(){
    let modal = document.getElementById("navigatorModal");
    let btn = document.getElementById("navigator");
    let close = document.getElementsByClassName("close")[0];
    modal.style.display = "block";
    
    close.onclick = function () {
        modal.style.display = "none";
    }
    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
}

function objetoScreen(){
    let modal = document.getElementById("screenModal");
    let btn = document.getElementById("screen");
    let close = document.getElementsByClassName("close")[1];
    modal.style.display = "block";
    close.onclick = function () {
        modal.style.display = "none";
    }
    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
}

function objetoWindow(){
    let modal = document.getElementById("windowModal");
    let btn = document.getElementById("window");
    let close = document.getElementsByClassName("close")[2];
    modal.style.display = "block";

    close.onclick = function () {
        modal.style.display = "none";
    }
    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
}

function objetoHistory(){
    let modal = document.getElementById("historyModal");
    let btn = document.getElementById("history");
    let close = document.getElementsByClassName("close")[3];
    modal.style.display = "block";
    
    close.onclick = function () {
        modal.style.display = "none";
    }
    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
}

function objetoDocument(){
    let modal = document.getElementById("documentModal");
    let btn = document.getElementById("document");
    let close = document.getElementsByClassName("close")[4];
    modal.style.display = "block";
    
    close.onclick = function () {
        modal.style.display = "none";
    }
    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
}

function objetoLocation(){
    let modal = document.getElementById("locationModal");
    let btn = document.getElementById("location");
    let close = document.getElementsByClassName("close")[5];
    modal.style.display = "block";
    
    close.onclick = function () {
        modal.style.display = "none";
    }
    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
}