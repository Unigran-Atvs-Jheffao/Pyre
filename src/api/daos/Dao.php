<?php
namespace Pyre\daos;

interface DAO {
    function add($element);
    function remove($element);
    function update($id, $element);
    function getById($id);
    function getAll();
}