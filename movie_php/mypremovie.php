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
.movielist {
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
        <h2>电影收藏夹</h2>
        <p>欢迎您,
        <?php 
            session_start();
            echo $_SESSION['name'];
        ?></p>
        <p><a href="./movies.php">返回首页</a>      <a href = "./profile.php">账号管理</a></p>
    </div>
    <div class="movielist">
        <?php
            $user = $_SESSION['name'];
            $conn = mysqli_connect("localhost","lab3","buaadbms","movieworld");
            if(!$conn){
                echo "<script> alert('连接数据库失败');history.go(-1); </script>";
            }else{
                $sql1 = "select movie_id from user_premovies natural join users where user_name='$user';";
                $result = mysqli_query($conn, $sql1);
                if(mysqli_num_rows($result) == 0){
                    echo "<p>还没有收藏过电影呢，快去首页看看吧~~";
                }else{
                    $ans = array();
                    $arr = array();
                    while($rs = mysqli_fetch_assoc($result)){ $arr[]=$rs;}
                    for($i = 0; $i < count($arr); $i++){
                        $ans[] = $arr[$i]["movie_id"];
                    }
                    for($i = 0; $i < count($ans); $i++){
                        $movieid = $ans[$i];
                        $sql_base = "select movie_picture ,movie_name, movie_score, movie_year from movies where movie_id = '$movieid';";
                        $sql_director = "select director_name from movie_director  natural join directors where movie_id='$movieid';";
                        $sql_writer = "select writer_name from movie_writer  natural join writers where movie_id='$movieid';";
                        $sql_actor = "select actor_name from movie_actor  natural join actors where movie_id='$movieid';";
                        $sql_type = "select type_name from movie_type  natural join types where movie_id='$movieid';";
                        $sql_area = "select area_name from movie_area  natural join areas where movie_id='$movieid';";
                        $result_base = mysqli_query($conn, $sql_base);
                        $result_director = mysqli_query($conn, $sql_director);
                        $result_writer = mysqli_query($conn, $sql_writer);
                        $result_actor = mysqli_query($conn, $sql_actor);
                        $result_type = mysqli_query($conn, $sql_type);
                        $result_area = mysqli_query($conn, $sql_area); 
                        echo "<table align=center border=1 width=80%>";
                        $rec = mysqli_fetch_array($result_base);
                        echo "<tr>";
                        echo "<td rowspan='7' width=240><img src=".$rec['movie_picture']."width=250 height=300></td>";
                        echo "<td>".$rec['movie_name']."  (".$rec["movie_year"].")";
                        echo "<form id='".$movieid."'action='./unlikemovie.php' method='post'><input type='hidden' name='movieid' value='".$movieid."'/><input type='hidden' name='username' value='".$_SESSION['name']."'><button onclick='javascript:document.getElementById(".$movieid.").submit();'>"."unlike!"."</button><input type='hidden' name='formsubmit' value='like'></form>";
                        echo "</td>";
                        echo "</tr>";
                        echo "<tr>";
                        echo "<td>"."score:".$rec['movie_score']."</td>";
                        echo "</tr>";
                        if(mysqli_num_rows($result_director) != 0){
                            echo "<tr>";
                            echo "<td>"."导演：";
                            while($rec = mysqli_fetch_array($result_director)){
                                echo $rec['director_name']." ";
                            }
                            echo "</td>";
                            echo "</tr>";
                        }
                        if(mysqli_num_rows($result_writer) != 0){
                            echo "<tr>";
                            echo "<td>"."编剧：";
                            while($rec = mysqli_fetch_array($result_writer)){
                                echo $rec['writer_name']." ";
                            }
                            echo "</td>";
                            echo "</tr>";
                        }
                        if(mysqli_num_rows($result_actor) != 0){
                            echo "<tr>";
                            echo "<td>"."演员：";
                            while($rec = mysqli_fetch_array($result_actor)){
                                echo $rec['actor_name']." ";
                            }
                            echo "</td>";
                            echo "</tr>";
                        }
                        if(mysqli_num_rows($result_type) != 0){
                            echo "<tr>";
                            echo "<td>"."类型：";
                            while($rec = mysqli_fetch_array($result_type)){
                                echo $rec['type_name']." ";
                            }
                            echo "</td>";
                            echo "</tr>";
                        }
                        if(mysqli_num_rows($result_area)!= 0){
                            echo "<tr>";
                            echo "<td>"."地区：";
                            while($rec = mysqli_fetch_array($result_area)){
                                echo $rec['area_name']." ";
                            }
                            echo "</td>";
                            echo "</tr>";
                        }
                        echo "</table>";    
                        echo "<br><br>";
                    }
                }
            }
        ?>
    </div>
    </body>
</html>