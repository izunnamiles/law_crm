<?php

namespace App\Repositories;

use App\Models\Cases;

class CasesRepository extends BaseRepository
{
    public function __construct(
        public Cases $cases,
    ) {
        parent::__construct($cases);
    }

}
