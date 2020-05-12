<?php
namespace samdark\webshell;

use yii\web\AssetBundle;

/**
 * JqueryTerminalAsset is an asset bundle used to include JQueryTerminal into the page.
 *
 * @see http://terminal.jcubic.pl/
 * @author Alexander Makarov <sam@rmcreative.ru>
 */
class JqueryTerminalAsset extends AssetBundle
{

    public $js = [
        'jquery.terminal/js/jquery.terminal-min.js',
    ];

    public $css = [
        'jquery.terminal/css/jquery.terminal.css',
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];

	public function init()
	{
		$this->sourcePath = __DIR__ . '/assets';
		parent::init();
	}
}
