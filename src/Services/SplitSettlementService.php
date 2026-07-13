<?php

declare(strict_types=1);

namespace Zoho\Payments\Services;

use Zoho\Payments\Internal\ZohoHttpClient;
use Zoho\Payments\Model\ConnectedAccount;
use Zoho\Payments\Model\ConnectedAccountPayout;
use Zoho\Payments\Model\ConnectedAccountPayoutSummary;
use Zoho\Payments\Model\ConnectedAccountPayoutTransaction;
use Zoho\Payments\Model\ConnectedAccountSummary;
use Zoho\Payments\Model\ConnectedAccountTransaction;
use Zoho\Payments\Model\ListResponse;
use Zoho\Payments\Model\Transfer;
use Zoho\Payments\Model\TransferCreateResponse;
use Zoho\Payments\Model\TransferReversal;
use Zoho\Payments\Model\TransferReversalCreateResponse;
use Zoho\Payments\Model\TransferReversalDetail;
use Zoho\Payments\Model\TransferSummary;
use Zoho\Payments\Param\ConnectedAccountCreateParams;
use Zoho\Payments\Param\ConnectedAccountListParams;
use Zoho\Payments\Param\ConnectedAccountTransactionListParams;
use Zoho\Payments\Param\ParamHelpers;
use Zoho\Payments\Param\TransferCreateParams;
use Zoho\Payments\Param\TransferListParams;
use Zoho\Payments\Param\TransferReversalCreateParams;
use Zoho\Payments\Param\TransferReversalListParams;

// Zoho Payments Split Settlement APIs: Transfers (/transfers), Transfer Reversals (/transferreversals), and Connected Accounts (/connectedaccounts).
final class SplitSettlementService
{
    private const TRANSFER_ENVELOPE = 'transfer_details';
    private const TRANSFERS_ENVELOPE = 'transfers';
    private const DATA = 'data';
    private const REVERSAL_ENVELOPE = 'transfer_reversal';
    private const REVERSAL_DETAIL_ENVELOPE = 'transfer_reversal_details';
    private const REVERSALS_ENVELOPE = 'transfer_reversals';
    private const CONNECTED_ACCOUNT_ENVELOPE = 'connected_account';
    private const CONNECTED_ACCOUNTS_ENVELOPE = 'connected_accounts';
    private const PAYOUT_ENVELOPE = 'payout';
    private const PAYOUTS_ENVELOPE = 'payouts';
    private const TRANSACTIONS_ENVELOPE = 'transactions';

    public function __construct(private readonly ZohoHttpClient $http)
    {
    }

    // Transfers

    public function createTransfer(TransferCreateParams $params): TransferCreateResponse
    {
        return $this->http->postObject(
            '/transfers',
            $params->toArray(),
            [TransferCreateResponse::class, 'fromArray'],
            self::DATA, self::TRANSFERS_ENVELOPE
        );
    }

    public function getTransfer(string $transferId): Transfer
    {
        ParamHelpers::require($transferId, 'transferId');
        $path = '/transfers/' . ZohoHttpClient::encodePath($transferId);
        return $this->http->getObject($path, [Transfer::class, 'fromArray'], self::TRANSFER_ENVELOPE);
    }

    /** @return ListResponse<TransferSummary> */
    public function listTransfers(?TransferListParams $params = null): ListResponse
    {
        $query = QueryBuilder::from($params?->toQuery());
        return $this->http->listObjects(
            '/transfers',
            $query,
            [TransferSummary::class, 'fromArray'],
            self::TRANSFERS_ENVELOPE,
        );
    }

    public function createTransferReversal(TransferReversalCreateParams $params): TransferReversalCreateResponse
    {
        return $this->http->postObject(
            '/transferreversals',
            $params->toArray(),
            [TransferReversalCreateResponse::class, 'fromArray'],
            self::DATA, self::REVERSAL_ENVELOPE
        );
    }

    public function getTransferReversal(string $transferReversalId): TransferReversalDetail
    {
        ParamHelpers::require($transferReversalId, 'transferReversalId');
        $path = '/transferreversals/' . ZohoHttpClient::encodePath($transferReversalId);
        return $this->http->getObject($path, [TransferReversalDetail::class, 'fromArray'], self::REVERSAL_DETAIL_ENVELOPE);
    }

