<?php
// // 현재 페이지의 URL을 가져옵니다.
// $current_url = $_SERVER['REQUEST_URI'];

// // 현재 페이지의 디렉토리 경로를 추출합니다.
// $directory = dirname($current_url);


// if(!empty($_SERVER["HTTP_X_REQUESTED_WITH"]) && 
//     strtolower($_SERVER["HTTP_X_REQUESTED_WITH"]) === "xmlhttprequest") {
//     $result = json_encode($result);
//     echo $result;

    // DB 연결
    $servername = "ServerName";
    $username = "UserName";
    $password = "Password1";
    $dbname = "dbname";

    // POST로 전송된 데이터 받기
    $id = $_POST['id'];
    $column = $_POST['column'];
    $getText = $_POST['newText'];

    if(!$getText) { $newText = "NULL"; } else { $newText = "\"" . $getText . "\""; }

    // 데이터베이스 연결 생성
    $conn = new mysqli($servername, $username, $password, $dbname);

    // 연결 확인
    if ($conn->connect_error) {
        die("연결 실패: " . $conn->connect_error);
    }

    // MySQL 업데이트 쿼리 실행
    $sql = "UPDATE servers SET $column = $newText WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(array("result" => "데이터가 업데이트되었습니다."));
    } else {
        echo json_encode(array("error" => $conn->error));
    }

    $conn->close();

    exit;

// }
// else {
//     echo "access deny";
//     // $result = $_SERVER['HTTP_X_REQUESTED_WITH'];
//     // echo $result;
// //    header("Location: ".$directory);
// }