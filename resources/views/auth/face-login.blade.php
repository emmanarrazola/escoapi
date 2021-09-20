
<!DOCTYPE html>
<html lang="en" class="w-100 h-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css">
    <style>
        video {
            height: 100%;
            max-width: 100%;
        }
    </style>
</head>
<body class="w-100 h-100">

    <div class="container-fluid inline-block h-100 bg-muted">
        <div class="row d-flex align-items-center justify-content-center">
            <div class="col-lg-4">
                <img style="width:150px;" class="mt-3 mx-auto d-block" src="{{asset('img/company-logo.png')}}" />
            </div>
        </div>
        <div class="row d-flex align-items-center justify-content-center">
            <div id="camera" class="col-lg-4 bg-secondary" style="height:300px">
                
            </div>
        </div>
        <div class="row d-flex align-items-center justify-content-center">
            <div class="col-lg-4">
                <div class="card border-0 text-center">
                    <div class="card-body">
                        <h5 class="card-title">Attendance System</h5>
                        <!-- <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6> -->
                        <p class="card-text">Please allow to open your camera and click verify.</p>
                        <!-- <a href="#" class="card-link">Card link</a>
                        <a href="#" class="card-link">Another link</a> -->
                        <form id="captureimage" method="POST" action="{{ route('facedetection.store') }}">
                            @csrf
                            <input type="hidden" name="image_tag" id="image_tag" />
                            <button type="submit" class="btn btn-primary w-100">Verify</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<!-- <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script> -->
<!-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>
<script type="text/javascript">
    $(function(){
        Webcam.set({
            height: 300,
            image_format: 'jpeg',
            jpeg_quality: 90
        });
    
        Webcam.attach( '#camera' );

        $("#captureimage").on('submit', function(e){
            e.preventDefault();
            var form = this;
            Webcam.snap( function(data_uri) {
                $("#image_tag").val(data_uri);

                form.submit();
                // document.getElementById('results').innerHTML = '<img src="'+data_uri+'"/>';
            } );
        })
    });
</script>
</html>