<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MLModel;
use App\Models\ModelUpdate;
use App\Models\ModelReview;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
      $models_count = Auth::user()->models()->count();
      $updates_count =Auth::user()->updates()->count();
      $reviews_count = Auth::user()->reviews()->count();
      $credits = Auth::user()->credits;
      $updates = ModelUpdate::orderBy('created_at', 'DESC')->limit(15)->get();

      return view('dashboard', compact('models_count', 'updates_count', 'reviews_count', 'credits', 'updates'));
    }

    public function manageCredits(){
      return view('manage_credits');
    }

    public function verifyPayment(Request $request){

      $args = http_build_query(array(
        'token' => $request->input('token'),
        'amount'  => $request->input('amount')
      ));
      
      $url = "https://khalti.com/api/v2/payment/verify/";
      
      # Make the call using API.
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_POST, 1);
      curl_setopt($ch, CURLOPT_POSTFIELDS,$args);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      
      $headers = ['Authorization: Key test_secret_key_f59e8b7d18b4499ca40f68195a846e9b'];
      curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
      
      // Response
      $response = curl_exec($ch);
      $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
      curl_close($ch);

      Auth::user()->update([
        'credits' => Auth::user()->credits + ($request->input('amount')/100)
      ]);

      return $response . '<br>' . $status_code;
    }

}
