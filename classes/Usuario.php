<?php
class Usuarios
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function login($email, $senha)
    {
        
    }
}