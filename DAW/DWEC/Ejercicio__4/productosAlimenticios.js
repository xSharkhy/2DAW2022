// Crea un objeto de tipo ProductoAlimenticio
// con las propiedades codigo, nombre y precio
// y el método imprimeDatos
function ProductoAlimenticio(codigo, nombre, precio) {
    this.codigo = codigo;
    this.nombre = nombre;
    this.precio = precio;
    this.imprimeDatos = () => {
        console.log(`Código: ${this.codigo}`);
        console.log(`Nombre: ${this.nombre}`);
        console.log(`Precio: ${this.precio}`);
    }
}

// crea tres instancias de ProductoAlimenticio y guárdalas en un array
let productos = [
    new ProductoAlimenticio(1, 'Leche', 1.05),
    new ProductoAlimenticio(2, 'Pan', 0.80),
    new ProductoAlimenticio(3, 'Yogur', 0.90)
];

// muestra los datos de los productos con un bucle for
for (let i = 0; i < productos.length; i++) {
    productos[i].imprimeDatos();
}