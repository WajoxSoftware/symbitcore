<?php
namespace wajox\symbitcore\bitrix\base;

class BaseController extends \wajox\symbitcore\base\BaseController
{
	public function init()
	{
		parent::init();

		$this->getApplication()->getSettings()->loadBitrixFiles = true;
	}

	public function can($action)
	{
		$this->getBitrixUser()->CanDoOperation($action);
	}

	public function getBitrixUser()
	{
		return $this->getBitrix()->USER;
	}

	public function getBitrixApp()
	{
		return $this->getBitrix()->APPLICATION;
	}
}