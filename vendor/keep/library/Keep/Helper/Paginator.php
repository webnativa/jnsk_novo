<?php

namespace Keep\Helper;

use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use Zend\Paginator\Paginator as ZendPaginator;

class Paginator {
    
    protected $query;
    
    public function __construct($query) {
        $this->query = $query;
    }
    
    public function getPaginator($CountPerPage = 50) {
        if(!$this->query){
            return false;
        }
        $adapter = new DoctrineAdapter(new ORMPaginator($this->query));
        $paginator = new ZendPaginator($adapter);
        $paginator->setDefaultItemCountPerPage($CountPerPage);
        return $paginator;
    }

}
