<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/customStyle.css">
    <link rel="stylesheet" href="/css/application.css">
    <link rel="stylesheet" href="/css/responsive.css">
    <link rel="stylesheet" href="/css/tribute-5.1.3.css">
    <style>
        #main {
            width: 70%;
            max-width: 600px;
            margin: 0 auto;
        }
        #content {
            box-shadow: 0 0 0 3px #00000069;
        }
    </style>
<title>H1SYSTEM</title>
</head>
<body>

    <?php
        // session_start();
        // if(!isset($_SESSION['username'])) {
        //     echo "<script>location.replace('login.php');</script>";            
        // }
        
        // else {
        //     $username = $_SESSION['username'];
        //     $name = $_SESSION['name'];
        // } 
    ?>
<header class="header">
    <div>
        <img src="/img/logo.png" width="50" />
    </div>
</header>
<div id="main" class="part_fp_1">
    <div id="content">
        <div id="projects-index" class="customProjects-index">
            <ul class="projects root">
                <li class="root">
                    <div class="root">
                        <a class="project root leaf public" href="/list/">서버</a>
                        <div class="wiki description">
                            <p style="font: size 11px;">업체/서버 리스트</p>
                        </div>
                    </div>
                </li>
                <li class="root">
                    <div class="root">
                        <a class="project root leaf public" href="/guide.php">가이드</a>
                        <div class="wiki description">
                            <p style="font: size 11px;">웹페이지 사용 가이드</p>
                        </div>
                    </div>
                </li>
                <li class="root">
                    <div class="root">
                        <a id="redmineInFirstPage" class="project root leaf public" style="cursor: pointer;">
                            Redmine
                        </a>
                        <div class="wiki description">
                            <p style="font: size 11px;">작업/에러 상세 정보</p>
                        </div>
                    </div>      
                </li>
                <!-- <li class="root">
                    <div class="root">
                        <a class="project root leaf public" href="#">test</a>
                        <div class="wiki description">
                            <p></p>
                        </div>
                    </div>
                </li> -->
            </ul>
        </div>
    </div>
    <!-- <div id="sidebar_ex"></div> -->
</div>
</body>
<script src="/js/script.js"></script>
</html>