<?php 

function showMessage($msg = '', $status = '')
{
    session()->flash('flash', array('message' => $msg, 'status' => $status));
}
