<?php namespace Quince\Pelastic\Filters;

use Quince\Pelastic\Contracts\Filters\FilterInterface;
use Quince\Pelastic\Contracts\Filters\NotFilterInterface;
use Quince\Pelastic\Exceptions\PelasticLogicException;

class NotFilter extends Filter implements NotFilterInterface {

    use FilterCacheableTrait;

    /**
     * An array representation of object
     *
     * @return array
     */
    public function toArray()
    {
        /** @var FilterInterface $notFilter */
        $notFilter = $this->getAttribute('not', false, null);

        if (null === $notFilter) {
            throw new PelasticLogicException(
                "You have to apply a filter to a 'not' filter. use method [NotFilter::setNot(FilterInterface \$filter);] to apply one."
            );
        }

        $filter = ['not' => $notFilter->toArray()];

        if (null !== ($status = $this->getCacheStatus())) {
            $filter['_cache'] = (bool) $status;
        }

        return $filter;
    }

    /**
     * This filter acts as an all except this filter
     *
     * @param FilterInterface $filter
     * @return $this
     */
    public function iDontWantThisFilter(FilterInterface $filter)
    {
        return $this->setNot($filter);
    }

    /**
     * This filter acts as an all except this filter
     *
     * @param FilterInterface $filter
     * @return $this
     */
    public function not(FilterInterface $filter)
    {
        return $this->setNot($filter);
    }

    /**
     * A proxy to not
     *
     * @param FilterInterface $filter
     * @return $this
     */
    public function setNot(FilterInterface $filter)
    {
        $this->setAttribute('not', $filter);

        return $this;
    }
}