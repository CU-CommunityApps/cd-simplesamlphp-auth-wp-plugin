<?php

$metadata_config = [
    'test' => [
        'name' => 'Cornell University NetID Login - Test',
        'domain' => 'shibidp-test.cit.cornell.edu',
        'scope' => 'cornell.edu',
        'binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST',
        'location' => 'https://shibidp-test.cit.cornell.edu/idp/profile/SAML2/POST/SSO',
        'cert' => 'MIIDXDCCAkSgAwIBAgIVAMKCR8IGXIOzO/yLt6e4sd7OMLgEMA0GCSqGSIb3DQEB
BQUAMCcxJTAjBgNVBAMTHHNoaWJpZHAtdGVzdC5jaXQuY29ybmVsbC5lZHUwHhcN
MTIwNjA3MTg0NjIyWhcNMzIwNjA3MTg0NjIyWjAnMSUwIwYDVQQDExxzaGliaWRw
LXRlc3QuY2l0LmNvcm5lbGwuZWR1MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIB
CgKCAQEAkhlf9EP399mqnBtGmPG9Vqu79Af2NZhhsT+LTMA1uhPZYv4RX/E4VD+I
qce/EUP1ndPkGEwBnhrRT2ZegDpCmgo+EcED8cAh9AbwFTTitmBjxvErtJnS0ZBf
MCLDcgOV1zM6bT5fF9SAIm0ZVSaeyQbNDwVDdwsBQHjAdg5vLd5VeYH9MI6enzdg
BtPNSrEt3qZtCWl7ev8YQlWF3vZ+EoyDrWPZSOWzgR31QBs7mz13ABSveIri68Fg
Nth9ylgFS7VNUlAp6xx6BRnMgL1QzVMZ5F4PbSRDp3UBoS6PMHd+WFenJWPPh6Sh
MyrInrJ4QAPfKC77tJW+GUXl4T4DqQIDAQABo38wfTBcBgNVHREEVTBTghxzaGli
aWRwLXRlc3QuY2l0LmNvcm5lbGwuZWR1hjNodHRwczovL3NoaWJpZHAtdGVzdC5j
aXQuY29ybmVsbC5lZHUvaWRwL3NoaWJib2xldGgwHQYDVR0OBBYEFF9RADnmBsO5
0hD8T+MUFqIgWAOxMA0GCSqGSIb3DQEBBQUAA4IBAQBqYpfdK4XAYE56sYmq/vUK
OSBcbO2Uy3R7oTGrDKxrZI7xC1jchaaTW6BXtg6wzTSn8Jo2M0gvQrWyxZgQDrXG
aL2TaPf5WjOWt/SsuJ+IShofS6ZWLkPCnrR0Ag9PwU58szw2jjUE4eJyv/dLDzhD
HJ0EGastgSzRh1r3v2w8BYz1RHvjwESPB2HTgV1iuHwaIjaJxN39XyS6ZQzBj6sZ
6Lem1R39zXmEvtVfCk9qgSKnbYulrrkIBzxllB34TUTKFs+Nz1j/sg2gj6Q5u9uW
6mSm66mqn2E53r2CNHPTzWGwom5Mi9Z/DtOb2L/5jjxhFvCKxnEbIWm7XIe8qtqo',
    ],
    'live' => [
        'name' => 'Cornell University NetID Login',
        'domain' => 'shibidp.cit.cornell.edu',
        'scope' => 'cornell.edu',
        'binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST',
        'location' => 'https://shibidp.cit.cornell.edu/idp/profile/SAML2/POST/SSO',
        'cert' => 'MIIDSDCCAjCgAwIBAgIVAOZ8NfBem6sHcI7F39sYmD/JG4YDMA0GCSqGSIb3DQEB
BQUAMCIxIDAeBgNVBAMTF3NoaWJpZHAuY2l0LmNvcm5lbGwuZWR1MB4XDTA5MTEy
MzE4NTI0NFoXDTI5MTEyMzE4NTI0NFowIjEgMB4GA1UEAxMXc2hpYmlkcC5jaXQu
Y29ybmVsbC5lZHUwggEiMA0GCSqGSIb3DQEBAQUAA4IBDwAwggEKAoIBAQCTURo9
90uuODo/5ju3GZThcT67K3RXW69jwlBwfn3png75Dhyw9Xa50RFv0EbdfrojH1P1
9LyfCjubfsm9Z7FYkVWSVdPSvQ0BXx7zQxdTpE9137qj740tMJr7Wi+iWdkyBQS/
bCNhuLHeNQor6NXZoBgX8HvLy4sCUb/4v7vbp90HkmP3FzJRDevzgr6PVNqWwNqp
tZ0vQHSF5D3iBNbxq3csfRGQQyVi729XuWMSqEjPhhkf1UjVcJ3/cG8tWbRKw+W+
OIm71k+99kOgg7IvygndzzaGDVhDFMyiGZ4njMzEJT67sEq0pMuuwLMlLE/86mSv
uGwO2Qacb1ckzjodAgMBAAGjdTBzMFIGA1UdEQRLMEmCF3NoaWJpZHAuY2l0LmNv
cm5lbGwuZWR1hi5odHRwczovL3NoaWJpZHAuY2l0LmNvcm5lbGwuZWR1L2lkcC9z
aGliYm9sZXRoMB0GA1UdDgQWBBSQgitoP2/rJMDepS1sFgM35xw19zANBgkqhkiG
9w0BAQUFAAOCAQEAaFrLOGqMsbX1YlseO+SM3JKfgfjBBL5TP86qqiCuq9a1J6B7
Yv+XYLmZBy04EfV0L7HjYX5aGIWLDtz9YAis4g3xTPWe1/bjdltUq5seRuksJjyb
prGI2oAv/ShPBOyrkadectHzvu5K6CL7AxNTWCSXswtfdsuxcKo65tO5TRO1hWlr
7Pq2F+Oj2hOvcwC0vOOjlYNe9yRE9DjJAzv4rrZUg71R3IEKNjfOF80LYPAFD2Sp
p36uB6TmSYl1nBmS5LgWF4EpEuODPSmy4sIV6jl1otuyI/An2dOcNqcgu7tYEXLX
C8N6DXggDWPtPRdpk96UW45huvXudpZenrcd7A==',
    ],
];

