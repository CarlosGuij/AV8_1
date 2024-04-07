<?php
require_once 'clases/Connection.php';

class Gestion extends Connection
{
    public function getBrands()
    {
        $dataBase = $this->getConn();
        $html = "<form action='' method='post'>";

        $sql = "SELECT brandId, brandName FROM brands ORDER BY brandName ASC";
        $result = $dataBase->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $html .= "<input type='checkbox' value='{$row['brandId']}' name='{$row['brandName']}'> {$row['brandName']}<br>";
            }
        } else {
            $html .= "No hay marcas disponibles.";
        }

        $html .= "<br><input type='submit' value='Seleccionar'>";
        $html .= "</form>";

        return $html;
    }
}
?>
