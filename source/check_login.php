<?php
session_start();
// DB 연결
$servername = "ServerName";
$username = "UserName";
$password = "Password1";
$dbname = "dbname";

$conn = new mysqli($servername, $username, $password, $dbname); //db 연결

// 연결 확인
if ($conn->connect_error) {
    die("연결 실패: " . $conn->connect_error);
}

//login.php에서 입력받은 id, password
$username = $_POST['id'];
$userpass = $_POST['pw'];

$sql = "SELECT * FROM member WHERE id = '$username' AND passwd = '$userpass'";
$result = $conn->query($sql);
if($result) {
    $row = $result->fetch_array(MYSQLI_ASSOC);
}
$conn->close();

//결과가 존재하면 세션 생성
if ($row != null) {
    $_SESSION['username'] = $row['id'];
    $_SESSION['name'] = $row['name'];
    echo "<script>location.replace('index.php');</script>";
    exit;
}

//결과가 존재하지 않으면 로그인 실패
if($row == null){
    echo "<script>alert('Invalid username or password')</script>";
    echo "<script>location.replace('login.php');</script>";
    exit;
}
