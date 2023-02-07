<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title></title>
     <style>
                html, body {
                    background-color: #FFF;
                    color: #636b6f;
                    font-family: 'Nunito', sans-serif;
                    font-weight: 200;
                    height: 100vh;
                    margin: 0;
                }
    
                .full-height {
                    height: 100vh;
                } 
    
                .flex-center {
                    align-items: center;
                    display: flex;
                    justify-content: center;
                    background:url(../assets/images/png/1A.png) no-repeat fixed 50% 50% / 100% 150%!important;
                }
    
                .position-ref {
                    position: relative;
                }
    
                .top-right {
                    position: absolute;
                    right: 10px;
                    top: 18px;
                }
    
                .content {
                    text-align: center;
                    position:absolute;
                    /*background:rgba(0,0,0,0.5);*/
                    top:0;
                    left:0;
                    right:0;
                    bottom:0;
                    
                }
    
                .title {
                    font-size: 84px;
                    color:#fff;
                    margin-top:100px;
                    font-weight:600;
                }
    
                .links > a {
                    color: #636b6f;
                    padding: 0 25px;
                    font-size: 13px;
                    font-weight: 600;
                    letter-spacing: .1rem;
                    text-decoration: none;
                    text-transform: uppercase;
                }
    
                .m-b-md {
                    margin-bottom: 30px;
                }
    
                .img-float{
                    position: absolute;
                    bottom:0;
                    left:20px;
                }
            </style>
</head>


 <body class="">
        <div class="flex-center position-ref full-height">
            <div class="content p-5">
                <div class="title">
                    <img src="{{ asset('/images/logo.jpg') }}" width="120" alt="logo {{ env('APP_NAME') }}"/>
                </div>
                <h4 style="color:#262626">Votre adresse email a bien été vérifiée, cliquez ici <a href="{{ url('') }}">Lisocash</a></h1>
    
                    {{-- <a href="{{ url('/login') }}" class="btn btn-primary btn-lg mb-3" style="text-decoration:none;color:#FFF;padding: 10px;background:#ff0017;border:0;font-weight:bold;border-radius:40px;width:400px">CONNECTEZ-VOUS</a>--}}
                    <p> Merci d'avoir choisi LISOCASH Transfer !

                            Cordialement, <br>
                            TEL France : 06 05 93 90 08 <br>
                            TEL Gabon : +241 07 46 54 66 <br>
                          EMAIL : <a href="mailto:contact@baxe-moneytransfer.com">contact@lisocash.com</a>
                    </p>
           </div>
        </div>
    </body>
    
</html>


