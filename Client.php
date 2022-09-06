<?php

namespace sammaye\solr;

use Yii;
use yii\base\Component;
use Solarium\Client as SolrClient;
use Solarium\Core\Client\Adapter\Curl;
use Symfony\Component\EventDispatcher\EventDispatcher;

class Client extends Component
{
	public $options = [];

	public $solr;

	public function init()
	{
		$adapter = new Curl();
		$eventDispatcher = new EventDispatcher();
		
		$this->solr = new SolrClient($adapter, $eventDispatcher, $this->options);
	}

	public function __call($name, $params)
	{
		if(method_exists($this->solr, $name)){
			return call_user_func_array([$this->solr, $name], $params);
		}
		parent::call($name, $params); // We do this so we don't have to implement the exceptions ourselves
	}
}
