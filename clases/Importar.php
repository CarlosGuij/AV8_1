<?php
require_once 'Connection.php';

class Importar extends Connection
{
    public function customers()
    {
        $dataBase = $this->getConn();

        $sql = "UPDATE customers SET customerName = ? WHERE customerId = ?";
        $stmt = $dataBase->prepare($sql);

        $file = fopen("customers.csv", "r");

        if ($file !== FALSE) {
            while (($data = fgetcsv($file, 1000, "#")) !== FALSE) {
                if (count($data) >= 2) {
                    $customerId = $data[0];
                    $customerName = $data[1];

                    $stmt->bind_param("ss", $customerName, $customerId);
                    $result = $stmt->execute();
            }
            fclose($file);
            $stmt->close();
            }
        }
    }

    public function getBrandId($brandName)
    {
    $dataBase = $this->getConn();
    $sql = 'SELECT brandId FROM brands WHERE brandName=?';  
    $stmt = $dataBase->prepare($sql);                
    $stmt->bind_param('s', $brandName);
    
    if (!$stmt->execute()) {
        echo "Error al ejecutar la consulta para obtener el ID de la marca: " . $stmt->error;
        return null;
    }

    $resultado = $stmt->get_result();    
    $fila = $resultado->fetch_assoc();
    $stmt->close();
    
    return $fila ? $fila['brandId'] : null;
    }
    
    

    public function brandCustomer()
    {
        $dataBase = $this->getConn();
        $file = fopen("customers.csv", "r");
        
        $insertSql = "INSERT INTO brandCustomer (customerId, brandId) VALUES (?, ?)";
        $insertStmt = $dataBase->prepare($insertSql);
        
        while (($data = fgetcsv($file, 1000, "#")) !== FALSE) {
            if (count($data) >= 3) {
                $customerId = $data[0];
                $brands = explode(", ", $data[2]);
                
                foreach ($brands as $brandName) {
                    $brandId = $this->getBrandId($brandName);
                    
                    if ($brandId !== null) {
                        $insertStmt->bind_param("ss", $customerId, $brandId);
                        if (!$insertStmt->execute()) {
                            echo "Error al insertar datos en brandCustomer: " . $insertStmt->error;
                        }
                    } else {
                        echo "La marca '$brandName' no se encuentra en la tabla de marcas.";
                    }
                }
            }
        }
        
        fclose($file);
        $insertStmt->close();
    }
}


?>