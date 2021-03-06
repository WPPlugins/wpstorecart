<html>
	<head>
		<title>Intuit IPP/IDS + PHP Test - Keith Palmer</title>
	</head>
	
	<body>
		
		<h1>Intuit IPP/IDS + PHP Test - Object Serialization</h1>
		
<?php

require_once dirname(__FILE__) . '/../QuickBooks.php';

error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 1);

$xml = '<?xml version="1.0" encoding="UTF-8"?><!--XML GENERATED by IntuitDataSyncEngine (IDS) using \\SBDomainServices\CDM\branches\3.0.0-rel-->
<RestResponse xmlns="http://www.intuit.com/sb/cdm/v2"
xmlns:xdb          ="http://xmlns.oracle.com/xdb"
xmlns:xsi          ="http://www.w3.org/2001/XMLSchema-instance"
xsi:schemaLocation ="http://www.intuit.com/sb/cdm/v2 ../common/RestDataFilter.xsd"><Customers>
	<Customer>
		<Id idDomain="QB">2</Id>
		<SyncToken>1</SyncToken>
		<MetaData>
			<CreatedBy>app</CreatedBy>
			<CreateTime>2010-04-07T13:49:53.0</CreateTime>
			<LastModifiedBy>app</LastModifiedBy>
			<LastUpdatedTime>2010-04-07T13:49:53.0</LastUpdatedTime>
		</MetaData>
		<ExternalKey idDomain="QB">2</ExternalKey>
		<Synchronized>true</Synchronized>
		<PartyReferenceId idDomain="QB">2</PartyReferenceId>
		<TypeOf>Person</TypeOf>
		<Name>Test Customer 2</Name>
		<Address>
			<Id idDomain="QB">00000000000000rp</Id>
			<Line1>134 Stonemill Road</Line1>
			<Line2>Suite 2</Line2>
			<Line3>Storrs-Mansfield, CT 06279</Line3>
			<Line4>United States</Line4>
			<City>Storrs-Mansfield</City>
			<Country>USA</Country>
			<CountrySubDivisionCode>CT</CountrySubDivisionCode>
			<PostalCode>06268</PostalCode>
			<Default>1</Default>
			<Tag>Billing</Tag>
		</Address>
		<Active>true</Active>
		<ShowAs>Test Customer 2</ShowAs>
		<OpenBalance>
			<CurrencyCode>USD</CurrencyCode>
			<Amount>0</Amount>
		</OpenBalance>
	</Customer>

	<Customer>
		<Id idDomain="QB">1</Id>
		<SyncToken>1</SyncToken>
		<MetaData>
			<CreatedBy>app</CreatedBy>
			<CreateTime>2010-04-07T13:49:48.0</CreateTime>
			<LastModifiedBy>app</LastModifiedBy>
			<LastUpdatedTime>2010-04-07T14:49:24.0</LastUpdatedTime>
		</MetaData>
		<ExternalKey idDomain="QB">1</ExternalKey>
		<Synchronized>true</Synchronized>
		<PartyReferenceId idDomain="QB">1</PartyReferenceId>
		<TypeOf>Person</TypeOf>
		<Name>Test Customer 1</Name>
		<Address>
			<Id idDomain="QB">00000000000000rp</Id>
			<Line1>56 Cowles Road</Line1>
			<Line2>Suite D</Line2>
			<Line3>Willington, CT 06279</Line3>
			<Line4>United States</Line4>
			<City>Willington</City>
			<Country>USA</Country>
			<CountrySubDivisionCode>CT</CountrySubDivisionCode>
			<PostalCode>06279</PostalCode>
			<Default>1</Default>
			<Tag>Billing</Tag>
		</Address>
		<Address>
			<Id idDomain="QB">00000000000000s9</Id>
			<Line1>56 Cowles Road</Line1>
			<Line2>Suite D</Line2>
			<Line3>Willington, CT 06279</Line3>
			<Line4>USA</Line4>
			<City>Willington</City>
			<Country>USA</Country>
			<CountrySubDivisionCode>CT</CountrySubDivisionCode>
			<PostalCode>06279</PostalCode>
			<Default>1</Default>
			<Tag>Shipping</Tag>
		</Address>
		<Phone>
			<Id idDomain="QB">00000000000000rp</Id>
			<DeviceType>LandLine</DeviceType>
			<FreeFormNumber>860-634-1602</FreeFormNumber>
			<Default>1</Default>
			<Tag>Business</Tag>
		</Phone>
		<Title>Mr.</Title>
		<GivenName>Keith</GivenName>
		<FamilyName>Palmer</FamilyName>
		<DBAName>Test Customer 1, LLC</DBAName>
		<Active>true</Active>
		<ShowAs>Test Customer 1</ShowAs>
		<OpenBalance>
			<CurrencyCode>USD</CurrencyCode>
			<Amount>250</Amount>
		</OpenBalance>
		<OpenBalanceDate>2010-04-07</OpenBalanceDate>
	</Customer>

</Customers></RestResponse>';

print('
	<h2>We start off with a XML IDS Response:</h2>
	<textarea cols="100" rows="20">' . $xml . '</textarea>
');

$Parser = new QuickBooks_IPP_Parser();

$list = $Parser->parse($xml);

print('
	<h2>We can convert that to a list of PHP objects:</h2>
	<textarea cols="100" rows="20">' . print_r($list, true) . '</textarea>
');

print('
	<h2>We can loop through those objects and get data from them:</h2>
');


foreach ($list as $Customer)
{
	$line = '';
	$city = '';
	$state = '';
	if ($Address = $Customer->getAddress(0))
	{
		$line = $Address->getLine1();
		$city = $Address->getCity();
		$state = $Address->getCountrySubDivisionCode();
	}
	
	print('<strong>Customer name is:</strong> ' . $Customer->getName() . ' <strong>has an address of:</strong> ' . $line . ' ' . $city . ' ' . $state . "<br />\n");
}

$Customer = end($list);

print('
	<h2>... and we can convert it back to XML!</h2>
	<textarea cols="100" rows="20">' . $Customer->asIDSXML() . '</textarea>
');

?>
		
		<br />
		<br />
		<br />
		
	</body>
</html>


