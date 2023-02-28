@extends('dashboard.admin.layouts.app')
@section('title',"Retrait")

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
@endsection