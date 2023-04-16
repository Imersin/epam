<?php

namespace system;

abstract class Model
{
    public $aParams;
    public $aRequired;
    public $sTableName;
    public $iId;

    public function __construct($aParams, $iId = null) {
        $this->iId = $iId;
        $this->aParams = $aParams;
    }

    public function load(){
        return \system\Registry::get('db')
            ->add('SELECT * FROM ' . $this->sTableName)
            ->add('WHERE id = ?')
            ->execute([$this->iId])->fetchAll()[0];
    }

    public function validate(){
        if (count(array_intersect_key($this->aParams, $this->aRequired)) == count($this->aRequired))
            return true;
        return false;
    }

    public function save(){
        if ($this->validate()) {
            \system\Registry::get('db')
                ->add('INSERT INTO ' . $this->sTableName)
                ->add('(' . implode(", ", array_keys($this->aParams)) . ')')
                ->add('VALUES (' . implode(", ", $this->aParams) . ')')
                ->execute([]);
        }
    }

    public function update($aParams){
        $oDb = \system\Registry::get('db')
            ->add('UPDATE ' . $this->sTableName . ' SET');
        $sQuery = "";
        foreach ($aParams as $sKey => $mVal) {
            $sQuery .= $sKey . ' = ' . $mVal . ',';
        }
        $sQuery = substr($sQuery, 0, -1);
        $oDb->add($sQuery);
        $oDb->add('WHERE id = ?')->execute([$this->iId]);
    }
}