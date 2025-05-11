<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

abstract class Repository
{
    private string $modelClass;

    protected Model $model;

    public function __construct(string $modelClass)
    {
        $this->modelClass = $modelClass;
        $this->model = app($this->modelClass);
    }

    /**
     * クラス名を取得
     */
    public function getModelClass(): string
    {
        return $this->modelClass;
    }

    /**
     * IDで単一のモデルを取得
     *
     * @param  int|string  $id
     */
    public function getOneById($id): ?Model
    {
        return $this->model->find($id) instanceof Model ? $this->model->find($id) : null;
    }

    /**
     * 複数のIDに基づいてモデルのコレクションを取得
     *
     * @param  array<int|string>  $ids
     * @return \Illuminate\Support\Collection<int, Model>
     */
    public function getByIds(array $ids): Collection
    {
        return $this->model->find($ids);
    }

    /**
     * すべてのモデルのコレクションを取得
     *
     * @return \Illuminate\Support\Collection<int, Model>
     */
    public function getAll(): Collection
    {
        return $this->model->all();
    }

    public function getFirstWhere(...$params): ?Model
    {
        return $this->model->firstWhere(...$params);
    }
}
