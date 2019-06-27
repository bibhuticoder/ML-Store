@extends('adminlte::page')

@section('title', 'Manage Credits')
@section('content')
<div class="box box-solid">
  <div class="box-header with-border">
    <h2 class="box-title"> Manage Credits </h2>
  </div>
  <div class="box-body">
    <div class="row">
      <div class="col-md-12">
          <h1>Credits: Rs. {{Auth::user()->credits}}</h1>
          <hr>
      </div>
      <div class="col-md-12">
        <p class="lead">Buy Credits</p>
        <div class="form-inline">
            <label for="amount">Amount:</label>
            <br>

            <div class="form-group">
              <label class="sr-only" for="exampleInputAmount">Amount (in dollars)</label>
              <div class="input-group">
                <div class="input-group-addon">Rs. </div>
                <input type="number" min="10" max="10000" value="15" class="form-control mr-5" id="amount" placeholder="Rs.">
                <div class="input-group-addon">.00</div>
              </div>
            </div>

            <button class="btn btn-primary" id="btn-payment">Buy with Khalti</button>
            <p class="lead" id="message"></p>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://khalti.com/static/khalti-checkout.js"></script>
<script>
  var config = {
      "publicKey": "test_public_key_54d062f3764347b5aba6d0e1babefeca",
      "productIdentity": "1234567890",
      "productName": "ML Store",
      "productUrl": "http://mlstore.com",
      "eventHandler": {
          onSuccess (payload) {
              document.getElementById("message").innerHTML = "Verifying payment...";
              let data = {
                  "token": payload.token,
                  "amount": payload.amount,
                  "user_id": "{{Auth::user()->id}}",
                  "_token": "{{ csrf_token() }}"
              };
              
              $.post("/verify-payment", data)
              .done(response => {
                  location.reload();
              })
              .fail(error => {
                  console.log(error);
              });
          },
          onError (error) {
              console.log(error);
              alert(error.payload.mobile[0]);
          },
          onClose () {
              console.log('Widget is closing');
          }
      }
  };

  var checkout = new KhaltiCheckout(config);
  var btn = document.getElementById("btn-payment");
  var amount = parseInt(document.getElementById("amount").value);
  btn.onclick = function () {
    checkout.show({amount: amount * 100});
  }
</script>


@stop

