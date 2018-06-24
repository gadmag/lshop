<?php

namespace App\Service;

trait TreeService
{
    public static function getTree($tree, $pid=0) {
        $output = array();
        foreach ($tree as $key => $row) {
            if ($row->parent_id == $pid) {
                $child = self::getTree($tree, $row->id);
                $output[] = array('item' => $row, 'children' => $child );
            }
        }

        if(count($output) == 0) {
            return null;
        }

        return $output;
    }
}