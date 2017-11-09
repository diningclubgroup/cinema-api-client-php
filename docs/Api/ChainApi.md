# DCG\Cinema\ChainApi

All URIs are relative to *https://cinema-api.tastecard.co.uk/v1*

Method | HTTP request | Description
------------- | ------------- | -------------
[**chainsChainIdCinemasGet**](ChainApi.md#chainsChainIdCinemasGet) | **GET** /chains/{chainId}/cinemas | Retrieve a list of all cinemas associated with a single cinema chain
[**chainsChainIdTicketTypesGet**](ChainApi.md#chainsChainIdTicketTypesGet) | **GET** /chains/{chainId}/ticket-types | Retrieve a list of all ticket types associated with a single cinema chain
[**chainsGet**](ChainApi.md#chainsGet) | **GET** /chains | Retrieve a list of all cinema chains


# **chainsChainIdCinemasGet**
> chainsChainIdCinemasGet($chain_id)

Retrieve a list of all cinemas associated with a single cinema chain

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

$api_instance = new DCG\Cinema\Api\ChainApi();
$chain_id = "chain_id_example"; // string | The ID of the cinema chain

try {
    $api_instance->chainsChainIdCinemasGet($chain_id);
} catch (Exception $e) {
    echo 'Exception when calling ChainApi->chainsChainIdCinemasGet: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **chain_id** | **string**| The ID of the cinema chain |

### Return type

void (empty response body)

### Authorization

[client_token](../../README.md#client_token), [user_token](../../README.md#user_token)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **chainsChainIdTicketTypesGet**
> chainsChainIdTicketTypesGet($chain_id)

Retrieve a list of all ticket types associated with a single cinema chain

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

$api_instance = new DCG\Cinema\Api\ChainApi();
$chain_id = "chain_id_example"; // string | The ID of the cinema chain

try {
    $api_instance->chainsChainIdTicketTypesGet($chain_id);
} catch (Exception $e) {
    echo 'Exception when calling ChainApi->chainsChainIdTicketTypesGet: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **chain_id** | **string**| The ID of the cinema chain |

### Return type

void (empty response body)

### Authorization

[client_token](../../README.md#client_token), [user_token](../../README.md#user_token)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **chainsGet**
> chainsGet()

Retrieve a list of all cinema chains

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

$api_instance = new DCG\Cinema\Api\ChainApi();

try {
    $api_instance->chainsGet();
} catch (Exception $e) {
    echo 'Exception when calling ChainApi->chainsGet: ', $e->getMessage(), PHP_EOL;
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

