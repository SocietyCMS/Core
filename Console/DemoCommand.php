<?php

namespace Modules\Core\Console;

use Illuminate\Console\Command;
use Modules\Core\Console\Demo\DemoMode;
use Modules\Core\Console\Installers\Traits\BlockMessage;
use Modules\Core\Console\Installers\Traits\SectionMessage;
use Symfony\Component\Console\Input\InputOption;

class DemoCommand extends Command
{
    use BlockMessage, SectionMessage;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'society:demo';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Enable SocietyCMS Demo-Mode';
    /**
     * @var DemoMode
     */
    private $demoMode;


    /**
     * Create a new command instance.
     * @param DemoMode $demoMode
     */
    public function __construct(DemoMode $demoMode)
    {
        parent::__construct();
        $this->getLaravel()['env'] = 'local';
        $this->demoMode = $demoMode;
    }

    /**
     * Execute the actions
     *
     * @return mixed
     */
    public function fire()
    {
        $this->blockMessage('Demo Mode', 'This will put SocietyCMS in Demo-Mode and populate it with sample data.', 'comment');

        $success = $this->demoMode->stack([
            \Modules\Core\Console\Demo\Scripts\ModuleSeeders::class,
        ])->enable($this);

        if ($success) {
            $this->blockMessage(
                'SocietyCMS is ready',
                'You can now login with your username and password at /backend',
                'fg=black;bg=green;options=bold'
            );
        }
    }

    protected function getOptions()
    {
        return [
            ['force', 'f', InputOption::VALUE_NONE, 'Force the installation, even if already installed']
        ];
    }
}
