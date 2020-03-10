<?php


interface PlaceInterface
{
    /**
     * @param $id
     * @return array()
     */
    public function queryForPlaces($id=null);
}