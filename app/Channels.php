<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Channels extends Model
{
    protected $table = 'channels';

    public function id()
    {
        return $this->getAttribute('id');
    }

    public function setRepository($repository)
    {
        $this->setAttribute('repository', $repository);
    }

    public function repository()
    {
        return $this->getAttribute('repository');
    }

    public function setDestination($destination)
    {
        $this->setAttribute('destination', $destination);
    }

    public function destination()
    {
        return $this->getAttribute('destination');
    }
}
