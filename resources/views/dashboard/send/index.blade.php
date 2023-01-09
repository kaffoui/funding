@extends('layouts.app')
@section('title', "Envoyer de l'argent")

@section('css')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
@endsection


@section('content')
    <div id="main-wrapper" class="h-100">
        <form id="form-send-money"  action="{{route('transferts')}}" method="post">
            @csrf
        <div class="container-fluid px-0 h-100">
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
                            <div class="row no-gutters my-5">
                                <div class="col-10 col-lg-9 mx-auto">
                                    <h6 class="text-white mb-3">Moyen de réception
                                    </h6>
                                    <select name="receptionMethod" id="" class="form-control">
                                        <option value="Lisocash" selected>Lisocash</option>
                                        {{-- <option value="Airtel">Airtel Money</option>
                                        <option value="Mtn">MTN Mobile Money</option>
                                        <option value="Orange">Orange Money</option> --}}
                                    </select>
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
                                    {{-- <h3 class="text-5 font-weight-400 mb-3">Personal Details</h3> --}}
                                    <!-- Send Money Form
                                                ============================================= -->
                               
                                        <div class="form-group">
                                            <div class=" row col-12 mb-3">
                                                <label for="destinataire" class="col-9 mt-3">Pays de destination</label>
                                                <div class="input-group-prepend col-3"><img id="flag" height="60" ,
                                                        width="100" src=" "></img>
                                                </div>
                                            </div>

                                            <select name="country" id="country" class="form-control">
                                                @foreach ($countries as $country)
                                                    <option value="{{ $country->nom }}">{{ $country->nom }}</option>
                                                @endforeach
                                            </select>

                                        </div>
                                        <div class="form-group">
                                            <label for="destinataire">Destinataire</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend"> <span class="input-group-text"
                                                        id="indicatif">+229</span>
                                                </div>
                                                <input type="text" value="" name="pays" hidden>
                                                <input type="text" value="" class="form-control"
                                                    data-bv-field="destinataire" id="destinataire" name="destinataire"
                                                    required placeholder="Entrez le numéro de téléphone">

                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="youSend">Vous envoyez</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend"> <span class="input-group-text">{{$current_devise}}</span>
                                                </div>
                                                <input type="text" class="form-control" data-bv-field="montant"
                                                    name="montant" value="1" placeholder="" required>
                                             
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="recipientGets">Le destinataire reçoit</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend"> <span class="input-group-text" id="receiptDevis" >$</span>
                                                </div>
                                                <input type="text" class="form-control" data-bv-field="recipientGets"
                                                    id="recipientGets" value="1,410.06" placeholder="" disabled>
                                            </div>
                                        </div>
                                        {{-- <p class="text-muted text-center">The current exchange rate is <span
                                                class="font-weight-500">1
                                                USD = 1.42030 AUD</span></p> --}}
                                        <hr>
                                        <p class="mb-1">Frais de transactions<span class="text-3 float-right">7.21
                                                USD</span></p>
                                        <p class="font-weight-500">Montant prélevé<span
                                                class="text-3 float-right">1,000.00 USD</span>
                                        </p>
                                        <button  type="submit"
                                            class="btn btn-primary btn-block">Continuer</button>
                                  
                                    <!-- Send Money Form end -->
                                </div>
                            </div>
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
