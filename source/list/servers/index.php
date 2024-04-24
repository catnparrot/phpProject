<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/customStyle.css">
    <style>
        .hidden {
            display: none;
        }
        .serversPageButton {
            width: 1000px;
            position: relative;
        }
        #RedmineButton {
            float: right;
        }
        .board_area_title {
            text-align: center;
            font-weight: bold;
            font-size: 24px;
        }
        .listClass {
            text-align: right;
            max-width: 1467px;
        }
        #cFormBar {
            font-weight: bold;
        }
        #periodstart {
            min-width: 50px;
        }
        #periodend {
            min-width: 50px;
        }
    </style>
<title>H1SYSTEM</title>
</head>
<body>
<?php
// -- DB -- //
    // DB 연결
    $servername = "ServerName";
    $username = "UserName";
    $password = "Password1";
    $dbname = "dbname";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // 연결 체크
    if ($conn->connect_error)
    {
        die("Connection failed: " . $conn->connect_error);
    }

    // table 이름 및 가져올 쿼리값
    $list_table = "companies";
    $table_name = "servers";
    $col_pid = $_GET['co'];

    // SQL 쿼리
    $sql = "SELECT * FROM " . $table_name;
    $list_sql = "SELECT id, name FROM " . $list_table;
    $field_sql = "DESCRIBE $table_name";

    if(!is_null($col_pid) && $col_pid != 0 && $col_pid != "")
    {
        $sql .= " WHERE servers.pid=" . $col_pid;
    }

    //쿼리 실행
    $result = $conn->query($sql);
    $result2 = $conn->query($list_sql);
    $result3 = $conn->query($field_sql);
    
    if(!$result2)
    {
        echo "companies table is missing!<br>companies table is missing!<br>companies table is missing!<br>companies table is missing!<br>companies table is missing!<br>companies table is missing!<br>companies table is missing!<br>companies table is missing!<br>companies table is missing!<br>companies table is missing!<br>";
        echo "<script>setTimeout(function() { window.location = /test.html'; }, 3000);</script>";
    }

    if(!$result)
    {
        echo "servers table is missing!<br>servers table is missing!<br>servers table is missing!<br>servers table is missing!<br>servers table is missing!<br>servers table is missing!<br>servers table is missing!<br>servers table is missing!<br>servers table is missing!<br>servers table is missing!<br>";
        echo "<script>setTimeout(function() { window.location = /test.html'; }, 3000);</script>";
    }

    $tableValues = array();
    $listdata = array();
    $fields = array();

    if ($result->num_rows > 0)
    {
        // 결과값들을 배열에 할당
        while($row = $result->fetch_assoc())
            array_push($tableValues, $row);
    }

    if ($result2->num_rows > 0)
    {
        // 결과값들을 배열에 할당
        while ($row2 = $result2->fetch_assoc()) {
            array_push($listdata, $row2);
        }
    }
    
    if ($result3->num_rows > 0) {
        // 결과값들을 배열에 할당
        while($row3 = $result3->fetch_assoc()) {
            $fields[] = $row3['Field'];
        }
    }

    // DB 연결 끊기
    $conn->close();
// -- /DB -- //

//servers.pid, companies.id 맵핑 
    $pid_2_id_mapping = [];
    foreach ($listdata as $item) {
        $pid_2_id_mapping[$item['id']] = $item['name'];
    }
?>

<header class="header_in_list">
    <div>
        <a href="/"><img src="/img/logo.png" width="50" /></a>
    </div>
</header>
<div class="serversPageButton">
    <input type="button" value="업체 리스트" onclick="window.location='../'">
    <input id="RedmineButton" type="button" value="REDMINE" onclick="connectRedmine('/projects')">
