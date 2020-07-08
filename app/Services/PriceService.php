<?php

namespace App\Services;

class PriceService extends BaseService
{

    /**
     * 名称
     */
    private $name = "";

    /**
     * 本体価格
     */
    private $amount = 0;

    /**
     * 消費税
     * ex) 10% => 0.1
     */
    private $taxRate = 0;

    /**
     * 税・その他金額
     */
    private $tax = 0;

    /**
     * 税込み価格
     */
    private $incluedTax = 0;

    public function __construct(String $name, int $amount)
    {
        $this->setItem($name, $amount);
    }

    public function setItem(String $name, int $amount)
    {
        // 引数チェック
        $this::checkNumeric($amount);

        // 名称
        $this->name = $name;

        // 本体価格
        $this->amount = $amount;

        // 消費税の取得
        $this->taxRate = config("price.tax");

        // 税・その他金額1
        $this->tax = $this->amount * $this->taxRate;

        // 税込み価格
        $this->incluedTax = $this->amount + $this->tax;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getAmount()
    {
        return $this->amount;
    }

    public function getTaxRate()
    {
        return $this->taxRate;
    }

    public function getTax()
    {
        return $this->tax;
    }

    public function getIncludeTax()
    {
        return $this->incluedTax;
    }

    public static function calcIncludeTax($amount)
    {
        // 引数チェック
        PriceService::checkNumeric($amount);

        // 消費税の取得
        $taxRate = config("price.tax");

        // 税・その他金額1
        $tax = $amount * $taxRate;

        // 税込み価格
        return $amount + $tax;
    }

    /**
     * 価格が通常値ならtrue, 異常値ならfalseを返却
     * 通常値：数値かつ、0 <= x < 100000000
     * 異常値：通常値以外
     */
    public static function checkNumeric($num)
    {
        if (!is_numeric($num)) {
            return false;
        }
        if ($num < 0 || 100000000 < $num) {
            return false;
        }

        return true;
    }
}
