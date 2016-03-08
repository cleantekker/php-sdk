<?php

namespace Dummy\Entity;

class Job extends AbstractEntity
{
    public function all()
    {
        return $this->client->request('GET', "jobs", []);
    }
    
    public function one($id, array $params = [])
    {
        return $this->client->request('GET', "jobs/" . $id, $params);
    }
}