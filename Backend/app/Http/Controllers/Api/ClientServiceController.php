<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Service;
use App\Models\ClientService;
use Illuminate\Http\Request;

class ClientServiceController extends Controller
{
 
    public function index()
    {
        // consulta la relacion de clientes y servicios
        // un cliente puede tener varios servicios, y un
        $clients = Client::with('services')->get();

        foreach ($clients as $client) {
            $text_services = '';
            foreach ($client->services as $service) {
                if($text_services == ''){
                    $text_services = $service->name;
                    continue;
                }else{
                    $text_services = $text_services.', '.$service->name;
                }
            }
            $client['services_names'] = $text_services;
        }

        return response()->json(['data' => $clients, 'msg' => 'Data queried successfully'], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'service_id' => 'required',
            'client_id' => 'required',
            'position' => 'required',
        ]);
        $data = ClientService::create($request->all());
        return response()->json(['data' => $data, 'msg' => 'Data created successfully'], 200);
    }

    public function show($id)
    {
        $ClientService = ClientService::find($id);
        if(!$ClientService) {
            return response()->json(['data' => $ClientService, 'msg' => 'Data not found'], 404);
        }
        else{
            return response()->json(['data' => $ClientService, 'msg' => 'Data queried successfully'], 200);
        }
    }

    public function update(Request $request, $id)
    {
        $ClientService = ClientService::find($id);
        if(!$ClientService) {
            return response()->json(['data' => $ClientService, 'msg' => 'Data not found'], 404);
        }
        else{
            $ClientService->update($request->all());
            return response()->json(['data' => $ClientService, 'msg' => 'Data updated successfully'], 200);
        }
    }

    public function destroy($id)
    {
        $ClientService = ClientService::find($id);
        if(!$ClientService) {
            return response()->json(['data' => $ClientService, 'msg' => 'Data not found'], 404);
        }
        else{
            $ClientService->delete();
            return response()->json(['data' => $ClientService, 'msg' => 'Data deleted successfully'], 200);
        }
    }
}
