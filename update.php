<?php
session_start();
if(isset($_SESSION['uid'])){
    include_once("headpage.php");
    include_once("menu.php");
    require_once("connect.php");

    //update

    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $age = $_POST['age'];
    $mail = $_POST['mail'];
    $reg = $_POST['regas'];
    $id = $_POST['id'];
    echo $img = $_FILES['img']['name'];
    echo $temp_name = $_FILES['img']['tmp_name'];

    $sql = "update reg_tb set F_Name='$fname', L_Name='$lname', Age='$age', Mail='$mail', Reg='$reg', img='$img' where id='$id'";
    move_uploaded_file($temp_name, "./imgs/".$img);
    if($conn->query($sql)==true){
        echo "<h1>Data Updated</h1>";
    }
    else{
        echo "<h1 style='color:red'>Something Went Wrong</h1>";
    }
    echo "<a href='logout.php' style='text-align:center'>Click to Logout</a></br>";

    include_once("footer.php");

}
else{
    header("location:/php-site/login.php");
}
?>