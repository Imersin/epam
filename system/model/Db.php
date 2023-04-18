<?php

namespace system;

class Db
{
    private $sQueryString;
    private $oPdo;
    private $oResult;

    public function __construct($aUri)
    {
        $this->oPdo = $this->connect($aUri);
    }

    public function connect($aUri) {
        try {
            $oPdo = new \PDO('pgsql:host=' . $aUri[3] . ';port=' . $aUri[4] . ';dbname=' . $aUri[6], $aUri[1], $aUri[2], array(\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION));
            $oPdo->query('SET search_path TO ' . $aUri[5]);
        }
        catch (\Exception $oE) {
            \system\Logger::log($oE);
        }
        return $oPdo;
    }

    public function add($sQueryPart)
    {
        $this->sQueryString .= "\n" . $sQueryPart;
        return $this;
    }

    public function fetchAll()
    {
        $aResult = $this->oResult->fetchAll(\PDO::FETCH_ASSOC);
        return false === $aResult ? array() : $aResult;
    }

    public function execute(array $aParams = array())
    {
        $this->oResult = $this->executeQuery($this->sQueryString, $aParams);
        return $this;
    }

    private function executeQuery($sSql, array $aParams = array())
    {
        try {
            $this->cleanQuery();

            $this->oResult = $this->oPdo->prepare($this->replaceQuestionMarks($sSql, $aParams));

            $aPsParams = array();
            $i = 1;
            foreach ($aParams AS $sParam) {
                $aPsParams[':' . $i] = $sParam;
                $i++;
            }

            $this->oResult->execute($aPsParams);

            return $this->oResult;
        } catch (\Exception $oE) {
            \system\Logger::log($oE);
            throw new \Exception($sSql);
        }
    }

    public function cleanQuery()
    {
        $this->sQueryString = '';
        return $this;
    }

    public function replaceQuestionMarks($sSql, array $aParams = array())
    {
        for($i = 0; $i < count($aParams); $i++) {
            $sSql = preg_replace('/\?/', sprintf(':%s',  $i + 1), $sSql, 1);
        }
        return $sSql;
    }

}