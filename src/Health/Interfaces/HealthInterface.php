<?php
declare(strict_types=1);

namespace EoneoPay\Externals\Health\Interfaces;

interface HealthInterface
{
    /**
     * Represents a degraded state.
     *
     * @const int
     */
    public const STATE_DEGRADED = 0;

    /**
     * Represents a healthy state.
     *
     * @const int
     */
    public const STATE_HEALTHY = 1;

    /**
     * Performs a simple health check.
     *
     * @return int
     */
    public function simple(): int;

    /**
     * Performs an extended health check.
     *
     * @return bool[]
     */
    public function extended(): array;
}
