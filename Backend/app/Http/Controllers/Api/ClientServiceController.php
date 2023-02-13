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
        $clients = Client::with(['services', 'clientServices'])->get();


        foreach ($clients as $client) {
            $text_services = '';
            foreach ($client->services as $service) {
                if ($text_services == '') {
                    $text_services = $service->name;
                    continue;
                } else {
                    $text_services = $text_services . ', ' . $service->name;
                }
            }
            $client['services_names'] = $text_services == '' ? 'No tiene servicios' : $text_services;
        }

        return response()->json(['data' => $clients, 'msg' => 'Data queried successfully'], 200);
    }

    // functión que retorna los servicios que no están relacionados a un cliente
    public function getServicesNotClient($idClient)
    {
        $services = Service::whereNotIn('id', function ($query) use ($idClient) {
            $query->select('service_id')->from('client_services')->where('client_id', $idClient);
        })->get();
        return response()->json(['data' => $services, 'msg' => 'Data queried successfully'], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'services' => 'required',
            'client_id' => 'required',
        ]);

        foreach ($request->services as $service) {
            $data = [
                'service_id' => $service,
                'client_id' => $request->client_id,
                'position' => 0
            ];
            ClientService::create($data);
        }

        return response()->json(['data' => $data, 'msg' => 'Data created successfully'], 200);
    }

    public function show($id_client)
    {
        $client = Client::with(['services', 'clientServices'])->find($id_client);

        return response()->json(['data' => $client, 'msg' => 'Data queried successfully'], 200);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'services' => 'required',
        ]);


        $ClientService = ClientService::find($id);
        if (!$ClientService) {
            return response()->json(['data' => $ClientService, 'msg' => 'Data not found'], 404);
        } else {
            $ClientService->update($request->all());
            return response()->json(['data' => $ClientService, 'msg' => 'Data updated successfully'], 200);
        }
    }

    public function destroy($idService, $idClient)
    {
        $ClientService = ClientService::where('service_id', $idService)->where('client_id', $idClient)->first();

        if (!$ClientService) {
            return response()->json(['data' => $ClientService, 'msg' => 'Data not found'], 404);
        } else {
            $ClientService->delete();
            return response()->json(['data' => $ClientService, 'msg' => 'Data deleted successfully'], 200);
        }
    }
}
