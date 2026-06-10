<?php

declare(strict_types=1);

namespace Zoho\Payments\Model;

use Zoho\Payments\Internal\Coerce;

final class Configurations
{
    /** @var list<string> */
    public readonly array $allowedPaymentMethods;
    public readonly ?HostedPageResponse $hostedPageParameters;

    /** @param list<string> $allowedPaymentMethods */
    public function __construct(
        array $allowedPaymentMethods = [],
        ?HostedPageResponse $hostedPageParameters = null,
    ) {
        $this->allowedPaymentMethods = $allowedPaymentMethods;
        $this->hostedPageParameters = $hostedPageParameters;
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        return new self(
            allowedPaymentMethods: Coerce::optStrList($data, 'allowed_payment_methods'),
            hostedPageParameters: Coerce::optObj(
                $data,
                'hosted_page_parameters',
                [HostedPageResponse::class, 'fromArray'],
            ),
        );
    }
}
