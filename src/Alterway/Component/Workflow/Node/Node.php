<?php

namespace Alterway\Component\Workflow\Node;

use Alterway\Component\Workflow\ContextInterface;
use Alterway\Component\Workflow\SpecificationInterface;
use Alterway\Component\Workflow\Transition;
use Alterway\Component\Workflow\TransitionInterface;

class Node implements NodeInterface
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var array
     */
    private $transitions;

    public function __construct($name)
    {
        $this->name = (string)$name;
        $this->transitions = array();
    }

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @inheritdoc
     */
    public function addTransition(NodeInterface $dst, SpecificationInterface $spec)
    {
        $this->transitions[] = new Transition($this, $dst, $spec);
    }

    /**
     * @inheritdoc
     */
    public function getOpenTransitions(ContextInterface $context)
    {
        $transitions = array();

        foreach ($this->transitions as $transition) {
            /** @var $transition TransitionInterface */
            if ($transition->isOpen($context)) {
                $transitions[] = $transition;
            }
        }

        return $transitions;
    }
}
