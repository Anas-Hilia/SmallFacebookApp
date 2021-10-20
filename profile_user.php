<?php 
    session_start(); 
    if($_SESSION["id"]==NULL) header('location: authentification.php');
    $conn = new mysqli("localhost", "root", "" , "app"); 


    // post_message 
    
    
    $statusMsg='';
    if(isset($_POST["submit"])){ 
    
        $from=$_SESSION["id"]  ;
        $to=$_GET["id_profile"]  ;  
        $post=htmlspecialchars($_POST["post"]);
    
        if(empty($_FILES["photo_post"]["name"])) {
            
    
        $sql = "INSERT INTO post (message_post, id_from , id_to ,date_actuelle )
        VALUES ( '$post' , '$from' ,'$to' , NOW())";
                                
            if ($conn->query($sql) ==TRUE)
            {
                $statusMsg = "Votre post a eté publier avec succès";
                echo '<meta http-equiv="refresh" content="1">';            
            } 
            else 
            {
              $statusMsg = "L'e téléchargement du post a échoué, veuillez réessayer.";
            }
        }
        if(!empty($_FILES["photo_post"]["name"])) { 
            // Get file info 
            $fileName = basename($_FILES["photo_post"]["name"]); 
            $fileType = pathinfo($fileName, PATHINFO_EXTENSION); 
             
            // Allow certain file formats 
            $allowTypes = array('jpg','png','jpeg','gif'); 
            if(in_array(strtolower($fileType), $allowTypes)){ 
                $image = $_FILES['photo_post']['tmp_name']; 
                $imgContent = addslashes(file_get_contents($image)); 
             
                // Insert image content into database 
                $sql = "INSERT INTO post (message_post, id_from , id_to ,photo_post,date_actuelle )
        VALUES ( '$post' , '$from' ,'$to', '$imgContent', NOW())";
                 
                 if($conn->query($sql) ==TRUE){ 
                    
                    $statusMsg = "Votre post a eté publier avec succès";
                    echo '<meta http-equiv="refresh" content="1">'; 
                    
                }else{ 
                    $statusMsg = "Le téléchargement du fichier a échoué, veuillez réessayer."; 
                   
                }  
            }else{ 
                $statusMsg = 'Désolé, seuls les fichiers JPG, JPEG, PNG et GIF sont autorisés à télécharger.';
                 
            }  
        } 
    } 
     
    
    
    //------------------------------
    ?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
*{
  font-family: cursive;
}
.card {
  float:left;
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
  max-width: 300px;
  margin: auto;
  text-align: center;
  
  position:absolute;
  left:100px;
  top:30px;
  width:40%;
}

.title {
  
  color: grey;
  font-size: 18px;
}

button {
  border: none;
  outline: 0;
  display: inline-block;
  padding: 8px;
  color: white;
  background-color: #000;
  text-align: center;
  cursor: pointer;
  width: 100%;
  font-size: 18px;
}
p button
{
    color : orange;
}
a {
  text-decoration: none;
  font-size: 22px;
  color: black;
}
button:hover, a:hover {
  opacity: 0.7;
}
.aa
{
  float:right;
    position:absolute;
    left:65%;
    top:20px;
    width:20%;
}
</style>
</head>
<body>

<h2 style="text-align:center; color:green;font-family: Georgia, serif;">Profile d'utilisateur </h2>

