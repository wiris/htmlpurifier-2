<?php

/**
 * Tests based off of custom MathML snippets.
 */
class HTMLPurifier_HTMLModule_MathCustomTest extends HTMLPurifier_HTMLModuleHarness
{

    public function test()
    {

        $this->config->set('HTML.Math', true);

        $pre = new DOMDocument();
        $post = new DOMDocument();

        // Load the snippets from MathML/custom and subfolders
        $objects = new RecursiveIteratorIterator(new RecursiveDirectoryIterator('MathML/custom'));
        foreach($objects as $filename => $object){
            
            // Skip . and ..
            if (basename($filename) == '.' || basename($filename) == '..') {
                continue;
            }

            $snippet = file_get_contents($filename);

            $pre->loadXML($snippet);
            $pre->normalizeDocument();

            $post->loadXML($this->purifier->purify($snippet, $this->config));
            $post->normalizeDocument();

            $this->assertIdentical($pre->saveXML(), $post->saveXML());
        }

    }

}