@extends('layouts.app')
@section('title', "Envoyer de l'argent")

@section('css')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
@endsection


@section('content')
    <div id="main-wrapper" class="h-100">
        <form id="form-send-money"  action="{{route('transferts')}}" method="post">
            @csrf
        <div class="container-fluid px-0 " style="height: 600px">
            <div class="row no-gutters h-100">
                <!-- Welcome Text
                      ============================================= -->
                <div class="col-md-6">
                    <div class="hero-wrap d-flex align-items-center h-100">
                        <div class="hero-mask opacity-8 bg-primary"></div>
                        <div class="hero-bg hero-bg-scroll"
                            style="background-image:url('{{ asset('images/bg/image-3.jpg') }}');"></div>
                        <div class="hero-content mx-auto w-100 h-100 d-flex flex-column">
                            <div class="row no-gutters">
                                <div class="col-10 col-lg-9 mx-auto">
                                    <div class="logo mt-2 mb-1 mb-md-0"> <a class="d-flex" title="Lisocash"><img
                                                src="{{ asset('images/logo.png') }}" style="height: 10%; width : 100%"
                                                alt="Lisocash"></a> </div>
                                </div>
                            </div>
                            <div class="row no-gutters my-auto">
                                <div class="col-10 col-lg-9 mx-auto">
                                    <p class="text-3 text-white line-height-4 mb-5">Placez le code QR face au scanner
                                    </p>
                                </div>
                            </div>
                             
                        </div>
                       
                    </div>
                    
                </div>
                
                <!-- Welcome Text End -->

                <!-- Login Form
                      ============================================= -->
                <div class="col-md-6 d-flex align-items-center">
                    
                    <div class="container my-4">
                        <div class="row">
                            <div class="col-md-11 col-lg-12 col-xl-10 mx-auto">
                                <div class="bg-light shadow-sm rounded p-3 p-sm-4 mb-4">
                                    <div class=" " style="border-color : grey" style="height: 500px">
                                        <div style="color: black">
                                        <center>
                                            <p><strong>Scan en cours..</strong></p>
                                        </center>
                                        </div>
                                          <div class="col-6">
                                            <video width="215%" height="100%" src="" id="preview"></video>
                                          </div>
                                      </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                        <label for="text">SCAN CODE RESULT</label>
                        <input type="text" id="text" name="text" readonly class="form-group">
                      </div>
                    </div>
                </div>
                <!-- Login Form End -->
            </div>
        </div>
    </form>
    </div>
@endsection


@section('script')

<script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.1.10/vue.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/webrtc-adapter/3.3.3/adapter.min.js"></script>
<style src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css"></style>

<script>
    let scanner = new Instascan.Scanner({ video: document.getElementById("preview") });
    Instascan.Camera.getCameras().then(function(cameras){
      console.log("CONSOLE => ",cameras); 
          if(cameras.length > 0){
              scanner.start(cameras[0])
          }
          else{
              alert('No camera found')
          }
    }).catch((e)=>{
        console.error(e);
    });

    scanner.addListener('scan',function(c){
      document.getElementById('text').value = c;
    })
  </script>

    <script>
        window.addEventListener('load', function (av) {
            var url = "{{ route('getCountryInfos', ':name') }}";
            url = url.replace(':name', $("#country").val().toString());
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                }
            });
            $.ajax({
                url: url,
                type: 'GET',
                success: function(resp) {
                    // console.log(resp[0].indicatif);
                    $("#indicatif")[0].innerHTML = resp[0].indicatif;
                    $("#flag")[0].src = resp[0].url_drapeau;
                    $("#receiptDevis")[0].innerHTML = resp[0].symbole_monnaie;
                    $("[name = 'pays']")[0].value = resp[0].indicatif;
                    // console.log($("[name = 'indicatif']")[0].value);
                },
                error: function(error) {
                    console.log("error");
                },
            });
        });
    </script>
    <script>
        let destination = $("#country");
        destination.on('change', () => {
            var url = "{{ route('getCountryInfos', ':name') }}";
            url = url.replace(':name', destination.val().toString());
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                }
            });
            $.ajax({
                url: url,
                type: 'GET',
                success: function(resp) {
                    // console.log(resp[0].indicatif);
                    $("#indicatif")[0].innerHTML = resp[0].indicatif;
                    $("#flag")[0].src = resp[0].url_drapeau;
                    $("#receiptDevis")[0].innerHTML = resp[0].symbole_monnaie;
                    $("[name = 'pays']")[0].value = resp[0].indicatif;
                    // console.log($("[name = 'indicatif']")[0].value);
                },
                error: function(error) {
                    console.log("error");
                },
            });
        });
    </script>

<script>
    document.getElementById("sendtrans").addEventListener('click',function (ev){
        ev.preventDefault();
    });
</script>
    <script>
        function sendTransaction(){
            
            console.log("sending transaction");
            var data =  {
                "pays" : $("[name = 'pays']")[0].value,
                "destinataire" : $("[name = 'destinataire']")[0].value,
                "montant" : $("[name = 'montant']")[0].value,
                "paymentMethod" : "Lisocash",
                "receptionMethod" :  $("[name = 'receptionMethod']")[0].value,
            };
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                }
            });
            var url = "http://" + window.location.host + '/api/transferts';
            console.log(data);
            console.log(url);
            $.ajax({
                url: url,
                type: 'POST', 
                data : data,
                success: function(resp) {
                    if(resp.success){
                        console.log(resp);
                        console.log("Well happen");
                    }
                    else{
                        console.log(resp);
                        console.log("Bad happen");
                    }
                },
                error: function(error) {
                    console.log("Very Bad happen");
                    console.log(error);
                },
            });
        }
    </script>


@endsection
