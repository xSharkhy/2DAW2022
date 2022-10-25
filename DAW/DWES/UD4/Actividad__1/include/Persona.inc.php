<?php
class Persona
{

    private $idContacto;
    private $nombre;
    private $apellido1;
    private $apellido2;
    private $telefono;

    public function __construct($idContacto, $nombre, $apellido1, $apellido2, $telefono)
    {
        $this->idContacto = $idContacto;
        $this->nombre = $nombre;
        $this->apellido1 = $apellido1;
        $this->apellido2 = $apellido2;
        $this->telefono = $telefono;
    }

    public function getIdContacto(): int
    {
        return $this->idContacto;
    }

    public function setIdContacto(int $idContacto): void
    {
        $this->idContacto = $idContacto;
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): void
    {
        $this->nombre = $nombre;
    }

    public function getApellido1(): string
    {
        return $this->apellido1;
    }

    public function setApellido1(string $apellido1): void
    {
        $this->apellido1 = $apellido1;
    }

    public function getApellido2(): string
    {
        return $this->apellido2;
    }

    public function setApellido2(string $apellido2): void
    {
        $this->apellido2 = $apellido2;
    }

    public function getTelefono(): string
    {
        return $this->telefono;
    }

    public function setTelefono(string $telefono): void
    {
        $this->telefono = $telefono;
    }

    public function __toString(): string
    {
        return $this->idContacto . ' ' . $this->nombre . ' ' . $this->apellido1 . ' ' . $this->apellido2 . ' ' . $this->telefono . ' ';
    }
}
