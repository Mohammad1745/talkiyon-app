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
     * @param array $data
     * @return mixed
     */
    public function create(array $data)
    {
        return $this->model->create($data);
    }

    /**
     * @param int $id
     * @param array $data
     * @return mixed
     */
    public function update(int $id, array $data)
    {
        return $this->model->where(['id' => $id])->update($data);
    }

    /**
     * @param array $where
     * @param array $data
     * @return mixed
     */
    public function updateWhere(array $where, array $data)
    {
        return $this->model->where($where)->update($data);
    }

    /**
     * @param array $where
     * @param array $data
     * @return mixed
     */
    public function updateOrCreate(array $where, array $data){
        return $this->model->updateOrCreate($where,$data);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function delete(int $id) {
        return $this->model->where(['id' => $id])->delete();
    }

    /**
     * @param array $where
     * @return mixed
     */
    public function deleteWhere(array $where)
    {
        return $this->model->where($where)->delete();
    }

    /**
     * @param array $where
     * @return mixed
     */
    public function firstWhere(array $where)
    {
        return $this->model->where($where)->first();
    }

    /**
     * @param array $where
     * @return mixed
     */
    public function lastWhere(array $where)
    {
        return $this->model->where($where)->orderby('created_at', 'desc')->first();
    }

    /**
     * @param array $where
     * @return mixed
     */
    public function pluckWhere(array $where)
    {
        return $this->model->where($where)->pluck();
    }

    /**
     * @param array $where
     * @return mixed
     */
    public function getWhere(array $where)
    {
        return $this->model->where($where)->get();
    }

    /**
     * @param array $where
     * @return mixed
     */
    public function countWhere(array $where)
    {
        return $this->model->where($where)->count();
    }

    /**
     * @param array $where
     * @param string $field
     * @return mixed
     */
    public function sumWhere(array $where, string $field)
    {
        return $this->model->where($where)->sum($field);
    }
}
