<?php

    include'includes/connect.php';
    $id=$_GET['id'];
    $result = $db->prepare("DELETE FROM users WHERE id= :post_id");
    $result->bindParam(':post_id', $id);
       if($result->execute()){
      header("location:users1.php?success=true");
        }else{
            header("location:users1.php?failed=true");
        } 
        
?>