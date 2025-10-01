<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Simple-ecommerce</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 min-h-screen">
    <div id="app">
    <header class="fixed top-5 right-5 p-4 flex justify-end items-center w-fit rounded-full hover:cursor-pointer shadow-md z-50 bg-white">
       <cart-icon />
    </header>

    <main class="container mx-auto p-6">
      @yield('content')
    </main>
  </div>
</body>