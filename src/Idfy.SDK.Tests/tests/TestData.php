<?php
 
class TestData {
	public static $valid_b64 = "VGhpcyBpcyBhbiBlbmNvZGVkIHN0cmluZw=="; 
	public static $invalid_b64 ="VGhpcyBpcyBhbiBlbmNvZGVkIHN0cmluZw==//";
	public static $token = 
		 "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsIng1dCI6IkhLaDkxUU9qRmpCaDVTaGoySFg0Tm1FRm"
		."pwbyIsImtpZCI6IkhLaDkxUU9qRmpCaDVTaGoySFg0Tm1FRmpwbyJ9.eyJpc3MiOiJodHRwczovL29"
		."hdXRoMnRlc3Quc2lnbmVyZS5jb20iLCJhdWQiOiJodHRwczovL29hdXRoMnRlc3Quc2lnbmVyZS5jb"
		."20vcmVzb3VyY2VzIiwiZXhwIjoxNTQzOTU2MjIyLCJuYmYiOjE1NDM5NTI2MjIsImNsaWVudF9pZCI"
		."6InQzZmJiY2RiZWE2MzQ0ZTg1OGJjYTUxZjNmNzNhNWQyNCIsImNsaWVudF9wcm92aWRlcmlkIjoiM"
		."DMyZGY5ZTItN2E3YS00NjE0LTkzYjAtYTZiNDAwZjFlNTkxIiwic2NvcGUiOlsiZG9jdW1lbnRfcmV"
		."hZCIsImRvY3VtZW50X3dyaXRlIl0sImVudiI6InByZXByb2QifQ.GmpwAADrZl2NSWVUW8_WH9rwPo"
		."PDPlWne3AWABjd4axKjZD70jjoHy1C-CCjpyxxkEI0SkNl9Lp5oPaTEfd553ZgfxBPpBzxN5Z0GEz2"
		."AbV2wS4Q8xvRACTpP7kf-I9VsP4OiBO6T2-8CmV5HUp3G4oaHoz4-m5dWeMQ932ry8kF9P6Q8S6ldB"
		."dvNGzKPLj9CaSeqtnpJ4FRhadZNBiiNAjGxz-jMEPeelRVvf8gBpLvcVSYODVT47ZADI3UEXMKyy3U"
		."4War33wcyEDRXJyoMF2SrcgqPWuna9GeTYxv70RkE0lOv21Effb_k4dAxW7ZZ0s4YhyHnC81FGKl1xr46A";
	public static $token_missing_jwt = 
		 "eyJ0eXAiOiJuaWwiLCJhbGciOiJSUzI1NiIsIng1dCI6IkhLaDkxUU9qRmpCaDVTaGoySFg0Tm1F\nRm"
		."pwbyIsImtpZCI6IkhLaDkxUU9qRmpCaDVTaGoySFg0Tm1FRmpwbyJ9\n.eyJpc3MiOiJodHRwczovL29"
		."hdXRoMnRlc3Quc2lnbmVyZS5jb20iLCJhdWQiOiJodHRwczovL29hdXRoMnRlc3Quc2lnbmVyZS5jb20"
		."vcmVzb3VyY2VzIiwiZXhwIjoxNTQzOTU2MjIyLCJuYmYiOjE1NDM5NTI2MjIsImNsaWVudF9pZCI6InQ"
		."zZmJiY2RiZWE2MzQ0ZTg1OGJjYTUxZjNmNzNhNWQyNCIsImNsaWVudF9wcm92aWRlcmlkIjoiMDMyZGY"
		."5ZTItN2E3YS00NjE0LTkzYjAtYTZiNDAwZjFlNTkxIiwic2NvcGUiOlsiZG9jdW1lbnRfcmVhZCIsImR"
		."vY3VtZW50X3dyaXRlIl0sImVudiI6InByZXByb2QifQ.GmpwAADrZl2NSWVUW8_WH9rwPoPDPlWne3AW"
		."ABjd4axKjZD70jjoHy1C-CCjpyxxkEI0SkNl9Lp5oPaTEfd553ZgfxBPpBzxN5Z0GEz2AbV2wS4Q8xvR"
		."ACTpP7kf-I9VsP4OiBO6T2-8CmV5HUp3G4oaHoz4-m5dWeMQ932ry8kF9P6Q8S6ldBdvNGzKPLj9CaSe"
		."qtnpJ4FRhadZNBiiNAjGxz-jMEPeelRVvf8gBpLvcVSYODVT47ZADI3UEXMKyy3U4War33wcyEDRXJyo"
		."MF2SrcgqPWuna9GeTYxv70RkE0lOv21Effb_k4dAxW7ZZ0s4YhyHnC81FGKl1xr46A";

	public static $client_id = "ar2jch29d82j3kdhsjakdhwjdkaiweoql";
	public static $client_secret = "0ed82b5800247e8c17956577517408d27c90a9938cde554bb26df"
		."b89f31f43560e0b8aa04a828241fa1abba8e97719036712938b34a2f7dbb5b49c09e79f02bc0000001e";
	public static $scopes_read = ["document_read"];
	public static $scopes_write = ["document_write"];
	public static $scopes_readwrite = ["document_read","document_write"];

	public static $access_token_response = 
		'{"access_token":"eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsIng1dCI6IkhLaDkxUU9qRmpCaD'
		.'VTaGoySFg0Tm1FRmpwbyIsImtpZCI6IkhLaDkxUU9qRmpCaDVTaGoySFg0Tm1FRmpwbyJ9.eyJpc3Mi'
		.'OiJodHRwczovL29hdXRoMnRlc3Quc2lnbmVyZS5jb20iLCJhdWQiOiJodHRwczovL29hdXRoMnRlc3Q'
		.'uc2lnbmVyZS5jb20vcmVzb3VyY2VzIiwiZXhwIjoxNTQzOTU2MjIyLCJuYmYiOjE1NDM5NTI2MjIsIm'
		.'NsaWVudF9pZCI6InQzZmJiY2RiZWE2MzQ0ZTg1OGJjYTUxZjNmNzNhNWQyNCIsImNsaWVudF9wcm92a'
		.'WRlcmlkIjoiMDMyZGY5ZTItN2E3YS00NjE0LTkzYjAtYTZiNDAwZjFlNTkxIiwic2NvcGUiOlsiZG9j'
		.'dW1lbnRfcmVhZCIsImRvY3VtZW50X3dyaXRlIl0sImVudiI6InByZXByb2QifQ.GmpwAADrZl2NSWVU'
		.'W8_WH9rwPoPDPlWne3AWABjd4axKjZD70jjoHy1C-CCjpyxxkEI0SkNl9Lp5oPaTEfd553ZgfxBPpBz'
		.'xN5Z0GEz2AbV2wS4Q8xvRACTpP7kf-I9VsP4OiBO6T2-8CmV5HUp3G4oaHoz4-m5dWeMQ932ry8kF9P6'
		.'Q8S6ldBdvNGzKPLj9CaSeqtnpJ4FRhadZNBiiNAjGxz-jMEPeelRVvf8gBpLvcVSYODVT47ZADI3UEXM'
		.'Kyy3U4War33wcyEDRXJyoMF2SrcgqPWuna9GeTYxv70RkE0lOv21Effb_k4dAxW7ZZ0s4YhyHnC81FG'
		.'Kl1xr46A","expires_in":3600,"token_type":"Bearer"}';

	public static $valid_base_url = "https://api.idfy.io";
}