<div class="card">  
<!------------------------>
<br>
<?php
 $id_from=$_GET["id_profile"]; 
 $reponse=$conn->query("SELECT * FROM  user WHERE iduser='$id_from' ");
 while( $data = $reponse->fetch_assoc())
 {      
  if($data['photo_profile']!=NULL){ ?>
    <img style="border:2px solid lightblue;border-radius:5px;height:200px;width:200px;" src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($data['photo_profile']); ?>" /> 
    <?php } else {?>
    <img style="border:2px solid lightblue;border-radius:5px;height:200px;width:200px;" src="images/male.png" class="mx-auto img-fluid img-circle d-block" alt="avatar">
    <?php } ?>
                
  <!------------------------>
  

  <h1><?php echo strtoupper($data["pseudo"]) ?></h1>
  <h3 class="mt-2"><?php echo "<span style='color: #0958d9'>NOM :</span>     ". strtoupper($data["nom"]) ?></h6>
  <h3 class="mt-2"><?php echo "<span style='color: #0958d9'>PRENOM :</span>  ". strtoupper($data["prenom"]) ?></h6>
 <?php } $id_to=$_SESSION['id'];$id_from=$_GET["id_profile"];  $amis=1;
   if($id_to!=$id_from) { ?>
  
  <a href="message.php?id_profile=<?php echo $_GET["id_profile"] ?>" ><p><button style="width:60%">Contactez moi <i class="fas fa-envelope"></i></button></p></a>
  

 <?php

 $id_from=$_GET["id_profile"];
  $id_to =$_SESSION['id'];
  $from=$_SESSION["id"]  ;
    $to=$_GET["id_profile"]  ;
  $reponse=$conn->query("SELECT COUNT(id_demande_amitie) AS nbr FROM demande_amitie WHERE id_from='$id_from' AND id_to='$id_to'");
   while( $data = $reponse->fetch_assoc()){ $nbr=$data["nbr"] ; } 
$reponse=$conn->query("SELECT COUNT(id_demande_amitie) AS rbn FROM demande_amitie WHERE id_from='$from' AND id_to='$to'");
while( $data = $reponse->fetch_assoc()){ $rbn=$data["rbn"] ;  }
$reponse=$conn->query("SELECT COUNT(id) AS amis FROM friend WHERE id_user='$from' AND id_amis='$to'");
   while( $data = $reponse->fetch_assoc()){ $amis=$data["amis"] ; }

?>
<form action="" method="post">
<?php if($amis==0){ ?>
<a href="#"><p><button name="annuler" style="color:green; display:<?php if($rbn == 0 ) { echo "none" ;} ?> ;"><i class="fas fa-user-minus"> </i> Annuller la demande </button></p></a>
<?php  if($nbr==0) { ?>
 
  <a href="#"><p><button name="ajouter" style="color:green; display:<?php if($rbn ==1 ) { echo "none" ;} ?> ;"><i class="fas fa-user-plus"> </i> AJOUTER </button></p></a>
  </form>
<?php } else { ?>
  <form action="" method="post">
    <button name="accepter" style="color:green ; display:<?php if($amis!=0 && $ar==0){ echo "none" ;} ?>">
      <i class="fa fa-check-square"></i> accepter 
    </button> <h5></h5>
    <button name="refuser" style="color:red; display:<?php if($amis!=0){ echo "none" ;} ?>">
      <i class="fa fa-times-circle"></i> refuser 
    </button>
    </form>
    <?php }} ?>
 <form action="" method="post">
 
 
 
 <?php if($amis!=0){ ?>
 <p><button name="retirer" style="color:#39dbc0; ?> ;"><i class="fas fa-user-times"> </i> Retirer de la liste d'amis </button></p>
 <?php } ?>
 </form>
 <?php }?>
</div>

 


<a class="aa"  href="index.php"> <button  class="btn btn-primary"> retourner vers votre compte <span class="glyphicon glyphicon-user"></span></button></a>

<?php



if(isset($_POST["ajouter"]) && $rbn==0)
{ 
    $from=$_SESSION["id"]  ;
    $to=$_GET["id_profile"]  ;
    $sql="INSERT INTO demande_amitie (id_from , id_to) VALUES ('$from','$to')";
    if ($conn->query($sql)==TRUE){
    ?>
    <center> 
        <span style="position:absolute; top:200px ; left: 42%"  class="btn btn-success"> Votre demande a eté envoyer  
        <i class="glyphicon glyphicon-ok"></i></span></center>
        <meta http-equiv="refresh" content="1">

<?php }
else 
{
     
     echo "Error: " . $sql . "<br>" . $conn->error;
}
} ?>


