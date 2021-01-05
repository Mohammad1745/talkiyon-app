<?php


namespace App\Http\Services;


class Service
{
    /**
     * @var
     */
    private $repository;

    /**
     * BaseService constructor.
     * @param $repository
     */
    public function __construct($repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return mixed
     */
    public function all()
    {
        return $this->repository->all();
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data)
    {
        return $this->repository->create($data);
    }

    /**
     * @param int $id
     * @param array $data
     * @return mixed
     */
    public function update(int $id, array $data)
    {
        return $this->repository->update($id, $data);
    }

    /**
     * @param array $where
     * @param array $data
     * @return mixed
     */
    public function updateWhere(array $where, array $data)
    {
        return $this->repository->updateWhere($where, $data);
    }

    /**
     * @param array $where
     * @param array $data
     * @return mixed
     */
    public function updateOrCreate(array $where, array $data){
        return $this->repository->updateOrCreate($where, $data);
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function delete(int $id) {
        return $this->repository->delete($id);
    }

    /**
     * @param array $where
     * @return mixed
     */
    public function deleteWhere(array $where)
    {
        return $this->repository->deleteWhere($where);
    }

    /**
     * @param array $where
     * @return mixed
     */
    public function firstWhere(array $where)
    {
        return $this->repository->firstWhere($where);
    }

    /**
     * @param array $where
     * @return mixed
     */
    public function lastWhere(array $where)
    {
        return $this->repository->lastWhere($where);
    }

    /**
     * @param array $where
     * @return mixed
     */
    public function pluckWhere(array $where)
    {
        return $this->repository->pluckWhere($where);
    }

    /**
     * @param array $where
     * @return mixed
     */
    public function getWhere(array $where)
    {
        return $this->repository->getWhere($where);
    }

    /**
     * @param array $where
     * @return mixed
     */
    public function countWhere(array $where)
    {
        return $this->repository->countWhere($where);
    }

    /**
     * @param array $where
     * @param string $field
     * @return mixed
     */
    public function sumWhere(array $where, string $field)
    {
        return $this->repository->sumWhere($where, $field);
    }
}
