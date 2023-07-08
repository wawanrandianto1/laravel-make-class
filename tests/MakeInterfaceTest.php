<?php

namespace Wawan\MakeClass\Tests;

use Orchestra\Testbench\TestCase as BaseTestCase;
use Wawan\MakeClass\MakeClassServiceProvider;
use Illuminate\Filesystem\Filesystem;

class MakeClassTest extends BaseTestCase
{
    /**
     * The filesystem instance.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $files;

    /**
     * Class name.
     *
     * @var string
     */
    protected $classname;

    /**
     * Class file path.
     *
     * @var string
     */
    protected $filepath;

    /**
     * Load package service provider
     * @param  \Illuminate\Foundation\Application $app
     * @return \Wawan\MakeClass\MakeClassServiceProvider
     */
    protected function getPackageProviders($app)
    {
        return [MakeClassServiceProvider::class];
    }

    /**
     * Setup the test environment.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->files = new Filesystem();
        $this->interfacename = 'TestInterface';
        $this->filepath = $this->app['path'].'/'.$this->interfacename.'.php';
    }

    /**
     * Test for creating a new class from artisan command.
     *
     * @test
     */
    public function testCreateInterface()
    {
        $this->artisan('make:interface', ['name' => $this->interfacename, '--force' => true])
             ->doesntExpectOutput('');
        
        $interface_content = $this->files->get($this->filepath);
        
        $this->assertTrue($this->files->exists($this->filepath));
        $this->assertStringContainsStringIgnoringCase('interface '.$this->interfacename, $interface_content);
    }

    /**
     * Test for creating a new class in subfolder from artisan command.
     *
     * @test
     */
    public function testCreateInterfaceInSubfolder()
    {
        $subfolder = 'Subfolder';
        $filepath = $this->app['path'].'/'.$subfolder.'/'.$this->interfacename.'.php';

        $this->artisan('make:interface', ['name' => $subfolder.'\\'.$this->interfacename, '--force' => true])
             ->doesntExpectOutput('');
        
        $interface_content = $this->files->get($filepath);
        
        $this->assertTrue($this->files->exists($filepath));
        $this->assertStringContainsStringIgnoringCase('interface '.$this->interfacename, $interface_content);
        $this->assertStringContainsStringIgnoringCase('namespace App\\'.$subfolder, $interface_content);
    }
}
