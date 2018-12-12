 <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
 <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet' type='text/css'>
 <meta name="viewport" content="width=device-width, user-scalable=no">
 <meta name="twitter:card" content="summary_large_image">
 <meta name="twitter:title" content="JavaScript Event KeyCodes">
 <meta name="twitter:description" content="Keycode testing tool - which keys map to which keycodes?">
 <meta name="twitter:creator" content="@wesbos">
 <meta name="twitter:image" content="http://f.cl.ly/items/1Z3e0c1R36001s1D271A/ss%202014-04-28%20at%2012.08.06%20PM.png">
 <link rel="stylesheet" href="css/style.css?v=10112018">
 <link rel="icon" href="">
  <canvas width="128" height="128" hidden></canvas>
  <div class="display">
    <table class="table hide">
      <thead>
        <tr>
          <th>Key</th>
          <th>Key Code</th>
        </tr>
      </thead>
      <tbody class="table-body">
      </tbody>
    </table>
    <div class="wrap" aria-live="polite" aria-atomic="true">
      <p class="keycode-display"></p>
      <p class="text-display">Press any key to get the JavaScript event keycode</p>
      <div class="cards hide">
        <div class="card item-key">
          <div class="card-header">event.key</div>
          <div class="card-main">
            <div class="main-description">key</div>
          </div>
        </div>
        <div class="card item-which">
          <div class="card-header">
           event.which
          </div>
          <div class="card-main">
            <div class="main-description">which</div>
          </div>
        </div>
        <div class="card item-code">
          <div class="card-header">event.code</div>
          <div class="card-main">
            <div class="main-description">code</div>
          </div>
        </div>
      </div>
      <div class="mobile-input">
      </div>
    </div>
  </div>
</div>
</body>
  <script type='text/javascript'>
    if ('serviceWorker' in navigator) {
      navigator.serviceWorker.register('js/service-worker.js');
    }
  </script>
  <script src="js/scripts.js?v=10112018"></script>
  <script>!function (d, s, id) { var js, fjs = d.getElementsByTagName(s)[0], p = /^http:/.test(d.location) ? 'http' : 'https'; if (!d.getElementById(id)) { js = d.createElement(s); js.id = id; js.src = p + '://platform.twitter.com/widgets.js'; fjs.parentNode.insertBefore(js, fjs); } }(document, 'script', 'twitter-wjs');</script>

</html>