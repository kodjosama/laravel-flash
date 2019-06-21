<?php

namespace Spatie\Flash\Tests;

use Spatie\Flash\Flash;
use Spatie\Flash\Message;
use Orchestra\Testbench\TestCase;

/**
 * @coversNothing
 */
class FlashTest extends TestCase
{
    public function testCan_set_a_simple_flash_message()
    {
        flash('my message');

        $this->assertSame('my message', flash()->message);
    }

    public function testCan_flash_array_of_messages()
    {
        flash(['my message', 'my message']);

        $this->assertSame(['my message', 'my message'], flash()->message);
    }

    public function testCan_set_a_flash_message_with_a_class()
    {
        flash('my message', 'my-class');

        $this->assertSame('my message', flash()->message);
        $this->assertSame('my-class', flash()->class);
    }

    public function testCan_set_a_flash_message_with_multiple_classes()
    {
        flash('my message', ['my-class', 'another-class']);

        $this->assertSame('my message', flash()->message);
        $this->assertSame('my-class another-class', flash()->class);
    }

    public function testThe_flash_function_is_macroable()
    {
        Flash::macro('info', function (string $message) {
            return $this->flash(new Message($message, 'my-info-class'));
        });

        flash()->info('my message');

        $this->assertSame('my message', flash()->message);
        $this->assertSame('my-info-class', flash()->class);
    }

    public function testMultiple_methods_can_be_added_in_one_go()
    {
        Flash::levels([
            'warning' => 'alert-warning',
            'error' => 'alert-error',
        ]);

        flash()->warning('my warning');
        $this->assertSame('my warning', flash()->message);
        $this->assertSame('alert-warning', flash()->class);

        flash()->error('my error');
        $this->assertSame('my error', flash()->message);
        $this->assertSame('alert-error', flash()->class);
    }

    public function testWhen_passing_a_class_name_that_is_registered_as_method_it_will_call_that_method()
    {
        flash('my message', 'custom');
        $this->assertSame('custom', flash()->class);

        Flash::levels([
            'custom' => 'overridden-custom',
        ]);

        flash('my message', 'custom');
        $this->assertSame('overridden-custom', flash()->class);
    }

    public function testEmpty_flash_message_returns_null()
    {
        $this->assertNull(flash()->message);
    }
}
