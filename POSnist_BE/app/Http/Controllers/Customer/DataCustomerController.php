<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DataCustomerController extends Controller
{
    public function open()
    {
        $data = "This data is open and can be accessed without the client being authenticated";
        return response()->json(compact('data'), 200);

    }

    public function Closed()
    {
        $data = "Only authorized users can see this";
        return response()->json(compact('data'), 200);
    }
}
