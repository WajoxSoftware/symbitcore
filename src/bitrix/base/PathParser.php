<?php
namespace wajox\symbitcore\bitrix\base;

use wajox\symbitcore\exceptions\NotFoundException;

class PathParser
{
    protected $rewriteRules = [];

    public function getBitrixPath($path)
    {
        $fullPath = APP_BITRIX_ROOT_DIR . $this->computeBitrixPath($path);

        if (!file_exists($fullPath)
            || !$this->isBitrixPath($fullPath)
        ) {
            return APP_BITRIX_ROOT_DIR . '/404.php';
        }

        return $fullPath;
    }

    protected function computeBitrixPath($path)
    {
        foreach ($this->rewriteRules as $rule) {
            if (preg_match($rule['CONDITION'], $path) === 1) {
                return $rule['PATH'];
            }
        }

        $ext = pathinfo($path, PATHINFO_EXTENSION);

        if (file_exists(APP_BITRIX_ROOT_DIR . $path . '/index.php')) {
            return $path . '/index.php';
        }

        if (file_exists(APP_BITRIX_ROOT_DIR . $path)) {
            return $path;
        }

        return $path;
    }

    protected function isBitrixPath($path)
    {
        $realPath = realpath($path);
        $bitrixRealPath = realpath(APP_BITRIX_ROOT_DIR);

        return strpos($realPath, $bitrixRealPath) === 0
            && (file_exists($realPath) || file_exists($realPath . '/index.php'));
    }

    protected function setRewriteRules($rewriteRules)
    {
        $this->rewriteRules = $rewriteRules;

        return $this;
    }

    protected function loadRewriteRules()
    {
        $arUrlRewrite = [];

        if (file_exists(APP_BITRIX_ROOT_DIR . "/urlrewrite.php")) {
            include(APP_BITRIX_ROOT_DIR . "/urlrewrite.php");
            $this->setRewriteRules($arUrlRewrite);
        }
    }
}
