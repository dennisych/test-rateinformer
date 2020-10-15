<?php

namespace RateInformer\Cli\DataProviders;

interface ICurrencyRatesProvider
{
    /**
     * Возвращает массив курсов валют.
     *
     * Каждый элемент результирующего массива ДОЛЖЕН быть массивом с ключами
     * `id`, `name` и `rate`:
     *
     * ```
     * [
     *     'id'   => string - ISO 4217 alfa-3 код валюты,
     *     'name' => string - Наименование вылюты,
     *     'rate' => double - Курс валюты по отношению к российскому рублю.
     * ]
     * ```
     *
     * @return array
     */
    public function getRates(): array;
}
