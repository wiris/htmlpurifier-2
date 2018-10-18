<?php

/**
 * Tests based off of W3C MathML tests. See:
 * http://www.w3.org/Math/testsuite/build/mathml3tests.zip
 */
class HTMLPurifier_HTMLModule_MathW3CTest extends HTMLPurifier_HTMLModuleHarness
{

    public function test()
    {

        $this->config->set('HTML.Math', true);

        $pre = new DOMDocument();
        $post = new DOMDocument();

        // Load the snippets from MathML/w3c and subfolders
        $objects = new RecursiveIteratorIterator(new RecursiveDirectoryIterator('MathML/w3c'));
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