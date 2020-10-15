<?php

namespace RateInformer\Cli\DataProviders;

class CrbXmlRatesDataProvider extends \XMLReader implements ICurrencyRatesProvider
{
    /**
     * URI ресурса с курсами валют.
     */
    private const URI = "http://www.cbr.ru/scripts/XML_daily.asp";

    /**
     * Массив преобразованных данных.
     *
     * @var array
     */
    private $parsed_data;

    /**
     * {@inheritdoc}
     */
    public function getRates(): array
    {
        if (!$this->parsed_data) {
            $this->open(self::URI);

            while ($this->read() && $this->name !== 'Valute');

            $result = [];

            while ($this->name === 'Valute') {
                $result[] = $this->parseValute();
                $this->next('Valute');
            }

            $this->parsed_data = $result;
            $this->close();
        }

        return array_map(function ($item) {
            return [
                'id'   => $item['char_code'],
                'name' => $item['name'],
                'rate' => $item['value'] / $item['nominal'],
            ];
        }, $this->parsed_data);
    }

    /**
     * Возвращает массив преобразованных данных `Valute` node.
     *
     * @return array
     */
    private function parseValute(): array
    {
        $result['id'] = $this->getAttribute(('ID'));

        while ($this->read() && $this->name !== 'Valute') {
            switch ($this->name) {
                case "NumCode":
                    $this->read();
                    $result["num_coode"] = $this->value;
                    $this->read();
                    break;
                case "CharCode":
                    $this->read();
                    $result["char_code"] = $this->value;
                    $this->read();
                    break;
                case "Nominal":
                    $this->read();
                    $result["nominal"] = intval($this->value);
                    $this->read();
                    break;
                case "Name":
                    $this->read();
                    $result["name"] = $this->value;
                    $this->read();
                    break;
                case "Value":
                    $this->read();
                    $result["value"] = floatval(str_replace(',', '.', $this->value));
                    $this->read();
                    break;
            }
        }

        return $result;
    }
}
