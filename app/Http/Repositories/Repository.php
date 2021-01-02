<?php


namespace App\Http\Repositories;


class Repository
{
    /**
     * @var
     */
    private $model;

    /**
     * Repository constructor.
     * @param $model
     */
    public function __construct($model)
    {
        $this->model = $model;
    }

    /**
     * @return mixed
     */
    public function all()
    {
        return $this->model->all();
    }

    /**
     * @param $data
     * @return mixed
     */
    public function create($data)
    {
        return $this->model->create($data);
    }

    /**
     * @param $where
     * @param $data
     * @return mixed
     */
    public function updateWhere($where, $data)
    {
        return $this->model->where($where)->update($data);
    }

    /**
     * @param $where
     * @return mixed
     */
    public function firstWhere($where)
    {
        return $this->model->where($where)->first();
    }

    /**
     * @param $where
     * @return mixed
     */
    public function deleteWhere($where)
    {
        return $this->model->where($where)->delete();
    }
}
