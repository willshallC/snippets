<?php


session_start();
$mail = $_SESSION['uid'];
$pswd = $_SESSION['pswd'];
require_once("connect.php");

if($conn->connect_error){
    die("Error Connecting to DataBase " . $conn->connect_error);
}
else{
    //selecting 

    $sql = "select F_Name,Mail,Pswrd,Reg from reg_tb where Mail='$mail'";

    $data = $conn->query($sql);
   // print_r($data);

    if($data->num_rows > 0){
        while($row = $data->fetch_assoc()){
            $mailB = $row['Mail'];
            $pswdB = $row['Pswrd'];
            $regas = $row['Reg'];   
            $fname = $row['F_Name'];
            

            $_SESSION['uid'] = $mailB;
            $_SESSION['pswd'] = $pswdB;
        }
        if($mail==$mailB && md5($pswd)== $pswdB){

            if($regas=='User'){
                echo "<h1 style='text-align:center'>WELCOME</h1>";
                echo "<h1 style='text-align:center'>{$fname}, You Logged In as {$regas}</h1>";
                echo "<a href='/dashboard.php' style='text-align:center'>View Dashboard</a>";
                echo "<a href='logout.php' style='text-align:center'>Click to Logout</a></br>";
            }
            if($regas=='Admin'){
                echo "<h1 style='text-align:center'>WELCOME</h1>";
                echo "<h1 style='text-align:center'>{$fname}, You Logged In as {$regas}</h1>";
                echo "<a href='#'>View Managers List</a></br>";
                echo "<a href='#'>View Team Leaders List</a></br>";
                echo "<a href='#'>View Employees List</a>";
                echo "<a href='/dashboard.php' style='text-align:center'>View Dashboard</a>";
                echo "<a href='logout.php' style='text-align:center'>Click to Logout</a></br>";
            }
            if($regas=='Manager'){
                echo "<h1 style='text-align:center'>WELCOME</h1>";
                echo "<h1 style='text-align:center'>{$fname}, You Logged In as {$regas}</h1>";
                echo "<a href='#'>View Managers List</a></br>";
                echo "<a href='#'>View Team Leaders List</a></br>";
                echo "<a href='/dashboard.php' style='text-align:center'>View Dashboard</a>";
                echo "<a href='logout.php' style='text-align:center'>Click to Logout</a></br>";
            }
            if($regas=='Team Leader'){
                echo "<h1 style='text-align:center'>WELCOME</h1>";
                echo "<h1 style='text-align:center'>{$fname}, You Logged In as {$regas}</h1>";
                echo "<a href='#'>View Employees List</a>";
                echo "<a href='/dashboard.php' style='text-align:center'>View Dashboard</a>";
                echo "<a href='logout.php' style='text-align:center'>Click to Logout</a></br>";
            }
            
        }
        else{
            echo "<h1>Email or Password is Incorrect</h1>";
        }
    }
    else {
        echo "<h1 style='text-align:center'>Error Registering</h1>";
    }
}


?>