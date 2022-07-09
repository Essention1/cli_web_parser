<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\ParseWorker;


class ParseCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parse:command {link}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     *
     * @var object
     */
    private $parse;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(ParseWorker $pw)
    {
        parent::__construct();
        $this->parse = $pw;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $link = $this->argument('link');
        if ($link) { 
            $output = array();

            $html = file_get_contents($link);

            $entries = $this->parse->getEntries($html, 'a');

            $tag_a = array();
            foreach ($entries as $entry) {
                array_push($tag_a, $entry->getAttribute("href"));
            }
            array_push($output, [
                'a' => $tag_a
            ]);

            //<img href> images
            $entries = $this->parse->getEntries($html, 'img');

            $tag_img = array();
            foreach ($entries as $entry) {
                array_push($tag_img, $entry->getAttribute("href"));
            }
            array_push($output, [
                'img' => $tag_img
            ]);

            //<script src> scripts
            $entries = $this->parse->getEntries($html, 'script');

            $tag_script = array();
            foreach ($entries as $entry) {
                array_push($tag_script, $entry->getAttribute("src"));
            }
            array_push($output, [
                'script' => $tag_script
            ]);

            //<link href> styles
            $entries = $this->parse->getEntries($html, 'link');

            $tag_link = array();
            foreach ($entries as $entry) {
                array_push($tag_link, $entry->getAttribute("href"));
            }
            array_push($output, [
                'link' => $tag_link
            ]);

            echo json_encode($output);
        }
    }
}
