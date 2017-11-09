# OrdersDataEntity

## Properties
Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**id** | **string** | The ID of the order | [optional] 
**reference** | **string** | The reference that should be provided to the user | [optional] 
**user_id** | **string** | The ID of the associated user | [optional] 
**total_price** | **float** | The total price of the order | [optional] 
**currency** | **string** | The currency used to determine the price of the order | [optional] 
**is_successful** | **bool** | Whether the order has been successful or not | [optional] 
**completed_at** | [**\DateTime**](\DateTime.md) | The timestamp the order was completed | [optional] 
**items** | [**\DCG\Cinema\Model\OrdersDataEntityItems[]**](OrdersDataEntityItems.md) | An array of line items | [optional] 

[[Back to Model list]](../README.md#documentation-for-models) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to README]](../README.md)


