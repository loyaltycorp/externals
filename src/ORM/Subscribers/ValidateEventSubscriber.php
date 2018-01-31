<?php
declare(strict_types=1);

namespace EoneoPay\External\ORM\Subscribers;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use EoneoPay\External\ORM\Exceptions\EntityValidationException;
use EoneoPay\External\ORM\Interfaces\EntityInterface;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Validator;

class ValidateEventSubscriber implements EventSubscriber
{
    /**
     * @var \Illuminate\Validation\Validator
     */
    private $validator;

    /**
     * ValidateEventSubscriber constructor.
     *
     * @param \Illuminate\Validation\Validator $validator
     */
    public function __construct(Validator $validator)
    {
        $this->validator = $validator;
    }

    /**
     * Returns an array of events this subscriber wants to listen to.
     *
     * @return array
     */
    public function getSubscribedEvents(): array
    {
        return [
            Events::prePersist,
            Events::preUpdate
        ];
    }

    /**
     * Validate entity against rule set on insert
     *
     * @param \Doctrine\ORM\Event\LifeCycleEventArgs $eventArgs
     *
     * @return void
     *
     * @throws \EoneoPay\External\ORM\Exceptions\EntityValidationException Inherited, if validation fails
     */
    public function prePersist(LifecycleEventArgs $eventArgs): void
    {
        $this->callValidator($eventArgs);
    }

    /**
     * Validate entity against rule set on update
     *
     * @param \Doctrine\ORM\Event\LifeCycleEventArgs $eventArgs
     *
     * @return void
     *
     * @throws \EoneoPay\External\ORM\Exceptions\EntityValidationException Inherited, if validation fails
     */
    public function preUpdate(LifecycleEventArgs $eventArgs): void
    {
        $this->callValidator($eventArgs);
    }

    /**
     * Call validator on an object
     *
     * @param \Doctrine\ORM\Event\LifeCycleEventArgs $eventArgs
     *
     * @return void
     *
     * @throws \EoneoPay\External\ORM\Exceptions\EntityValidationException If validation fails
     */
    private function callValidator(LifecycleEventArgs $eventArgs): void
    {
        $entity = $eventArgs->getObject();

        if (!$entity instanceof EntityInterface
            || !\method_exists($entity, 'getRules')
            || !\is_array($entity->getRules())) {
            return;
        }

        try {
            $this->validator
                ->setRules($entity->getRules())
                ->setData($entity->toArray())
                ->validate();
        } catch (ValidationException $exception) {
            // Rethrow an wrapped exception
            throw new EntityValidationException($exception->getMessage(), $exception->getCode(), $exception);
        }
    }
}
