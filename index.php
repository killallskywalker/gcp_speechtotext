<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Subtitle Generator</title>

  <!-- Bootstrap core CSS -->
  <link href="public/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom fonts for this template -->
  <link href="public/vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
  <link href="public/vendor/simple-line-icons/css/simple-line-icons.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">

  <!-- Custom styles for this template -->
  <link href="public/css/landing-page.min.css" rel="stylesheet">
  <link rel='stylesheet' href='node_modules/mprogress/mprogress.min.css'/>

  <script src='node_modules/mprogress/mprogress.min.js'></script>
</head>

<body>

  <!-- Navigation -->
  <nav class="navbar navbar-light bg-light static-top">
    <div class="container">
      <a class="navbar-brand" href="#">Speech To Text
</a>
      <!-- <a class="btn btn-primary" href="#">Sign In</a> -->
    </div>
  </nav>
  <div id="demoBuffer"></div>
  <!-- Masthead -->
  <header class="masthead text-white text-center">
    <div class="overlay"></div>
    <div class="container">
      <div class="row">
        <div class="col-xl-9 mx-auto">
          <h1 class="mb-5">Upload File And Wait For Text Generated</h1>
        </div>
        <div class="col-md-10 col-lg-8 col-xl-7 mx-auto">
          <form id="form" enctype="multipart/form-data">
            <div class="form-row">
              <div class="col-12 col-md-9 mb-2 mb-md-0">
                <input type="file" class="p-0 form-control form-control-lg" placeholder="* Flac format" name="file">
              </div>
              <div class="col-12 col-md-3">
                <button type="submit" name="submit" class="btn btn-block btn-lg btn-primary">Process File</button>
              </div>
            </div>
          </form>
          <br>
           <h6 class="mb-5">Format file to flac first <a style="color:red;" href='https://audio.online-convert.com/convert-to-flac'>flac converter</a> and change sampling rate to <span style="color:red;">16000</span> and audio channels to <span style="color:red;">mono</span> . </h6>
            <br>
            <div id="downloadLink" style="display: none;">
            <p><a href="https://www.w3schools.com" id="url">Download Text here!</a></p>
          </div>
        </div>
      </div>
    </div>
  </header>


  <!-- Footer -->
  <footer class="footer bg-light">
    <div class="container">
      <div class="row">
        <div class="col-lg-6 h-100 text-center text-lg-left my-auto">
          <p class="text-muted small mb-4 mb-lg-0">&copy; Speech To Text 2019. All Rights Reserved.</p>
        </div>
      </div>
    </div>
  </footer>

  <!-- Bootstrap core JavaScript -->
  <script src="public/vendor/jquery/jquery.min.js"></script>
  <script src="public/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script>
var mprogress = new Mprogress();

$(document).ready(function (e) {
 $("#form").on('submit',(function(e) {
  e.preventDefault();
  $.ajax({
     url: "upload.php",
     type: "POST",
     data:  new FormData(this),
     contentType: false,
           cache: false,
     processData:false,
   beforeSend : function()
   {  
    mprogress.start();
   },
   success: function(data)
    {

    mprogress.end();

    console.log(data);
    if(data !=='fail')
    {
      alert('success');
      $("#form")[0].reset(); 
      $("#url").attr("href", data);
      $("#downloadLink").show();
      // window.location.href = data; //Will take you to Google.
    }
    else
    {
      alert('Upload Fail!');
    }
    },
     error: function(e) 
      {
          alert('server error!');
      }          
    });
 }));
});
</script>
</body>

</html>
