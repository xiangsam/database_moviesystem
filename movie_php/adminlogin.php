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
.login {
    background-color:whitesmoke;
    color:black;
    margin:20px;
    padding:20px;
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
        <h2>Movies World</h2>
        <p>管理员系统</p>
    </div>
    <div class="login">
        <center>
            <h3>登录</h3>
            <p>亲爱的管理员，请登陆</p>
            <form action="./adminlogincheck.php" method="post">
                <label>用户名:</label><input type="text" name="adminname">
                <br>
                <label>密&nbsp码:</label><input type="text" name="adminpassword">
                <br>
                <input type="submit" name="formsubmit" value="登录">
            </form>
        </center>
    </div>

</body>
</html>