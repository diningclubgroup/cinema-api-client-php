# DCG\Cinema\UserApi

All URIs are relative to *https://cinema-api.tastecard.co.uk/v1*

Method | HTTP request | Description
------------- | ------------- | -------------
[**usersGet**](UserApi.md#usersGet) | **GET** /users | Retrieve a list of users
[**usersMeGet**](UserApi.md#usersMeGet) | **GET** /users/me | Retrieve the user identified by the attached access token
[**usersPost**](UserApi.md#usersPost) | **POST** /users | Create a new user
[**usersUserIdGet**](UserApi.md#usersUserIdGet) | **GET** /users/{userId} | Retrieve a single user from their ID
[**usersUserIdTokensPost**](UserApi.md#usersUserIdTokensPost) | **POST** /users/{userId}/tokens | Create a new access token for a user
[**usersUserIdTokensTokenGet**](UserApi.md#usersUserIdTokensTokenGet) | **GET** /users/{userId}/tokens/{token} | Retrieve a token and its associated metadata (Not MVP)


# **usersGet**
> usersGet($email)

Retrieve a list of users

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: client_token
DCG\Cinema\Configuration::getDefaultConfiguration()->setApiKey('Client-Token', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// DCG\Cinema\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Client-Token', 'Bearer');

$api_instance = new DCG\Cinema\Api\UserApi();
$email = "email_example"; // string | The user's email address (note that this is currently required but only as a small security step - otherwise any user would be able to fetch a list of all users registered with the same client as them)

try {
    $api_instance->usersGet($email);
} catch (Exception $e) {
    echo 'Exception when calling UserApi->usersGet: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **email** | **string**| The user&#39;s email address (note that this is currently required but only as a small security step - otherwise any user would be able to fetch a list of all users registered with the same client as them) |

### Return type

void (empty response body)

### Authorization

[client_token](../../README.md#client_token)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **usersMeGet**
> usersMeGet()

Retrieve the user identified by the attached access token

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

$api_instance = new DCG\Cinema\Api\UserApi();

try {
    $api_instance->usersMeGet();
} catch (Exception $e) {
    echo 'Exception when calling UserApi->usersMeGet: ', $e->getMessage(), PHP_EOL;
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

# **usersPost**
> usersPost($user_data)

Create a new user

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: client_token
DCG\Cinema\Configuration::getDefaultConfiguration()->setApiKey('Client-Token', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// DCG\Cinema\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Client-Token', 'Bearer');

$api_instance = new DCG\Cinema\Api\UserApi();
$user_data = new \DCG\Cinema\Model\UserData(); // \DCG\Cinema\Model\UserData | Data representing a user

try {
    $api_instance->usersPost($user_data);
} catch (Exception $e) {
    echo 'Exception when calling UserApi->usersPost: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **user_data** | [**\DCG\Cinema\Model\UserData**](../Model/UserData.md)| Data representing a user |

### Return type

void (empty response body)

### Authorization

[client_token](../../README.md#client_token)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **usersUserIdGet**
> usersUserIdGet($user_id)

Retrieve a single user from their ID

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

$api_instance = new DCG\Cinema\Api\UserApi();
$user_id = "user_id_example"; // string | The user's ID

try {
    $api_instance->usersUserIdGet($user_id);
} catch (Exception $e) {
    echo 'Exception when calling UserApi->usersUserIdGet: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **user_id** | **string**| The user&#39;s ID |

### Return type

void (empty response body)

### Authorization

[client_token](../../README.md#client_token), [user_token](../../README.md#user_token)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **usersUserIdTokensPost**
> usersUserIdTokensPost($user_id)

Create a new access token for a user

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

$api_instance = new DCG\Cinema\Api\UserApi();
$user_id = "user_id_example"; // string | The user's ID

try {
    $api_instance->usersUserIdTokensPost($user_id);
} catch (Exception $e) {
    echo 'Exception when calling UserApi->usersUserIdTokensPost: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **user_id** | **string**| The user&#39;s ID |

### Return type

void (empty response body)

### Authorization

[client_token](../../README.md#client_token), [user_token](../../README.md#user_token)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **usersUserIdTokensTokenGet**
> usersUserIdTokensTokenGet($user_id, $token)

Retrieve a token and its associated metadata (Not MVP)

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

$api_instance = new DCG\Cinema\Api\UserApi();
$user_id = "user_id_example"; // string | The user's ID
$token = "token_example"; // string | The user access token

try {
    $api_instance->usersUserIdTokensTokenGet($user_id, $token);
} catch (Exception $e) {
    echo 'Exception when calling UserApi->usersUserIdTokensTokenGet: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **user_id** | **string**| The user&#39;s ID |
 **token** | **string**| The user access token |

### Return type

void (empty response body)

### Authorization

[client_token](../../README.md#client_token), [user_token](../../README.md#user_token)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

