let body = document.getElementById('body');

function start() {
    document.removeEventListener('click', start, true);

    let h = screen.height;
    let w = h * 0.5625;
    window.open('gameBoy.html', 'Game Boy', 'toolbar=no ,location=0, status=no,titlebar=no,menubar=no,width=' + w + ',height=' + h);
}

document.addEventListener('keypress', function (e) {
    // si la tecla es 's' o 'S' se inicia el juego
    if (e.key === 's' || e.key === 'S') {
        body.innerHTML += '<h1>OLEEEEEEEEEEEEEEEEEEEEEEEE</h1>';
        setTimeout(function () {
            start();
        }, 1500);
    } else if (e.key === 'n' || e.key === 'N') {
        body.innerHTML += '<h1>Eres un desagradecido.</h1>';
        setTimeout(function () {
            window.close();
        }, 1500);
    } else {
        alert('No te entiendo ://');
    }
});