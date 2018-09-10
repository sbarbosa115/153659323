<?php

namespace App\Facade;

use App\Providers\Comics;
use App\Providers\DataProvider;
use App\Providers\Space;
use App\Factories\ValidatorFactory;
use App\Service\DataManager;
use Exception;
use Illuminate\Validation\Rule;

class Data {

    protected $dataProvider;

    protected $dataManager;

    protected $params;

    public function __construct(array $params)
    {
        $this->isDataInputValid($params);
        $this->dataManager = new DataManager($this->chooseDataProvider($params['sourceId']));
    }

    public static function getResult($params): array
    {
        $self  = new Data($params);
        $data = $self->dataManager->filter($params['year'], $params['limit']);
        return $self->wrapRequest($data);
    }

    protected function chooseDataProvider(string $source): DataProvider
    {
        switch ($source){
            case 'space':
                return new Space();
            case 'comics':
                return new Comics();
            default:
                throw new Exception('Given source does not match with either known.');
        }
    }

    protected function wrapRequest(array $data): array
    {
        return [
            'meta' => [
                'request' => $this->params,
                'timestamp' => time(),
            ],
            'data' => $data
        ];
    }

    protected function isDataInputValid(array $params): void
    {
        $validatorFactory = new ValidatorFactory();

        $validator = $validatorFactory->make($params, [
            'sourceId' => ['required', 'in:comics,space'],
            'year' => ['required', 'numeric', 'min:2000'],
            'limit' => ['required', 'numeric', 'min:1'],
        ]);

        if($validator->fails()){
            throw new \Exception($validator->errors());
        }

        $this->params = $params;
    }
}