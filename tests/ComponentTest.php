<?php
use PHPUnit\Framework\TestCase;
use App\Facade\Data;

class ComponentTest extends TestCase
{
    public function testExpectedFormatData()
    {
        $data = Data::getResult([
            'sourceId' => 'space',
            'year' => 2010,
            'limit' => 1
        ]);

        $this->assertArrayHasKey('meta', $data);
        $this->assertArrayHasKey('request', $data['meta']);
        $this->assertArrayHasKey('timestamp', $data['meta']);
        $this->assertArrayHasKey('data', $data);

        foreach ($data['data'] as $item){
            $this->assertArrayHasKey('number', $item);
            $this->assertArrayHasKey('date', $item);
            $this->assertArrayHasKey('link', $item);
            $this->assertArrayHasKey('details', $item);
        }

        $data = Data::getResult([
            'sourceId' => 'comics',
            'year' => 2010,
            'limit' => 1
        ]);

        $this->assertArrayHasKey('meta', $data);
        $this->assertArrayHasKey('request', $data['meta']);
        $this->assertArrayHasKey('timestamp', $data['meta']);
        $this->assertArrayHasKey('data', $data);
        foreach ($data['data'] as $item){
            $this->assertArrayHasKey('number', $item);
            $this->assertArrayHasKey('date', $item);
            $this->assertArrayHasKey('link', $item);
            $this->assertArrayHasKey('details', $item);
        }

    }

    public function testData()
    {
        $data = Data::getResult([
            'sourceId' => 'space',
            'year' => 2016,
            'limit' => 1
        ]);

        foreach ($data['data'] as $item){
            $this->assertArrayHasKey('date', $item);
            $date = \DateTime::createFromFormat('Y-m-d', $item['date']);
            $this->assertSame('2016', $date->format('Y'));
        }
        $this->assertSame(1, count($data['data']));

        $data = Data::getResult([
            'sourceId' => 'comics',
            'year' => 2014,
            'limit' => 2
        ]);

        foreach ($data['data'] as $item){
            $this->assertArrayHasKey('date', $item);
            $date = \DateTime::createFromFormat('Y-m-d', $item['date']);
            $this->assertSame('2014', $date->format('Y'));
        }

        $this->assertSame(2, count($data['data']));
    }

    public function testExceptionParameter1()
    {
        $this->expectException(\Exception::class);
        Data::getResult([
            'sourceIsd' => 'space',
            'year' => 2016,
            'limit' => 1
        ]);
    }

    public function testExceptionParameter2()
    {
        $this->expectException(\Exception::class);
        Data::getResult([
            'sourceIsd' => 'space',
            'year' => 2016,
            'limit' => 1
        ]);
    }

    public function testExceptionParameter3()
    {
        $this->expectException(\Exception::class);
        Data::getResult([
            'sourceId' => 'SPACE',
            'year' => 2016,
            'limit' => 1
        ]);
    }
}