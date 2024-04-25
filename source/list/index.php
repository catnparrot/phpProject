<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<!--     
    <link rel="stylesheet" href="./css/231415865f098d99.css">
    <link rel="stylesheet" href="./css/ce32a2f0ad80d926.css">
     -->
    <link rel="stylesheet" href="/css/customStyle.css">
   
    <style>
        .hidden {
            display: none;
        }
        .companiesPageButton {
            width: 750px;
            position: relative;
            padding: 10px;
        }
        .board_area_class {
            width: 80%;
        }
        .board_area_title {
            text-align: center;
            font-weight: bold;
            font-size: 24px;
        }
        #RedmineButton {
            float: right;
        }
        #servertable {
            width: 100%;
        }
        #sub_res {
            font-size: 10px;
        }
    </style>


<title>testSrv</title>
</head>
<body>

<!-- DB -->
<?php
    // DB 연결
    $servername = "ServerName";
    $username = "UserName";
    $password = "Password1";
    $dbname = "dbname";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error)
    {
        die("Connection failed: " . $conn->connect_error);
    }

    // Query to fetch data
    $table_name = "companies";

    $sql = "SELECT * FROM " . $table_name;
    $field_sql = "DESCRIBE $table_name";

    $result = $conn->query($sql);
    $result2 = $conn->query($field_sql);
    
    if(!$result)
    {
        echo "the table is missing!<br>the table is missing!<br>the table is missing!<br>the table is missing!<br>the table is missing!<br>the table is missing!<br>the table is missing!<br>the table is missing!<br>the table is missing!<br>the table is missing!<br>the table is missing!<br>the table is missing!<br>";
        echo "<script>setTimeout(function() { window.location = '/test.html'; }, 3000);</script>";
    }

    // record를 담을 array 변수
    $tableValues=array();
    $fields = array();

    if ($result->num_rows > 0)
    {
        while($row = $result->fetch_assoc())
        array_push($tableValues, $row);
    }
    else
    {
        echo "0 results";
    }

    if ($result2->num_rows > 0) {
        while($row2 = $result2->fetch_assoc()) {
            $fields[] = $row2['Field'];
        }
    }

    // Disconnect DB
    $conn->close();
?>
<!-- /DB -->

<header class="header_in_list">
    <div>
        <a href="/"><img src="/img/logo.png" width="50" /></a>
    </div>
</header>

<div class="companiesPageButton">
    <input type="button" value="서버" onclick="window.location='./servers/'">
    <input id="RedmineButton" type="button" value="REDMINE" onclick="connectRedmine('/projects')">
</div>
<div class="board_area_class">
    <div class="board_area_title">
        업체 인벤토리
    </div>
    <table id="servertable" class="list-table">
        <thead>
            <tr>
                <?
                    if ($result)
                    {
                        echo
                        "
                        <th>
                            번호
                        </th>
                        <th>
                            업체명
                        </th>
                        <th>
                            대응담당자
                        </th>
                        <th>
                            연락처
                        </th>
                        <th>
                            담당자(정)
                        </th>
                        <th>
                            담당자(부)
                        </th>
                        <th>
                            업데이트
                        </th>
                        <th>
                            상세
                        </th>
                        <th>
                            <input type=\"button\" class=\"submitfordelete\" value=\"삭제\" />
                        </th>
                        ";
                    }
                ?>
            </tr>
        </thead>
        <tbody>
            <?
                foreach ($tableValues as $tmptablevalue)
                {
                    echo "<tr id=" . $tmptablevalue['id'] . ">";
                    foreach ($tmptablevalue as $key => $value)
                    {
                        if($key === "id")
                        {
                            echo "<td id=" . $key . ">" . $value . "</td>";
                        }
                        else
                        {
                            echo "<td id=" . $key . " class=\"editable\">" . $value . "</td>";
                        }
                    }
                    echo "<td><a href=\"./servers/?co=" . $tmptablevalue['id'] . "\">▶</a></td>";
                    echo "<td><input type=\"checkbox\" class=\"checkboxClassName\" /></td></tr>";   //삭제 체크박스
                }
            ?>
            <tr id="createR">
                <td colspan="7"><button onclick="createForm()">추가하기</button></td>
            </tr>
            <div id="newsrv">
                <tr id="cForm" class="hidden">
                <?php
                    foreach ($fields as $colitem)
                    {
                        if ($colitem === "id")
                        {
                            echo "<td>NEW</td>";
                        }
                        elseif($colitem === "updatedate")
                        {
                            echo "<td><input name=$colitem type=\"date\" max=\"2099-12-31\" min=\"1999-01-01\" /></td>";
                        }
                        else
                        {
                            echo "<td><input name=$colitem type=\"text\"></input></td>";
                        }
                    }
                ?>
                    <td><button id="submitButton">등록</button></td>
                    <td><button id="cancleSubmitButton">취소</button></td>
                </tr>
        </tbody>
    </table>
</div>
</body>
<script src="/js/script.js"></script>
</html>