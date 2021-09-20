
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
            <div class="col-lg-4 bg-secondary" style="height:300px">
                <video autoplay="true" id="videoElement" class="mx-auto d-block">
        
                </video>
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
                        <button type="button" class="btn btn-primary w-100">Verify</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<!-- <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script> -->
<!-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> -->
<script type="text/javascript">
    var video = document.querySelector("#videoElement");

        if (navigator.mediaDevices.getUserMedia) {
        navigator.mediaDevices.getUserMedia({ video: true })
            .then(function (stream) {
            video.srcObject = stream;
            })
            .catch(function (err0r) {
            console.log("Something went wrong!");
            });
        }
</script>
</html>