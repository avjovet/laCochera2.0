
<?php

include 'conexion/cone.php';
   if(isset($_POST['accion_pedido'])){
       $pedido_id = $_POST['pedido_id'];
       $accion = $_POST['accion_pedido'];
       try{
           if($accion == 'Cocinando' ){
               $stmt = $cone->prepare("UPDATE pedido SET Estado = 3 WHERE idPedido = :pedido_id");
               //$stmt = $cone->prepare("DELETE FROM pedido WHERE idPedido =:pedido_id");

               
   
           }elseif ($accion == 'terminado'){
                
              $stmt = $cone->prepare("UPDATE pedido SET Estado = 2 WHERE idPedido =: pedido_id");
           }
           $stmt->bindParam(':pedido_id',$pedido_id);
           $stmt->execute();

           header("Location: ".$_SERVER['PHP_SELF']);
           exit();
       }catch(PDOException $e){
           echo "Error: " . $e->getMessage();
       }
   }

   try {
       
       // Mostrar los resultados
       echo "<!DOCTYPE html>";
       echo "<html>";
       echo "<head>";
       echo "<title>Tabla de Cocina</title>";
       echo "<link rel='stylesheet' type='text/css' href='styles.css'>";
       echo "<link rel='stylesheet' type='text/css' href='styles2.css'>";
       echo "<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css'>";
       echo "</head>";
       echo "<body>";
       echo '<div class="principal ">';
       echo '<div class="sidebar-container  ">';
           include 'sidebar.php';
       echo '</div>';

       echo "<div class='container'>";
       echo "<table id='table_pedidos'>";

       
       echo '<caption>home</caption>';
       
       echo "<tr><th>Fecha Pedido</th><th>Numero Mesa</th><th>Tipo Pedido</th><th>Productos</th><th>Total</th><th>Estado Pedido</th><th>Acciones</th></tr>";
   
   echo "</table>";
   echo "</div>";
   echo "</body>";
   echo "</html>";

}catch(PDOException $e){
   echo "Error: " . $e->getMessage();
}
$cone = null;

?>