<?php
if(isset($_POST["annuler"]))
{   
    $sql = "DELETE FROM demande_amitie WHERE id_from='$from' AND id_to='$to'";
    if ($conn->query($sql) ==TRUE)
    {
      $pseudo=$_GET["pseudo"];
      echo '<center> 
      <span style="position:absolute; top:200px ; left: 42%"  class="btn btn-success"> Votre demande est annulée  
      <i class="glyphicon glyphicon-ok"></i></span></center>' ;
      echo '<meta http-equiv="refresh" content="1">';
    } 
    else 
    {
    echo "Error: " . $sql . "<br>" . $conn->error;
    } 
}
?>


<?php  

if(isset($_POST["accepter"])) 
{   
  $to=$_SESSION["id"]  ;
  $from=$_GET["id_profile"]  ;
    $sql1 ="INSERT INTO friend (id_user , id_amis) VALUES ( '$to', '$from')";
    $sql2 ="INSERT INTO friend (id_user , id_amis) VALUES ( '$from', '$to' )";

    if ($conn->query($sql1) ==TRUE && $conn->query($sql2) ==TRUE)
    {
      echo '<meta http-equiv="refresh" content="0">';
    } 
    else 
    {
    echo "Error: " . $sql . "<br>" . $conn->error;
    } 
} 
$ar=1;
if(isset($_POST["accepter"]) || isset($_POST["refuser"])) 
{
  $to=$_SESSION["id"]  ;
  $from=$_GET["id_profile"]  ;
  $sql = "DELETE FROM demande_amitie WHERE id_from='$from' AND id_to='$to'";
  if ($conn->query($sql) ==TRUE)
  {
      $ar=0;
      echo '<meta http-equiv="refresh" content="0">';
  } 
  else 
  {
  echo "Error: " . $sql . "<br>" . $conn->error;
  } 
}


if(isset($_POST["retirer"]))
{   
  $to=$_SESSION["id"]  ;
  $from=$_GET["id_profile"]  ;
    $sql1 = "DELETE FROM friend WHERE id_user='$to' AND id_amis='$from'";
    $sql2 = "DELETE FROM friend WHERE id_user='$from' AND id_amis='$to'";
    if ($conn->query($sql1) ==TRUE && $conn->query($sql2) ==TRUE)
    {
       ?>
      <center> 
        <span style="position:absolute; top:550px ; left:  60px;"  class="btn btn-success"> <strong><?php echo $_GET["pseudo"]; ?> </strong> a été retirer de votre liste des amis(es) . 
        <i class="glyphicon glyphicon-ok"></i></span>
      </center>
      <?php
      echo '<meta http-equiv="refresh" content="1">';
    } 
    else 
    {
    echo "Error: " . $sql . "<br>" . $conn->error;
    } 
}

