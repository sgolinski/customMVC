<?php


class Pages
{
    public function __construct()
    {
    }

    public function index()
    {
        echo 'Im in index.';
    }

    public function about($id)
    {
        echo 'This is about site';
    }
}