<?php

namespace Ark\Console\Commands\Ark;

use Illuminate\Console\Command;

class Changelog extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ark:changelog';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Insert changelog';

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
    	$this->line('Loading HTML...');
        $bar 			= $this->output->createProgressBar(100);
	    $bar->advance(10);

        $html           = file_get_contents('http://steamcommunity.com/app/346110/discussions/0/594820656447032287/');
        $bar->advance(40);
        $dom            = \pQuery::parseStr($html);
        $form           = $dom->query('.forum_op .content');
        $text           = $form->text();

        $count_having   = count(\Ark\Models\Changelog::all());

        if ($count_having === 0)
        {
            $html           = file_get_contents('http://steamcommunity.com/app/346110/discussions/0/535151589891562062/');
            $dom            = \pQuery::parseStr($html);
            $form           = $dom->query('.forum_op .content');
            $text           .= $form->text();
        }

		$bar->finish();
		$this->line('');
    	$this->line('Parsing HTML...');

        preg_match_all('/v[0-9]+(\.[0-9]){0,1}+/', $text, $versions);
        $versions   = current($versions);
        $versions   = array_values(array_filter($versions, function($item){
            return mb_strlen($item) > 2;
        }));
        $i          = 0;

        while (mb_strlen($text) > 0)
        {
            if (!isset($versions[$i]))
                break;
            $version    = $versions[$i];
            $position   = mb_strpos($text, $version);
            // check if from or to
            $position_from   = mb_strpos($text, 'from ' . $version);
            $position_to     = mb_strpos($text, 'to ' . $version);

            if (false !== $position_to && $position_to < $position && $position - 3 === $position_to)
            {
                $position = false;
            }

            if (false !== $position_from && $position_from < $position && $position - 5 === $position_from)
            {
                $position = false;
            }

            if (false !== $position)
            {
                ++$i;
                if (!isset($versions[$i]))
                    break;
                $position_next = mb_strpos($text, $versions[$i]);

                $changelog = mb_substr($text, $position + mb_strlen($version), $position_next - $position - mb_strlen($version));
                $changelog = str_replace(['- ', '*'], PHP_EOL . '*', $changelog);
                $changelog = preg_replace('/\[.+\]/', '', $changelog);
                if (false !== mb_strpos($changelog, '--'))
                {
                    $changelog = mb_substr($changelog, 0, mb_strpos($changelog, '--'));
                }
                if (false !== mb_strpos($changelog, ': '))
                {
                    $changelog = mb_substr($changelog, 2);
                }
                if (0 === mb_strpos($changelog, PHP_EOL))
                {
                    $changelog = mb_substr($changelog, 1);
                }

                $this->info($version);
                $this->line($changelog);

                if (mb_strlen($changelog) > 0)
                {
                    $exist = \Ark\Models\Changelog::where('version', str_replace('v', '', $version))->first();

                    if (null === $exist)
                    {
                        $conf = \Ark\Models\Changelog::firstOrCreate([
                            'version'   => str_replace('v', '', $version),
                            'text'      => $changelog,
                            'seen'      => $count_having === 0 && ($i > 2)
                        ]);

                        $this->info('  INSERT ');
                    }
                    else
                    {
                        $exist->text = $changelog;
                        $exist->save();
                    }
                }
                $text = mb_substr($text, $position + mb_strlen($version));
            }
            else
            {
                ++$i;
            }
            // break;
        }
        dd($text);

    }
}
