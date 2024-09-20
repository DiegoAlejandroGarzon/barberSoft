<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use srmklive\paypal\src\Service\PayPal;
use App\Models\Order;
use DB;

class PaypalController extends Controller
{
    //
    public function create(Request $request){

        $data=json_decode($request->getContent(),true);

       

        //init paypal
        $provider=\PayPal::setProvider();
        $provider->setApiCredentials(config('paypal'));
        $token=$provider->getAccessToken();
        $provider->setAccessToken($token);
        $price = Order::getProductPrice($data['quantity']);
        $description = $data['quantity'];

       
        
        $order=$provider->createOrder([
            "intent"=>"CAPTURE",
            "purchase_units"=> [
                [
                    "amount" => [
                    "currency_code"=>"USD",
                    "value"=> $price
                    ],
                    "description" => $description
                    ]
            ]
            ]);
        //save create order to database
        Order::create([
           'nombres'=>$data['name'],
           'apellidos'=>$data['lastName'],
           'cedula'=>$data['id'],
           'telefono'=>$data['phone'],
           'reference_number'=>$order['id'],
           'description'=>$data['quantity'],
           'precio'=>$price,
           'status'=>$order['status'],
        ]);

        return response()->json($order);
    }


    public function capture(Request $request){

        $data=json_decode($request->getContent(),true);
        $orderId=$data['orderId'];
       

        //init paypal
        $provider=\PayPal::setProvider();
        $provider->setApiCredentials(config('paypal'));
        $token=$provider->getAccessToken();
        $provider->setAccessToken($token);

        $result=$provider->capturePaymentOrder($orderId);

        //update database
            if($result['status'=='COMPLETED']){
            DB:table('orders')
            ->where('reference_number',$result['id'])
            ->update(['status'=>'COMPLETED','updated_at'=>\Carbon\Carbon::now()]);
        }
        return response()->json($result);
    }


    public function Paypal(){
      return view('paypal.checkout');

    }


}
