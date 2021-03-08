<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <title>Email Templates</title>
</head>
<body>
    <style>
        .iframe_container {
            display: inline;
            position: relative;
            height: 360px;
            width: 300px;
            float: left;
            margin-bottom: 30px;
        }

        .iframe {
            height: 360px;
            width: 100%;
            pointer-events: none;
            user-select: none;
            border-radius: 5px;
        }
        
        .btn {
            position: absolute;
            top: 5px;
            left: 5px;
        }
    </style>
    <div class="album py-5 bg-primary h-100 min-vh-100">
        <div class="container">
            <div class="row center-block">
                @foreach($templates as $item)
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="card mb-4 box-shadow">
                            <button type="button" class="btn btn-sm btn-outline-primary" onclick="location.href = 'mail/{{$item}}'">View Template</button>
                            <iframe class="iframe" src="mail/{{$item}}" 
                                id='inneriframe'
                                frameborder='no'
                            ></iframe>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>
</body>
</html>