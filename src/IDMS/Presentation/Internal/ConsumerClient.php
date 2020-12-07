<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\IDMS\Presentation\Internal;

/**
 * Interface ConsumerClient
 * @package IlyaPokamestov\ProductivitySuite\IDMS\Presentation\Internal
 *
 * This interface may represent some internal API with any kind of protocols which is used for internal purpose.
 * In my case I'm going to use it as a some kind of Anti-corruption layer between IDMS bounded context and
 * other contexts in the system.
 *
 * I've decided to organize it in this way to prevent leaking of internal queries or DTO to other contexts.
 * This interface should be implemented by Infrastructure layers of other bounded contexts.
 */
interface ConsumerClient
{
    /**
     * Usually contracts here can be in generic for like findConsumer.
     * I'm going to simplify it at the moment.
     *
     * @param string $consumerId
     * @return string
     */
    public function consumerStatus(string $consumerId): string;
}
