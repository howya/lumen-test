<?php

namespace Tests\Unit;

use Tests\TestCase;

class IOCBindingTest extends TestCase
{
    /**
     * Test IOC binding to ID3 adapter
     *
     * @return void
     */
    public function testActualClassBinding_resolvesToCorrectBinding()
    {
        config(['id3_adapter_path' => \App\ID3\ID3Adapter::class]);

        $class = app(\App\ID3\Contracts\ID3Contract::class);

        $this->assertInstanceOf(\App\ID3\Contracts\ID3Contract::class, $class);
    }

    /**
     * Test IOC binding to ID3 adapter 2
     *
     * @return void
     */
    public function testFakeClassBinding_resolvesToCorrectBinding()
    {
        config(['id3_adapter_path' => \Tests\Fixtures\Classes\ID3Adapter2::class]);

        $class = app(\App\ID3\Contracts\ID3Contract::class);

        $this->assertInstanceOf(\App\ID3\Contracts\ID3Contract::class, $class);
    }
}
