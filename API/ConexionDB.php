<?php class ConexionDB{
    private $pdo;
    public function __construct($host, $dbname, $username, $password)
    {
        try {
            $this->pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Error en la conexión: " . $e->getMessage());
        }
    }
    public function getPDO()
    {
        return $this->pdo;
    }
}
if (!isset($_SESSION['usuarios'])) {
    $_SESSION['usuarios'] = [];
}

?>