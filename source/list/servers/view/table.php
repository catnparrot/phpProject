<?php
    $sid = $_GET['sid'];
    $intSid = (int)$sid;
    $trnid = $intSid * 100;
    $detailId = $_GET['newid'];

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

    $table_name2 = "servers";

    $sql2 = "SELECT pid FROM " . $table_name2 . " WHERE id=" . $sid;

    $result2 = $conn->query($sql2);

    if($result2->num_rows > 0)
    {
        $row2 = $result2->fetch_assoc();
    }

    echo
    "
    <div class='board_area_new'>
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
                        <th colspan='20' id='title' class='detail_value'></th>
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
                        <td id='servicename' class='detail_value' colspan='8'></td>
                        <td class='query' colspan='2'>Host Name</td>
                        <td id='hostname' class='detail_value' colspan='8' ></td>
                    </tr>
                    <tr>
                        <td class='query' align='center' colspan='2'>System Model</td>
                        <td colspan='8'></td>
                        <td class='query' colspan='2'>HDD</td>
                        <td id='diskmodel' class='detail_value' colspan='8'></td>
                    </tr>
                    <tr>
                        <td class='query' align='center' colspan='2'>CPU</td>
                        <td id='cpumodel' class='detail_value' colspan='8'></td>
                        <td class='query' colspan='2'>Memory</td>
                        <td id='mmemory' class='detail_value' colspan='8'></td>
                    </tr>
                    <tr>
                        <td class='query' colspan='2'>IP address</td>
                        <td id='ipaddr' class='detail_value' colspan='8'></td>
                        <td class='query' align='center' colspan='2'>RAID</td>
                        <td id='raid' class='detail_value' colspan='5'></td>
                        <td class='query' align='center' colspan='2'>Tool</td>
                        <td id='tool' class='detail_value' colspan='1'></td>
                    </tr>
                    <tr>
                        <td class='query' align='center' colspan='2'>Kernel/Build Version</td>
                        <td id='os_version' class='detail_value' colspan='8'></td>
                        <td class='query' colspan='2'>OS</td>
                        <td id='os' class='detail_value' colspan='8'></td>
                    </tr>
                    <tr>
                        <td id='note' class='query' align='center' colspan='2'>추가내용</td>
                        <td id='note' class='detail_value' colspan='18'></td>
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
        <div>※미구현된 부분이 많아 문제가 많습니다. 새 서버 문서 작성 후 새로고침 해주세요.</div>
        <div id='extraBoardArea'>
            <input id='extraBoardAreaBtn' type='button' value='새로고침' onclick=\"location.reload()\">
        </div>
    </div>
    ";