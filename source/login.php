<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./css/231415865f098d99.css">
  <link rel="stylesheet" href="./css/ce32a2f0ad80d926.css">
  <style>
      #font {
          font-weight: bold;
      }
  </style>
  <title>Document</title> 
</head>
<body>
    <!--
// v0 by Vercel.
// https://v0.dev/t/dEEBKgEnEfd
-->
  <div class="flex flex-col min-h-screen">
    <header class="px-4 lg:px-6 h-14 flex items-center">
      <nav class="ml-auto flex gap-4 sm:gap-6">
        <a class="text-sm font-medium hover:underline underline-offset-4" href="#">
          Features
        </a>
        <a class="text-sm font-medium hover:underline underline-offset-4" href="#">
          Pricing
        </a>
        <a class="text-sm font-medium hover:underline underline-offset-4" href="#">
          About
        </a>
        <a class="text-sm font-medium hover:underline underline-offset-4" href="#">
          Contact
        </a>
      </nav>
    </header>
    <main class="flex-1 flex flex-col items-center space-y-6 justify-center">
      <div class="space-y-2 text-center">
        <img src="./img/logo.png" width="190">
        <!-- <h1 class="text-3xl font-bold tracking-tighter sm:text-5xl">데이터 관리 페이지</h1> -->
        <p class="max-w-[600px] text-black-500 md:text-xl/relaxed lg:text-base/relaxed xl:text-xl/relaxed dark:text-gray-400" id="font">
          데이터 관리 페이지
        </p>
      </div>
      <div class="rounded-lg border bg-card text-card-foreground shadow-sm w-full max-w-sm" data-v0-t="card">
        <div class="flex flex-col space-y-1.5 p-6">
          <h3 class="whitespace-nowrap tracking-tight text-lg font-medium" id="font">로그인</h3>
          <p class="text-sm text-muted-foreground">ID와 Password를 입력하세요</p>
        </div>
        <form method="post" action="check_login.php" class="loginForm">
          <div class="p-6 space-y-4">
            <input
              class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
              id="id"
              placeholder="ID"
              required=""
              type="text"
            />
            <input
              class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
              id="pw"
              placeholder="Password"
              required=""
              type="password"
            />
            <button
              class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2 w-full"
              type="submit"
            >
              Sign in
            </button>
          </div>
        </form>
      </div>
      <!-- <div class="text-sm text-center"></div> -->
    </main>
  </div>
</body>
</html>