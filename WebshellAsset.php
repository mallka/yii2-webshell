<?php
namespace samdark\webshell;

use yii\web\AssetBundle;

/**
 * WebshellAsset is an asset bundle used to include custom overrides for terminal into the page.
 *
 * @author Alexander Makarov <sam@rmcreative.ru>
 */
class WebshellAsset extends AssetBundle
{

    public $css = [
        'webshell.css',
    ];

    public $depends = [
        'samdark\webshell\JqueryTerminalAsset',
    ];

	public function init()
	{
		$this->sourcePath = __DIR__ . '/assets';
		parent::init();
	}
}
