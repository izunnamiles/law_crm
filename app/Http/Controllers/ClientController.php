<?php

namespace App\Http\Controllers;

use App\Repositories\ClientRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClientController extends Controller
{
    public function __construct(
        private ClientRepository $clientRepository
    ) {
    }
    public function index(Request $request)
    {
        $clients = $this->clientRepository
            ->list($request)
            ->paginate();
        return view('clients.list', compact('clients'));
    }

    public function find(Request $request)
    {
        $relation = [
            'cases' => function ($q) {
                $q->take(5);
            },
            'cases.counsel'
        ];
        $client = $this->clientRepository->find($request->id, $relation);
        return view('clients.info', compact('client'));
    }

    public function select(Request $request)
    {
        return response()->json([
            'data' => $this->clientRepository
                ->list($request)
                ->select('id', DB::raw("CONCAT(first_name,' ',last_name) as  name"))
                ->pluck('name', 'id')
                ->toArray()
        ]);
    }
}
