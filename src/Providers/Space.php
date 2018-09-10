<?php

namespace App\Providers;

class Space implements DataProvider
{
    public $url = 'https://api.spacexdata.com/v2/launches';

    protected $data = [];

    public function __construct()
    {
        $data = $this->getRemoteData($this->url);
        $this->prepareData($data);
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function getRemoteData(string $path): ?array
    {
        $data = @file_get_contents($path);
        if($data){
            return  json_decode($data, true);
        }
        return null;
    }

    public function prepareData(array $items): void
    {
        $result = [];
        foreach ($items as $item){
            $date = new \DateTime("@{$item['launch_date_unix']}");
            $link = isset($item['links']['wikipedia']) ? $item['links']['wikipedia'] : array_rand($item['links'], 2);
            $result[] = [
                'number' => $item['flight_number'],
                'date' => $date->format('Y-m-d'),
                'name' => $item['mission_name'],
                'link' => $link,
                'details' => $item['details']
            ];
        }
        $this->data = $result;
    }
}