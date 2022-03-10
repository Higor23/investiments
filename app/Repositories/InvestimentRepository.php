<?php

namespace App\Repositories;

use App\Models\Investiment;

class InvestimentRepository
{
  protected $entity;

  public function __construct(Investiment $model)
  {
    $this->entity = $model;
  }

  public function getAllInvestiments()
  {
    return $this->entity->paginate();
  }

  public function createNewInvestment(array $data): Investiment
  {

    $investiment = $this->entity->create($data);
    return $investiment;
  }
}
