<?php
/*
    Función para controlar los productos del carrito.
    Recibe como parámetro la página desde la que se llama a la función para poder redirigir al usuario
    a la página desde la que se ha llamado a la función.

    CASOS:
    - Si la acción es 'add' y el producto no está en el carrito, se añade el producto al carrito.
    - Si la acción es 'add' y el producto ya está en el carrito, se aumenta la cantidad del producto en el carrito.
    - Si la acción es 'substract' y el producto está en el carrito, se disminuye la cantidad del producto en el carrito.
    - Si la acción es 'substract' y el producto no está en el carrito, no se hace nada.
    - Si la acción es 'remove' y el producto está en el carrito, se elimina el producto del carrito.
    - Si la acción es 'remove' y el producto no está en el carrito, no se hace nada.

    Si la acción no es ninguna de las anteriores, no se hace nada.
*/
function carrito($archivo)
{
    switch ($_GET['act']):
        case 'add':
            if (isset($_SESSION['carrito']))
                if (isset($_SESSION['carrito'][$_GET['id']])) $_SESSION['carrito'][$_GET['id']]++;
                else $_SESSION['carrito'][$_GET['id']] = 1;
            else $_SESSION['carrito'][$_GET['id']] = 1;

            $_SESSION['timer'] = time() + 60 * 10;
            break;
        case 'substract':
            if (isset($_SESSION['carrito'][$_GET['id']]))
                if ($_SESSION['carrito'][$_GET['id']] > 1) $_SESSION['carrito'][$_GET['id']]--;
                else unset($_SESSION['carrito'][$_GET['id']]);
            break;
        case 'remove':
            if (isset($_SESSION['carrito'][$_GET['id']])) unset($_SESSION['carrito'][$_GET['id']]);
            if (count($_SESSION['carrito']) == null) unset($_SESSION['carrito']);
            break;
    endswitch;
    header("Location: $archivo");
}
