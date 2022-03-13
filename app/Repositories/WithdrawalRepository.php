<?php

namespace App\Repositories;

use App\Models\Withdrawal;
use DateTime;

class WithdrawalRepository
{
    protected $entity;

    public function __construct(Withdrawal $model, InvestimentRepository $investiment)
    {
        $this->entity = $model;
        $this->investiment = $investiment;
    }

    public function saveWithdrawal(array $data)
    {

        $idInvestiment = $data['investiment_id'];
        $investiment = $this->investiment->getInvestiment($idInvestiment);
        $verifyInvestimentDateInvert = self::getInvestimentTimeYear($investiment->investiment_date);
        $verifyDateWithdrawal = self::verifyDateWithdrawal($investiment->investiment_date);
        if ($verifyInvestimentDateInvert->invert === 1 or $verifyDateWithdrawal === 1) {
            return [
                'status'  => 'error',
                'message' => 'The withdrawal date cannot be earlier than the investment date or later than today.'
            ];
        }

        $currentValue = $this->investiment->getCurrentValue($investiment->value, $investiment->investiment_date);
        $income =  (float) number_format($currentValue - $investiment->value, 2, '.', '');
        $investimentTime = self::getInvestimentTimeYear($investiment->investiment_date);
        $tax = self::getTax($income, (int) $investimentTime->y);
        $value = $currentValue - $tax;
        $data['value'] = number_format($value, 2, '.', '');
        $data['value_no_tax'] = number_format($currentValue, 2, '.', '');
        $data['income'] = $income;

        $dataInvestiment = [
            'user_id' => $data['user_id'],
            'withdraw' => 'y',
        ];

        $this->investiment->update($dataInvestiment, $idInvestiment);
        return $this->entity->create($data);
    }

    public static function getTax(float $income, string $investimentTime)
    {
        if ($investimentTime < 1) {
            return $income * 0.225;
        } else if ($investimentTime > 1 and $investimentTime <= 2) {
            return $income * 0.185;
        } else {
            return $income * 0.15;
        }
    }

    public static function getInvestimentTimeYear(string $date)
    {
        $dateInvestiment = new DateTime($date);
        $dateNow = new DateTime(date("Y-m-d"));

        return $dateInvestiment->diff($dateNow);
    }

    public static function verifyDateWithdrawal(string $date)
    {
        $result = false;
        $dateNow = date("Y-m-d");
        if ($date > $dateNow) {
            $result = true;
        }
        return $result;
    }
}
