<?php 
    $conn = new mysqli("localhost", "root", "" , "app");

    // Check connection//
    if ($conn->connect_error)
    {
        die("Connection failed: " . $conn->connect_error);
    }

    session_start(); 
    if($_SESSION["id"]==NULL) header('location: authentification.php');
?>

<!DOCTYPE html>
<html>
<head>
<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">

<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
* {
    box-sizing: border-box;
}


h3 {
    text-align: center;
    margin-bottom: 20px;
    color: #fff;
}



/* form starting stylings ------------------------------- */
.group {
    position: relative;
    margin-bottom: 30px;
}

input {
    font-size: 18px;
    padding: 5px 10px 10px 5px;
    display: block;
    width: 100%;
    border: none;
    border-bottom: 1px solid #fff;
    background: transparent;
}

    input:focus {
        outline: none;
    }

/* LABEL ======================================= */
label {
    color: #fff;
    font-size: 18px;
    font-weight: normal;
    position: absolute;
    pointer-events: none;
    left: 5px;
    top: 10px;
    transition: 0.2s ease all;
    -moz-transition: 0.2s ease all;
    -webkit-transition: 0.2s ease all;
}

/* active state */
input:focus ~ label, input:valid ~ label {
    top: -10px;
    font-size: 14px;
    color: #fff;
}

/* BOTTOM BARS ================================= */
.bar {
    position: relative;
    display: block;
    width: 100%;
}

    .bar:before, .bar:after {
        content: '';
        height: 2px;
        width: 0;
        bottom: 1px;
        position: absolute;
        background: #fff;
        transition: 0.2s ease all;
        -moz-transition: 0.2s ease all;
        -webkit-transition: 0.2s ease all;
    }

    .bar:before {
        left: 50%;
    }

    .bar:after {
        right: 50%;
    }



/* active state */
input:focus ~ .bar:before, input:focus ~ .bar:after {
    width: 50%;
}

/* HIGHLIGHTER ================================== */
.highlight {
    position: absolute;
    height: 60%;
    width: 100px;
    top: 25%;
    left: 0;
    pointer-events: none;
    opacity: 0.5;
}

/* active state */
input:focus ~ .highlight {
    -webkit-animation: inputHighlighter 0.3s ease;
    -moz-animation: inputHighlighter 0.3s ease;
    animation: inputHighlighter 0.3s ease;
}

/* ANIMATIONS ================ */
@-webkit-keyframes inputHighlighter {
    from {
        background: #fff;
    }

    to {
        width: 0;
        background: transparent;
    }
}

@-moz-keyframes inputHighlighter {
    from {
        background: #fff;
    }

    to {
        width: 0;
        background: transparent;
    }
}

@keyframes inputHighlighter {
    from {
        background: #fff;
    }

    to {
        width: 0;
        background: transparent;
    }
}


