<?php

use Composer\Composer;
use Composer\IO\IOInterface;
use Composer\Plugin\PluginInterface;
use Composer\EventDispatcher\EventSubscriberInterface;

use Ellipse\Binder\Plugin;

describe('Plugin', function () {

    beforeEach(function () {

        $this->composer = Mockery::mock(Composer::class);
        $this->io = Mockery::mock(IOInterface::class);

        $this->plugin = new Plugin;

        $this->plugin->activate($this->composer, $this->io);

    });

    it('should implement PluginInterface', function () {

        expect($this->plugin)->to->be->an->instanceof(PluginInterface::class);

    });

    it('should implement EventSubscriberInterface', function () {

        expect($this->plugin)->to->be->an->instanceof(EventSubscriberInterface::class);

    });

    describe('->generate()', function () {

        it('should ...', function () {

            $this->composer->shouldReceive('getConfig->get')->once()
                ->with('vendor-dir')
                ->andReturn(sys_get_temp_dir());

            expect([$this->plugin, 'generate'])->to->throw(\Exception::class);

        });

    });

});
