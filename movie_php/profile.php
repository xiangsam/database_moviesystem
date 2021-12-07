<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <style>
.websitetitle {
    background-color:black;
    color:white;
    margin:20px;
    padding:20px;
}
.profile {
    background-color:whitesmoke;
    color:black;
    margin:20px;
    padding:20px;
}
table {
    border: black 1px solid;
    border-collapse: collapse;
}
th {
    border: black 1px solid;
    font-style: italic;
    font-family: sans-serif;
}

td {
    border: black 1px solid;
    text-align: center;
    text-align-last: center;
}
label {
    display: inline-block;
    width: 70px;
    text-align: justify;
    text-align-last: justify;
    margin-right: 10px;
}
        </style>
    </head>
    <body>
    <div class="websitetitle">
        <h2>账号管理</h2>
        <p>欢迎您,
        <?php 
            session_start();
            echo $_SESSION['name'];
        ?></p>
        <p><a href="./mypremovie.php">电影收藏夹</a>      <a href = "./movies.php">返回首页</a></p>
    </div>
    <div class="profile">
        <form action='<?php echo $_SERVER['PHP_SELF'];?>' method='POST' align=center>
        <?php
            $user = $_SESSION['name'];
            $conn = mysqli_connect("localhost","lab3","buaadbms","movieworld");
            if(!$conn){
                echo "<script> alert('连接数据库失败');history.go(-1); </script>";
            }else{
                $sql = "select * from users where user_name = '$user'";
                $result = mysqli_query($conn, $sql);
                if(mysqli_num_rows($result) != 1){
                    echo "Oops~似乎除了点问题，请联系管理员";
                }
                $arr = mysqli_fetch_array($result);
                echo "<label>&nbsp用户名:</label><input type='text' name='username' value='".$arr['user_name']."' readonly><br>";
                echo "<label>&nbsp邮&nbsp箱:</label><input type='text' name='email' value='".$arr['user_email']."' readonly><br>";
                echo "<label>&nbsp新密码:</label><input type='text' name='pwd'><br>";
                echo "<label>确认密码:</label><input type='text' name='pwd2'><br>";
                echo "<input type='submit' name='formsubmit' value='提交修改'>";
                echo "</form>";
            }
        ?>
        <?php
            if(isset($_POST['formsubmit']) && $_POST['formsubmit'] == "提交修改"){
                $user = $_POST['username'];
                $email = $_POST['email'];
                $pwd = $_POST['pwd'];
                $pwd2 = $_POST['pwd2'];
                if($pwd2 == '' || $pwd2 == ''){
                    echo "<script> alert('密码不能为空，修改失败'); </script>";
                }else if($pwd2 != $pwd){
                    echo "<script> alert('两次密码不一致，修改失败'); </script>";
                }else{
                    $sql2 = "update users set user_password='$pwd' where user_name='$user';";
                    $result = mysqli_query($conn,$sql2);
                    if($result === false){
                        echo "<script> alert(`exec error:".mysqli_error($conn)."`); </script>";
                    }else{
                        echo "<script> alert('密码修改成功'); </script>";
                    }
                }
            }
        ?>
    </div>
    </body>
</html>