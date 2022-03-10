<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreInvestiment;
use App\Http\Resources\InvestimentResource;
use App\Repositories\InvestimentRepository;
use Illuminate\Http\Request;

class InvestimentController extends Controller
{
    protected $repository;

    public function __construct(InvestimentRepository $investimentRepository)
    {
        $this->repository = $investimentRepository;
    }
    
    public function index()
    {
        return InvestimentResource::collection($this->repository->getAllInvestiments());
    }

    public function store(StoreInvestiment $request)
    {
        return $this->repository->createNewInvestment($request->validated());
    }
}
