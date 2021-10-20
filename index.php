<?php 
    session_start(); 
    if($_SESSION["id"]==NULL) header('location: authentification.php');

    


    // Create connection//
    $conn = new mysqli("localhost", "root", "" , "app");
    // Check connection//
    if ($conn->connect_error)
    {
        die("Connection failed: " . $conn->connect_error);
    }
    
    
    
  
    $statusMsg='';
    if(isset($_POST["submit"])){ 
    
        $from=$_SESSION["id"]  ;
        $to=$_SESSION["id"]  ;  
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
<html lang="en">
	<head>
		<script src=" https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js" type="text/javascript" language="javascript" ></script>
		<script src="js/appParse.js" type="text/javascript" language="javascript" ></script>
		<link href="css/bootstrap.min.css" type="text/css" rel="stylesheet" />
		<link href="css/style.css" type="text/css" rel="stylesheet" />
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap 4 DatePicker</title>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
    <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />
<style>
button  {
  border: none;
  outline: 0;
  display: inline-block;
  padding: 8px;
  color: white;
  text-align: center;
  cursor: pointer;
  width: 20%;
  font-size: 18px;
  border-radius:10px;
}

.acc_ref button
{
    float:right;
    display:inline-block;
    margin-left:10px;
    width:110px;
    
    
}

</style>
	</head>
	<body>


    <div class="container" >
    <form action="" method="POST">
    <a   style="float: right; width:100px; position:absolute; left:80%; z-index:1;" href="" > <input style=" width:160px;" class="btn btn-outline-danger " name="deconnect" value="SE DECONNECTER" type="submit" > </a>
    </form><div class="row my-2">
        <div class="col-lg-8 order-lg-2">
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a href="" data-target="#profile" data-toggle="tab" class="nav-link active">Profile</a>
                </li>
                <li class="nav-item">
                    <a href="" data-target="#amis" data-toggle="tab" class="nav-link">Amis(es)</a>
                </li>
                <li class="nav-item">
                    <a href="" data-target="#messages" data-toggle="tab" class="nav-link">Messages</a>
                </li>
                <li class="nav-item">
                    <a href="" data-target="#demadeamitie" data-toggle="tab" class="nav-link">Demande Amitié</a>
                </li>
                <li class="nav-item">
                    <a href="" data-target="#utilisateurs" data-toggle="tab" class="nav-link">Les utilisateurs</a>
                </li>
            </ul>
            <div class="tab-content py-4">
                <div class="tab-pane active" id="profile">
                    
                    <div class="row">
                        <div class="col-md-12">
                        <table class="table table-sm table-hover table-striped">
                        <form  method="POST" action="" enctype="multipart/form-data">
                          <div class="form-group">
                            <textarea name="post" class="form-control" rows="2" required ></textarea>
                          </div>
                          <div class="form-group">
                            <input type="file" name="photo_post" class="form-control"  >
                          </div>
                        <center><button type="submit" name="submit" class="btn btn-success">Poster</button></center><br>
                        </form>
                        
                                                           
                        
    <?php // Display status message 
    if($statusMsg!=''){
    ?>
    <br>
              <center> 
              <div  class="alert alert-info" > <?php echo $statusMsg ;?>   
              </div></center>
              <br>             
    <?php } ?>
    <tbody> 
                        <?php 
                          $id =$_SESSION['id']; $k=0;
                          if(isset($_POST["envoyer"]) && !empty($_POST["date"]))
                          {
                              
                 $date=$_POST["date"];
                 $tab=explode('/',"$date"); $date=implode('-',$tab);$date=trim($date);
                 echo "<strong>".$date."</strong>" ;
                $reponse=$conn->query("SELECT * FROM post , user WHERE id_from=iduser AND date_actuelle='$date' AND  id_to='$id'");
               
                }
                else
                { $reponse=$conn->query("SELECT * FROM post , user WHERE id_from=iduser AND  id_to='$id' ORDER BY date_actuelle DESC");
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
                                    <?php $k++ ; $l="a"; $l.="$k";$tabfrom["$k"]= $data["id_post"] ; ?>
                                    <?php  if($data['id_from']==$_SESSION["id"] ){ ?>
                                        <button name="<?php echo $k ;?>" style="color:green ;background-color:lightgrey; border-radius:8px;float:right; width:120px ;margin-right:10px; margin-top:10px;"><i class="fa fa-edit"></i> modifier  </button></p>
                                    <?php }  if($data['id_from']==$_SESSION["id"] || $data['id_to']==$_SESSION["id"]  ){ ?>     
                                        <button name="<?php echo $l ; ?>" style="color:red;background-color:lightgrey; border-radius:8px; width:120px ;float:right;margin-right:10px;margin-top:10px;"><i class="fa fa-times-circle"></i> supprimer </button></p>
                                    <?php } ?>
                                    </form>              
                                    <hr>
                                <div class="row">
                                   <div class="span8">
                                      <p style="margin-left:10px;">
                                        <i class="icon-user"></i> Par <a href="profile_user.php?pseudo=<?php echo $data["pseudo"]?> && id_profile=<?php echo $data["iduser"]?>"><?php  echo strtoupper($data["pseudo"]) ; ?></a> 
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
                    <!--/row-->
                </div>
                <div class="tab-pane" id="amis">
                <h5 class="mb-3"><i class="fas fa-users"></i> Vos Amis(es)</h5>   
                <table class="table table-hover table-striped">                          
                          <tbody>                                    
                              
                          <?php 
                          $id =$_SESSION['id'];
                  $reponse=$conn->query("SELECT * FROM friend , user WHERE id_amis=iduser AND  id_user='$id'");
                   while( $data = $reponse->fetch_assoc()){?>
                              <tr>
                                  <td class="h3">
                                 
                                  <a href="profile_user.php?pseudo=<?php echo $data["pseudo"]?> && id_profile=<?php echo $data["id_amis"];?>" class="h3" >
                                  <?php echo $data["pseudo"] ?></a> <br>
                                 
                                  </td>
                              </tr>
                   <?php }?>
                              
                          </tbody> 
                      </table>

                </div>
                <div class="tab-pane" id="messages">
                    
                    <table class="table table-hover table-striped">
                        <tbody>
                                                            
                        <?php 
                        $id =$_SESSION['id'];
                        
                $reponse=$conn->query("SELECT * FROM message WHERE  id_to='$id' ||  id_from='$id' ORDER BY date DESC");
                while( $data = $reponse->fetch_assoc()){ ?>
                    <tr>
                    <td class="h3">
                <?php 
                        if($data['id_to']=="$id"){
                            $id1 = $data['id_from'];
                            $reponse=$conn->query("SELECT * FROM user WHERE  iduser='$id1' ");
                while( $data01 = $reponse->fetch_assoc()){
                            ?>
                                
                                    <a href="profile_user.php?pseudo=<?php echo $data01["pseudo"]?> && id_profile=<?php echo $data01["iduser"];?>" class="h3" >
                                    <?php echo $data01["pseudo"] ?></a> <br>
                                    <span style="opacity:<?php if($data['vu']=='1'){ echo 0.5 ;}else{echo 1 ;}?>;">
                                    <?php 
                                        echo $data["message"];
                                        if($data['photo_message']!=NULL){?>
                                            <i class="far fa-images"></i>
                                        <?php
                                        }

                                    ?>
                                    <span style="font-size:15px;"> <?php echo " | " . $data['date']  ; ?> </span>
                                
                                </span>
                                
                                    <a href="message.php?id_profile=<?php echo $data01["iduser"];?>" class="btn btn-outline-warning" style="position:absolute;right:20px;"> Repondre </a>
                                
                            
                        <?php 
                        }}else{
                            $id2 = $data['id_to'];
                            $reponse=$conn->query("SELECT * FROM user WHERE  iduser='$id2' ");
                            while( $data02 = $reponse->fetch_assoc()){
                        
                            ?>
                                <span >
                                    <a href="profile_user.php?pseudo=<?php echo $data02["pseudo"]?> && id_profile=<?php echo $data02["iduser"];?>" class="h3" >
                                    <?php echo $data02["pseudo"] ?></a> <br>
                                    
                                    <span class="h4"> Vous :   </span> 
                                    <?php 
                                        echo $data["message"];
                                        if($data['photo_message']!=NULL){?>
                                            <i class="far fa-images"></i>
                                        <?php
                                        }

                                    ?>
                                      <span style="font-size:15px;" > | <i   class="fas <?php if($data['vu']=='1'){ echo 'fa-eye' ;}else{echo 'fa-eye-slash' ;}?>"></i></span>   
                                    <span style="font-size:15px;"> <?php echo " | " . $data['date']  ; ?> </span>
                                </span>    
                                    <a href="message.php?id_profile=<?php echo $data["id_to"];?>" class="btn btn-outline-warning" style="position:absolute;right:20px;" > Contacter </a>
                                
                                
                        <?php }} ?>
                            

                        </td>
                        </tr> 
                    <?php } ?>
                            
                        </tbody> 
                    </table>
                </div>
                <div class="tab-pane" id="demadeamitie">
                <table class="table table-hover table-striped">
                        <tbody>                                    
                        <?php 
                        $id =$_SESSION['id'];
                        $i=0;
                        
                        
                        $reponse=$conn->query("SELECT DISTINCT pseudo ,id_from  FROM demande_amitie,user WHERE id_from=iduser AND id_to='$id' ");
                        while( $data = $reponse->fetch_assoc())
                        {   ?>    
                        
                        <tr>
                            <td class="h3">
                            <a href="profile_user.php?pseudo=<?php echo $data["pseudo"]?> && id_profile=<?php echo $data["id_from"] ?>"> 
                               <?php echo strtoupper($data["pseudo"]) ; $i++ ; $r="a"; $r.="$i";  ?></a>
                            <?php $tab_id_from["$i"]= $data["id_from"] ; ?>
                            <form action="" method="post">
                            <a class="acc_ref" href=""><button class="btn btn-outline-success" name="<?php echo $i ; ?>" ><i class="fa fa-check-square"></i> accepter </button></p></a>
                            <a class="acc_ref" href=""><button class="btn btn-outline-danger" name="<?php echo $r ; ?>" ><i class="fa fa-times-circle"></i> refuser </button></p>
                            </form>
                            </td>
                           
                        </tr>
                        
                        <?php  } ?> 

                        </tbody> 
                    </table>
                </div>
                <div class="tab-pane" id="utilisateurs">
                <table class="table table-hover table-striped">
                        <tbody>                                    
                        <?php 
                        $id =$_SESSION['id'];
                $reponse=$conn->query("SELECT * FROM user WHERE iduser!='$id'");
                 while( $data = $reponse->fetch_assoc()){?>
                            <tr>
                                <td class="h3">
                               <a href="profile_user.php?pseudo=<?php echo $data["pseudo"]?> && id_profile=<?php echo $data["iduser"] ?>"> 
                               <?php echo strtoupper($data["pseudo"]); ?></a>
                                </td>
                            </tr>
                 <?php }?>
                        </tbody> 
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-4 order-lg-1 text-center">
        <?php
            $id = $_SESSION['id'];  
            $reponse1=$conn->query("SELECT photo_profile FROM user WHERE iduser='$id'");
            while( $data = $reponse1->fetch_assoc()){
                if($data['photo_profile']!=NULL){ ?>
                    <img style="border:2px solid lightblue;border-radius:5px;height:200px;width:200px;" src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($data['photo_profile']); ?>" /> 
                <?php } else {?>
                <img style="border:2px solid lightblue;border-radius:5px;height:200px;width:200px;" src="images/male.png" class="mx-auto img-fluid img-circle d-block" alt="avatar">
                <?php }} ?>
            
            <h6 class="mt-2"><?php echo "<span style='color: #0958d9'>PSEUDO :</span>  ".strtoupper($_SESSION["pseudo"]) ?></h6>
            <h6 class="mt-2"><?php echo "<span style='color: #0958d9'>NOM :</span>     ". strtoupper($_SESSION["nom"]) ?></h6>
            <h6 class="mt-2"><?php echo "<span style='color: #0958d9'>PRENOM :</span>  ". strtoupper($_SESSION["prenom"]) ?></h6>
        <br><br>
    
<form action="" method="post">
    <input style="margin-left:80px ;width:200px" name="date" type="date"  width="276" />
    <center><input style="width:120px ; background:#f2d68a" type="submit" name="envoyer" value="envoyer"></center>
    </form>
    
        
        
        </div>
    </div>
</div>








<?php  

for($j=0 ; $j <= $i ; $j++){
if(isset($_POST["$j"])) 
{   $id_from=$tab_id_from["$j"];
    $sql1 ="INSERT INTO friend (id_user , id_amis) VALUES ( '$id', '$id_from')";
    $sql2 ="INSERT INTO friend (id_user , id_amis) VALUES ( '$id_from','$id' )";

    if ($conn->query($sql1) ==TRUE && $conn->query($sql2) ==TRUE)
    {
        echo '<meta http-equiv="refresh" content="0"';
    } 
    else 
    {
    echo "Error: " . $sql . "<br>" . $conn->error;
    } 
} 

    $r="a";
    $r.="$j";

if(isset($_POST["$j"]) || isset($_POST["$r"]))
{   
    $id_from=$tab_id_from["$j"];
    $to=$_SESSION["id"]  ;
    $sql = "DELETE FROM demande_amitie WHERE id_from='$id_from' AND id_to='$to' ";
    if ($conn->query($sql) ==TRUE)
    {
        echo '<meta http-equiv="refresh" content="0">';    } 
    else 
    {
    echo "Error: " . $sql . "<br>" . $conn->error;
    } 
}


}









if(isset($_POST["deconnect"]))
{
    $_SESSION["id"]=NULL;
    echo '<meta http-equiv="refresh" content="0;URL=authentification.php">';
}


?>


<?php
$from=$_SESSION["id"];
for($j=1 ; $j <= $k ; $j++)
{$to=$tabfrom["$j"];
  if(isset($_POST["$j"])) 
  { $h="b";
    $h.="$j";?>

  <form style="position:absolute; top:85% ; left:100px" method="POST" action="" >
  
    <div class="form-group">
   
       <textarea name="post1" class="form-control" rows="3" style="width:300px; height:40px" required ></textarea>
  
     </div>
     
      <button type="submit" name="<?php echo $j ; ?>" class="btn btn-success" style="width:100px">Modifier</button>
   
     </form>

<?php
  if(isset($_POST["$j"]) && isset($_POST["post1"]))
  {   $id=$tabfrom["$j"];
      $post = htmlspecialchars($_POST["post1"]);
    $sql ="UPDATE post SET message_post = '$post'   WHERE id_post = '$id'";
  
      if ($conn->query($sql) ==TRUE)
      {
        echo '<meta http-equiv="refresh" content="0"';     
      } 
      else 
      {
      echo "Error: " . $sql . "<br>" . $conn->error;
      } 
  } 
}
      $l="a";
      $l.="$j";
  
  if(isset($_POST["$l"]))
  {   
    $id=$tabfrom["$j"];
    $to=$_SESSION["id"]  ;
    $sql = "DELETE FROM post WHERE id_post='$id' ";
    if ($conn->query($sql) ==TRUE)
    {
        echo '<meta http-equiv="refresh" content="0"';
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