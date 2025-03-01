<?php

namespace App\Models\Google;


class GoogleApi
{
    private $recaptcha_secret = '';
    private $recaptcha_public = '';

    public function __construct()
    {
        echo "GoogleApi";
    }
    public function useRecaptcha()
    {
        $librerias  = '<script>const recaptchaKey = "' . $this->recaptcha_public . '";</script>';
        $librerias .= '<script src="https://www.google.com/recaptcha/enterprise.js?render=' . $this->recaptcha_public . '"></script>';
        return $librerias;
    }
    public function verifyRecaptcha($captcha, $opcion)
    {
        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array('secret' => $this->recaptcha_secret, 'response' => $captcha)));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            curl_close($ch);
            $res = json_decode($response, true);

            if ($res["success"] == '1' && $res["action"] == $opcion && $res["score"] >= 0.5) {
                return (array('status' => true, 'response' => 'success', 'text' => 'Recaptcha valido'));
            } else {
                return ((array('status' => false, 'response' => 'error', 'text' => 'No se capturo de forma correcta el captcha',)));
            }
        } catch (\Throwable $th) {
            return ((array('status' => false, 'response' => 'error', 'text' => 'Ocurrio un error al hacer la validación del usuario', 'err' => $th->getMessage())));
        }
    }
    public function setAnalytics($key)
    {
        $librerias = '<script async src="https://www.googletagmanager.com/gtag/js?id=' . $key . '"></script>';
        $librerias .= '<script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag("js", new Date());
        gtag("config", "' . $key . '");
        </script>';
        return $librerias;
    }
}
