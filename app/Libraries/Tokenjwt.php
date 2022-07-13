<?php

namespace App\Libraries;

use Firebase\JWT\BeforeValidException;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Tokenjwt
{
    public $auth;
    public function privateKey()
    {
        $privateKey = "-----BEGIN CERTIFICATE-----\nMIIDHDCCAgSgAwIBAgIIWUn7zRiEbFgwDQYJKoZIhvcNAQEFBQAwMTEvMC0GA1UE\nAwwmc2VjdXJldG9rZW4uc3lzdGVtLmdzZXJ2aWNlYWNjb3VudC5jb20wHhcNMjIw\nNzA2MDkzODQ5WhcNMjIwNzIyMjE1MzQ5WjAxMS8wLQYDVQQDDCZzZWN1cmV0b2tl\nbi5zeXN0ZW0uZ3NlcnZpY2VhY2NvdW50LmNvbTCCASIwDQYJKoZIhvcNAQEBBQAD\nggEPADCCAQoCggEBALbHGtdJt0LSrNHPfemoi3IXZwiIT4/2vVpLG/B8PZGEkWYM\n7WfXsCLqUaCY1itiGSKUfxVXI2wIHt0WkCyWJ7+6eYJ4pFw8w30xJ+K3m+BGp2em\nZxWq0txxDG2xg2MIUwfku+pmrqm8gs237nJY3zuRAPCdBnBTXz9C3EwATofs5fO6\nmw6EeNBU4aEBFW1kBDweNBu9rAqGxnqulmT7FvVW59TdgocODmdNdrAvUU4ihPXK\nS3c4G5NbbYtZDfuKIuvesgatMweFCx0EJoY8pNfYWU4ZwIOjyZJMpPSEcVBNPp+v\n88EnM77C7gsZmf229S+maqc7jxakcOynPzvXoLkCAwEAAaM4MDYwDAYDVR0TAQH/\nBAIwADAOBgNVHQ8BAf8EBAMCB4AwFgYDVR0lAQH/BAwwCgYIKwYBBQUHAwIwDQYJ\nKoZIhvcNAQEFBQADggEBAF3YDXk5684IpPhSdwS5Qznn1vJEfrG3ci+6ocwwiW5n\n1I3rbbPkwtrZ9ztGa+Dz+TmIRWi9pQQRsYZN6SUoq+8LrYFmVjf7OJZP8FxDeI/N\n3HlYx8MJfwf7iZKuLmpAE9jrjOq+aPveRmvqEEd8NbTogrGsHssqgIsy43d510wJ\n8kOsdgm0mms2eGVe4JIX0SOi0/xhARRTD6FYSlKniM4657RAuW7pkQzZu8A/Gf7q\nf7kS+YUMx1M0fmH+G+UURgLK7wBwLZzYfNGuI6bnDIPCVZgzQDIaaFlnHOqQx1Bb\nm2jjdFzvKJyZo79vNGgyhKdJZyY+koywbxIvY6rG8f8=\n-----END CERTIFICATE-----\n";
        return $privateKey;
    }
    public function getToken($data)
    {
        $secret_key = $this->privateKey();
        $issuer_claim = "SmartVillage"; // this can be the servername. Example: https://domain.com
        $audience_claim = "SmartVillage";
        $issuedat_claim = time(); // issued at
        $notbefore_claim = $issuedat_claim; //not before in seconds
        $expire_claim = $issuedat_claim + (10 * 60 * 60); // expire time in seconds
        $token = array(
            "iss" => $issuer_claim,
            "aud" => $audience_claim,
            "iat" => $issuedat_claim,
            "nbf" => $notbefore_claim,
            "exp" => $expire_claim,
            "data" => $data
        );
        $token = JWT::encode($token, $secret_key, "HS256");
        return $token;
    }
    public function checkToken($authHeader)
    {
        if ($authHeader == null) {
            $output = [
                'message' => 'Access denied',
                'status' => 401
            ];
            return $output;
        }

        $secret_key = $this->privateKey();

        $token = null;

        $arr = explode(" ", $authHeader);
        $token = $arr[1];
        $tokenParts = explode(".", $token);
        $tokenHeader = base64_decode($tokenParts[0]);
        $tokenHeaderJson = json_decode($tokenHeader);
        if (!preg_match('/^[a-z0-9]+$/i', $tokenHeaderJson->kid)) {
            $output = [
                'message' => 'Invalid Request',
                'status' => 200,
            ];
            return $output;
        }
        if ($token) {

            try {
                $decoded = JWT::decode($token, new Key($secret_key, 'RS256'));
                // Access is granted. Add code of the operation here 
                if ($decoded) {
                    // response true
                    $output = [
                        'message' => 'Access granted',
                        'data' => $decoded,
                        'status' => 200,
                    ];
                    return $output;
                }
            } catch (BeforeValidException $e) {
                $output = [
                    'message' => 'Access denied',
                    "error" => $e->getMessage(),
                    'status' => 401
                ];
                return $output;
                $decoded = json_decode(base64_decode($tokenParts[1]));
            } catch (\Exception $e) {

                $output = [
                    'message' => 'Access denied',
                    "error" => $e->getMessage(),
                    'status' => 401
                ];
                return $output;
            }
        }
    }
}
