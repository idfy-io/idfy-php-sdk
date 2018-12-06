<?php
declare(strict_types=1);

/* Entities/OAuthToken */
class BadAccessTokenException extends Exception {}
class UnsupportedTokenTypeException extends Exception {}
class BadExpiresInException extends Exception {}


/* Infrastructure/AuthManager */
class BadClientIdException extends Exception {}
class BadClientSecretException extends Exception {}
class BadOAuthScopesException extends Exception {}
class MissingNetworkServiceException extends Exception {}

/* Infrastructure/NetworkService */
class MissingBaseUrlException extends Exception {}
class InvalidBaseUrlException extends Exception {}

