# DCG\Cinema\TermsConditionsApi

All URIs are relative to *https://cinema-api.tastecard.co.uk/v1*

Method | HTTP request | Description
------------- | ------------- | -------------
[**termsAndConditionsGet**](TermsConditionsApi.md#termsAndConditionsGet) | **GET** /terms-and-conditions | Get the Terms &amp; Conditions


# **termsAndConditionsGet**
> termsAndConditionsGet()

Get the Terms & Conditions

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

$api_instance = new DCG\Cinema\Api\TermsConditionsApi();

try {
    $api_instance->termsAndConditionsGet();
} catch (Exception $e) {
    echo 'Exception when calling TermsConditionsApi->termsAndConditionsGet: ', $e->getMessage(), PHP_EOL;
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

