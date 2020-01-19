<?php
declare(strict_types=1);

namespace Tests\EoneoPay\Externals\Stubs\ORM\Entities;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @method ArrayCollection getChildren()
 *
 * @ORM\Entity()
 */
class ParentStub extends EntityStub
{
    /**
     * @ORM\OneToMany(
     *     mappedBy="parent",
     *     targetEntity="ChildStub"
     * )
     *
     * @phpstan-var \Doctrine\Common\Collections\Collection<int, \Tests\EoneoPay\Externals\Stubs\ORM\Entities\ChildStub>
     *
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    protected $children;

    /**
     * @ORM\OneToMany(
     *     mappedBy="parentPersist",
     *     targetEntity="ChildStub"
     * )
     *
     * @phpstan-var \Doctrine\Common\Collections\Collection<int, \Tests\EoneoPay\Externals\Stubs\ORM\Entities\ChildStub>
     *
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    protected $childrenPersist;

    /**
     * ParentEntityStub constructor.
     *
     * @param mixed[]|null $data
     */
    public function __construct(?array $data = null)
    {
        parent::__construct($data);

        $this->children = new ArrayCollection();
        $this->childrenPersist = new ArrayCollection();
    }
}
