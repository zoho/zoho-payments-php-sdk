<?php

declare(strict_types=1);

namespace Zoho\Payments\Services;

use Zoho\Payments\Internal\ZohoHttpClient;
use Zoho\Payments\Model\Mandate;
use Zoho\Payments\Model\MandateNotification;
use Zoho\Payments\Model\MandatePayment;
use Zoho\Payments\Model\PaymentSession;
use Zoho\Payments\Param\MandateEnrollmentSessionCreateParams;
use Zoho\Payments\Param\MandateExecuteParams;
use Zoho\Payments\Param\MandateExecutionSessionCreateParams;
use Zoho\Payments\Param\MandateNotifyParams;

/** Requires {@see \Zoho\Payments\Edition::IN}. */
final class MandateService
{
    private const SESSION_ENVELOPE = 'payments_session';
    private const NOTIFICATION_ENVELOPE = 'mandate_notification';
    private const PAYMENT_ENVELOPE = 'payment';
    private const MANDATE_ENVELOPE = 'mandate';

    public function __construct(private readonly ZohoHttpClient $http)
    {
    }

    public function createEnrollmentSession(MandateEnrollmentSessionCreateParams $params): PaymentSession
    {
        return $this->http->postObject(
            '/paymentsessions',
            $params->toArray(),
            [PaymentSession::class, 'fromArray'],
            self::SESSION_ENVELOPE,
        );
    }

    public function createExecutionSession(MandateExecutionSessionCreateParams $params): PaymentSession
    {
        return $this->http->postObject(
            '/paymentsessions',
            $params->toArray(),
            [PaymentSession::class, 'fromArray'],
            self::SESSION_ENVELOPE,
        );
    }

    public function sendNotification(MandateNotifyParams $params): MandateNotification
    {
        return $this->http->postObject(
            '/mandates/notify',
            $params->toArray(),
            [MandateNotification::class, 'fromArray'],
            self::NOTIFICATION_ENVELOPE,
        );
    }

    public function execute(MandateExecuteParams $params): MandatePayment
    {
        return $this->http->postObject(
            '/mandates/execute',
            $params->toArray(),
            [MandatePayment::class, 'fromArray'],
            self::PAYMENT_ENVELOPE,
        );
    }

    public function getNotification(string $mandateNotificationId): MandateNotification
    {
        $path = '/mandates/notifications/' . ZohoHttpClient::encodePath($mandateNotificationId);
        return $this->http->getObject(
            $path,
            [MandateNotification::class, 'fromArray'],
            self::NOTIFICATION_ENVELOPE,
        );
    }

    public function get(string $mandateId): Mandate
    {
        $path = '/mandates/' . ZohoHttpClient::encodePath($mandateId);
        return $this->http->getObject($path, [Mandate::class, 'fromArray'], self::MANDATE_ENVELOPE);
    }
}
