# DCG\Cinema\OrderApi

All URIs are relative to *https://cinema-api.tastecard.co.uk/v1*

Method | HTTP request | Description
------------- | ------------- | -------------
[**ordersGet**](OrderApi.md#ordersGet) | **GET** /orders | Retrieve a list of orders the user has access to. If the user is an administrator, they may filter by user ID.
[**ordersOrderIdGet**](OrderApi.md#ordersOrderIdGet) | **GET** /orders/{orderId} | Retrieve a single order from its ID
[**ordersOrderIdNotifyPost**](OrderApi.md#ordersOrderIdNotifyPost) | **POST** /orders/{orderId}/notify | Request that the service sends an order confirmation email to the provided email address
[**ordersPost**](OrderApi.md#ordersPost) | **POST** /orders | Create a new order and begin a new transaction
[**paymentProvidersGet**](OrderApi.md#paymentProvidersGet) | **GET** /payment-providers | Retrieve a list of payment providers that the user may utilise to complete an order
[**transactionsTransactionIdPatch**](OrderApi.md#transactionsTransactionIdPatch) | **PATCH** /transactions/{transactionId} | Complete a pending transaction


# **ordersGet**
> ordersGet($user_id)

Retrieve a list of orders the user has access to. If the user is an administrator, they may filter by user ID.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: client_token
DCG\Cinema\Configuration::getDefaultConfiguration()->setApiKey('Client-Token', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// DCG\Cinema\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Client-Token', 'Bearer');
// Configure API key authorization: user_token
DCG\Cinema\Configuration::getDefaultConfiguration()->setApiKey('User-Token', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// DCG\Cinema\Configuration::getDefaultConfiguration()->setApiKeyPrefix('User-Token', 'Bearer');

$api_instance = new DCG\Cinema\Api\OrderApi();
$user_id = "user_id_example"; // string | The user's ID

try {
    $api_instance->ordersGet($user_id);
} catch (Exception $e) {
    echo 'Exception when calling OrderApi->ordersGet: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **user_id** | **string**| The user&#39;s ID | [optional]

### Return type

void (empty response body)

### Authorization

[client_token](../../README.md#client_token), [user_token](../../README.md#user_token)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **ordersOrderIdGet**
> ordersOrderIdGet($order_id)

Retrieve a single order from its ID

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: client_token
DCG\Cinema\Configuration::getDefaultConfiguration()->setApiKey('Client-Token', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// DCG\Cinema\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Client-Token', 'Bearer');
// Configure API key authorization: user_token
DCG\Cinema\Configuration::getDefaultConfiguration()->setApiKey('User-Token', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// DCG\Cinema\Configuration::getDefaultConfiguration()->setApiKeyPrefix('User-Token', 'Bearer');

$api_instance = new DCG\Cinema\Api\OrderApi();
$order_id = "order_id_example"; // string | The ID of the user's order

try {
    $api_instance->ordersOrderIdGet($order_id);
} catch (Exception $e) {
    echo 'Exception when calling OrderApi->ordersOrderIdGet: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **order_id** | **string**| The ID of the user&#39;s order |

### Return type

void (empty response body)

### Authorization

[client_token](../../README.md#client_token), [user_token](../../README.md#user_token)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **ordersOrderIdNotifyPost**
> ordersOrderIdNotifyPost($order_id, $email_address)

Request that the service sends an order confirmation email to the provided email address

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: client_token
DCG\Cinema\Configuration::getDefaultConfiguration()->setApiKey('Client-Token', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// DCG\Cinema\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Client-Token', 'Bearer');
// Configure API key authorization: user_token
DCG\Cinema\Configuration::getDefaultConfiguration()->setApiKey('User-Token', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// DCG\Cinema\Configuration::getDefaultConfiguration()->setApiKeyPrefix('User-Token', 'Bearer');

$api_instance = new DCG\Cinema\Api\OrderApi();
$order_id = "order_id_example"; // string | The ID of the user's order
$email_address = new \DCG\Cinema\Model\EmailAddress(); // \DCG\Cinema\Model\EmailAddress | An object containing a single 'email_address' entry

try {
    $api_instance->ordersOrderIdNotifyPost($order_id, $email_address);
} catch (Exception $e) {
    echo 'Exception when calling OrderApi->ordersOrderIdNotifyPost: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **order_id** | **string**| The ID of the user&#39;s order |
 **email_address** | [**\DCG\Cinema\Model\EmailAddress**](../Model/EmailAddress.md)| An object containing a single &#39;email_address&#39; entry |

### Return type

void (empty response body)

### Authorization

[client_token](../../README.md#client_token), [user_token](../../README.md#user_token)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **ordersPost**
> ordersPost($order_data)

Create a new order and begin a new transaction

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: client_token
DCG\Cinema\Configuration::getDefaultConfiguration()->setApiKey('Client-Token', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// DCG\Cinema\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Client-Token', 'Bearer');
// Configure API key authorization: user_token
DCG\Cinema\Configuration::getDefaultConfiguration()->setApiKey('User-Token', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// DCG\Cinema\Configuration::getDefaultConfiguration()->setApiKeyPrefix('User-Token', 'Bearer');

$api_instance = new DCG\Cinema\Api\OrderApi();
$order_data = new \DCG\Cinema\Model\OrderData(); // \DCG\Cinema\Model\OrderData | Data representing an order

try {
    $api_instance->ordersPost($order_data);
} catch (Exception $e) {
    echo 'Exception when calling OrderApi->ordersPost: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **order_data** | [**\DCG\Cinema\Model\OrderData**](../Model/OrderData.md)| Data representing an order |

### Return type

void (empty response body)

### Authorization

[client_token](../../README.md#client_token), [user_token](../../README.md#user_token)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **paymentProvidersGet**
> paymentProvidersGet()

Retrieve a list of payment providers that the user may utilise to complete an order

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: client_token
DCG\Cinema\Configuration::getDefaultConfiguration()->setApiKey('Client-Token', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// DCG\Cinema\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Client-Token', 'Bearer');
// Configure API key authorization: user_token
DCG\Cinema\Configuration::getDefaultConfiguration()->setApiKey('User-Token', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// DCG\Cinema\Configuration::getDefaultConfiguration()->setApiKeyPrefix('User-Token', 'Bearer');

$api_instance = new DCG\Cinema\Api\OrderApi();

try {
    $api_instance->paymentProvidersGet();
} catch (Exception $e) {
    echo 'Exception when calling OrderApi->paymentProvidersGet: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters
This endpoint does not need any parameter.

### Return type

void (empty response body)

### Authorization

[client_token](../../README.md#client_token), [user_token](../../README.md#user_token)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **transactionsTransactionIdPatch**
> transactionsTransactionIdPatch($transaction_id, $transaction_patch_data)

Complete a pending transaction

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: client_token
DCG\Cinema\Configuration::getDefaultConfiguration()->setApiKey('Client-Token', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// DCG\Cinema\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Client-Token', 'Bearer');
// Configure API key authorization: user_token
DCG\Cinema\Configuration::getDefaultConfiguration()->setApiKey('User-Token', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// DCG\Cinema\Configuration::getDefaultConfiguration()->setApiKeyPrefix('User-Token', 'Bearer');

$api_instance = new DCG\Cinema\Api\OrderApi();
$transaction_id = "transaction_id_example"; // string | The ID of the transaction
$transaction_patch_data = new \DCG\Cinema\Model\TransactionPatchData(); // \DCG\Cinema\Model\TransactionPatchData | Additional data needed to complete a transaction. payer_id is required for PayPal transactions only.

try {
    $api_instance->transactionsTransactionIdPatch($transaction_id, $transaction_patch_data);
} catch (Exception $e) {
    echo 'Exception when calling OrderApi->transactionsTransactionIdPatch: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **transaction_id** | **string**| The ID of the transaction |
 **transaction_patch_data** | [**\DCG\Cinema\Model\TransactionPatchData**](../Model/TransactionPatchData.md)| Additional data needed to complete a transaction. payer_id is required for PayPal transactions only. | [optional]

### Return type

void (empty response body)

### Authorization

[client_token](../../README.md#client_token), [user_token](../../README.md#user_token)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

