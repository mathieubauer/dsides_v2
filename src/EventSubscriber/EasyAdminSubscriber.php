<?php

namespace App\EventSubscriber;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityUpdatedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class EasyAdminSubscriber implements EventSubscriberInterface
{
	public function __construct(private readonly UserPasswordHasherInterface $hasher) {}

	/**
	 * @inheritDoc
	 */
	public static function getSubscribedEvents(): array
	{
		return [
			BeforeEntityPersistedEvent::class => 'setUserPassword',
			BeforeEntityUpdatedEvent::class => 'updateUserPassword'
		];
	}

	public function setUserPassword(BeforeEntityPersistedEvent $event): void
	{
		$entity  = $event->getEntityInstance();

		if(!($entity instanceof User)) {
			return;
		}

		$pass = $this->hasher->hashPassword($entity, $entity->getPassword());
		$entity->setPassword($pass);
	}

	public function updateUserPassword(BeforeEntityUpdatedEvent $event): void
	{
		$entity  = $event->getEntityInstance();

		if(!($entity instanceof User)) {
			return;
		}

		$pass = $this->hasher->hashPassword($entity, $entity->getPassword());
		$entity->setPassword($pass);
	}
}