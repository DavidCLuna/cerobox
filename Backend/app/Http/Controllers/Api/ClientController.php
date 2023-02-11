<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    
    public function index()
    {
        $data = Client::orderBy('id', 'desc')->get();
        return response()->json(['data' => $data, 'msg' => 'Data queried successfully'], 200);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
                'email' => 'required',
                'phone' => 'required',
                'document' => 'required',
                'image' => 'required',
                'observations' => 'required',
            ]);
            $data = Client::create($request->all());
            return response()->json(['data' => $data, 'msg' => 'Data created successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['data' => $e->getMessage(), 'msg' => 'Error'], 500);
        }
    }

    public function show($id)
    {
        $data = Client::find($id);
        if(!$data) {
            return response()->json(['data' => $data, 'msg' => 'Data not found'], 404);
        }
        else{
            return response()->json(['data' => $data, 'msg' => 'Data queried successfully'], 200);
        }
    }

    public function update(Request $request, $id)
    {
        $client = Client::find($id);
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
        $client = Client::find($id);
        if(!$client) {
            return response()->json(['data' => $client, 'msg' => 'Data not found'], 404);
        }
        else{
            $client->delete();
            return response()->json(['data' => $client, 'msg' => 'Data deleted successfully'], 200);
        }
    }
}
