<?php

declare(strict_types=1);

namespace Zoho\Payments\Param;

final class MandateDetailsParams
{
    public function __construct(
        public readonly string $paymentMethodType,
        public readonly string $frequency,
        public readonly string $description,
        public readonly string $amountRule,
        public readonly ?float $maxAmount = null,
        public readonly ?string $startDate = null,
        public readonly ?string $endDate = null,
        public readonly ?int $debitDay = null,
        public readonly ?string $debitRule = null,
    ) {
        ParamHelpers::require($paymentMethodType, 'payment_method_type');
        ParamHelpers::require($frequency, 'frequency');
        ParamHelpers::require($description, 'description');
        ParamHelpers::require($amountRule, 'amount_rule');
        if ($amountRule === 'variable' && $maxAmount === null) {
            throw new \InvalidArgumentException("max_amount is required when amount_rule is 'variable'");
        }
        ParamValidator::validateDescription($description);
    }

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        return [
            'payment_method_type' => $this->paymentMethodType,
            'frequency' => $this->frequency,
            'description' => $this->description,
            'amount_rule' => $this->amountRule,
            'max_amount' => $this->maxAmount,
            'start_date' => $this->startDate,
            'end_date' => $this->endDate,
            'debit_day' => $this->debitDay,
            'debit_rule' => $this->debitRule,
        ];
    }
}
