<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/customStyle.css">
    <title>testSrv</title>

    <style>
        /* CSS 스타일링은 선택사항입니다. */
        .bar {
            cursor: pointer;
        }
        .hidden {
            display: none;
        }
        table {
            table-layout: fixed;
            text-align: center;
        }
        tr {
            height: 45px;
        }
        td {
            width: 5%;
            word-wrap: break-word;
        }
        .query {
            font-weight: bold;
        }
        #note {
            height: 200px;
        }
        .board_area {
            width: 80%;
            min-width: 768px;
        }
        .board_area div {
            margin-bottom: 32px;
        }
        .board_area_title {
            text-align: center;
            font-weight: bold;
            font-size: 24px;
            margin-top: 35px;
            margin-bottom: 20px;
        }
        .hidden {
            display: none;
        }
        .superHidden {
            display: none;
        }
        .empty {
            width: 5%;
            height: 0px;
            border: 0;
        }
        .empty th {
            border: 0;
        }
        #detail table thead tr th {
            word-wrap: break-word;
        }
        .extraCSS {
            font-weight: bold;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
<?php
$sid = $_GET['sid'];
$intSid = (int)$sid;
$trnid = $intSid * 100;

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
    
    $table_name = "server_detail";
    $table_name2 = "servers";

    $sql_ex = "SELECT * FROM " . $table_name . " WHERE sid=" . $sid;
    $sql = $sql_ex . " AND id=" . $trnid;
    $sql2 = "SELECT product, sn, cat, pid FROM " . $table_name2 . " WHERE id=" . $sid;
    $sql_count = "SELECT COUNT(*) AS record_count FROM " . $table_name . " WHERE sid=" . $sid;

    $result = $conn->query($sql);
    $result2 = $conn->query($sql2);
    $result_count = $conn->query($sql_count);

    $detailsArray = array();

    if($result->num_rows > 0)
    {
        $row = $result->fetch_assoc();
        $sql_rev = $sql_ex . " AND id !=" . $trnid;
        $result3 = $conn->query($sql_rev);
    }

    if($result2->num_rows > 0)
    {
        $row2 = $result2->fetch_assoc();
    }

    if($result3->num_rows > 0)
    {
        $isResult3 = 1;
        while($row3 = $result3->fetch_assoc())
        {
            array_push($detailsArray, $row3);
        }
    }

    if($result_count->num_rows > 0)
    {
        $row_count = $result_count->fetch_assoc();
        $rowCount = $row_count['record_count'];
    }
    // print_r($detailsArray);
?>
<header class="header_in_list">
    <div>
        <a href="/"><img src="/img/logo.png" width="50" /></a>
    </div>
</header>

<div class="board_area">
    <div class="board_area0">
        <div class="board_area_title">
            <? echo $row2['cat'] . " 상세페이지"; ?>
        </div>
        <div id="detail" class="tab_div">
            <table border="1" cellspacing="0" cellpadding="0" width="100%">
                <thead>
                    <tr class="empty">
                        <th></th><th></th><th></th><th></th>
                        <th></th><th></th><th></th><th></th>
                        <th></th><th></th><th></th><th></th>
                        <th></th><th></th><th></th><th></th>
                        <th></th><th></th><th></th><th></th>
                    </tr>
                    <tr>
                        <th colspan="20" id="title" class="detail_value"><? echo $row['title']; ?></th>
                    </tr>
                    <tr class="superHidden">
                        <th id="id" class="detail_id"><? echo $sid * 100; ?></th>
                        <th id="sid" class="detail_sid"><? echo $sid; ?></th>
                        <th id="pid" class="detail_pid"><? echo $row2['pid']; ?></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="query" align="center" colspan="2">서비스명</td>
                        <td id="servicename" class="detail_value" colspan="8"><? echo $row['servicename']; ?></td>
                        <td class="query" colspan="2">Host Name</td>
                        <td id="hostname" class="detail_value" colspan="8" ><? echo $row['hostname']; ?></td>
                    </tr>
                    <tr>
                        <td class="query" align="center" colspan="2">System Model</td>
                        <td colspan="8"><? echo $row2['product']; ?></td>
                        <td class="query" colspan="2">HDD</td>
                        <td id="diskmodel" class="detail_value" colspan="8"><? echo $row['diskmodel']; ?></td>
                    </tr>
                    <tr>
                        <td class="query" align="center" colspan="2">CPU</td>
                        <td id="cpumodel" class="detail_value" colspan="8"><? echo $row['cpumodel']; ?></td>
                        <td class="query" colspan="2">Memory</td>
                        <td id="mmemory" class="detail_value" colspan="8"><? echo $row['mmemory']; ?></td>
                    </tr>
                    <tr>
                        <td class="query" colspan="2">IP address</td>
                        <td id="ipaddr" class="detail_value" colspan="8"><? echo $row['ipaddr']; ?></td>
                        <td class="query" align="center" colspan="2">RAID</td>
                        <td id="raid" class="detail_value" colspan="5"><? echo $row['raid']; ?></td>
                        <td class="query" align="center" colspan="2">Tool</td>
                        <td id="tool" class="detail_value" colspan="1">
                            <?
                                if($row['tool'] === '2') {
                                    echo "X";
                                } elseif ($row['tool'] === '1') {
                                    echo "O";
                                }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="query" align="center" colspan="2">Kernel/Build Version</td>
                        <td id="os_version" class="detail_value" colspan="8"><? echo $row['os_version']; ?></td>
                        <td class="query" colspan="2">OS</td>
                        <td id="os" class="detail_value" colspan="8"><? echo $row['os']; ?></td>
                    </tr>
                    <tr>
                        <td id="note" class="query" align="center" colspan="2">추가내용</td>
                        <td id="note" class="detail_value" colspan="18">
                            <? echo $row['note']; ?>    
                        </td>
                    </tr>
                    <tr>
                        <td class='btnintable' colspan="20" align="center">
                            <input id="createUpdateForm" type="button" value="글수정">
                            <input id="back2list" type="button" value="글목록" onclick="redirectToPreviousPage()">
                            <input id="updateDetail" class="hidden" type="button" value="수정완료">
                            <input id="cancle2update" class="hidden" type="button" value="취소">
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!--     
        <div id="erroreported" class="tab_div">
            <div class="bar" onclick="toggleTable(1)">error 리포트1</div>
            <div id="table1" class="hidden">
                <table border="1" cellspacing="0" cellpadding="0" width="90%">
                    <tr width="90%">
                        <td width="10%" align="center">글쓴이</td>
                        <td width="50%"></td>
                    </tr>
                    <tr>
                        <td align="center">Email</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td align="center">제목</td>
                        <td><input type="text" name="subject" style="width: 95%;"></td>
                    </tr>
                    <tr>
                        <td align="center">내용</td>
                        <td id="content">
                            <textarea name="content" style="width: 95%;height: 200px;"></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" align="center">
                            <input type="submit" value="글수정">
                            <input type="button" value="글목록" onclick="window.location='/list/servers'">
                        </td>
                    </tr>
                </table>
            </div>

            <div class="bar" onclick="toggleTable(2)">error 리포트2</div>
            <div id="table2" class="hidden">
                <table border="1" cellspacing="0" cellpadding="0" width="90%">
                    <tr width="90%">
                        <td width="10%" align="center">글쓴이</td>
                        <td width="50%"></td>
                    </tr>
                    <tr>
                        <td align="center">Email</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td align="center">제목</td>
                        <td><input type="text" name="subject" style="width: 95%;"></td>
                    </tr>
                    <tr>
                        <td align="center">내용</td>
                        <td id="content">
                            <textarea name="content" style="width: 95%;height: 200px;"></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" align="center">
                            <input type="submit" value="글수정">
                            <input type="button" value="글목록" onclick="window.location='/list/servers'">
                        </td>
                    </tr>
                </table>
            </div>
        </div> -->
    </div>


<?
    if($isResult3)
    {
        $y=1;
        while ($y < $rowCount)
        {
            $z=$y-1;
            $detailrcd = $detailsArray[$z];
            $detailId = $trnid + $y;
            echo
            "
            <div class='extraCSS'>추가 " . $y . " </div>
            <div class='board_area" . $y . "'>
                <div id='detail' class='tab_div'>
                    <table border='1' cellspacing='0' cellpadding='0' width='100%'>
                        <thead>
                            <tr class='empty'>
                                <th></th><th></th><th></th><th></th>
                                <th></th><th></th><th></th><th></th>
                                <th></th><th></th><th></th><th></th>
                                <th></th><th></th><th></th><th></th>
                                <th></th><th></th><th></th><th></th>
                            </tr>
                            <tr>
                                <th colspan='20' id='title' class='detail_value'>" . $detailrcd['title'] . "</th>
                            </tr>
                            <tr class='superHidden'>
                                <th id='id' class='detail_id'>" . $detailId . "</th>
                                <th id='sid' class='detail_sid'>" . $sid . "</th>
                                <th id='pid' class='detail_pid'>" . $row2['pid'] . "</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class='query' align='center' colspan='2'>서비스명</td>
                                <td id='servicename' class='detail_value' colspan='8'>" . $detailrcd['servicename'] . "</td>
                                <td class='query' colspan='2'>Host Name</td>
                                <td id='hostname' class='detail_value' colspan='8' >" . $detailrcd['hostname'] . "</td>
                            </tr>
                            <tr>
                                <td class='query' align='center' colspan='2'>System Model</td>
                                <td colspan='8'>" . $row2['product'] . "</td>
                                <td class='query' colspan='2'>HDD</td>
                                <td id='diskmodel' class='detail_value' colspan='8'>" . $detailrcd['diskmodel'] . "</td>
                            </tr>
                            <tr>
                                <td class='query' align='center' colspan='2'>CPU</td>
                                <td id='cpumodel' class='detail_value' colspan='8'>" . $detailrcd['cpumodel'] . "</td>
                                <td class='query' colspan='2'>Memory</td>
                                <td id='mmemory' class='detail_value' colspan='8'>" . $detailrcd['mmemory'] . "</td>
                            </tr>
                            <tr>
                                <td class='query' colspan='2'>IP address</td>
                                <td id='ipaddr' class='detail_value' colspan='8'>" . $detailrcd['ipaddr'] . "</td>
                                <td class='query' align='center' colspan='2'>RAID</td>
                                <td id='raid' class='detail_value' colspan='5'>" . $detailrcd['raid'] . "</td>
                                <td class='query' align='center' colspan='2'>Tool</td>
                                <td id='tool' class='detail_value' colspan='1'>
                                    ";
                                        if($detailrcd['tool'] === '2') {
                                            echo 'X';
                                        } elseif ($detailrcd['tool'] === '1') {
                                            echo 'O';
                                        }
                                    echo
                                    "
                                </td>
                            </tr>
                            <tr>
                                <td class='query' align='center' colspan='2'>Kernel/Build Version</td>
                                <td id='os_version' class='detail_value' colspan='8'>" . $detailrcd['os_version'] . "</td>
                                <td class='query' colspan='2'>OS</td>
                                <td id='os' class='detail_value' colspan='8'>" . $detailrcd['os'] . "</td>
                            </tr>
                            <tr>
                                <td id='note' class='query' align='center' colspan='2'>추가내용</td>
                                <td id='note' class='detail_value' colspan='18'>
                                    " . $detailrcd['note'] . "    
                                </td>
                            </tr>
                            <tr>
                                <td class='btnintable' colspan='20' align='center'>
                                    <input id='createUpdateForm' type='button' value='글수정'>
                                    <input id='back2list' type='button' value='글목록' onclick='redirectToPreviousPage()'>
                                    <input id='updateDetail' class='hidden' type='button' value='수정완료'>
                                    <input id='cancle2update' class='hidden' type='button' value='취소'>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!--     
                <div id='erroreported' class='tab_div'>
                    <div class='bar' onclick=\"toggleTable(1)\">error 리포트1</div>
                    <div id='table1' class='hidden'>
                        <table border='1' cellspacing='0' cellpadding='0' width='90%'>
                            <tr width='90%'>
                                <td width='10%' align='center'>글쓴이</td>
                                <td width='50%'></td>
                            </tr>
                            <tr>
                                <td align='center'>Email</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td align='center'>제목</td>
                                <td><input type='text' name='subject' style='width: 95%;'></td>
                            </tr>
                            <tr>
                                <td align='center'>내용</td>
                                <td id='content'>
                                    <textarea name='content' style='width: 95%;height: 200px;'></textarea>
                                </td>
                            </tr>
                            <tr>
                                <td colspan='2' align='center'>
                                    <input type='submit' value='글수정'>
                                    <input type='button' value='글목록' onclick=\"window.location='/list/servers'\">
                                </td>
                            </tr>
                        </table>
                    </div>

                    <div class='bar' onclick=\"toggleTable(2)\">error 리포트2</div>
                    <div id='table2' class='hidden'>
                        <table border='1' cellspacing='0' cellpadding='0' width='90%'>
                            <tr width='90%'>
                                <td width='10%' align='center'>글쓴이</td>
                                <td width='50%'></td>
                            </tr>
                            <tr>
                                <td align='center'>Email</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td align='center'>제목</td>
                                <td><input type='text' name='subject' style='width: 95%;'></td>
                            </tr>
                            <tr>
                                <td align='center'>내용</td>
                                <td id='content'>
                                    <textarea name='content' style='width: 95%;height: 200px;'></textarea>
                                </td>
                            </tr>
                            <tr>
                                <td colspan='2' align='center'>
                                    <input type='submit' value='글수정'>
                                    <input type='button' value='글목록' onclick=\"window.location='/list/servers'\">
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                -->
            </div>
            ";
            $y++;
        }
    }

    if($isResult3)
    {
        echo
        "
        <div>
            <input id='deleteBoardAreaBtn' type='button' onclick='submitDetailDataForDelete($detailId)' value='삭제하기'>
        </div>
        ";
    }
?>

    <div id='extraBoardArea'>
        <input id='extraBoardAreaBtn' type='button' value='서버 추가' onclick="extraBoard()">
    </div>
</div>
</body>
<script src="/js/script.js" />
<script>

// -- error 페이지 생겼을 때 사용할 펑션 -- //
function toggleTable(tableId) {
    console.log("toggleTable");
    console.log(tableId);
    
    var table = document.getElementById('table' + tableId);
    console.log(table.style);
    console.log(table.style.display);
    if (table.style.display !== 'block') {
        console.log("none");
        table.style.display = 'block';
    } else {
        console.log("not none");
        table.style.display = 'none';
    }
}

function toggleTab() {
    // #code
}
</script>
</html>