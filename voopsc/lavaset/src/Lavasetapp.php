<?php

namespace Voopsc\Lavaset;

class Lavasetapp
{
    public function __construct(?array $params)
    {
        $this->params = $params;
        $this->getParams();
    }

    private function getParams()
    {
        $params = explode(':', $this->params[1]);
        var_dump($params);
//        $params = $this->params[1];
//        printf($params);
//        return $this->params;
    }
}
