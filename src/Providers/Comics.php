<?php

namespace App\Providers;

class Comics implements DataProvider
{
    public $url = 'http://xkcd.com/info.0.json';

    protected $data = [];

    protected $dbFile;

    public function __construct()
    {
        $this->dbFile = __DIR__ . '/../../db/Comics';
        $data = $this->fetchAllRemoteData();
        $this->prepareData($data);
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function prepareData(array $items): void
    {
        $result = [];
        foreach ($items as $item){
            $date = \DateTime::createFromFormat('Y-m-d', "{$item['year']}-{$item['month']}-{$item['day']}");
            $result[] = [
                'number' => $item['num'],
                'date' => $date->format('Y-m-d'),
                'name' => $item['safe_title'],
                'link' => $item['img'],
                'details' => $item['alt']
            ];
        }
        $this->data = $result;
    }

    protected function fetchAllRemoteData(): array
    {
        $this->checkIfFileExist();
        $data = $this->getFromFile();
        $last = $this->getRemoteData($this->url);
        for($i = 1; $i <= $last['num']; $i++){
            if(!array_key_exists($i, $data)){
                $remoteData = $this->getRemoteData("http://xkcd.com/{$i}/info.0.json");
                if(null !== $remoteData){
                    $data[$remoteData['num']] = $remoteData;
                }
            }
        }

        $this->setToFile($data);
        return $data;
    }

    public function getRemoteData(string $path): ?array
    {
        $data = @file_get_contents($path);
        if($data){
            return  json_decode($data, true);
        }
        return null;
    }

    protected function getFromFile(): array
    {
        try {
            $handle = fopen($this->dbFile, 'r');
            $data = fread($handle, filesize($this->dbFile));
            if($data){
                $result = json_decode($data, true);
            } else {
                $result = [];
            }
            fclose($handle);
            return $result;
        } catch (\Exception $e){
            throw $e;
        }
    }

    protected function setToFile(array $data): void
    {
        try {
            $handle = fopen($this->dbFile, 'w');
            fwrite($handle, json_encode($data));
            fclose($handle);
        } catch (\Exception $e){
            throw $e;
        }
    }

    protected function checkIfFileExist(): void
    {
        if(!file_exists($this->dbFile)){
            file_put_contents($this->dbFile, '[]');
        }
    }
}