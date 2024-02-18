<?php

return (new PhpCsFixer\Config())
    ->setFinder(
        PhpCsFixer\Finder::create()
            ->exclude(['vendor', 'resources', 'storage', 'pipelines', 'bootstrap'])
            ->in(__DIR__)
    )
;
