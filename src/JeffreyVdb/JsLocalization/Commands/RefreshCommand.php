<?php
namespace JeffreyVdb\JsLocalization\Commands;

use Illuminate\Console\Command;
use JeffreyVdb\JsLocalization\Facades\CachingService;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class RefreshCommand extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'jslocalization:refresh';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Refresh message cache after changing the config file";
 
    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {
        $this->line('Refreshing the message cache...');
        CachingService::refreshMessageCache($this->argument('section'));
    }

    /**
    * Get the console command arguments.
    *
    * @return array
    */
    protected function getArguments()
    {
        return array(
            array('section', InputArgument::REQUIRED, 'Name of the export section'),
        );
    }
}