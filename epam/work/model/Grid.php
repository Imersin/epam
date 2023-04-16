<?php

namespace work;

class Grid
{
    public $sTableName;
    public $aConditions = [];
    public $iPage;
    public $sJoin = null;
    public $aColumns = [];

    public function __construct($sTableName){
        $this->sTableName = $sTableName;
    }

    public function setJoin($sJoin) {
        $this->sJoin = $sJoin;
    }

    public function addCondition($sCond){
        $this->aConditions[] = $sCond;
    }

    public function clearConditions(){
        $this->aConditions = [];
    }

    public function setPage($iPage){
        $this->iPage = $iPage;
    }

    public function getPage(){
        return $this->iPage;
    }

    public function addColumn($sColumn){
        $this->aColumns[] = $sColumn;
    }

    public function getData(){
        $oDb = \system\Registry::get('db')
            ->add('SELECT ' . implode(', ', $this->aColumns) . ' FROM ' . $this->sTableName);
        if ($this->sJoin) {
            $oDb->add($this->sJoin);
        }
            $oDb->add('WHERE 1=1');
        foreach ($this->aConditions as $sCond) {
            $oDb->add(' AND ' . $sCond);
        }
        $iOffset = ($this->iPage - 1) * 10;
        return $oDb->add('LIMIT 10 OFFSET '. $iOffset)->execute([])->fetchAll();
    }

    public function getCount(){
        $oDb = \system\Registry::get('db')
            ->add('SELECT count(*) FROM ' . $this->sTableName);
        $oDb->add('WHERE 1=1');
        foreach ($this->aConditions as $sCond) {
            $oDb->add(' AND ' . $sCond);
        }
        return $oDb->execute([])->fetchAll()[0]['count'];
    }
}