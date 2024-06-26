<?php
    require_once('../../models/Platform.php');
    require_once('../../utils/utils.php');

    function listPlatforms() {
        $mysqli = initConnectionDb();
        $platformList = $mysqli->query(query: "SELECT * FROM platforms");

        $platformObjectArray = [];
        foreach ($platformList as $platformItem) {
            $platformObject = new Platform($platformItem['id'], $platformItem['name']);
            array_push($platformObjectArray, $platformObject);
        }
        $mysqli->close();

        return $platformObjectArray;
    }

    function storePlatform($platformName) {
        $mysqli = initConnectionDb();

        $platformCreated = false;

        //TODO: comprobar que no exista una plataforma con el mismo nombre
        $resultadoInsert = $mysqli->query(query: "SELECT * FROM platforms WHERE name = '$platformName'");
        if ($resultadoInsert->num_rows > 0) {
            return false;
        } 

        if ($resultadoInsert = $mysqli->query(query: "INSERT INTO platforms (name) values ('$platformName')")) {
            $platformCreated = true;
        }   
        $mysqli->close();

        return $platformCreated;
    }

    function updatePlatform($platformId, $platformName) {
        $mysqli = initConnectionDb();

        $platformEdited = false;

        if ($resultadoUpdate = $mysqli->query(query: "UPDATE platforms set name = '$platformName' where id = $platformId")) {
            $platformEdited = true;
        }

        $mysqli->close();

        return $platformEdited;
    }

    function getPlatformData($idPlatform) {
        $mysqli = initConnectionDb();
        $platformData = $mysqli->query(query: "SELECT * FROM platforms WHERE id=$idPlatform");
        $platformObject = null;
        foreach ($platformData as $platformItem) {
            $platformObject = new Platform($platformItem['id'], $platformItem['name']);
            break;
        }
        $mysqli->close();
        return $platformObject;
    }

    function deletePlatform($platformId) {
        $mysqli = initConnectionDb();

        $platformDeleted = false;

        if ($resultado = $mysqli->query(query: "DELETE FROM platforms where id = $platformId")) {
            $platformDeleted = true;
        }

        $mysqli->close();

        return $platformDeleted;
    }
?>