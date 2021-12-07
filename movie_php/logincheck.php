<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <?php
            if(isset($_POST["formsubmit"]) && $_POST["formsubmit"]=="登录")
            {
                $user = $_POST["username"];
                $pwd = $_POST["password"];
                if($user == "" || $pwd == ""){
                    echo "<script> alert('用户名与密码不能为空');history.go(-1);</script>";
                }else{
                    $conn = mysqli_connect("localhost","lab3","buaadbms","movieworld");
                    if(!$conn){
                        echo "<script> alert('连接数据库失败');history.go(-1); </script>";
                    }
                    $sql = "select * from users where user_name='$user' and user_password='$pwd';";
                    $result = mysqli_query($conn, $sql);
                    $num = mysqli_num_rows($result);
                    if($num){
                        session_start();
                        $_SESSION['name']=$user;
                        header("Location:movies.php");
                    }else{
                        echo "<script>alert('用户名或密码不正确！');  history.go(-1); </script>";
                    }
                }
            }else{
                echo "<script>alert('提交未成功！'); history.go(-1);</script>";
            }
        ?>
    </head>
</html>