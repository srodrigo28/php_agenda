<?php
    session_start();

    include_once("connection.php");
    include_once("url.php");

    $data = $_POST;

    if(!empty($data)){
        if($data["type"] === "create"){
            $name = $data["name"];
            $phone = $data["phone"];
            $observations = $data["observations"];

            // var_dump($data); exit();

            $query = " INSERT INTO contacts(name, phone, observations) VALUES (:name, :phone, :observations)";
            $stmt = $conn->prepare($query);
        
            $stmt->bindParam(":name", $name);
            $stmt->bindParam(":phone", $phone);
            $stmt->bindParam(":observations", $observations);

            try{
                $stmt->execute();
                $_SESSION["msg"] = "Contato criado com sucesso!";
            } catch(PDOException $e){
                $error = $e->getMessage();
                echo "Erro: $error";
            }
        }
        // Redirect Home
        header("Location:" . $BASE_URL . "../index.php");
    } else {
    
    $id;
    if (!empty($_GET)) {
        $id = $_GET['id'];
    }

    //Retorna o dado de um contato
    if (!empty($id)) {  
        $query = "SELECT * FROM contacts WHERE id = :id"; 

        $stmt = $conn->prepare($query);

        $stmt->bindParam(":id", $id);

        $stmt->execute();

        $contact = $stmt->fetch();

    } else {
        
        //Retorna todos os dados
        $contacts = [];

        $query = "SELECT * FROM contacts";

        $stmt = $conn->prepare($query);

        $stmt->execute();

        $contacts = $stmt->fetchAll();
    }
}