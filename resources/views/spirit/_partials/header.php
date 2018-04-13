<!doctype html>
<html class="no-js" lang="">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Spirit - A design system that works for you</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="../../../../public/favicon.ico" type="image/x-icon">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Andada|Montserrat:300">

<!--    <link rel="stylesheet" href="assets/css/warpaint.css">-->
<!--    <link rel="stylesheet" href="assets/css/spirit.css">-->
<!--    <link rel="stylesheet" href="assets/css/layout.css">-->

    <!-- temp links when spirit is still inside chief -->
    <link rel="stylesheet" href="/assets/back/css/main.css">
    <link rel="stylesheet" href="/assets/spirit/css/layout.css">

    <!-- Google Tag Manager -->
	<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
			new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
			j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
			'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
		})(window,document,'script','dataLayer','GTM-5NGHP2D');</script>
	<!-- End Google Tag Manager -->
</head>
<body>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5NGHP2D"
                  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
    <main class="row" id="main">

        <?php include(__DIR__.'/sidebar.php'); ?>

        <?php

        $pagetitles = [
            'icons' => 'Spirit icons',
            'settings' => 'Spirit settings',
            'colors' => 'Spirit colors',
            'elements' => 'Spirit elementen',
            'components' => 'Spirit componenten',
        ];

        $extracted = array_filter(explode("/",parse_url($_SERVER['REQUEST_URI'],PHP_URL_PATH)));
        $current_section = $extracted[2];
//        $current_item = isset($extracted[3]) ? $extracted[3] : null;

        ?>

        <article class="column-10">
            <header class="hero squished-xl">
                <h1 class="title"><?= $pagetitles[$current_section]; ?></h1>
            </header>
            <div class="squished-xl">

