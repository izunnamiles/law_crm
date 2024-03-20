<?php

namespace App\Repositories;

use App\Models\Client;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class ClientRepository extends BaseRepository
{
    public function __construct(
        public Client $client,
    ) {
        parent::__construct($client);
    }

    public function list($request): Builder
    {
        $search = $request->query('q');
        $select = $request->query('search');
        return $this->model::query()
            ->when($search, function ($q) use ($search) {
                $q->where('last_name', 'REGEXP', $search);
            })
            ->when($select, function ($q) use ($select) {
                $q->where('first_name', 'REGEXP', $select)
                    ->orWhere('last_name', 'REGEXP', $select);
            });
    }
}
