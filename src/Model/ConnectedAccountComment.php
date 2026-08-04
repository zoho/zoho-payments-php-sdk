<?php

declare(strict_types=1);

namespace Zoho\Payments\Model;

use Zoho\Payments\Internal\Coerce;

final class ConnectedAccountComment
{
    public function __construct(
        public readonly ?string $commentId = null,
        public readonly ?string $amount = null,
        public readonly ?string $operationType = null,
        public readonly ?string $actionType = null,
        public readonly ?string $type = null,
        public readonly ?string $description = null,
        public readonly ?string $createdBy = null,
        public readonly ?string $createdTime = null,
    ) {
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        return new self(
            commentId: Coerce::optStr($data, 'comment_id'),
            amount: Coerce::optStr($data, 'amount'),
            operationType: Coerce::optStr($data, 'operation_type'),
            actionType: Coerce::optStr($data, 'action_type'),
            type: Coerce::optStr($data, 'type'),
            description: Coerce::optStr($data, 'description'),
            createdBy: Coerce::optStr($data, 'created_by'),
            createdTime: Coerce::optStr($data, 'created_time'),
        );
    }
}