</div>
<div id="board_area">
    <div class="board_area_title">
        서버 인벤토리
    </div>
    <!-- 목록 -->
    <form id="covalue">
        <div class="listClass">
            업체 목록
            <select id="company_list" onchange="submitForm()">
                <option value="0">모두보기</option>
                <?php
                    $x=0;
                    while ($x < count($listdata))
                    {
                        $litem=$listdata[$x];
                        $string = "<option value=" . $litem["id"] . ">" . $litem["name"] . "</option>";
                        echo $string;
                        ++$x;
                    }
                ?>
            </select>
        </div>
    </form>
    <!-- /목록 -->

    <table id="servertable" class="list-table">
        <thead>
            <tr>
                <?php
                    if ($result2)
                    {
                    echo
                        "
                        <th id=\"loc\">
                            지점
                        </th>
                        <th id=\"product\">
                            장비명
                        </th>
                        <th id=\"cat\">
                            용도
                        </th>
                        <th id=\"charpol\">    
                            유무상여부
                        </th>
                        <th id=\"period\" colspan=\"3\">
                            유지보수기간
                        </th>
                        <th id=\"back\">
                            Back 계약업체
                        </th>
                        <th id=\"backmem\">
                            Back 지원담당                        
                        </th>
                        <th id=\"phonnum\">
                            연락처
                        </th>
                        <th id=\"suplev\">
                            지원 Level
                        </th>
                        <th id=\"beforeco\">
                            앞단 업체
                        </th>
                        <th id=\"sn\">
                            S/N
                        </th>
                        <th id=\"note\">
                            비고
                        </th>
                        <th>
                            상세
                        </th>
                        <th>
                            로그
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
            <?php
                foreach ($tableValues as $tmptablevalue)
                {
                    echo "<tr id=" . $tmptablevalue['id'] . " class=" . $tmptablevalue['pid'] . ">";
                    foreach ($tmptablevalue as $key => $value)
                    {
                        if($key === "pid")
                        {
                            echo "<td id=" . $key . " class=\"hidden\">" . $pid_2_id_mapping[$value] . "</td>";
                        }
                        elseif($key === "id") { echo ""; }
                        elseif ($key === "periodstart")
                        {
                            echo "<td id=" . $key . " class=\"editable\">" . $value . "</td><td>~</td>";
                        }
                        else
                        {
                            echo "<td id=" . $key . " class=\"editable\">" . $value . "</td>";
                        }
                    }
                    echo "<td><a href=\"./view/?sid=" . $tmptablevalue['id'] . "\">▶</a></td>";   //hostname, 혹은 현페이지 url가져오는 법 찾기
                    echo "<td><input type=\"button\" class=\"move2where\" onclick=\"connectRedmine('/search?utf8=✓&scope=&q=" . $tmptablevalue['sn'] . "')\" value=\"▶\"></td>";
                    echo "<td><input type=\"checkbox\" class=\"checkboxClassName\" /></td></tr>";   //삭제 체크박스
                }
            ?>
            <tr id="createR">
                <td colspan="16"><button onclick="createForm()">추가하기</button></td>
            </tr>
            <div id="newsrv">
                <tr id="cFormBar" class="hidden">
                    <td id="pid">
                        고객사
                    </td>
                    <td id="loc">
                        지점
                    </td>
                    <td id="product">
                        장비명
                    </td>
                    <td id="cat">
                        용도
                    </td>
                    <td id="charpol">    
                        유무상여부
                    </td>
                    <td id="back">
                        Back 계약업체
                    </td>
                    <td id="backmem">
                        Back 지원담당                        
                    </td>
                    <td id="phonnum">
                        연락처
                    </td>
                    <td id="suplev">
                        지원 Level
                    </td>
                    <td id="beforeco">
                        앞단 업체
                    </td>
                    <td id="sn">
                        S/N
                    </td>
                    <td id="note">
                        비고
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                </tr>
                <tr id="cForm" class="hidden">
                <?
                    foreach ($fields as $colitem)
                    {
                        if($colitem == "pid") {
                            echo "<td>";
                            if($col_pid == "0" || !$col_pid) {
                                echo "<select id=\"company_options\"><option value=\"0\"></option>";
                                foreach ($listdata as $litem)
                                {
                                    $string = "<option value=" . $litem["id"] . ">" . $litem["name"] . "</option>";
                                    echo $string;
                                }
                                echo "</select>";
                            }
                            else
                            {
                                echo "<span>" . $pid_2_id_mapping[$col_pid] . "</span><input type=\"hidden\" name=\"pid\" value=$col_pid>";
                            }
                            echo "</td>";
                        }
                        elseif ($colitem === "id" || $colitem === "periodstart" || $colitem === "periodend")
                        {
                            continue;
                        }
                        else
                        {
                            echo "<td><input name=$colitem type=\"text\"></input></td>";
                        }
                    }
                ?>
                    <td colspan="2"><button id="submitButton">등록</button></td>
                    <td colspan="2"><button id="cancleSubmitButton">취소</button></td>
                </tr>
            </div>
        </tbody>
    </table>
</div>

</body>
<script src="/js/script.js"></script>
</html>