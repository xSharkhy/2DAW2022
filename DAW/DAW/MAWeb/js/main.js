function objetoP2P(){
    let modal = document.getElementById("p2pModal");
    let btn = document.getElementById("p2p");
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

function objetoClienteServidor(){
    let modal = document.getElementById("clienteServidorModal");
    let btn = document.getElementById("clienteServidor");
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

function objetoAppServer() {
	let modal = document.getElementById("appServerModal");
	let btn = document.getElementById("appServer");
	let close = document.getElementsByClassName("close")[2];
	modal.style.display = "block";

	close.onclick = function () {
		modal.style.display = "none";
	};
	window.onclick = function (event) {
		if (event.target == modal) {
			modal.style.display = "none";
		}
	};
}

function objetoExtAppServer() {
	let modal = document.getElementById("extAppServerModal");
	let btn = document.getElementById("extAppServer");
	let close = document.getElementsByClassName("close")[3];
	modal.style.display = "block";

	close.onclick = function () {
		modal.style.display = "none";
	};
	window.onclick = function (event) {
		if (event.target == modal) {
			modal.style.display = "none";
		}
	};
}

function objetoMultAppServer() {
	let modal = document.getElementById("multAppServerModal");
	let btn = document.getElementById("multAppServer");
	let close = document.getElementsByClassName("close")[4];
	modal.style.display = "block";

	close.onclick = function () {
		modal.style.display = "none";
	};
	window.onclick = function (event) {
		if (event.target == modal) {
			modal.style.display = "none";
		}
	};
}