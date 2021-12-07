<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <?php
            if(isset($_POST["formsubmit"]) && $_POST["formsubmit"]=="like")
            {
                $username = $_POST["username"];
                $movieid = $_POST["movieid"];
                $conn = mysqli_connect("localhost","lab3","buaadbms","movieworld");
                if(!$conn){
                    echo "<script> alert('连接数据库失败');history.go(-1); </script>";
                }
                $sql1 = "select user_id from users where user_name='$username';";
                $result = mysqli_query($conn, $sql1);
                $arr1 = mysqli_fetch_array($result);
                $userid = $arr1['user_id'];
                $sql2 = "insert into user_premovies values('$userid', '$movieid');";
                $result = mysqli_query($conn, $sql2);
                if($result === false){
                    echo "<script> alert(`exec error:".mysqli_error($conn)."`); location.href='movies.php';</script>";
                }else{
                    echo "<script> alert('收藏成功!');location.href='movies.php';</script>";
                }
            }else{
                echo "<script>alert('提交未成功！'); location.href='movies.php';</script>";
            }
        ?>
    </head>
</html>