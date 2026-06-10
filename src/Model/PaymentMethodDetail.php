<?php

declare(strict_types=1);

namespace Zoho\Payments\Model;

use Zoho\Payments\Internal\Coerce;

/** Payment-method snapshot attached to payments, mandates, etc. */
final class PaymentMethodDetail
{
    public function __construct(
        public readonly ?string $type = null,
        public readonly ?string $mandateId = null,
        public readonly ?CardDetail $card = null,
        public readonly ?AchDebitDetail $achDebit = null,
        public readonly ?Upi $upi = null,
        public readonly ?NetBanking $netBanking = null,
        public readonly ?BankTransfer $bankTransfer = null,
    ) {
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        return new self(
            type: Coerce::optStr($data, 'type'),
            mandateId: Coerce::optStr($data, 'mandate_id'),
            card: Coerce::optObj($data, 'card', [CardDetail::class, 'fromArray']),
            achDebit: Coerce::optObj($data, 'ach_debit', [AchDebitDetail::class, 'fromArray']),
            upi: Coerce::optObj($data, 'upi', [Upi::class, 'fromArray']),
            netBanking: Coerce::optObj($data, 'net_banking', [NetBanking::class, 'fromArray']),
            bankTransfer: Coerce::optObj($data, 'bank_transfer', [BankTransfer::class, 'fromArray']),
        );
    }
}
