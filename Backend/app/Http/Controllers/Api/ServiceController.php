<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{

    public function index()
    {
        $data = Service::all();
        return response()->json(['data' => $data, 'msg' => 'Data queried successfully'], 200);
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'image' => 'required',
            'type' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'observations' => 'required',
        ]);
        $data = Service::create($request->all());
        return response()->json(['data' => $data, 'msg' => 'Data created successfully'], 200);
    }

    public function show($id)
    {
        $service = Service::find($id);
        if(!$service) {
            return response()->json(['data' => $service, 'msg' => 'Data not found'], 404);
        }
        else{
            return response()->json(['data' => $service, 'msg' => 'Data queried successfully'], 200);
        }
    }

    public function update(Request $request, $id)
    {
        $client = Service::find($id);
        if(!$client) {
            return response()->json(['data' => $client, 'msg' => 'Data not found'], 404);
        }
        else{
            $client->update($request->all());
            return response()->json(['data' => $client, 'msg' => 'Data updated successfully'], 200);
        }
    }

    public function destroy($id)
    {
        $service = Service::find($id);
        if(!$service) {
            return response()->json(['data' => $service, 'msg' => 'Data not found'], 404);
        }
        else{
            $service->delete();
            return response()->json(['data' => $service, 'msg' => 'Data deleted successfully'], 200);
        }
    }
}