#panel {
    border: 1px solid rgb(200, 200, 200);
    box-shadow: rgba(0, 0, 0, 0.1) 0px 5px 5px 2px;
    background: -webkit-linear-gradient(90deg, #2caab3 0%, #2c8cb3 100%);
    background: red; /* For browsers that do not support gradients */
    background: -webkit-linear-gradient(90deg, #2caab3 0%, #2c8cb3 100%); /* For Safari 5.1 to 6.0 */
    background: -o-linear-gradient(90deg, #2caab3 0%, #2c8cb3 100%); /* For Opera 11.1 to 12.0 */
    background: -moz-linear-gradient(90deg, #2caab3 0%, #2c8cb3 100%); /* For Firefox 3.6 to 15 */
    background: linear-gradient(90deg, #2caab3 0%, #2c8cb3 100%); /* Standard syntax (must be last) */
    
    
    border-radius: 4px;
    top: 20px;
}
.aa button
{
    width:100%;
}
</style>
</head>
<body>

<!------ Include the above in your HEAD tag ---------->


<div class="container">
<a style="float:right;" href="index.php"><center> <button  class="btn btn-primary"> retourner vers votre compte <span class="glyphicon glyphicon-user"></span></button></center></a>
    <?php
        $from=$_SESSION["id"]  ;
        $to=$_GET["id_profile"]  ;
    ?>

    <div class="col-lg-offset-3 col-lg-6" id="panel">
        <h3>Discuter avec <span style="color:orange;font-size:22px;font-family: cursive;"> 
                <?php $reponse2=$conn->query("SELECT pseudo FROM user WHERE iduser='$to'");
                while( $data = $reponse2->fetch_assoc()){ echo strtoupper($data['pseudo']);} ?></span></h3>

<!-- affichage des messgaes precedents -->
    <span>

        
        <?php 
            $reponse3=$conn->query("SELECT * FROM user,message WHERE iduser=id_from && ((id_from='$from' && id_to='$to')||( id_from='$to' && id_to='$from' ))");
            while( $data = $reponse3->fetch_assoc())
            { ?>
                <span style="color:orange;font-size:22px;font-family: cursive;">
                    <?php 
                        if($data['id_from']==$to){
                            if($data['vu']=='0'){
                                $id_message=$data['id_message'];    
                                $sqlll ="UPDATE message SET vu = '1' WHERE id_message = '$id_message'";
  
                                if ($conn->query($sqlll) ==TRUE)
                                {
                                     
                                } 
                                else 
                                {
                                    echo "Error: " . $sqlll . "<br>" . $conn->error;
                                }

                            }    
                            echo strtoupper($data['pseudo']) . ":" ;
                        }else{
                            echo 'Vous : ' ;
                        }
                             
                    ?>
                </span>
                <span style="color:black;font-size:20px;font-family: cursive;opacity:<?php if($data['vu']=='1' && $data['id_from']==$to ){ echo 0.5 ;}else{echo 1 ;}?>;">
                    <?php 
                        echo $data['message']  ;
                        if($data['photo_message']!=NULL){ ?>
                            <br>
                            <center>
                                <img style="border:2px solid lightblue;border-radius:5px;height:200px;width:200px;" src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($data['photo_message']); ?>" /> 
                            </center>
                            
                            
                         <?php } ?>
                         </span>
                         <br>
                         <span style="position:absolute;right:10px;font-size:15px;">
                         <?php if($data['id_from']==$from) { ?>
                         | <i   class="fas <?php if($data['vu']=='1'){ echo 'fa-eye' ;}else{echo 'fa-eye-slash' ;}?>"></i> |
                         <?php } ?>
                         
                          <?php echo  $data['date']  ; ?> </span>
                         <br>
                    
                

            <?php } ?>  

    
    </span>


        <form method="POST"  enctype="multipart/form-data">


            <div class="group">
                <input type="text" name="message" required>
                
                <span class="highlight"></span>
                <span class="bar"></span>
                <label>Message</label>
                <br>
                <input type="file" name="photo_message" >
            </div>
            <div class="group">
                <center> <button type="submit" name="submit" class="btn btn-warning">Send <span class="glyphicon glyphicon-send"></span></button></center>
            </div>
        </form>
            
            
<?php


//------------------------------
$statusMsg='';
if(isset($_POST["submit"])){ 
    $from=$_SESSION["id"]  ;
    $to=$_GET["id_profile"]  ;
    $sql0 = "DELETE FROM message WHERE (id_from='$from' && id_to='$to')||( id_from='$to' && id_to='$from' )";
                            
    if ($conn->query($sql0) ==TRUE)
    {
         

    $message=$_POST["message"]  ;
    

    if(empty($_FILES["photo_message"]["name"])) {
        $sql = "INSERT INTO message (message, id_from , id_to , date )
    VALUES ( '$message' , '$from' ,'$to', NOW() )";
                            
        if ($conn->query($sql) ==TRUE)
        {
            $statusMsg = "Votre message a eté envoyer avec succès";           
        
        } 
        else 
        {
            $statusMsg = "L'envoi du message a échoué, veuillez réessayer."; 
        }
    }
    if(!empty($_FILES["photo_message"]["name"])) { 
        // Get file info 
        $fileName = basename($_FILES["photo_message"]["name"]); 
        $fileType = pathinfo($fileName, PATHINFO_EXTENSION); 
         
        // Allow certain file formats 
        $allowTypes = array('jpg','png','jpeg','gif'); 
        if(in_array(strtolower($fileType), $allowTypes)){ 
            $image = $_FILES['photo_message']['tmp_name']; 
            $imgContent = addslashes(file_get_contents($image)); 
         
            // Insert image content into database 
            $sql = "INSERT INTO message (message, id_from , id_to, photo_message , date )
    VALUES ( '$message' , '$from' ,'$to','$imgContent', NOW() )";
             
            if($conn->query($sql) ==TRUE){ 
                
                $statusMsg = "Votre photo et message ont eté envoyer avec succès";
                
            }else{ 
                $statusMsg = "Le téléchargement du fichier a échoué, veuillez réessayer."; 
            }  
        }else{ 
            $statusMsg = 'Désolé, seuls les fichiers JPG, JPEG, PNG et GIF sont autorisés à télécharger.'; 
        } 
    }
} 
}
//------------------------------
// Display status message 
if($statusMsg!=''){
?>
            <center> 
              <div  class="alert alert-info" > <?php echo $statusMsg ;?>   
              </div></center>
                      
<?php 
        echo '<meta http-equiv="refresh" content="1"';
} ?>





<br>
    </div>
    
</div>































</body>
</html>
