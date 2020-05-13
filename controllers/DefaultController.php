<?php
	namespace mallka\webshell\controllers;

	use Yii;
	use yii\helpers\Json;
	use yii\helpers\Url;
	use yii\web\Controller;
	use yii\web\Response;

	/**
	 * DefaultController
	 *
	 * @author Alexander Makarov <sam@rmcreative.ru>
	 *
	 * @property \samdark\webshell\Module $module
	 */
	class DefaultController extends Controller
	{
		/**
		 * @inheritdoc
		 */
		public function init()
		{
			Yii::$app->request->enableCsrfValidation = false;
			parent::init();
		}

		/**
		 * Displays initial HTML markup
		 * @return string
		 */
		public function actionIndex()
		{
			$this->layout = 'shell';
			return $this->render('index', [
				'quitUrl' => $this->module->quitUrl ? Url::toRoute($this->module->quitUrl) : null,
				'greetings' => $this->module->greetings
			]);
		}

		/**
		 * RPC handler
		 * @return array
		 */
		public function actionRpc()
		{
			Yii::$app->response->format = Response::FORMAT_JSON;

			$options = Json::decode(Yii::$app->request->getRawBody());

			switch ($options['method']) {
				case 'yii':
					list ($status, $output) = $this->runConsole(implode(' ', $options['params']));
					return ['result' => $output];
				default:
					if(!$this->module->unlimit)
						return ['result'=>'Limited cammand! Please set `unlimit` flag to true if you want to run'];

					list ($status, $output) = $this->runConsoleUnlimit($options['method']);
					return ['result' => $output];
			}
		}

		/**
		 * Runs console command
		 *
		 * @param string $command
		 *
		 * @return array [status, output]
		 */
		private function runConsole($command)
		{
			$cmd = Yii::getAlias($this->module->yiiScript) . ' ' . $command . ' 2>&1';

			$handler = popen($cmd, 'r');
			$output = '';
			while (!feof($handler)) {
				$output .= fgets($handler);
			}

			$output = trim($output);
			$status = pclose($handler);

			return [$status, $output];
		}

		/**
		 * Runs console command without unlimit
		 *
		 * @param string $command
		 *
		 * @return array [status, output]
		 */
		private function runConsoleUnlimit($command)
		{

			$arr = $this->module->unsupportCommands;
			if(is_array($arr) && !empty($arr)){
				$temp = explode(' ',$command);
				$mainCommand = $temp[0];
				if(in_array($mainCommand,$arr))
				{
					return ['0','Error: Still  not support for communicate commands.'];
				}
			}


			$cmd = $command ;
			$handler = popen($cmd, 'r');
			$output = '';
			while (!feof($handler)) {
				$output .= fgets($handler);
			}

			$output = trim($output);
			$status = pclose($handler);

			return [$status, $output];
		}
	}
