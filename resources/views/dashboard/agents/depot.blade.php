@extends('dashboard.admin.layouts.app')
@section('title',"Rechargement")

@section('content')
<div class="main-panel">
    <div class="content-wrapper">

        <div class="row">
            <div class="col-md-8 col-lg-6 col-xl-5 mx-auto">
              <div class="bg-light shadow-sm rounded p-3 p-sm-4 mb-4">

                @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                    <p>{{ $message }}</p>
                    </div>
                @endif
                <!-- Deposit Money Form
                ============================================= -->
                <form id="form-send-money" method="post" action="">
                    @csrf
                  <div class="form-group">
                    <label for="youSend">Numero</label>
                    <input type="hidden" name="users_id" value="{{auth()->user()->id}}">
                    <div class="input-group">

                      <input type="text" name="numero" class="form-control"  placeholder="0">

                    </div>

                    <div class="form-group">
                        <label for="youSend">Montant</label>
                        <div class="input-group">
                            <div class="input-group-prepend"> <span class="input-group-text">{{auth()->user()->pays->symbole_monnaie}}</span> </div>
                        <input type="text" name="montant" class="form-control" data-bv-field="youSend" id="amountToSend" placeholder="0">

                    </div>

                  <p class="text-muted mt-4">Frais de transactions<span class="float-right d-flex align-items-center">
                       <span id="fee_amount">1.00</span> {{auth()->user()->pays->symbole_monnaie}}

                    </p>

                        <hr>
                  <button class="btn btn-primary btn-block">Envoyer</button>
                </form>
                <!-- Deposit Money Form end -->
              </div>
            </div>
          </div>

    </div>
</div>

@endsection

@section('script')
    <script>

        document.getElementById("amountToSend").addEventListener('keyup', function (e){
            var montant = document.getElementById("amountToSend").value;
            var fees = document.getElementById("fee_amount").innerHTML;
            try {
                // var p = parseInt(montant);
                if(isNaN(montant) || montant.length < 1){
                    montant = 0;
                }
                else{
                    console.log(montant);
                }
            } catch (error) {
                console.log("notint")
                montant = 0;
            }
            document.getElementById("totalAmount").innerHTML = parseFloat(montant) + parseFloat(fees);

        });
    </script>
    <script>
        if (@json(session()->has('success'), JSON_PRETTY_PRINT)) {
            // console.log(@json(session()->has('success'));
            if (@json(session('success'), JSON_PRETTY_PRINT)) {
                toastr.success("{{ session('message') }}", 'Opération réussie', {
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut",
                    timeOut: 5000
                })
            }
            if (!@json(session('success'), JSON_PRETTY_PRINT)) {
                toastr.error("{{ session('message') }}", 'Echec de l\'opération', {
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut",
                    timeOut: 5000
                })
            }
        }

        if (@json($errors->any(), JSON_PRETTY_PRINT)) {
            toastr.error('{{ $errors->first() }}', 'Echec de l\'opération', {
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut",
                timeOut: 5000
            })
        }
    </script>
@endsection