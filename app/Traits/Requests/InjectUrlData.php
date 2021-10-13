<?php

namespace App\Traits\Requests;

trait InjectUrlData
{
    /**
     * inject ot request ids kept in the links
     *
     * @param null $keys
     * @return array
     */
    public function all($keys = NULL): array
    {
        $data = parent::all($keys = NULL);
        $data['id'] = $this->route('id');

        return $data;
    }
}