foreach ($metadata_config as $config) {
    $name = $config['name'];
    $domain = $config['domain'];
    $scope = $config['scope'];
    $binding = $config['binding'];
    $location = $config['location'];
    $metadata['https://' . $domain . '/idp/shibboleth'] = [
        'name' => ['en' => $name],
        'entityid' => 'https://' . $domain . '/idp/shibboleth',
        'metadata-set' => 'saml20-idp-remote',
        'SingleSignOnService' => [
            [
                'Binding' => $binding,
                'Location' => $location,
            ],
        ],
        'keys' => [
            [
                'encryption' => true,
                'signing' => true,
                'type' => 'X509Certificate',
                'X509Certificate' => $config['cert'],
            ],
        ],
        'scope' => [$scope],
        'UIInfo' => [
            'DisplayName' => ['en' => $name],
        ],
    ];
}

// Weill Test meta data
$metadata['https://login-test.weill.cornell.edu/idp'] = array(
    'metadata-set' => 'saml20-idp-remote',
    'entityid' => 'https://login-test.weill.cornell.edu/idp',
    'SingleSignOnService' =>
    array(
        0 =>
        array(
            'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
            'Location' => 'https://login-test.weill.cornell.edu/idp/profile/SAML2/Redirect/SSO',
        ),
    ),
    'SingleLogoutService' =>
    array(
        0 =>
        array(
            'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
            'Location' => 'https://login-test.weill.cornell.edu/idp/profile/SAML2/Redirect/SLO',
        ),
    ),
    'certData' => 'MIIEkTCCA3mgAwIBAgIJAIM3E9bM6upbMA0GCSqGSIb3DQEBCwUAMIHeMQswCQYDVQQGEwJVUzERMA8GA1UECAwITmV3IFlvcmsxETAPBgNVBAcMCE5ldyBZb3JrMSYwJAYDVQQKDB1XZWlsbCBDb3JuZWxsIE1lZGljYWwgQ29sbGVnZTEtMCsGA1UECwwkSVRTIC0gU2VjdXJpdHkgJiBJZGVudGl0eSBNYW5hZ2VtZW50MSUwIwYDVQQDDBxsb2dpbi10ZXN0LndlaWxsLmNvcm5lbGwuZWR1MSswKQYJKoZIhvcNAQkBFhxpdHMtc2VjdXJpdHlAbWVkLmNvcm5lbGwuZWR1MB4XDTE2MDgxMDE3NTExMloXDTI2MDgxMDE3NTExMlowgd4xCzAJBgNVBAYTAlVTMREwDwYDVQQIDAhOZXcgWW9yazERMA8GA1UEBwwITmV3IFlvcmsxJjAkBgNVBAoMHVdlaWxsIENvcm5lbGwgTWVkaWNhbCBDb2xsZWdlMS0wKwYDVQQLDCRJVFMgLSBTZWN1cml0eSAmIElkZW50aXR5IE1hbmFnZW1lbnQxJTAjBgNVBAMMHGxvZ2luLXRlc3Qud2VpbGwuY29ybmVsbC5lZHUxKzApBgkqhkiG9w0BCQEWHGl0cy1zZWN1cml0eUBtZWQuY29ybmVsbC5lZHUwggEiMA0GCSqGSIb3DQEBAQUAA4IBDwAwggEKAoIBAQCjnXimV2HPxAIaHXsiqjoiUAdpLIF2j3aCeQAvNZvZGiksMlHDMtf6wRUFlqOmfqb3JJiXHj+oEh3zCxEdYS5sDm2110z3A3ZN53pCShLKS3IFRATmxtujT42EvihyK3RJz4u/slwzjiRScicZ3fcLA0o0V4B6FxCHA7AZyvsZ+bI/B8c3cA0D0c0NhmRVKYqZ5ae5Qwi9ikNrn9dOCU2wPIOL1U9pqmoBXRX948k6ZgJ6uFkNbc2XyOiQVfQXYgcXnSOtjzits6BBkCXQ9xuQHDV8f8AnRvq8F4gsPoTPpj9HX1W5Xn1YqdqdmTujYkE5qVDDmtpKfmZ2HhD3+v23AgMBAAGjUDBOMB0GA1UdDgQWBBSeQwGkdE4Qt8B8SfLY8dqr9u3xCjAfBgNVHSMEGDAWgBSeQwGkdE4Qt8B8SfLY8dqr9u3xCjAMBgNVHRMEBTADAQH/MA0GCSqGSIb3DQEBCwUAA4IBAQBufsPXhAi5tnPZXKuAKKvSJHUNavGWUqxmY3Yvd5aAKGZ0bm+aTs90/j+smmaRxFun2nJPpLNRqVWXrHkP7OA+ZRMOBBrtagWgk3wipM22o32vEvtByCiPTRPXvctguaIkBWUNQVwMp7d+ZT5YlXkiYfu9W2uPr7fyqicr3FVY/cYdJV6Ff5MBAVhQlJMJ2FGumT4AUxlIYKjM4qDzEc7xPJjkQzVDIRf8QcJCBahpSL0R9ddnGUit+CC2Az8E3BW+xxvoF+uIyryJ5m/U+TE5SUE7G72O1xfz4wvOys5Uf/jsUnEhCUyYHWASWA9JfrinohBFLc4KgQWnmmJIf7ZQ',
    'NameIDFormat' => 'urn:oasis:names:tc:SAML:2.0:nameid-format:transient',
    'OrganizationName' =>
    array(
        'en' => 'Weill Cornell Medicine (test)',
    ),
    'OrganizationDisplayName' =>
    array(
        'en' => 'Weill Cornell Medicine (test)',
    ),
    'OrganizationURL' =>
    array(
        'en' => 'http://weill.cornell.edu/',
    ),
    'scope' =>
    array(
        0 => 'med.cornell.edu',
    ),
    'contacts' =>
    array(
        0 =>
        array(
            'emailAddress' => 'idm@med.cornell.edu',
            'contactType' => 'technical',
            'givenName' => 'ITS Identity Management',
        ),
    ),
);

