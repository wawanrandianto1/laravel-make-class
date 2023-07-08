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
        $this->classname = 'TestClass';
        $this->filepath = $this->app['path'].'/'.$this->classname.'.php';
    }

    /**
     * Test for creating a new class from artisan command.
     *
     * @test
     */
    public function testCreateClass()
    {
        $this->artisan('make:class', ['name' => $this->classname, '--force' => true])
                ->doesntExpectOutput('');
        
        $class_content = $this->files->get($this->filepath);
        
        $this->assertTrue($this->files->exists($this->filepath));
        $this->assertStringContainsStringIgnoringCase('class '.$this->classname, $class_content);
        $this->assertStringNotContainsString('__construct', $class_content);
    }

    /**
     * Test for creating a new class with constructor from artisan command.
     *
     * @test
     */
    public function testCreateClassWithConstructor()
    {
        $this->artisan('make:class', ['name' => $this->classname, '--force' => true, '--constructor' => true])
             ->doesntExpectOutput('');
             
        $class_content = $this->files->get($this->filepath);
        
        $this->assertTrue($this->files->exists($this->filepath));
        $this->assertStringContainsStringIgnoringCase('class '.$this->classname, $class_content);
        $this->assertStringContainsString('__construct', $class_content);
    }

    /**
     * Test for creating a new class in subfolder from artisan command.
     *
     * @test
     */
    public function testCreateClassInSubfolder()
    {
        $subfolder = 'Subfolder';
        $filepath = $this->app['path'].'/'.$subfolder.'/'.$this->classname.'.php';

        $this->artisan('make:class', ['name' => $subfolder.'\\'.$this->classname, '--force' => true])
            ->doesntExpectOutput('');
        
        $class_content = $this->files->get($filepath);
        
        $this->assertTrue($this->files->exists($filepath));
        $this->assertStringContainsStringIgnoringCase('class '.$this->classname, $class_content);
        $this->assertStringContainsString('namespace App\\'.$subfolder, $class_content);
    }
}
