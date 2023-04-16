<?php

namespace work;

class Request extends \system\Model
{
    public $sTableName = 'client_requests';

    public function __construct($aParams, $iId = null)
    {
        parent::__construct($aParams, $iId);
        $this->aRequired = [
            'description' => 1,
            'request_type_id' => 1,
            'open_date' => 1,
            'user_id' => 1,
            'status_id' => 1
        ];
    }
}