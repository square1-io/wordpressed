<?php

namespace Square1\Wordpressed;

trait MetaTrait
{
    /**
     * Return meta value from parent object via a magic method.
     *
     * @param string $key
     *
     * @return string
     */
    public function __get($key)
    {
        if (!isset($this->$key)) {
            return $this->meta->$key;
        }

        return parent::__get($key);
    }
}
