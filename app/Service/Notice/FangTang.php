<?php


namespace app\Service\Notice;


class FangTang
{
    function sc_send(  $text , $desp = '' , $key = 'SCU52987T8d85ef98f515bed01ada53cd3bafc7695cf8b4372bd62'  )
    {
        $postdata = http_build_query(
            array(
                'text' => $text,
                'desp' => $desp
            )
        );

        $opts = array('http' =>
                          array(
                              'method'  => 'POST',
                              'header'  => 'Content-type: application/x-www-form-urlencoded',
                              'content' => $postdata
                          )
        );
        $context  = stream_context_create($opts);
        return $result = file_get_contents('https://sc.ftqq.com/'.$key.'.send', false, $context);

    }
}