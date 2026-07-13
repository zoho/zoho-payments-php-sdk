<?php

declare(strict_types=1);

namespace Zoho\Payments\Param;

use InvalidArgumentException;

final class TransferCreateParams
{
    /** @var list<TransferSplitParams> */
    public readonly array $transferSplit;

    /**
     * @param list<TransferSplitParams> $transferSplit
     */
    public function __construct(
        public readonly string $paymentId,
        array $transferSplit,
    ) {
        ParamHelpers::require($paymentId, 'payment_id');
        if (count($transferSplit) === 0) {
            throw new InvalidArgumentException('transfer_split must have at least one entry');
        }
        $this->transferSplit = $transferSplit;
    }

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        $splits = [];
        foreach ($this->transferSplit as $split) {
            $splits[] = $split->toArray();
        }
        return [
            'payment_id' => $this->paymentId,
            'transfer_split' => $splits,
        ];
    }
}
