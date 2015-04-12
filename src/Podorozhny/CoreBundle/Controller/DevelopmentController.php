<?php

namespace Podorozhny\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class DevelopmentController
	extends Controller
{
	public function testAction()
	{
		$phone = '+7 (495) 500-77-35';

		list($code, $block1, $block2, $block3) = sscanf($phone, "+7 (%d) %d-%d-%d");

		$phone = $code . $block1 . $block2 . $block3;

		return new Response($phone);
	}

//    public function test2Action()
//    {
//        $content = "I'm using special secret features for debugging app";
//
//        return new Response($content);
//    }
}