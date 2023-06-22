<!DOCTYPE html>
<html lang="en">

<head>
    @include('layouts.head')
</head>

<body>
    @include('layouts.header')
    <div class="main-container" id="container">
        <div class="overlay"></div>
        <div class="search-overlay"></div>
        @include('layouts.sidebar')
        @section('main-content')
        @show
        @include('layouts.footer')
    </div>
</body>

</html>
