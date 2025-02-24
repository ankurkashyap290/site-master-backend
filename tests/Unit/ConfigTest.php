<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Facades\Config;

class ConfigTest extends TestCase
{
    /**
     * @group config
     */
    public function testExport()
    {
        $exportable = Config::get('exportable');
        $exportedConfig = Config::export();
        
        $this->assertEquals(count($exportable), count($exportedConfig));
        foreach ($exportable as $key => $value) {
            $this->assertTrue(array_key_exists(is_array($value) ? $key : $value, $exportedConfig));
            if (is_array($value)) {
                $this->assertEquals(count($value), count($exportedConfig[$key]));
            }
        }
    }
}
