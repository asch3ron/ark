<?php

namespace Ark\Console\Commands\Ark;

use Illuminate\Console\Command;

class Install extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ark:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install & configure environnement';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if ($this->confirm('Do you want to run migrations "php artisan migrate" ?', 'yes'))
        {
            echo shell_exec('php artisan migrate');
        }

    	if ($this->confirm('Do you want to run "composer install" ?', 'yes'))
    	{
		   	echo shell_exec('composer install');
		}

		if ($this->confirm('Do you want to configure your .env ?', 'yes'))
    	{
		   	$ark_path 	= $this->ask('What is your ARK path ?', '/home/steam/servers/ark');
			$ark_map  	= $this->ask('So, what is your ARK Map ?', 'TheIsland');
			$ark_ip  	= $this->ask('What is your ARK server IP ?', '62.210.97.105');
			$ark_port  	= $this->ask('What is your ARK server PORT ?', '7777');
		   	$ark_name 	= $this->ask('What would be the name of your server ?', 'ARK Server');

			$ark_str 	= PHP_EOL . PHP_EOL . "ARK_PATH=$ark_path" . PHP_EOL . "ARK_MAP=$ark_map" . PHP_EOL . "ARK_SERVER_IP=$ark_ip" . PHP_EOL . "ARK_SERVER_PORT=$ark_port" . PHP_EOL . PHP_EOL;

			$env 		= file_get_contents('.env');

			$begin_env 	= substr($env, 0, strrpos($env, '### ARK') + strlen('### ARK'));
    		$end_env   	= substr($env, strrpos($env, '### /ARK'));

    		file_put_contents('.env', $begin_env . $ark_str . $end_env);

    		$this->line('>> .env ark configuration rewrite!');

    		// save server into DB
    		$conf = \Ark\Models\Server::firstOrCreate([
                'name'      => $ark_name,
                'ip'      	=> $ark_ip,
                'path'   	=> $ark_path,
                'port'   	=> $ark_port
            ]);
		}

        if ($this->confirm('Do you want to install crontab configuration "php artisan ark:cron" ?', 'yes'))
        {
            echo shell_exec('php artisan ark:cron');
        }

		if ($this->confirm('Do you want import ARK server configuration from `http://ark.gamepedia.com/Server_Configuration` ?', 'yes'))
    	{
		   	$this->loadConfiguration();
		}

        $this->info(shell_exec('php artisan key:generate'));
    }

    private function loadConfiguration()
    {
    	$this->line('Loading HTML...');
        $bar 			= $this->output->createProgressBar(100);
	    $bar->advance(10);

        $html           = file_get_contents('http://ark.gamepedia.com/Server_Configuration');
        $dom            = \pQuery::parseStr($html);
        $wikitables     = $dom->query('.wikitable');
        $configurations = null;

		$bar->finish();
		$this->line('');
    	$this->line('Parsing HTML...');

    	$server = \Ark\Models\Server::first();

        foreach ($wikitables as $wikitable)
        {
            if (trim($wikitable->query('tr')->text()) === 'Option Value Type Default Effect')
            {
                $configurations = $wikitable;
                break;
            }
        }

        if (null !== $configurations)
        {
            $configurations = \pQuery::parseStr($configurations->html());
            $bar 			= $this->output->createProgressBar(count($configurations->query('tr')));

            foreach ($configurations->query('tr') as $line)
            {
                $configuration = [];
                foreach ($line->query('td') as $td)
                    $configuration[] = trim($td->text());

                if (count($configuration) > 0)
                {
                    list($name, $type, $default, $comment) = $configuration;

                    if (!empty($name) && $type != 'N/A')
                    {
                        $conf = \Ark\Models\Configuration::firstOrCreate([
                            'name'      => $name,
                            'type'      => $type,
                            'default'   => $default,
                            'comment'   => $comment
                        ]);

                        if (null !== $server)
                        {
                        	\Ark\Models\Server\Configuration::firstOrCreate([
	                            'id_server'     	=> $server->id_server,
	                            'id_configuration'  => $conf->id,
	                            'value'   			=> $default
	                        ]);
                        }

                        if ($conf->wasRecentlyCreated)
	                        $this->info('  INSERT ' . $name);
                    }
                }

			    $bar->advance();
            }

			$bar->finish();
			$this->line('');
        }
    }
}
