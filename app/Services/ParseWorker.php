<?php

namespace App\Services;

use DOMDocument;
use DOMXPath;

class ParseWorker 
{
    public function getEntries($html, $tag)
    {
        $doc = new DOMDocument;
        @$doc->loadHTML($html);
        $xpath = new DOMXPath($doc);

        $query = "//".$tag;
        return $xpath->query($query);
    }
}