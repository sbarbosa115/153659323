<?php

namespace App\Service;

use App\Providers\DataProvider;

class DataManager
{
    public $source;

    public function __construct(DataProvider $source)
    {
        $this->source = $source;
    }

    public function filter(int $year, int $limit): array
    {
        $result = [];
        $items = $this->source->getData();
        foreach ($items as $item){
            $date = \DateTime::createFromFormat('Y-m-d', "{$item['date']}");
            if((string) $date->format('Y') === (string) $year && count($result) < $limit){
                $result[] = $item;
            }

            if(count($result) === $limit){
                break;
            }
        }
        return $result;
    }

}