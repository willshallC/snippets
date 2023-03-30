<?php
session_start();
if(isset($_SESSION['uid'])){
    include_once("headpage.php");
    include_once("menu.php");
    require_once("connect.php");

    //selecting Managers
    $sql = "select * from reg_tb where Reg='Team Leader' order by F_Name";

    $data = $conn->query($sql);

    if($data->num_rows>0){
        echo "<h1>Team Leaders</h1>"; ?>
        <table border="1px solid">
        <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Age</th>
                <th>E-mail</th>
                <th>Gender</th>
                <th>Action</th>
            </tr>

        <?php
        while($row = $data->fetch_assoc()){?>

        
            
            <tr>
                <td><?php echo $row['id']?></td>
                <td><?php echo $row['F_Name']?></td>
                <td><?php echo $row['L_Name']?></td>
                <td><?php echo $row['Age']?></td>
                <td><?php echo $row['Mail']?></td>
                <td><?php echo $row['Gender']?></td>
                <td><a href="/php-site/changeU.php?id=<?php echo $row['id']?>" id="<?php echo $row['id']?>">Edit</a>/<a href="/php-site/deleteU.php?id=<?php echo $row['id']?>" id="<?php echo $row['id']?>">Delete</a></td>
            </tr>
        
        <?php
        }?>
        </table>
        <?php

        include_once("footer.php");
    }
}
else{
    header("location:/php-site/login.php");
}

?>