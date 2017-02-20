<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

/**
 * HasResourceRoutes
 * -----------------------
 * Type of @link Model that has restful / resource routes.
 * -----------------------
 *
 * @author  Ferdinand Frank
 * @version 0.1
 * @package App\Models
 */
trait HasResourceRoutes {

    /**
     * Gets the path to the model's 'show' view.
     *
     * @return string
     */
    public function getPath() {
        return $this->buildResourcePath('show');
    }

    /**
     * Gets the path to the model's 'index' view.
     *
     * @return string
     */
    public function getIndexPath() {
        return $this->buildResourcePath('index', false);
    }

    /**
     * Gets the path to the model's 'edit' view.
     *
     * @return string
     */
    public function getEditPath() {
        return $this->buildResourcePath('edit');
    }

    /**
     * Gets the path to the model's 'create' view.
     *
     * @return string
     */
    public function getCreatePath() {
        return $this->buildResourcePath('create', false);
    }

    /**
     * Gets the path to the model's 'store' controller function.
     *
     * @return string
     */
    public function getStorePath() {
        return $this->buildResourcePath('store', false);
    }

    /**
     * Gets the path to the model's 'update' controller function.
     *
     * @return string
     */
    public function getUpdatePath() {
        return $this->buildResourcePath('update');
    }

    /**
     * Gets the path to the model's 'destroy' controller function.
     *
     * @return string
     */
    public function getDestroyPath() {
        return $this->buildResourcePath('destroy');
    }

    /**
     * Builds a resource route based upon the route parents of the model and the action param.
     *
     * @param string $action
     * @param bool $isEditingRoute
     * @return string
     */
    private function buildResourcePath(string $action, bool $isEditingRoute = true) {
        $routeName = '';
        $routeParams = [];

        if (method_exists($this, 'getRouteParents')) {
            foreach ($this->getRouteParents() as $routeParent) {
                $routeParentModel = $this[$routeParent];
                if (method_exists($routeParentModel, 'getRouteId')) {
                    $routeName .= $routeParentModel->getRouteId() . '.';
                } else {
                    $routeName .= $this->getBasicRouteId($routeParentModel) . '.';
                }
                $routeParams[$routeParent] = $routeParentModel;
            }
        }

        if (method_exists($this, 'getRouteId')) {
            $routeId = $this->getRouteId();
        } else {
            $routeId = $this->getBasicRouteId($this);
        }

        $routeName .= $routeId . '.';

        if ($isEditingRoute) {
            $routeParams[$routeId] = $this;
        }

        return route($routeName . $action, $routeParams);
    }

    /**
     * Gets the route id of the model.
     *
     * @param Model $model
     * @return mixed
     */
    private function getBasicRouteId($model) {
        return str_replace("_", "-", $model->getTable());
    }
}