    /** @return ListResponse<TransferReversal> */
    public function listTransferReversals(?TransferReversalListParams $params = null): ListResponse
    {
        $query = QueryBuilder::from($params?->toQuery());
        return $this->http->listObjects(
            '/transferreversals',
            $query,
            [TransferReversal::class, 'fromArray'],
            self::REVERSALS_ENVELOPE,
        );
    }

    // Connected Accounts

    public function createConnectedAccount(ConnectedAccountCreateParams $params): void
    {
        $this->http->post('/connectedaccounts', $params->toArray());
    }

    /** @return ListResponse<ConnectedAccountSummary> */
    public function listConnectedAccounts(?ConnectedAccountListParams $params = null): ListResponse
    {
        $query = QueryBuilder::from($params?->toQuery());
        return $this->http->listObjects(
            '/connectedaccounts',
            $query,
            [ConnectedAccountSummary::class, 'fromArray'],
            self::CONNECTED_ACCOUNTS_ENVELOPE,
        );
    }

    public function getConnectedAccount(string $connectedAccountId): ConnectedAccount
    {
        ParamHelpers::require($connectedAccountId, 'connectedAccountId');
        $path = '/connectedaccounts/' . ZohoHttpClient::encodePath($connectedAccountId);
        return $this->http->getObject($path, [ConnectedAccount::class, 'fromArray'], self::CONNECTED_ACCOUNT_ENVELOPE);
    }

    /** @return ListResponse<ConnectedAccountPayoutSummary> */
    public function listConnectedAccountPayouts(string $connectedAccountId): ListResponse
    {
        ParamHelpers::require($connectedAccountId, 'connectedAccountId');
        $path = '/connectedaccounts/' . ZohoHttpClient::encodePath($connectedAccountId) . '/payouts';
        return $this->http->listObjects(
            $path,
            null,
            [ConnectedAccountPayoutSummary::class, 'fromArray'],
            self::PAYOUTS_ENVELOPE,
        );
    }

    public function getConnectedAccountPayout(string $connectedAccountId, string $payoutId): ConnectedAccountPayout
    {
        ParamHelpers::require($connectedAccountId, 'connectedAccountId');
        ParamHelpers::require($payoutId, 'payoutId');
        $path = '/connectedaccounts/' . ZohoHttpClient::encodePath($connectedAccountId)
            . '/payouts/' . ZohoHttpClient::encodePath($payoutId);
        return $this->http->getObject($path, [ConnectedAccountPayout::class, 'fromArray'], self::PAYOUT_ENVELOPE);
    }

    /** @return ListResponse<ConnectedAccountPayoutTransaction> */
    public function listConnectedAccountPayoutTransactions(string $connectedAccountId, string $payoutId): ListResponse
    {
        ParamHelpers::require($connectedAccountId, 'connectedAccountId');
        ParamHelpers::require($payoutId, 'payoutId');
        $path = '/connectedaccounts/' . ZohoHttpClient::encodePath($connectedAccountId)
            . '/payouts/' . ZohoHttpClient::encodePath($payoutId) . '/transactions';
        return $this->http->listObjects(
            $path,
            null,
            [ConnectedAccountPayoutTransaction::class, 'fromArray'],
            self::TRANSACTIONS_ENVELOPE,
        );
    }

    /** @return ListResponse<ConnectedAccountTransaction> */
    public function listConnectedAccountTransactions(
        string $connectedAccountId,
        ?ConnectedAccountTransactionListParams $params = null,
    ): ListResponse {
        ParamHelpers::require($connectedAccountId, 'connectedAccountId');
        $path = '/connectedaccounts/' . ZohoHttpClient::encodePath($connectedAccountId) . '/transactions';
        $query = QueryBuilder::from($params?->toQuery());
        return $this->http->listObjects(
            $path,
            $query,
            [ConnectedAccountTransaction::class, 'fromArray'],
            self::TRANSACTIONS_ENVELOPE,
        );
    }
}