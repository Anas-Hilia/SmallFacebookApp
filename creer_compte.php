<?php
    $existe='0';
    // Create connection//
    $conn = new mysqli("localhost", "root", "" , "app");

    // Check connection//
    if ($conn->connect_error)
    {
        die("Connection failed: " . $conn->connect_error);
    }




//------------------------------
$statusMsg='';
if(isset($_POST["submit"])){ 

    $status = 'error';
    $nom=$_POST["nom"]  ;
    $prenom=$_POST["prenom"]  ;
    $pass=$_POST["pass"]  ;
    $pseudo=$_POST["pseudo"]  ;
    //on evite d'avoir deux comptes qui portent le mm pseudo
    
    $reponse=$conn->query("SELECT * FROM user ");
    while($existe=="0" && $dataa = $reponse->fetch_assoc() ){
        if($dataa['pseudo']==$pseudo){
            $existe="1";
            break;
        }
        
        
    }

    if($existe=='0'){
    if(empty($_FILES["photo_profile"]["name"])) {
        $sql = "INSERT INTO user (nom , prenom , pseudo , mot_de_passe)
        VALUES ( '$nom' , '$prenom' ,'$pseudo', '$pass')";
                            
        if ($conn->query($sql) ==TRUE)
        {
            header('Location: authentification.php');            
        } 
        else 
        {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
    if(!empty($_FILES["photo_profile"]["name"])) { 
        // Get file info 
        $fileName = basename($_FILES["photo_profile"]["name"]); 
        $fileType = pathinfo($fileName, PATHINFO_EXTENSION); 
         
        // Allow certain file formats 
        $allowTypes = array('jpg','png','jpeg','gif'); 
        if(in_array(strtolower($fileType), $allowTypes)){ 
            $image = $_FILES['photo_profile']['tmp_name']; 
            $imgContent = addslashes(file_get_contents($image)); 
         
            // Insert image content into database 
            $sql = "INSERT INTO user (nom , prenom , pseudo , mot_de_passe , photo_profile)
            VALUES ( '$nom' , '$prenom' ,'$pseudo', '$pass','$imgContent')"; 
             
            if($conn->query($sql) ==TRUE){ 
                $status = 'success'; 
                $statusMsg = "File uploaded successfully.";
                header('Location: authentification.php');  
            }else{ 
                $statusMsg = "File upload failed, please try again."; 
            }  
        }else{ 
            $statusMsg = 'Sorry, only JPG, JPEG, PNG, & GIF files are allowed to upload.'; 
        } 
    }
    }
} 
 
 
?>

<!-- //------------------------------ -->



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sign Up Form by Colorlib</title>

    <!-- Font Icon -->
    <link rel="stylesheet" href="fonts/material-icon/css/material-design-iconic-font.min.css">
    
    <!-- Main css -->
    <link rel="stylesheet" href="css/style.css">
    
</head>
<body>

    <div class="main"  style="padding-top:20px">

        <!-- Sign up form -->
        <section class="signup">
            <div class="container">
                <div class="signup-content">
                    <div class="signup-form">
                        <h2 class="form-title">Sign up</h2>
                        <form method="POST" class="register-form" id="register-form"  enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="name"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                <input type="text" name="nom" id="lname" placeholder="Votre Nom"/>
                            </div>
                            <div class="form-group">
                                <label for="name"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                <input type="text" name="prenom" id="fname" placeholder="Votre Prenom"/>
                            </div>
                            <div class="form-group">
                            <label for="name"><i class="zmdi zmdi-face"></i></label>
                            <input type="text" name="pseudo" id="Pseudo" placeholder="Votre Pseudo"/>
                            </div>
                            <div class="form-group">
                                <label for="pass"><i class="zmdi zmdi-lock"></i></label>
                                <input type="password" name="pass" id="pass" placeholder="Mot de passe"/>
                            </div>
                            <div class="form-group">
                                <label for="photo_profile"><i class="zmdi zmdi-image"></i></label>
                                <input type="file" name="photo_profile" id="pass" />
                            </div>
                            <?php if($existe=='1'){?>
                                <center> 
                                    <div style="font-size:15px;color:red;" class="alert alert-warnning" >
                                        Un compte existe déja avec ce pseudo .. veuillez saisir un nouveau et merci .
                                    </div>
                                </center>
                            <?php }?>
                            <?php 
                            // Display status message
                            if($statusMsg!=''){ ?>
                                <center> 
                                    <div style="color:blue;" class="alert alert-info" > <?php echo $statusMsg ;?>   </div>
                                </center>
                          
                            <?php }?>


                            <div class="form-group form-button">
                                <input type="submit" name="submit" id="signup" class="form-submit" value="Enregistrer"/>
                            
                            </div>
                            
                        </form>
                    </div>
                    <div class="signup-image">
                        <figure><img src="images/signup-image.jpg" alt="sing up image"></figure>
                        <a href="authentification.php" class="signup-image-link">j'ai déja un compte</a>
                    </div>
                </div>
            </div>
        </section>

    </div>

    <!-- JS -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="js/main.js"></script>

    








</body>
</html>