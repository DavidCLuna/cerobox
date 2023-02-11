<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\ServiceClient;
use Illuminate\Http\Request;

class ServiceClientController extends Controller
{
 
    public function index()
    {
        // consulta la relacion de clientes y servicios
        $data = ServiceClient::with('service', 'client')->get();
        return response()->json(['data' => $data, 'msg' => 'Data queried successfully'], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'service_id' => 'required',
            'client_id' => 'required',
            'position' => 'required',
        ]);
        $data = ServiceClient::create($request->all());
        return response()->json(['data' => $data, 'msg' => 'Data created successfully'], 200);
    }

    public function show($id)
    {
        $serviceClient = ServiceClient::find($id);
        if(!$serviceClient) {
            return response()->json(['data' => $serviceClient, 'msg' => 'Data not found'], 404);
        }
        else{
            return response()->json(['data' => $serviceClient, 'msg' => 'Data queried successfully'], 200);
        }
    }

    public function update(Request $request, $id)
    {
        $serviceClient = ServiceClient::find($id);
        if(!$serviceClient) {
            return response()->json(['data' => $serviceClient, 'msg' => 'Data not found'], 404);
        }
        else{
            $serviceClient->update($request->all());
            return response()->json(['data' => $serviceClient, 'msg' => 'Data updated successfully'], 200);
        }
    }

    public function destroy($id)
    {
        $serviceClient = ServiceClient::find($id);
        if(!$serviceClient) {
            return response()->json(['data' => $serviceClient, 'msg' => 'Data not found'], 404);
        }
        else{
            $serviceClient->delete();
            return response()->json(['data' => $serviceClient, 'msg' => 'Data deleted successfully'], 200);
        }
    }
}
