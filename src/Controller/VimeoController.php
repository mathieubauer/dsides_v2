<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Vimeo\Exceptions\VimeoRequestException;
use Vimeo\Vimeo;

/**
 * @Route("/video")
 */
class VimeoController extends AbstractController
{

	/**
	 * @Route("/dsides", name="app_vimeo")
	 * @throws VimeoRequestException
	 */
    public function index(Request $request): Response
    {
		$client = new Vimeo(
			$this->getParameter('app.vimeo.client_id'),
			$this->getParameter('app.vimeo.client.secret'),
			$this->getParameter('app.vimeo.access.public')
		);

		$responses = $client->request('/me/videos',[
			'per_page' => 20,
			'filter_tag' => 'site',
			'sort'=>'date',
			'direction'=>'desc'], 'GET');
		$body = $responses['body'];

	    $request->attributes->set('id', 'dsides_video');

		return $this->render('vimeo/index.html.twig', [
			'video' => $body,
		]);

    }
}
