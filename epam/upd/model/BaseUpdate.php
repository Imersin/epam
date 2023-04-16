<?php

namespace upd;

abstract class BaseUpdate
{

protected $oDb = null;

    public function __construct()
    {
        $this->oDb = \system\Registry::get('db');
    }

    abstract function execute();
}