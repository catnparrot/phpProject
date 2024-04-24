<?php

    // DB 연결
    $servername = "ServerName";
    $username = "UserName";
    $password = "Password1";
    $dbname = "dbname";

    $array = $_POST;
    $keyarray = [];
    $valuearray = [];
    $updatearray = [];
    print_r($array);

    foreach ($array as $key => $value) {
        if ($value) // insert 용
        {
            array_push($keyarray, $key);
            array_push($valuearray, $value);
        }

        // update 용
        if($key == 'id') { $id = $value; }
        if($key == 'sid') { continue; }
        $up_string = "" . $key . " = ";
        if(!$value) { $up_string .= "NULL"; } else { $up_string .= "\"" . $value . "\""; }
        array_push($updatearray, $up_string);
    }

    // create를 위한 변수
    $column_string = implode(", ", $keyarray);
    $quoted_values = array_map(function($value_item) {
        return '"' . $value_item . '"';
    }, $valuearray);
    $value_string = implode(", ", $quoted_values);
    $update_string = implode(", ", $updatearray);

    echo $column_string;
    echo $value_string;
    echo $update_string;

    // 데이터베이스 연결 생성
    $conn = new mysqli($servername, $username, $password, $dbname);

    // 연결 확인
    if ($conn->connect_error) {
        die("연결 실패: " . $conn->connect_error);
    }

    // MySQL 업데이트 쿼리 실행
    $sql4init = "INSERT INTO server_detail ( $column_string ) VALUES ( $value_string )";
    $sql = "UPDATE server_detail SET $update_string WHERE id = $id";

    if($conn->query($sql4init) === TRUE)
    {
        echo "세부 사항에 대한 레코드가 등록되었습니다.";
    }
    else
    {
        echo "1차 에러 발생: " . $sql4init . "<br>" . $conn->error;
        echo "레코드 업데이트를 진행합니다.";
        if ($conn->query($sql) === TRUE) {
            echo "데이터가 업데이트되었습니다.";
        } else {
            echo "2차 에러 발생: " . $sql . "<br>" . $conn->error . "<br>";
            echo "DB데이터가 변경되었거나 정상적인 경로의 요청이 아닙니다.";
        }

    }
    
    $conn->close();

    exit;