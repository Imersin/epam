<?php

namespace work;

class ServicesFactory
{
    public static function create()
    {
        switch (a($_SESSION, 'role_id')) {
            case '1': //admin
                return '\\work\\adminServicesAction';
            case '2': // worker
                return '\\work\\workerServicesAction';
            case '3':   // client
                return '\\work\\clientServicesAction';
        }
        return '\\work\\guestServicesAction';
    }

}