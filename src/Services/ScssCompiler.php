<?php

namespace App\Services;

use ScssPhp\ScssPhp\Compiler;
use ScssPhp\ScssPhp\OutputStyle;

class ScssCompiler {
    public static function compileIfNeeded(): void {
        $scssFile = __DIR__ . '/../../scss/style.scss';
        $cssFile = __DIR__ . '/../../public/css/style.css';

        if (!file_exists($scssFile)) {
            return;
        }

        if (!file_exists($cssFile) || filemtime($scssFile) > filemtime($cssFile)) {
            $cssDir = dirname($cssFile);
            if (!is_dir($cssDir)) {
                mkdir($cssDir, 0755, true);
            }

            $compiler = new Compiler();
            $compiler->setImportPaths(dirname($scssFile));
            $compiler->setOutputStyle(OutputStyle::COMPRESSED);

            try {
                $scssCode = file_get_contents($scssFile);
                $compiledCss = $compiler->compileString($scssCode)->getCss();
                file_put_contents($cssFile, $compiledCss);
            } catch (\Exception $e) {
                error_log("SCSS Compilation Error: " . $e->getMessage());
            }
        }
    }
}
