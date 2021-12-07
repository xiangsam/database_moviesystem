<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
<style>
.websitetitle {
    background-color:darkmagenta;
    color:white;
    margin:20px;
    padding:20px;
}
.queryboard {
    background-color:whitesmoke;
    color:black;
    margin:20px;
    padding:20px;
}
 
</style>
</head>
<body>
    <div class="websitetitle">
        <h2>管理员系统</h2>
        <p>欢迎您,
        <?php 
            session_start();
            echo $_SESSION['name'];
        ?></p>
        <p><a href="./login.php">返回</a></p>
    </div>
    <center>
    <div class="queryboard">
        <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
            <textarea row="10" cols="100" name="item" placeholder="SQL语句"></textarea>
            <br>
            <input type="submit" name="formsubmit" value="执行">
        </form>
        <p>执行结果</p>
        <p>
            <?php
                if(isset($_POST["formsubmit"])){
                    $item=$_POST["item"];
                    $conn = mysqli_connect("localhost","lab3","buaadbms","movieworld");
                    if(!$conn){
                        echo "<script> alert('连接数据库失败');history.go(-1); </script>";
                    }
                    $result = mysqli_query($conn,$item);
                    if($result === false){
                        echo "exec error:".mysqli_error($conn);
                    }
                    else{
                        if(strcasecmp(substr($item,0,6),"select")==0){
                            echo "<table border=1>";
                            $field_count=mysqli_num_fields($result);
                            for($i=0;$i<$field_count;++$i) {
                                $field_info = mysqli_fetch_field_direct($result,$i);
                                echo "<td>" . $field_info->name . "</td>>";
                            }
                            echo "</tr>";
                            while($rec=mysqli_fetch_array($result)){
                                echo "<tr>";
                                for ($i=0;$i<$field_count;++$i){
                                    $field_info = mysqli_fetch_field_direct($result,$i);
                                    echo "<td>". $rec[$field_info->name] . "</td>";
                                }
                                echo "</tr>";
                            }
                            echo "</table>";
                        }
                        else{
                            print("\nSuccessful!");
                        }
                    } 
                } 
            ?>
        </p>
    </div>
    </center>

</body>
</html>