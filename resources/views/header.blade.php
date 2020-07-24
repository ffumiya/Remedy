@section('header')
<div id="navbar-main">
    <!-- Fixed navbar -->
    <!-- <div class="navbar navbar-inverse navbar-fixed-top" style="background-color: RGB(0,96,146);"> -->
    <div class="navbar navbar-inverse" style="background-color: RGB(0,96,146);">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="icon icon-shield" style="font-size:30px; color:#3498db;"></span>
          </button>
          <a class="navbar-brand hidden-xs hidden-sm smoothscroll" href="#home"><span class="icon icon-shield" style="font-size:18px; color:#3498db;"></span></a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li><a href="/" class="smoothscroll" style="color: aliceblue;">ホーム</a></li>
            <li> <a href="/login" class="smoothscroll" style="color: aliceblue;"> ログイン</a></li>
            <!-- <li> <a href="#contact" class="smoothscroll" style="color: aliceblue;"> Contact</a></li> -->
        </div>
        <!--/.nav-collapse -->
      </div>
    </div>
  </div>
@endsection