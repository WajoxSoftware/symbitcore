<?php
namespace wajox\symbitcore\console;

class CommandsManager
{
	public function run($cmd, $params)
	{
		return (new Command($cmd, $params))->run();
	}
}
