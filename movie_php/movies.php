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
.movieselect {
    background-color:whitesmoke;
    color:black;
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
        <p><a href="./mypremovie.php">电影收藏夹</a>      <a href = "./profile.php">账号管理</a></p>
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
    <div class="movielist">
        <h3 align=center>IMDB Top250 movies</h3>
        <?php
            $conn = mysqli_connect("localhost","lab3","buaadbms","movieworld");
            if(!$conn){
                echo "Oops~ 连接数据库失败";
            }
            $sql = "select * from movies order by movie_rank;";
            $result = mysqli_query($conn,$sql);
            if($result === false){
                echo "exec error:".mysqli_error($conn);
            }
            else{
                echo "<table align=center border=1 width=80% frame=void>";
                $field_count=mysqli_num_fields($result);
                echo "</tr>";
                
                echo "<th>" ."图片". "</th>";
                echo "<th>" ."名称". "</th>";
                echo "<th>" . "排名" . "</th>";
                echo "<th>" . "评分". "</th>";
                echo "<th>" . "上映时间" . "</th>";

                echo "</tr>";
                while($rec=mysqli_fetch_array($result)){
                    echo "<tr>";
                    
                    $picture = mysqli_fetch_field_direct($result,4);
                    echo "<td width=45><img src=".$rec[$picture->name]."width=45 height=67></td>";
                    $moviename = mysqli_fetch_field_direct($result,1);
                    $movieid =  mysqli_fetch_field_direct($result,0);
                    echo "<td><form id='".$rec[$movieid->name]."'action='./search.php' method='post'><input type='hidden' name='moviename' value='".$rec[$moviename->name]."'/><a href='javascript:document.getElementById(".$rec[$movieid->name].").submit();'>".$rec[$moviename->name]."</a><input type='hidden' name='formsubmit' value='搜索'></form></td>";
                    $rank = mysqli_fetch_field_direct($result,2);
                    echo "<td>".$rec[$rank->name]."</td>";
                    $score = mysqli_fetch_field_direct($result,3);
                    echo "<td>".$rec[$score->name]."</td>";
                    $year = mysqli_fetch_field_direct($result,5);
                    echo "<td>".$rec[$year->name]."</td>";
                    echo "<td><form id='".$rec[$rank->name]."'action='./likemovie.php' method='post'><input type='hidden' name='movieid' value='".$rec[$movieid->name]."'/><input type='hidden' name='username' value='".$_SESSION['name']."'><button onclick='javascript:document.getElementById(".$rec[$rank->name].").submit();'>"."like!"."</button><input type='hidden' name='formsubmit' value='like'></form></td>";
                    echo "</tr>";
                }
                echo "</table>";
            }
        ?>
    </div>
    </body>
</html>