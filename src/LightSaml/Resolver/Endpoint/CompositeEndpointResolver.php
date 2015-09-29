<?php

namespace LightSaml\Resolver\Endpoint;

use LightSaml\Criteria\CriteriaSet;
use LightSaml\Model\Metadata\EndpointReference;

class CompositeEndpointResolver implements EndpointResolverInterface
{
    /** @var EndpointResolverInterface[] */
    protected $resolvers = array();

    /**
     * @param EndpointResolverInterface[] $builders
     */
    public function __construct(array $builders = array())
    {
        $this->resolvers = $builders;
    }

    /**
     * @param EndpointResolverInterface $builder
     *
     * @return CompositeEndpointResolver
     */
    public function add(EndpointResolverInterface $builder)
    {
        $this->resolvers[] = $builder;

        return $this;
    }

    /**
     * @param CriteriaSet         $criteriaSet
     * @param EndpointReference[] $candidates
     *
     * @return EndpointReference[]
     */
    public function resolve(CriteriaSet $criteriaSet, array $candidates)
    {
        $result = $candidates;

        foreach ($this->resolvers as $resolver) {
            $result = $resolver->resolve($criteriaSet, $result);
        }

        return $result;
    }
}