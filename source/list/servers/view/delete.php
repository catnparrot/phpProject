<?php
    // DB 연결
    $servername = "ServerName";
    $username = "UserName";
    $password = "Password1";
    $dbname = "dbname";

    // 데이터
    $table_name2 = "server_detail";
    $data = $_POST;       // POST로 전송된 데이터 받기
    $ids = array_keys($data);
    $id = $ids[0];

    // 데이터베이스 연결 생성
    $conn = new mysqli($servername, $username, $password, $dbname);

    // 연결 확인
    if ($conn->connect_error) {
        die("연결 실패: " . $conn->connect_error);
    }

    // MySQL 쿼리 실행
    $sql = "DELETE FROM $table_name2 WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        echo "삭제되었습니다.";
    } else {
        echo "에러 발생: " . $sql . "<br>" . $conn->error;
    }

    // DB 연결 종료
    $conn->close();

    exit;