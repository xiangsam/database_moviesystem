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
.board, .movieselect {
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
button {
    background-color: whitesmoke;
    -webkit-transition-duration: 0.4s; /* Safari */
    transition-duration: 0.4s;
}
 
button:hover {
    background-color: red; /* Green */
    color: white;
}
</style>
    </head>
    <body>
        <div class="websitetitle">
            <h2>Movie World</h2>
            <p>欢迎您,
            <?php 
                session_start();
                echo $_SESSION['name'];
            ?></p>
            <p><a href="./mypremovie.php">电影收藏夹</a>      <a href = "./profile.php">账号管理</a>     <a href = "./movies.php">返回首页</a></p>
        </div>
        <div class="movieselect">
        <table border="1" width="100%">
            <tbody>
                <tr align="center"><td>搜索箱</td></tr>
            </tbody>
            <tbody>
                <tr>
                    <td>
                    <form action="./search.php" method="post">
                        <label>电影名称</label><input type="text" name="moviename">
                        <label>导演</label><input type="text" name="director">
                        <label>编剧</label><input type="text" name="writer">
                        <label>演员</label><input type="text" name="actor">
                        <label>类型</label><input type="text" name="type">
                        <label>地区</label><input type="text" name="area">
                        <input type="submit" name="formsubmit" value="搜索">
                    </form>
                    </td>
                </tr>
            </tbody>
            <tbody></tbody>
        </table>
        </div>
        <div class="board">
        <?php
            if(isset($_POST["formsubmit"]) && $_POST["formsubmit"] == "搜索")
            {
                $moviename = $_POST["moviename"];
                $director = $_POST["director"];
                $writer = $_POST["writer"];
                $actor = $_POST["actor"];
                $type = $_POST["type"];
                $area = $_POST["area"];
                if($moviename == "" && $director == "" && $writer == "" && $actor == "" && $type == "" && $area == ""){
                    echo "<script>alert('搜索内容不能为空'); history.go(-1);</script>";
                }
                else{
                    $conn = mysqli_connect("localhost","lab3","buaadbms","movieworld");
                    if(!$conn){
                        echo "<script> alert('连接数据库失败');history.go(-1); </script>";
                    }
                    if($moviename != ""){
                        $sql1 = "select movie_id from movies where movie_name='$moviename'";
                        $result1 = mysqli_query($conn, $sql1);
                        $num1 = mysqli_num_rows($result1);
                        if($num1){
                            $arr1 = array();
                            while($rs = mysqli_fetch_assoc($result1)){ $arr1[]=$rs;}
                        }
                    }
                    if($director != ""){
                        $sql2 = "select movie_id from directors natural join movie_director where director_name='$director'";
                        $result2 = mysqli_query($conn, $sql2);
                        $num2 = mysqli_num_rows($result2);
                        if($num2){
                            $arr2 = array();
                            while($rs = mysqli_fetch_assoc($result2)){ $arr2[]=$rs;}
                        }
                    }
                    if($writer != ""){
                        $sql3 = "select movie_id from writers natural join movie_writer where writer_name='$writer'";
                        $result3 = mysqli_query($conn, $sql3);
                        $num3 = mysqli_num_rows($result3);
                        if($num3){
                            $arr3 = array();
                            while($rs = mysqli_fetch_assoc($result3)){ $arr3[]=$rs;}
                        }
                    }
                    if($actor != ""){
                        $sql4 = "select movie_id from actors natural join movie_actor where actor_name='$actor'";
                        $result4 = mysqli_query($conn, $sql4);
                        $num4 = mysqli_num_rows($result4);
                        if($num4){
                            $arr4 = array();
                            while($rs = mysqli_fetch_assoc($result4)){ $arr4[]=$rs;}
                        }
                    }
                    if($type != ""){
                        $sql5 = "select movie_id from types natural join movie_type where type_name='$type'";
                        $result5 = mysqli_query($conn, $sql5);
                        $num5 = mysqli_num_rows($result5);
                        if($num5){
                            $arr5 = array();
                            while($rs = mysqli_fetch_assoc($result5)){ $arr5[]=$rs;}
                        }
                    }
                    if($area != ""){
                        $sql6 = "select movie_id from areas natural join movie_area where area_name='$area'";
                        $result6 = mysqli_query($conn, $sql6);
                        $num6 = mysqli_num_rows($result6);
                        if($num6){
                            $arr6 = array();
                            while($rs = mysqli_fetch_assoc($result6)){ $arr6[]=$rs;}
                        }                        
                    }  
                }
            }else{
                echo "<script>alert('提交未成功！'); history.go(-1);</script>";
            }
        ?>
        <?php
                  
            $idarr = array(array(),array(),array(),array(),array(),array());
            for($i = 0; $i < count($arr1); $i++){
                $idarr[0][] = $arr1[$i]["movie_id"];
            }
            for($i = 0; $i < count($arr2); $i++){
                $idarr[1][] = $arr2[$i]["movie_id"];
            }
            for($i = 0; $i < count($arr3); $i++){
                $idarr[2][] = $arr3[$i]["movie_id"];
            }
            for($i = 0; $i < count($arr4); $i++){
                $idarr[3][] = $arr4[$i]["movie_id"];
            }
            for($i = 0; $i < count($arr5); $i++){
                $idarr[4][] = $arr5[$i]["movie_id"];
            }
            for($i = 0; $i < count($arr6); $i++){
                $idarr[5][] = $arr6[$i]["movie_id"];
            }
            $index = array();
            for($i = 0; $i < 6; $i++){
                if(count($idarr[$i]) != 0){
                    $index[] = $i;
                }
            }
            $ans = $idarr[$index[0]];
            for($i = 1; $i < count($index); $i++){
                $ans = array_intersect($ans, $idarr[$index[$i]]);
            }
            $ans = array_values($ans);
            if(count($ans) == 0){
                echo "查找无结果，请尝试缩减限制条件并确认条件正确";
                echo "<p><a href='./movies.php'>"."返回"."</a></p>";
            }else{
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
                    echo "<form id='".$movieid."'action='./likemovie.php' method='post'><input type='hidden' name='movieid' value='".$movieid."'/><input type='hidden' name='username' value='".$_SESSION['name']."'><button onclick='javascript:document.getElementById(".$movieid.").submit();'>"."like!"."</button><input type='hidden' name='formsubmit' value='like'></form>";
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
        ?>
        </div>
    </body>
</html>