<?php

class Pastoral
{
  static public function formatDate($date_string)
  {
    $datetime = new datetime($date_string);
    return date_format($datetime, 'm-d-Y');
 
  }
}