<?php
    // DB 연결
    $servername = "ServerName";
    $username = "UserName";
    $password = "Password1";
    $dbname = "dbname";

    // 데이터
    $table_name = "companies";
    $data = $_POST;       // POST로 전송된 데이터 받기 (배열)
    $values = array_keys($data);
    $values_string = implode(", ", $values);

    // 데이터베이스 연결 생성
    $conn = new mysqli($servername, $username, $password, $dbname);

    // 연결 확인
    if ($conn->connect_error) {
        die("연결 실패: " . $conn->connect_error);
    }

    // MySQL 쿼리 실행
    $sql = "DELETE FROM $table_name WHERE id in ($values_string)";

    if ($conn->query($sql) === TRUE) {
        echo "삭제되었습니다.";
    } else {
        echo "에러 발생: " . $sql . "<br>" . $conn->error;
    }

    // DB 연결 종료
    $conn->close();

    exit;