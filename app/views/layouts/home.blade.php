<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="{{ URL::to('images/favicon.ico') }}" type="image/x-icon">
    <link rel="icon" href="{{ URL::to('images/favicon.ico') }}" type="image/x-icon">

    <title>StreamFrog</title>

    {{ HTML::style('css/bootstrap.min.css') }}
    {{ HTML::style('css/style.css') }}

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

      ga('create', 'UA-39371834-6', 'auto');
      ga('send', 'pageview');

    </script>
  </head>

  <body>

    <div class="navbar navbar-default navbar-fixed-top" role="navigation">
          <a class="navbar-brand" href="{{ URL::to('/') }}">{{ HTML::image('images/logo.png', 'logo', array('class' => 'logoimg')) }} StreamFrog</a>
          <ul class="nav navbar-nav">
              <li><a href="#search"><span class="glyphicon glyphicon-search"></span></a></li>
            </ul>
          <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav pull-right">
              <li class="disabled"><a><span class="text-success glyphicon glyphicon-ok"></span>&nbsp;&nbsp;&nbsp;<strong class="text-success">Updated: </strong> <span class="text-success">{{ Date::parse(Streamer::orderBy('updated_at', 'DESC')->first()->updated_at)->ago() }}</span></a></li>
            </ul>
          </div>
    </div>

      <section class="content">
          @yield('content')
      </section>

    <footer>
      <p class="text-muted">&copy; 2014 by StreamFrog. All rights reserved.</p>
    </footer>

    {{ HTML::script('js/jquery.min.js') }}
    {{ HTML::script('js/bootstrap.min.js') }}
    {{ HTML::script('js/packery.min.js') }}
    {{ HTML::script('js/script.js') }}
  </body>
</html>
