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

    <title>StreamFrog | Admin</title>

    {{ HTML::style('css/bootstrap.min.css') }}
    {{ HTML::style('css/style.css') }}

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <div class="navbar navbar-default navbar-fixed-top" role="navigation">
      <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="{{ URL::to('/') }}">{{ HTML::image('images/logo.png', 'logo', array('class' => 'logoimg')) }} StreamFrog</a>
        </div>
        @if (Sentry::check())
        <div class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li {{ Request::is('admin/index') || Request::is('admin') ? 'class="active"' : '' }}>{{ HTML::link('admin/index', 'Dashboard') }}</li>
            <li {{ Request::is('admin/teams*') ? 'class="active"' : '' }}>{{ HTML::link('admin/teams', 'Teams') }}</li>
            <li {{ Request::is('admin/streamers*') ? 'class="active"' : '' }}>{{ HTML::link('admin/streamers', 'Streamers') }}</li>
          </ul>
        </div>
        @endif 
    </div>

      <section class="content">
          @yield('content')
      </section>

    <footer>
      <p class="text-muted">&copy; 2014 by StreamFrog. All rights reserved.</p>
    </footer>

    {{ HTML::script('js/jquery.min.js') }}
    {{ HTML::script('js/bootstrap.min.js') }}
    {{ HTML::script('js/script-admin.js') }}
  </body>
</html>
