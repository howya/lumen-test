<?php

namespace Tests\Unit;

use App\ID3\ID3Manager;
use Tests\Fixtures\Classes\ID3Adapter2;
use Tests\TestCase;

class IOCBindingTest extends TestCase
{
    /**
     * Test manger default binding to ID3 adapter
     *
     * @return void
     */
    public function testActualClassBinding_resolvesToCorrectBinding()
    {
        config()->set('id3.driver.name', 'ID3Adapter');

        $ID3Manager = new ID3Manager(app());

        $this->assertInstanceOf(\App\ID3\Contracts\ID3Contract::class, $ID3Manager->driver());
        $this->assertInstanceOf(\App\ID3\ID3Adapter::class, $ID3Manager->driver());
    }

    /**
     * Test manager default binding to ID3 adapter 2
     *
     * @return void
     */
    public function testFakeClassBinding_resolvesToCorrectBinding()
    {

        config()->set('id3.driver.name', 'ID3Adapter2');

        $ID3Manager = new ID3Manager(app());

        $ID3Manager->extend('ID3Adapter2', function () {
            return new ID3Adapter2();
        });

        $this->assertInstanceOf(\App\ID3\Contracts\ID3Contract::class, $ID3Manager->driver());
        $this->assertInstanceOf(ID3Adapter2::class, $ID3Manager->driver());
    }
}
