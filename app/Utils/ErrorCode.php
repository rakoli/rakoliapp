<?php

namespace App\Utils;

/**
 * Centralized Error Codes for API responses
 * Each error has a unique numeric code for easy identification and debugging
 */
class ErrorCode
{
    // Authentication Errors (1000-1099)
    const UNAUTHORIZED = 1001;
    const INVALID_CREDENTIALS = 1002;
    const ACCOUNT_DISABLED = 1003;
    const ACCOUNT_LOCKED = 1004;
    const ACCESS_DENIED = 1005;
    const INVALID_TOKEN = 1006;

    // Validation Errors (1100-1199)
    const VALIDATION_FAILED = 1100;
    const INVALID_INPUT = 1101;
    const INVALID_PIN = 1102;
    const INVALID_OTP = 1103;
    const WRONG_ENDPOINT = 1104;

    // Resource Errors (1200-1299)
    const NOT_FOUND = 1200;
    const ALREADY_EXISTS = 1201;
    const RESOURCE_CONFLICT = 1202;

    // Rate Limiting Errors (1300-1399)
    const TOO_MANY_REQUESTS = 1300;
    const OTP_STILL_ACTIVE = 1301;
    const OTP_LOCKED = 1302;
    const RESET_LOCKED = 1303;

    // Operation Errors (1400-1499)
    const OPERATION_FAILED = 1400;
    const ACTION_FAILED = 1401;
    const OTP_SEND_FAILED = 1402;
    const VERIFICATION_FAILED = 1403;
    const REGISTRATION_FAILED = 1404;
    const RESEND_FAILED = 1405;
    const REQUEST_FAILED = 1406;
    const RESET_FAILED = 1407;
    const CREATE_FAILED = 1408;
    const UPDATE_FAILED = 1409;
    const DELETE_FAILED = 1410;
    const RETRIEVE_FAILED = 1411;

    // Server Errors (1500-1599)
    const INTERNAL_ERROR = 1500;
    const DATABASE_ERROR = 1501;
    const SERVICE_UNAVAILABLE = 1502;
}