// Weill Live metadata
$metadata['https://login.weill.cornell.edu/idp'] = array(
    'metadata-set' => 'saml20-idp-remote',
    'entityid' => 'https://login.weill.cornell.edu/idp',
    'SingleSignOnService' =>
    array(
        0 =>
        array(
            'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
            'Location' => 'https://login.weill.cornell.edu/idp/profile/SAML2/Redirect/SSO',
        ),
    ),
    'SingleLogoutService' =>
    array(
        0 =>
        array(
            'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
            'Location' => 'https://login.weill.cornell.edu/idp/profile/SAML2/Redirect/SLO',
        ),
    ),
    'certData' => 'MIIEhzCCA2+gAwIBAgIJAL0+jmniqPpSMA0GCSqGSIb3DQEBCwUAMIHZMQswCQYDVQQGEwJVUzERMA8GA1UECAwITmV3IFlvcmsxETAPBgNVBAcMCE5ldyBZb3JrMSYwJAYDVQQKDB1XZWlsbCBDb3JuZWxsIE1lZGljYWwgQ29sbGVnZTEtMCsGA1UECwwkSVRTIC0gU2VjdXJpdHkgJiBJZGVudGl0eSBNYW5hZ2VtZW50MSAwHgYDVQQDDBdsb2dpbi53ZWlsbC5jb3JuZWxsLmVkdTErMCkGCSqGSIb3DQEJARYcaXRzLXNlY3VyaXR5QG1lZC5jb3JuZWxsLmVkdTAeFw0xNjA4MTAxNzUwMDNaFw0yNjA4MTAxNzUwMDNaMIHZMQswCQYDVQQGEwJVUzERMA8GA1UECAwITmV3IFlvcmsxETAPBgNVBAcMCE5ldyBZb3JrMSYwJAYDVQQKDB1XZWlsbCBDb3JuZWxsIE1lZGljYWwgQ29sbGVnZTEtMCsGA1UECwwkSVRTIC0gU2VjdXJpdHkgJiBJZGVudGl0eSBNYW5hZ2VtZW50MSAwHgYDVQQDDBdsb2dpbi53ZWlsbC5jb3JuZWxsLmVkdTErMCkGCSqGSIb3DQEJARYcaXRzLXNlY3VyaXR5QG1lZC5jb3JuZWxsLmVkdTCCASIwDQYJKoZIhvcNAQEBBQADggEPADCCAQoCggEBALd/2R1oC+LOG5vr70a+9aHn8eWIuQ29liHSvLjl2tsIAYH8FTDjesl0pqAYkzYz7ENIr8RnHbWPpBQyNmS9Z35x66aUfLaJB3clFo+GytDNhDgrojEZpHuyuiF015pHjVTVZYZwTiwdRsG13/lIieC//zvEiJwNF+5kE7dudxktYrYguy2nDEpeAr4wrNDcNaIcLr7hzb9NSCwe7qRyiN0w5BNS1MInjBlKmlxP3D07BEb5OWECnOZ7ZV7t0sxBGE2OAexWXT5cbsqkvxCUL8UXM4rW2z81IEIhcVFZtWtdExt1YiGp0WLLWm4ccHWaGWRbaN1F8Gc1kPbkhLZvKrcCAwEAAaNQME4wHQYDVR0OBBYEFKRkbXVfS70Gh2hcd3QsDNuYtOxfMB8GA1UdIwQYMBaAFKRkbXVfS70Gh2hcd3QsDNuYtOxfMAwGA1UdEwQFMAMBAf8wDQYJKoZIhvcNAQELBQADggEBAH4/q+0mZnMBSRjcyqxuF6azRG6dfp4Ui3JTcJjJ29heTZjPuGQP5dS924b18N+lj5T9R5gEkB0H34VjCGv6BOmFWSh56eBVs7aihSYOijELsZLawlSH89s/reTH6Jj7RUfggtgSCgNzOQNpQPvCBKe1253w942NeCnHQg9uyzP80olECbS3eaTSTyn0AxNjiZ+fLT9FAIsPR3q1mGXuKyBXt4gEVNyJzcnZ8KC/K/HhsoTUJ0hppdSmybJhhTY+FjgYxXuNJsapLD8T0AoWK00DOS+3kaqPPloiGyuil/RxIV80DAK8Ofmlnj5it09WJ2ijhN+xCBiJpyKMCwf9zYE=',
    'NameIDFormat' => 'urn:oasis:names:tc:SAML:2.0:nameid-format:transient',
    'OrganizationName' =>
    array(
        'en' => 'Weill Cornell Medicine',
    ),
    'OrganizationDisplayName' =>
    array(
        'en' => 'Weill Cornell Medicine',
    ),
    'OrganizationURL' =>
    array(
        'en' => 'http://weill.cornell.edu/',
    ),
    'scope' =>
    array(
        0 => 'med.cornell.edu',
    ),
    'contacts' =>
    array(
        0 =>
        array(
            'emailAddress' => 'idm@med.cornell.edu',
            'contactType' => 'technical',
            'givenName' => 'ITS Identity Management',
        ),
    ),
);
