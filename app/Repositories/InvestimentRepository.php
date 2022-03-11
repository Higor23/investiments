<?php

namespace App\Repositories;

use App\Models\Investiment;
use DateTime;

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
    return $this->entity->create($data);
  }

  public function getInvestiment(string $identify)
  {
    return $this->entity->findOrFail($identify);
  }

  public function getCurrentValue(float $value, string $date)
  {
    $investimentTime = self::getInvestimentTime($date);
    
    return (float) self::getIncome($value, $investimentTime);

  }

  public static function getInvestimentTime(string $date)
  {
    $dateInvestiment = new DateTime($date);
    $dayInvestiment = (int) $dateInvestiment->format('d');
    
    $dateNow = new DateTime(date("Y-m-d"));
    $today = (int) $dateNow->format('d');
    $diffTime = $dateInvestiment->diff($dateNow);

    if($today >= $dayInvestiment and $diffTime->d > 0) {
      $time = (int) $diffTime->m;
      return $time;
    }
    $time = ((int) $diffTime->m) - 1;
    return $time;
  }

  public static function getIncome(float $value, int $investimentTime)
  {
    $finalValue = $value;

    if($investimentTime > 0){
      $i = 0;

      while($i < $investimentTime){
        $value = number_format(($value * 0.52 + $value), 2, '.', '');
        $finalValue = $value;
        $i++;
      }
      return $finalValue;
    }
    return number_format($finalValue, 2, '.', '');
  }
}
