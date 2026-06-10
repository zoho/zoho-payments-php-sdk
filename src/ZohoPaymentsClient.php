<?php

declare(strict_types=1);

namespace Zoho\Payments;

use Zoho\Payments\Internal\TokenManager;
use Zoho\Payments\Internal\ZohoHttpClient;
use Zoho\Payments\Services\CollectService;
use Zoho\Payments\Services\CustomerService;
use Zoho\Payments\Services\MandateService;
use Zoho\Payments\Services\PaymentLinkService;
use Zoho\Payments\Services\PaymentMethodService;
use Zoho\Payments\Services\PaymentMethodSessionService;
use Zoho\Payments\Services\PaymentService;
use Zoho\Payments\Services\PaymentSessionService;
use Zoho\Payments\Services\RefundService;

/** The main Zoho Payments client; build via ZohoPayments::builder(). */
final class ZohoPaymentsClient
{
    private ZohoHttpClient $httpClient;
    private TokenManager $tokenManager;
    private Edition $edition;

    private PaymentLinkService $paymentLinks;
    private PaymentSessionService $paymentSessions;
    private CustomerService $customers;
    private PaymentService $payments;
    private RefundService $refunds;
    private PaymentMethodService $paymentMethods;
    private PaymentMethodSessionService $paymentMethodSessions;
    private MandateService $mandates;
    private CollectService $collect;

    public function __construct(
        ZohoHttpClient $httpClient,
        TokenManager $tokenManager,
        Edition $edition,
    ) {
        $this->httpClient = $httpClient;
        $this->tokenManager = $tokenManager;
        $this->edition = $edition;

        $this->paymentLinks = new PaymentLinkService($httpClient);
        $this->paymentSessions = new PaymentSessionService($httpClient);
        $this->customers = new CustomerService($httpClient, $edition);
        $this->payments = new PaymentService($httpClient, $edition);
        $this->refunds = new RefundService($httpClient);
        $this->paymentMethods = new PaymentMethodService($httpClient);
        $this->paymentMethodSessions = new PaymentMethodSessionService($httpClient);
        $this->mandates = new MandateService($httpClient);
        $this->collect = new CollectService($httpClient);
    }

    public function paymentLinks(): PaymentLinkService
    {
        return $this->paymentLinks;
    }

    public function paymentSessions(): PaymentSessionService
    {
        return $this->paymentSessions;
    }

    public function customers(): CustomerService
    {
        return $this->customers;
    }

    public function payments(): PaymentService
    {
        return $this->payments;
    }

    public function refunds(): RefundService
    {
        return $this->refunds;
    }

    // Requires Edition::US.
    public function paymentMethods(): PaymentMethodService
    {
        if (!$this->edition->isUs()) {
            throw new \BadMethodCallException(
                'paymentMethods() is available only on Edition::US',
            );
        }
        return $this->paymentMethods;
    }

    // Requires Edition::US.
    public function paymentMethodSessions(): PaymentMethodSessionService
    {
        if (!$this->edition->isUs()) {
            throw new \BadMethodCallException(
                'paymentMethodSessions() is available only on Edition::US',
            );
        }
        return $this->paymentMethodSessions;
    }

    // Requires Edition::IN or Edition::IN_SANDBOX.
    public function mandates(): MandateService
    {
        if (!$this->edition->isIn()) {
            throw new \BadMethodCallException(
                'mandates() is available only on Edition::IN / Edition::IN_SANDBOX',
            );
        }
        return $this->mandates;
    }

    // Requires Edition::IN or Edition::IN_SANDBOX.
    public function collect(): CollectService
    {
        if (!$this->edition->isIn()) {
            throw new \BadMethodCallException(
                'collect() is available only on Edition::IN / Edition::IN_SANDBOX',
            );
        }
        return $this->collect;
    }

    public function updateToken(string $newAccessToken): void
    {
        $this->tokenManager->updateToken($newAccessToken);
    }
}
