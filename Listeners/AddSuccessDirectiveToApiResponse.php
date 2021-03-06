<?php

namespace Modules\Core\Listeners;

use Dingo\Api\Event\ResponseWasMorphed;

/**
 * Class AddSuccessDirectiveToApiResponse.
 */
class AddSuccessDirectiveToApiResponse
{
    /**
     * @param ResponseWasMorphed $event
     *
     * @return bool|void
     */
    public function handle(ResponseWasMorphed $event)
    {
        if (! is_array($event->content)) {
            return;
        }
        if ($event->response->getStatusCode() == 200) {
            return $event->content['success'] = true;
        }

        return $event->content['success'] = false;
    }
}
