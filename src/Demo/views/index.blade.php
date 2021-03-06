@if(count( $_messages = Session::get('messages', [])) > 0)
    @foreach($_messages as $type => $_message)
        {!! $_message !!}
    @endforeach
@endif


<!DOCTYPE html>
<html>
<head>
    <meta charset=utf-8 />
    <title>Crius Group • Pagina's</title>
    <link rel="stylesheet" type="text/css" media="screen" href="https://unpkg.com/warpaint@0.0.9/dist/warpaint.min.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="http://spirit.thinktomorrow.be/assets/css/spirit.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="http://spirit.thinktomorrow.be/assets/css/layout.css" />

</head>
<body>
    <div class="row text-center" id="top">
        <header class="hero">
            <div class="absolute-center">
                <h1 class="title">Pagina's</h1>
            </div>
        </header>
    </div>
    <main class="--raised ">
        <div class="container stack-l">

            <ul>
                @foreach($pages as $page)
                    <li><a href="{{ route('demo.pages.show', $page->slug) }}">{{ $page->title }}</a></li>
                @endforeach
            </ul>
        </div>
    </main>
    <footer class="inset">
        © 2018 - Made with Warpaint & Spirit
    </footer>

</body>
</html>
