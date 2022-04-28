
<!-- Starting of submission.php code in HTML, CSS, PHP-->

<!DOCTYPE html>  
<html>  
<head>  
  <script>
if ( window.history.replaceState ) {
  window.history.replaceState( null, null, window.location.href );
}
</script>
  <title>Submission of animal information</title>
<meta name="viewport" content="width=device-width, initial-scale=1"> 


<!-- ........CSS Start............. -->
    
<style>  
body{  
  font-family: Calibri, Helvetica, sans-serif;  
  background-color: pink;
}  
.container {  
    padding: 50px;  
  background-color: lightblue;  
  
}   
input[type=text], input[type=image],  textarea {  
  width: 50%;  
  padding: 15px;  
  margin: 5px 0 22px 0;  
  display: inline-block;  
  border: none;  
  background: #f1f1f1;  
}  
input[type=text]:focus, {  
  background-color: orange;  
  outline: none;  
}  
 div {  
            padding: 10px 0;  
         }  
hr {  
  border: 1px solid #f1f1f1;  
  margin-bottom: 25px;  
}  
input[type=Submit] {  
  background-color: #4CAF50;  
  color: white;  
  padding: 16px 20px;  
  margin: 8px 0;  
  border: none;  
  cursor: pointer;  
  width: 20%;  
  opacity: 0.9;  
}  
input[type=Reset] {  
  background-color: #ff0000;  
  color: white;  
  padding: 16px 20px;  
  margin: 8px 0;  
  border: none;  
  cursor: pointer;  
  width: 20%;  
  opacity: 0.9;  
}  
</style> 
<!-- ..............CSS end..................... -->








</head>  
<body>  

<form action="submission.php" method="post" enctype="multipart/form-data"> 

  <div class="container">  

    
   <h1> Submit animal information</h1> <!-- Headline of the form-->
     
    
   <script src="https://www.google.com/recaptcha/api.js" async defer></script>  <!-- Declration of Recaptcha script-->
  <hr>  

<!-- Enter name of the animal section-->
  <div>
    <label for="name" style="font-weight: bold ; "> Name of the animal: </label>  <br> 
    <input type="text" name="animalname" id="animalname" placeholder= " Enter name of the animal" size="15" required />
  </div>
<!-- End Section-->

<!-- category of the animal section-->
  <div>  
    <label for="category" style="font-weight: bold ;">Category: </label><br>  
    <input type="radio" id="Herbivores" value="Herbivores" name="types" required> Herbivores <br>
    <input type="radio" id="Omnivores" value="Omnivores" name="types"> Omnivores   <br>
    <input type="radio" id="Carnivores" value="Carnivores" name="types"> Carnivores  <br>
  </div>  
<!--End Section-->

<!--Upload image of animal section-->
  <div>
    <label for="image"style="font-weight: bold ; ">Upload animal image:</label><br><br>
    <input type="file" id="image" name="image" accept="image/png, image/jpeg, image/jpg," value="", required> <p style="color: red;">Note: only "PNG", "JPEG", "JPG" file accepted</p>
  </div>
<!--End Section-->

<!--Description section-->
  <div>
    <label for="Description" style="font-weight: bold ; ">Description:</label>  <br>
    <textarea placeholder="Enter Description of animal" rows="5" cols="50"  id="Description" name="Description" required></textarea>
  </div>
<!--End Section-->

<!--Life expectancy section-->   
  <div>
    <label for="Life">Life expectancy:</label><br>
    <select name="life" id="life">
    <option value="0 - 1 Years">0 - 1 Years</option>
    <option value="1 - 5 Years">1 - 5 Years</option>
    <option value="5 - 10 Years">5 - 10 Years</option>
    <option value="10+ years">10+ years</option>
    </select>
  </div>   <br>
<!--End Section-->

<!-- Google recaptcha section-->
  <div class="g-recaptcha" data-sitekey="6Leql6AfAAAAAOXOs0M7UYE62UZWT0GdcD2a10f2">
  </div>
<!--End Section-->  

<!--Submit and Clear--> 
  <input type="Submit" name="Submit"> <input type="Reset" name="Reset">
<!--End Section-->


</form>  
</body>  
</html>  


<!--Php code for Recaptcha-->
<?php 
if (isset($_POST['Submit'])) {
    $recaptcha = $_POST['g-recaptcha-response'];
    $secret_key = '6Leql6AfAAAAAM0qC2EZphRJh2TpIzolcsE9GyXc';
    $url = 'https://www.google.com/recaptcha/api/siteverify?secret='
          . $secret_key . '&response=' . $recaptcha;
          $response = file_get_contents($url);
          $response = json_decode($response);
           if ($response->success == true) {
        //echo '<script>alert("Google reCAPTACHA verified")</script>';
    } else {
        echo 'Error in recaptcha';
    }
  }
?>
<!--End of recaptcha code-->

<!--PHP database connection-->
<?php
$servername = 'localhost';
$username="root";
$password="";
$dbname= "animals";

$conn= new mysqli($servername,$username,$password,$dbname);

if($conn->connect_error) 
{
  echo "Something went wrong". $conn->connect_error;
}
else
{
  //echo "connected succssfully";
}
//-----Connection end---------

//---PHP SQL code for insert data into database----
if (isset($_POST['Submit'], $_FILES['image']))
{
    $name=$_POST['animalname'];
    $category=$_POST['types'];
    $filename = $_FILES['image']['name'];
    $filetmp = $_FILES['image']['tmp_name'];
    $discription = $_POST['Description'];
    $life = $_POST['life'];


    $vali = "select * from listanimal where name = '$name'";

    $result = mysqli_query($conn, $vali);

    $num = mysqli_num_rows($result);

    if($num == 1)
    {
      echo "<script> window.open('submission.php')</script>";
      echo "<script> alert('Animal is already in list') </script>";
    }

    else
    {
    $sql= "insert into listanimal(name,category,image,description,life)values('$name','$category', '$filename', '$discription', '$life')";

    mysqli_query($conn,$sql);

    move_uploaded_file($filetmp, "image/". $filename);

      //echo "<script> alert('Animal register successfully') </script>";
      //echo "<script> window.open('animals.php')</script>";
    echo ("<script LANGUAGE='JavaScript'>
    window.alert('Succesfully Updated');
    window.location.href='animals.php';
    </script>");

}
}


?>