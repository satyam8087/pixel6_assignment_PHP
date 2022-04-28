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
}?>
<?php 
$ip = $_SERVER['REMOTE_ADDR'];
//echo "your ip address is: ".$ip;
//inserting ip in db
$ip_query = "insert into counter(count) values ('$ip')";
mysqli_query($conn, $ip_query);
//counting ip
$q = "select * from counter";
$f= mysqli_query($conn, $q);
$count = mysqli_num_rows($f);
echo "Total visitors: ".$count;

?>
<!DOCTYPE html>
<html>
<head>
  <script>
if ( window.history.replaceState ) {
  window.history.replaceState( null, null, window.location.href );
}</script>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>List of animals.</title>
  <style>
    .styled-table {
    border-collapse: collapse;
    margin: 25px 0;
    font-size: 0.9em;
    font-family: sans-serif;
    width: 1350px;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);
}
.styled-table thead tr {
    background-color: #009879;
    color: #ffffff;
    text-align: left;
}
.styled-table th,
.styled-table td {
    padding: 12px 15px;
}
.styled-table tbody tr {
    border-bottom: 1px solid #dddddd;
}

.styled-table tbody tr:nth-of-type(even) {
    background-color: #f3f3f3;
}

.styled-table tbody tr:last-of-type {
    border-bottom: 2px solid #009879;
}
.styled-table tbody tr.active-row {
    font-weight: bold;
    color: #009879;
}
.search {
  width: 100%;
  position: relative;
  display: flex;
}

.searchTerm {
  width: 100%;
  border: 3px solid #00B4CC;
  border-right: none;
  padding: 5px;
  height: 10px;
  border-radius: 5px 0 0 5px;
  outline: none;
  color: #9DBFAF;
}

.searchTerm:focus{
  color: #00B4CC;
}



/*Resize the wrap to see the search bar change!*/
.wrap{
  width: 40%;
  position: absolute;
  top: 10%;
  left: 50%;
  transform: translate(-50%, -50%);
}




  </style>
</head>
<body>
<h1>List of animals</h1><br>

<form action="" method="POST">
<div>
<input type="text"  name="filter_value" id="myinput" placeholder="category and life">
      <input type="submit" value="Filter" name="filter_btn">
   </div>





<div>
  <table class="styled-table" id="mytable">
    <thead>
        <tr>
            <th >Name <input type="submit" value="sort" name="sort1_btn"></button></th> 
            <th>Photo</th>
            <th>Category</th>
            <th>Description</th>
            <th>Life expectancy</th>
            <th >Date and time <input type="submit" value="sort" name="sort2_btn"></th>
        </tr>
    </thead>
    <tbody>
    
        <?php
error_reporting(0);
        if(isset($_POST['filter_btn']))
          $value_filter = $_POST['filter_value'];
      $query = "SELECT * FROM listanimal WHERE CONCAT(category,life) LIKE '%$value_filter%'";
      $query_run = mysqli_query($conn, $query);
      if(mysqli_num_rows($query_run) > 0)
        {
          while($row = mysqli_fetch_array($query_run))
        {
          ?>
           <tr>
          <td> <?php echo $row['name']; ?> 
          <td> <img src="image/<?php echo $row['image'] ;  ?>" height = "100px" width = "100px" ></td>
          <td><?php echo $row['category'] ; ?> </td>
          <td><?php echo $row['description'] ; ?></td>
          <td><?php echo $row['life'] ; ?></td>
          <td><?php echo $row['Time'] ; ?></td>
        </tr>  
        <?php
        }
      }  elseif(isset($_POST['sort1_btn'])){
          $sql = "SELECT * FROM listanimal ORDER BY name DESC";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
           // output data of each row
           while($row1 = mysqli_fetch_array($result)) {
            ?>
             <tr>
          <td> <?php echo $row1['name']; ?> 
          <td> <img src="image/<?php echo $row1['image'] ;  ?>" height = "100px" width = "100px" ></td>
          <td><?php echo $row1['category'] ; ?> </td>
          <td><?php echo $row1['description'] ; ?></td>
          <td><?php echo $row1['life'] ; ?></td>
          <td><?php echo $row1['Time'] ; ?></td>
        </tr>  
        <?php
           }
         }elseif(isset($_POST['sort2_btn'])){
          $sql = "SELECT * FROM listanimal ORDER BY Time DESC";
            $result1 = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result1) > 0) {
           // output data of each row
           while($row2 = mysqli_fetch_array($result1)) {
            ?>
             <tr>
          <td> <?php echo $row2['name']; ?> 
          <td> <img src="image/<?php echo $row2['image'] ;  ?>" height = "100px" width = "100px" ></td>
          <td><?php echo $row2['category'] ; ?> </td>
          <td><?php echo $row2['description'] ; ?></td>
          <td><?php echo $row2['life'] ; ?></td>
          <td><?php echo $row2['Time'] ; ?></td>
        </tr>  
        <?php
           }
         }else
         {
          echo "NO data found";
         }
       }
     }
       ?>
    
       

       
           
            

       

        
    </tbody>
</table>
</div>
</form>




</body>
</html>