?>
        <?php $i=0; if($amis!=0){   ?>
                    <div class="row" style="width:50%; float:right; margin-right:150px;margin-top:10px">
                        <div class="col-md-12">
                        <table class="table table-sm table-hover table-striped">
                        <form  method="POST" action="" enctype="multipart/form-data">
                          <div class="form-group">
                            <textarea name="post" class="form-control" rows="3" required ></textarea>
                          </div>
                          <div class="form-group">
                            <input type="file" name="photo_post" class="form-control"  >
                          </div>
                        <button type="submit" name="submit" class="btn btn-success" style="width:100px">Poster</button>
                        </form>
                        <tbody>   
                        </div>  
    
  <form action="" method="post">
    <input style="margin-left:142px ; border-radius:5px; text-align:center;" name="date" type="date"></input>
    <center><input style="width:120px ; background:#f2d68a" type="submit" name="envoyer" value="envoyer"></center>
    </form>
    
    <?php // Display status message 
    if($statusMsg!=''){
    ?>
              <br>
              <center> 
              <div  class="alert alert-info" > <?php echo $statusMsg ;?>   
              </div></center>
                       
    <?php } ?> <br>
                
                        <?php $i=0;
                          $id=$_GET['id_profile'];
                          if(isset($_POST["envoyer"]) && !empty($_POST["date"]))
                          {
                              
                 $date=$_POST["date"];
                 $tab=explode('/',"$date"); $date=implode('-',$tab);$date=trim($date);
                 echo "<strong>".$date."</strong>" ;
                $reponse=$conn->query("SELECT * FROM post , user WHERE id_from=iduser AND date_actuelle='$date' AND  id_to='$id' ORDER BY date_actuelle DESC");
               
                }
                else
                { $reponse=$conn->query("SELECT * FROM post , user WHERE id_from=iduser AND  id_to='$id' ORDER BY date_actuelle DESC ");
                }
                   while( $data = $reponse->fetch_assoc()){?>
                    
                            <tr>
                                <td class="h4" >
                                    <?php  echo  $data["message_post"];   
                                    if($data['photo_post']!=NULL){ ?>
                           
                                <center>
                                    <img style="border:2px solid lightblue;border-radius:5px;height:250px;width:260px;" src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($data['photo_post']); ?>" /> 
                                </center>
                                   <?php } ?>
                                    <form action="" method="post">
                                    <?php $i++ ; $r="a"; $r.="$i";$tab_id_from["$i"]= $data["id_post"] ; ?>
                                    <?php  if($data['id_from']==$_SESSION["id"] ){ ?>
                                      <button name="<?php echo $i ;?>" style="color:green ;background-color:lightgrey; border-radius:8px;float:right;font-size:15px; width:100px ;margin-right:10px;margin-top:40px;"><i class="fa fa-edit"></i> modifier  </button>
                                    <?php }  if($data['id_from']==$_SESSION["id"] || $data['id_to']==$_SESSION["id"]  ){ ?>
                                      <button name="<?php echo $r ; ?>" style="color:red;background-color:lightgrey; border-radius:8px; width:125px ;font-size:15px;float:right; width:110px ;margin-right:10px;margin-top:40px;"><i class="fa fa-times-circle"></i> supprimer </button>
                                    <?php } ?>
                                  </form>              
                                    <hr>
                                <div class="row">
                                   <div class="span8">
                                      <p style="margin-left:10px; ">
                                        <i class="icon-user"></i> Par <a style="color:#39dbc0;font-size:15;" href="profile_user.php?pseudo=<?php echo $data["pseudo"]?> && id_profile=<?php echo $data["iduser"]?>"><?php  echo strtoupper($data["pseudo"]) ; ?></a> 
                                         | <i class="icon-calendar"></i> <?php echo $data["date_actuelle"]?>
                                          </p>
                                   </div>
                                   </div>
                                </td>
                            </tr>
                            <?php }?>
                            
                        </tbody> 
                    </table>
                        </div>
                    </div>

                   <?php }   










for($j=1 ; $j <= $i ; $j++)
{
  if(isset($_POST["$j"])) 
  { $l="b";
    $l.="$j"; ?>

  <form style="position:absolute; top:85% ; left:100px" method="POST" action="" >
  
    <div class="form-group">
   
       <textarea name="post1" class="form-control" rows="3" style="width:300px; height:40px" required ></textarea>
  
     </div>
     
      <button type="submit" name="<?php echo $j ; ?>" class="btn btn-success" style="width:100px">Modifier</button>
   
     </form>

<?php
  if(isset($_POST["$j"]) && isset($_POST["post1"]))
  {   $id=$tab_id_from["$j"];
      $post = htmlspecialchars($_POST["post1"]);
    $sql ="UPDATE post SET message_post = '$post'   WHERE id_post = '$id'";
  
      if ($conn->query($sql) ==TRUE)
      {
        echo '<meta http-equiv="refresh" content="0">';
      } 
      else 
      {
      echo "Error: " . $sql . "<br>" . $conn->error;
      } 
  } 
}
      $r="a";
      $r.="$j";
  
  if(isset($_POST["$r"]))
  {   
    $id=$tab_id_from["$j"];
    $to=$_SESSION["id"]  ;
    $sql = "DELETE FROM post WHERE id_post='$id' ";
    if ($conn->query($sql) ==TRUE)
    {
      echo '<meta http-equiv="refresh" content="0">';

    } 
    else 
    {
    echo "Error: " . $sql . "<br>" . $conn->error;
    } 
  }
  }
  




?>




















</body>
</html>
