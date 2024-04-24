<?php
    // DB 연결
    $servername = "ServerName";
    $username = "UserName";
    $password = "Password1";
    $dbname = "dbname";

    $array = $_POST;
    $keyarray = [];
    $valuearray = [];

    foreach ($array as $key => $value) {
        if ($value) {
            array_push($keyarray, $key);
            array_push($valuearray, $value);
        }
    }

    $column_string = implode(", ", $keyarray);
    $quoted_values = array_map(function($value_item) {
        return '"' . $value_item . '"';
    }, $valuearray);
    $value_string = implode(", ", $quoted_values);

    // 데이터베이스 연결 생성
    $conn = new mysqli($servername, $username, $password, $dbname);

    // 연결 확인
    if ($conn->connect_error) {
        die("연결 실패: " . $conn->connect_error);
    }

    // MySQL 업데이트 쿼리 실행
    $sql = "INSERT INTO companies ( $column_string ) VALUES ( $value_string )";
    
    if ($conn->query($sql) === TRUE) {
        echo json_encode(array("result" => "새 고객사 목록이 생성되었습니다."));
    } else {
        echo json_encode(array("error" => $conn->error));
    }

    // DB 연결 종료
    $conn->close();

    exit;
