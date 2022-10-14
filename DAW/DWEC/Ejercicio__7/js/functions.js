function ejercicio1() {
    let array = [];

    for (let i = 0; i < 5; i++) array[i] = prompt("Introduce un número");

    let text = "Multiplicamos por 3 los números introducidos:\n"

    for (const key in array) text += array[key] + " * 3 = " + (array[key] * 3) + "\n"

    alert(text);
}

function ejercicio2() {
    let num = 0;

    for (let i = 0; i < 100; i++) i % 2 == 1 ? num += i : false;

    alert(num);
}

function ejercicio3() {
    do {
        let n = prompt("Introduce un número ( n > 0 ): ");
        let sum = 0;

        if (n > 0) {
            for (let i = 0; i <= n; i++)
                if (i % 2 == 0) sum += i;

            alert(sum);
        }
    } while (n > 0);
}

function ejercicio4() {
    let n = 1, aux = 0, min = 0;
    let array = [];

    while (true) {
        n = prompt("Introduce un número ( n > 0 ): ");

        if (n == 0 && array.length == 0) {
            alert("No has introducido ningún número");
            continue;
        }

        if (n == 0) break;
        array.push(n);
    }

    /**
     * Si quisieras resolverlo con un algoritmo:
     * 
     * for (let i = 0; i < array.length; i++) {
        min = i;

        for (let j = i + 1; j < array.length; j++) if (array[min] > array[j]) min = j;

        aux = array[min];
        array[min] = array[i];
        array[i] = aux;
    }
     * Yo lo hago con una función ya definida en JS:
     */

    array.sort(function (a, b) { return a - b; });

    alert("El máximo es " + array[array.length - 1] + " y el mínimo es " + array[0])
}