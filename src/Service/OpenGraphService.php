<?php

namespace App\Service;

use Leogout\Bundle\SeoBundle\Provider\SeoGeneratorProvider;
use Symfony\Component\Asset\Package;
use Symfony\Component\Asset\VersionStrategy\EmptyVersionStrategy;


class OpenGraphService
{
	public function __construct(private readonly SeoGeneratorProvider $seoGenerator) {}

	public function basic_open_graph(string $content,string $title): void
	{
		$this->seoGenerator->get('basic')
			->setDescription($content)
			->setTitle(content : $title)
			->setRobots(true, false);
	}

	public function og_open_graph(string $content, string $type, string $url, string $title, $img): void
	{
		$this->seoGenerator->get('og')
			->setTitle($title)
			->setType($type)
			->setDescription($content)
			->setImage($img)
			->setUrl($url);
	}

	public function twitter_open_graph(string $content, string $title, string $url, $img): void
	{
		$this->seoGenerator->get('twitter')
			->setTitle($title)
			->setCard('summary_large_image')
			->setDescription($content)
			->setImage($img)
			->setSite($url);
	}

	public function open_graph(string $content, string $type, string $url, string $title, $img): void
	{
		$titre = 'Dsides - '.$title;
		$folder = 'media/cache/w1600/uploads/images/projects/';
		$package = new Package(new EmptyVersionStrategy());
		$img_url = $package->getUrl($folder.$img);

		$this->basic_open_graph($content, $titre);
		$this->og_open_graph($content, $type, $url, $titre, $img_url);
		$this->twitter_open_graph($content,$titre,$url, $img_url);

	}

}