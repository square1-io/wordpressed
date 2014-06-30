<?php namespace Square1\Wordpressed;

use Illuminate\Database\Eloquent\Collection;

class MetaCollection extends Collection
{
    /**
     * Return value for the given key
     * 
     * @param string $key
     *
     * @return string
     */
    public function __get($key)
    {
        foreach ($this->items as $item) {
            if ($item->meta_key == $key) {
                return $item->meta_value;
            }
        }
    }
}
